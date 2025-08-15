<?php

namespace App\Http\Controllers;

use App\Models\Deteksi;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
            'nama' => 'required|string|max:255',
            'usia' => 'required',
            'jenis_kelamin' => 'required',
            'telepon' => 'nullable|string',
            'aktivitas' => 'nullable',
            'imt' => 'nullable',
            'tekanan_darah' => 'nullable|string', // format "120/80" atau kategori langsung
            'hipertensi' => 'nullable',
            'gula_darah' => 'nullable',
            'kardiovaskular' => 'nullable',
        ]);

        // Parsing tekanan darah jika formatnya mmHg
        $sistol = null;
        $diastol = null;
        if (!empty($validated['tekanan_darah']) && strpos($validated['tekanan_darah'], '/') !== false) {
            [$sistol, $diastol] = array_map('trim', explode('/', $validated['tekanan_darah']));
            $sistol = is_numeric($sistol) ? (int)$sistol : null;
            $diastol = is_numeric($diastol) ? (int)$diastol : null;
        }

        // ===== Konversi nilai asli ke kategori (kalau inputnya bukan kategori langsung) =====
        // Usia
        $usia_asli = $validated['usia'];
        if ($usia_asli <= 5 && is_numeric($usia_asli)) {
            // Jika sudah kategori langsung
            $usia_val = (int) $usia_asli;
        } else {
            $usia_val = $usia_asli >= 26 && $usia_asli <= 35 ? 0 :
                        ($usia_asli >= 36 && $usia_asli <= 45 ? 1 :
                        ($usia_asli >= 46 && $usia_asli <= 55 ? 2 :
                        ($usia_asli >= 56 && $usia_asli <= 65 ? 3 : 4)));
        }

        // Jenis kelamin
        $jk_val = is_numeric($validated['jenis_kelamin'])
            ? (int) $validated['jenis_kelamin']
            : (strtolower($validated['jenis_kelamin']) == 'laki-laki' ? 1 : 0);

        if ($sistol !== null && $diastol !== null) {
            if ($sistol >= 160 || $diastol >= 100) {
                $td_val = 3; // Hipertensi Tahap 2
            } elseif (($sistol >= 140 && $sistol <= 159) || ($diastol >= 90 && $diastol <= 99)) {
                $td_val = 2; // Hipertensi Tahap 1
            } elseif (($sistol >= 120 && $sistol <= 139) || ($diastol >= 80 && $diastol <= 89)) {
                $td_val = 1; // Prehipertensi
            } elseif ($sistol < 120 && $diastol < 80) {
                $td_val = 0; // Normal
            } else {
                $td_val = 0;
            }
        } else {
            $td_val = 0;
        }


        // Aktivitas
        $aktivitas_val = is_numeric($validated['aktivitas'])
            ? (int) $validated['aktivitas']
            : (strtolower($validated['aktivitas']) == 'cukup' ? 1 : 0);

        // IMT
        if (is_numeric($validated['imt']) && $validated['imt'] <= 3) {
            $imt_val = (int) $validated['imt'];
        } else {
            $imt_val = ($validated['imt'] < 18.4) ? 0 :
                      (($validated['imt'] >= 18.5 && $validated['imt'] <= 25.0) ? 1 : 2);
        }

        // Gula darah
        $gd_val = is_numeric($validated['gula_darah']) && $validated['gula_darah'] <= 1
            ? (int) $validated['gula_darah']
            : (($validated['gula_darah'] < 200) ? 0 : 1);

        // Hipertensi
        $hipertensi_val = is_numeric($validated['hipertensi'])
            ? (int) $validated['hipertensi']
            : (strtolower($validated['hipertensi']) == 'ya' ? 1 : 0);

        // Kardiovaskular
        $kardiovaskular_val = is_numeric($validated['kardiovaskular'])
            ? (int) $validated['kardiovaskular']
            : (strtolower($validated['kardiovaskular']) == 'ya' ? 1 : 0);

        // ===== Baca dataset =====
// ===== Baca dataset =====
$filePath = public_path('data/matang.xlsx');
$spreadsheet = IOFactory::load($filePath);
$sheet = $spreadsheet->getActiveSheet();
$rows = $sheet->toArray();
array_shift($rows); // hapus header

$data_diabetes = [];
$data_non_diabetes = [];

// [Exact Match] cek terlebih dahulu
$exactMatchLabel = null;

