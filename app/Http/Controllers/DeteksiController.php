<?php

namespace App\Http\Controllers;

use App\Models\Deteksi;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;
class DeteksiController extends Controller
{
    public function index()
    {
        $latest = Deteksi::latest()->first();
        return view('pages.hasil', compact('latest'));
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'nama'           => 'required|string|max:255',
        'usia'           => 'required|numeric',
        'jenis_kelamin'  => 'required',
        'telepon'        => 'nullable|string',
        'aktivitas'      => 'nullable',
        'tinggi_badan'   => 'nullable|numeric',
        'berat_badan'    => 'nullable|numeric',
        'tekanan_darah'  => 'nullable|string',
        'hipertensi'     => 'nullable',
        'gula_darah'     => 'nullable',
        'kardiovaskular' => 'nullable',
    ]);

    // ===============================
    // Hitung IMT
    // ===============================
    $imt = null;
    if (!empty($validated['tinggi_badan']) && !empty($validated['berat_badan'])) {
        $tinggi_m = $validated['tinggi_badan'] / 100;
        if ($tinggi_m > 0) {
            $imt = round($validated['berat_badan'] / ($tinggi_m * $tinggi_m), 2);
        }
    }

    // ===============================
    // Parsing Tekanan Darah
    // ===============================
    $sistol = $diastol = null;
    if (!empty($validated['tekanan_darah']) && strpos($validated['tekanan_darah'], '/') !== false) {
        [$sistol, $diastol] = array_map('trim', explode('/', $validated['tekanan_darah']));
        $sistol  = is_numeric($sistol) ? (int) $sistol : null;
        $diastol = is_numeric($diastol) ? (int) $diastol : null;
    }

    // ===============================
    // Konversi ke nilai kategorikal
    // ===============================
    $usia_asli = (int) $validated['usia'];
    $usia_val  = ($usia_asli >= 26 && $usia_asli <= 35) ? 0 :
                 (($usia_asli >= 36 && $usia_asli <= 45) ? 1 :
                 (($usia_asli >= 46 && $usia_asli <= 55) ? 2 :
                 (($usia_asli >= 56 && $usia_asli <= 65) ? 3 : 4)));

    $jk_val = is_numeric($validated['jenis_kelamin'])
        ? (int) $validated['jenis_kelamin']
        : (strtolower($validated['jenis_kelamin']) == 'laki-laki' ? 1 : 0);

    if ($sistol !== null && $diastol !== null) {
        if ($sistol >= 160 || $diastol >= 100) {
            $td_val = 3;
        } elseif ($sistol >= 140 || $diastol >= 90) {
            $td_val = 2;
        } elseif ($sistol >= 120 || $diastol >= 80) {
            $td_val = 1;
        } else {
            $td_val = 0;
        }
    } else {
        $td_val = 0;
    }

    $aktivitas_val = is_numeric($validated['aktivitas'])
        ? (int) $validated['aktivitas']
        : (strtolower($validated['aktivitas']) == 'cukup' ? 1 : 0);

    $imt_val = $imt !== null ? (($imt < 18.5) ? 0 : (($imt <= 25.0) ? 1 : 2)) : 0;

    $gd_val = is_numeric($validated['gula_darah']) && $validated['gula_darah'] <= 1
        ? (int) $validated['gula_darah']
        : (($validated['gula_darah'] < 200) ? 0 : 1);

    $hipertensi_val = is_numeric($validated['hipertensi'])
        ? (int) $validated['hipertensi']
        : (strtolower($validated['hipertensi']) == 'ya' ? 1 : 0);

    $kardiovaskular_val = is_numeric($validated['kardiovaskular'])
        ? (int) $validated['kardiovaskular']
        : (strtolower($validated['kardiovaskular']) == 'ya' ? 1 : 0);

    // ===============================
    // Baca Dataset Excel
    // ===============================
    $filePath    = public_path('data/matang.xlsx');
    $spreadsheet = IOFactory::load($filePath);
    $sheet       = $spreadsheet->getActiveSheet();
    $rows        = $sheet->toArray();
    array_shift($rows); // hapus header

    $data_diabetes     = [];
    $data_non_diabetes = [];
    $exactMatchLabel   = null;

    foreach ($rows as $row) {
        $record = [
            'usia'         => (int) $row[0],
            'jk'           => (int) $row[1],
            'imt'          => (int) $row[2],
            'td'           => (int) $row[3],
            'hipertensi'   => (int) $row[4],
            'kardiovaskular' => (int) $row[5],
            'aktivitas'    => (int) $row[6],
            'gd'           => (int) $row[7],
        ];

        $label = strtolower(trim($row[8]));

        // cek exact match
        if (
            $record['usia'] === $usia_val &&
            $record['jk'] === $jk_val &&
            $record['imt'] === $imt_val &&
            $record['td'] === $td_val &&
            $record['hipertensi'] === $hipertensi_val &&
            $record['kardiovaskular'] === $kardiovaskular_val &&
            $record['aktivitas'] === $aktivitas_val &&
            $record['gd'] === $gd_val
        ) {
            $exactMatchLabel = ucfirst($label);
            break;
        }

        if ($label === 'berisiko') {
            $data_diabetes[] = $record;
        } else {
            $data_non_diabetes[] = $record;
        }
    }

    // ===============================
    // Tentukan hasil
    // ===============================
    if ($exactMatchLabel !== null) {
        $hasil = $exactMatchLabel;
    } else {
        // cek faktor risiko manual
        $faktorRisiko = false;
        if ($gd_val == 1 || $td_val >= 2 || $imt_val == 2 || $hipertensi_val == 1 || $kardiovaskular_val == 1) {
            $faktorRisiko = true;
        }

        if ($faktorRisiko) {
            $hasil = "Berisiko";
        } else {
            // jika ingin tetap gunakan Naive Bayes
            $total = count($rows);
            if ($total > 0) {
                $p_diabetes     = count($data_diabetes) / $total;
                $p_non_diabetes = count($data_non_diabetes) / $total;

                $likelihood = function ($data, $field, $value) {
                    $total_data = count($data);
                    if ($total_data == 0) return 1;

                    $count = array_reduce($data, fn($carry, $item) =>
                        $carry + ($item[$field] == $value ? 1 : 0), 0);

                    $categories     = array_unique(array_column($data, $field));
                    $num_categories = count($categories) ?: 1;

                    return ($count + 1) / ($total_data + $num_categories);
                };

                $posterior_diabetes = $p_diabetes *
                    $likelihood($data_diabetes, 'usia', $usia_val) *
                    $likelihood($data_diabetes, 'jk', $jk_val) *
                    $likelihood($data_diabetes, 'imt', $imt_val) *
                    $likelihood($data_diabetes, 'td', $td_val) *
                    $likelihood($data_diabetes, 'hipertensi', $hipertensi_val) *
                    $likelihood($data_diabetes, 'kardiovaskular', $kardiovaskular_val) *
                    $likelihood($data_diabetes, 'aktivitas', $aktivitas_val) *
                    $likelihood($data_diabetes, 'gd', $gd_val);

                $posterior_non_diabetes = $p_non_diabetes *
                    $likelihood($data_non_diabetes, 'usia', $usia_val) *
                    $likelihood($data_non_diabetes, 'jk', $jk_val) *
                    $likelihood($data_non_diabetes, 'imt', $imt_val) *
                    $likelihood($data_non_diabetes, 'td', $td_val) *
                    $likelihood($data_non_diabetes, 'hipertensi', $hipertensi_val) *
                    $likelihood($data_non_diabetes, 'kardiovaskular', $kardiovaskular_val) *
                    $likelihood($data_non_diabetes, 'aktivitas', $aktivitas_val) *
                    $likelihood($data_non_diabetes, 'gd', $gd_val);

                $hasil = $posterior_diabetes > $posterior_non_diabetes ? 'Berisiko' : 'Tidak Berisiko';
            } else {
                $hasil = 'Tidak Berisiko';
            }
        }
    }

    // ===============================
    // Simpan ke DB
    // ===============================
    Deteksi::create([
        'nama'              => $validated['nama'],
        'usia'              => $usia_asli,
        'usia_val'          => $usia_val,
        'jenis_kelamin'     => $validated['jenis_kelamin'],
        'jk_val'            => $jk_val,
        'telepon'           => $validated['telepon'],
        'aktivitas'         => $validated['aktivitas'],
        'aktivitas_val'     => $aktivitas_val,
        'tinggi_badan'      => $validated['tinggi_badan'],
        'berat_badan'       => $validated['berat_badan'],
        'imt'               => $imt,
        'imt_val'           => $imt_val,
        'tekanan_darah'     => $validated['tekanan_darah'],
        'td_val'            => $td_val,
        'hipertensi'        => $validated['hipertensi'],
        'hipertensi_val'    => $hipertensi_val,
        'gula_darah'        => $validated['gula_darah'],
        'gula_darah_val'    => $gd_val,
        'kardiovaskular'    => $validated['kardiovaskular'],
        'kardio_val'        => $kardiovaskular_val,
        'hasil'             => $hasil,
    ]);

    return redirect()->route('hasil')->with('success', "Data berhasil disimpan! Berikut hasil deteksi");
}


    public function cetak()
    {
        // Ambil hasil terbaru
        $latest = Deteksi::latest()->first();

        if (!$latest) {
            return redirect()->route('hasil')->with('error', 'Data hasil deteksi tidak ditemukan.');
        }

        // Load view ke PDF
        $pdf = Pdf::loadView('pages.cetak_hasil', compact('latest'));

        // Tampilkan di browser (preview untuk print)
        return $pdf->stream('hasil_deteksi_' . $latest->nama . '.pdf');
    }

    public function download()
    {
        $latest = Deteksi::latest()->first();

        if (!$latest) {
            return redirect()->route('hasil')->with('error', 'Data hasil deteksi tidak ditemukan.');
        }

        $pdf = Pdf::loadView('pages.cetak_hasil', compact('latest'));
        return $pdf->download('hasil_deteksi_' . $latest->nama . '.pdf');
}

}
