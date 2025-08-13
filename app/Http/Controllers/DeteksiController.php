<?php

namespace App\Http\Controllers;

use App\Models\Deteksi;
use Illuminate\Http\Request;

class DeteksiController extends Controller
{

    public function index()
    {
        return view('pages.hasil');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'usia' => 'required|integer',
            'jenis_kelamin' => 'required|string',
            'telepon' => 'nullable|string',
            'berat_badan' => 'nullable|numeric',
            'tinggi_badan' => 'nullable|numeric',
            'imt' => 'nullable|numeric',
            'sistol' => 'nullable|numeric',
            'diastol' => 'nullable|numeric',
            'hipertensi' => 'nullable|string',
            'gula_darah' => 'nullable|numeric',
            'kardiovaskular' => 'nullable|string',
        ]);

        Deteksi::create($validated);

        return redirect()->route('hasil')->with('success', 'Data berhasil disimpan!');
    }
}
