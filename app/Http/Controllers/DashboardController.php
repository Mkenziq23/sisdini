<?php

namespace App\Http\Controllers;

use App\Models\Deteksi;
use App\Models\Kontak;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung total data di tabel
        $deteksicount = Deteksi::count();
        $totalUsers = User::count();
        $role = Auth::user()->role;

        // --- Ambil data dari Excel ---
        $filePath = public_path('data/matang.xlsx');
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);

        // Buang header
        array_shift($rows);

        $datasetExcel = [];
        foreach ($rows as $row) {
            $datasetExcel[] = [
                'usia' => (int)$row['A'],
                'jk' => (int)$row['B'],
                'imt' => (int)$row['C'],
                'td' => (int)$row['D'],
                'hipertensi' => (int)$row['E'],
                'kardiovaskular' => (int)$row['F'],
                'aktivitas' => (int)$row['G'],
                'gd' => (int)$row['H'], // label
            ];
        }

        // --- Ambil data dari database (kolom *_val) ---
        $datasetDB = Deteksi::select(
            'usia_val as usia',
            'jk_val as jk',
            'imt_val as imt',
            'td_val as td',
            'hipertensi_val as hipertensi',
            'kardio_val as kardiovaskular',
            'aktivitas_val as aktivitas',
            'gula_darah_val as gd' // label
        )->get()->map(function ($row) {
            return [
                'usia' => (int)$row->usia,
                'jk' => (int)$row->jk,
                'imt' => (int)$row->imt,
                'td' => (int)$row->td,
                'hipertensi' => (int)$row->hipertensi,
                'kardiovaskular' => (int)$row->kardiovaskular,
                'aktivitas' => (int)$row->aktivitas,
                'gd' => (int)$row->gd,
            ];
        })->toArray();

        // --- Pisahkan data latih & data uji (80:20) ---
        $fullDataset = array_merge($datasetExcel, $datasetDB);
        $trainSize = (int)(count($fullDataset) * 0.8);
        $trainData = array_slice($fullDataset, 0, $trainSize);
        $testData = array_slice($fullDataset, $trainSize);

        // Latih model Naive Bayes
        $model = $this->trainNaiveBayes($datasetExcel, $datasetDB);

        // Confusion matrix
        $tp = $fp = $tn = $fn = 0;
        foreach ($testData as $data) {
            $predicted = $this->predictNaiveBayes($model, $data);
            $actual = $data['gd'];

            if ($predicted == 1 && $actual == 1) $tp++;
            elseif ($predicted == 1 && $actual == 0) $fp++;
            elseif ($predicted == 0 && $actual == 0) $tn++;
            elseif ($predicted == 0 && $actual == 1) $fn++;
        }

        // Hitung metrik
        $accuracy = ($tp + $tn) / max(1, ($tp + $tn + $fp + $fn));
        $precision = $tp / max(1, ($tp + $fp));
        $recall = $tp / max(1, ($tp + $fn));

        return view('pages.auth.dashboard.index', compact(
            'deteksicount',
            'accuracy',
            'precision',
            'recall',
            'role',
            'totalUsers'
        ));
    }

    private function trainNaiveBayes($excelData, $dbData)
    {
        // Gabungkan data Excel + DB jika ada
        $dataset = $excelData;
        if (!empty($dbData)) {
            $dataset = array_merge($dataset, $dbData);
        }

        $model = [
            'priors' => [],
            'likelihoods' => [],
        ];

        $countClass = [];
        foreach ($dataset as $row) {
            $class = $row['gd'];
            $countClass[$class] = ($countClass[$class] ?? 0) + 1;
        }

        $total = count($dataset);
        foreach ($countClass as $class => $count) {
            $model['priors'][$class] = $count / $total;
        }

        foreach ($dataset as $row) {
            $class = $row['gd'];
            foreach ($row as $attr => $value) {
                if ($attr == 'gd') continue;
                $model['likelihoods'][$attr][$value][$class] =
                    ($model['likelihoods'][$attr][$value][$class] ?? 0) + 1;
            }
        }

        foreach ($model['likelihoods'] as $attr => $values) {
            foreach ($values as $val => $classes) {
                foreach ($classes as $class => $count) {
                    $model['likelihoods'][$attr][$val][$class] =
                        $count / $countClass[$class];
                }
            }
        }

        return $model;
    }

    private function predictNaiveBayes($model, $data)
    {
        $scores = [];
        foreach ($model['priors'] as $class => $prior) {
            $scores[$class] = $prior;
            foreach ($data as $attr => $value) {
                if ($attr == 'gd') continue;
                if (isset($model['likelihoods'][$attr][$value][$class])) {
                    $scores[$class] *= $model['likelihoods'][$attr][$value][$class];
                } else {
                    $scores[$class] *= 1e-6; // smoothing
                }
            }
        }
        return array_search(max($scores), $scores);
    }



    public function HasilDeteksi() {
        // Ambil semua data tapi hanya kolom tanpa '_val'
        $deteksi = Deteksi::select(
            'id',
            'nama',
            'usia',
            'jenis_kelamin',
            'telepon',
            'aktivitas',
            'imt',
            'tekanan_darah',
            'hipertensi',
            'gula_darah',
            'kardiovaskular',
            'hasil',
            'created_at'
        )->latest()->get();

        return view('pages.auth.dashboard.hasil deteksi.index', compact('deteksi'));
    }

    public function deleteHasil($id)
    {
        $deteksi = Deteksi::findOrFail($id);
        $deteksi->delete();

        return redirect()->route('hasil-deteksi')->with('success', 'Data berhasil dihapus');
    }


    public function KelolaAkun() {
        $kelolaAkun = User::all();
        return view('pages.auth.dashboard.akun.index', compact('kelolaAkun'));
        
    }

    public function CreateAkun() {
        return view('pages.auth.dashboard.akun.create');
    }

    public function StoreAkun(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,dokter,user'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        return redirect()->route('kelola-akun')->with('success', 'Akun berhasil ditambahkan.');
    }

    public function EditAkun($id) {
        $akun = User::findOrFail($id);
        return view('pages.auth.dashboard.akun.edit', compact('akun'));
    }

    public function UpdateAkun(Request $request, $id) {
        $akun = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $akun->id,
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|in:admin,dokter,user'
        ]);

        $akun->name = $request->name;
        $akun->email = $request->email;
        $akun->role = $request->role;

        if ($request->password) {
            $akun->password = Hash::make($request->password);
        }

        $akun->save();

        return redirect()->route('kelola-akun')->with('success', 'Akun berhasil diperbarui.');
    }

    public function DeleteAkun($id) {
        $akun = User::findOrFail($id);
        $akun->delete();

        return redirect()->route('kelola-akun')->with('success', 'Akun berhasil dihapus.');
    }

    public function KelolaPesan() {
        $kelolaPesan = Kontak::all();
        return view('pages.auth.dashboard.pesan.index', compact('kelolaPesan'));
        
    }

    public function DeletePesan($id) {
        $pesan = Kontak::findOrFail($id);
        $pesan->delete();

        return redirect()->route('kelola-pesan')->with('success', 'Pesan berhasil dihapus.');
    }

    


}