foreach ($rows as $row) {
    $record = [
        'usia' => (int)$row[0],
        'jk' => (int)$row[1],
        'imt' => (int)$row[2],
        'td' => (int)$row[3],
        'hipertensi' => (int)$row[4],
        'kardiovaskular' => (int)$row[5],
        'aktivitas' => (int)$row[6],
        'gd' => (int)$row[7],
    ];

    $label = strtolower(trim($row[8]));

    // Cek exact match
    if (
        $record['usia'] === (int)$usia_val &&
        $record['jk'] === (int)$jk_val &&
        $record['imt'] === (int)$imt_val &&
        $record['td'] === (int)$td_val &&
        $record['hipertensi'] === (int)$hipertensi_val &&
        $record['kardiovaskular'] === (int)$kardiovaskular_val &&
        $record['aktivitas'] === (int)$aktivitas_val &&
        $record['gd'] === (int)$gd_val
    ) {
        $exactMatchLabel = ucfirst($label); // simpan hasil, langsung hentikan loop
        break;
    }

    // Simpan ke dataset sesuai label
    if ($label === 'Berisiko') {
        $data_diabetes[] = $record;
    } else {
        $data_non_diabetes[] = $record;
    }
}

// Jika ada exact match, langsung simpan hasil & skip Naive Bayes
if ($exactMatchLabel !== null) {
    $hasil = $exactMatchLabel;
} else {
    // ===== Hitung prior =====
    $total = count($rows);
    $p_diabetes = count($data_diabetes) / $total;
    $p_non_diabetes = count($data_non_diabetes) / $total;

    // ===== Fungsi likelihood (Laplace smoothing) =====
    $likelihood = function($data, $field, $value) {
        $total_data = count($data);
        if ($total_data == 0) return 1;

        $count = array_reduce($data, fn($carry, $item) => $carry + ($item[$field] == $value ? 1 : 0), 0);
        $categories = array_unique(array_column($data, $field));
        $num_categories = count($categories) ?: 1;

        return ($count + 1) / ($total_data + $num_categories);
    };

    // ===== Hitung posterior =====
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
}
// if ($exactMatchLabel !== null) {
//     dd([
//         'status' => 'Exact Match ditemukan',
//         'input' => [
//             'usia' => $usia_val,
//             'jk' => $jk_val,
//             'imt' => $imt_val,
//             'td' => $td_val,
//             'hipertensi' => $hipertensi_val,
//             'kardiovaskular' => $kardiovaskular_val,
//             'aktivitas' => $aktivitas_val,
//             'gd' => $gd_val,
//         ],
//         'label_dataset' => $exactMatchLabel
//     ]);
//     $hasil = $exactMatchLabel;
// } else {
//     dd([
//         'status' => 'Tidak ada exact match',
//         'input' => [
//             'usia' => $usia_val,
//             'jk' => $jk_val,
//             'imt' => $imt_val,
//             'td' => $td_val,
//             'hipertensi' => $hipertensi_val,
//             'kardiovaskular' => $kardiovaskular_val,
//             'aktivitas' => $aktivitas_val,
//             'gd' => $gd_val,
//         ],
//         'lanjut_naive_bayes' => true
//     ]);
// }


        // Simpan ke DB
        Deteksi::create([
            'nama' => $validated['nama'],
            'usia' => $usia_asli,
            'usia_val' => $usia_val,
            'jenis_kelamin' => $validated['jenis_kelamin'], // input asli
            'jk_val' => $jk_val,
            'telepon' => $validated['telepon'],
            'aktivitas' => $validated['aktivitas'], // input asli
            'aktivitas_val' => $aktivitas_val,
            'imt' => $validated['imt'],
            'imt_val' => $imt_val,
            'tekanan_darah' => $validated['tekanan_darah'],
            'td_val' => $td_val,
            'hipertensi' => $validated['hipertensi'], // input asli
            'hipertensi_val' => $hipertensi_val,
            'gula_darah' => $validated['gula_darah'], // input asli
            'gula_darah_val' => $gd_val,
            'kardiovaskular' => $validated['kardiovaskular'], // input asli
            'kardio_val' => $kardiovaskular_val,
            'hasil' => $hasil
        ]);


        return redirect()->route('hasil')->with('success', "Data berhasil disimpan! Hasil deteksi: $hasil");
    }
}
