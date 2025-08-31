<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deteksi extends Model
{
    use HasFactory;
    
    protected $table = 'deteksi';

    protected $fillable = [
        'nama',
        'usia',
        'usia_val',
        'jenis_kelamin',
        'jk_val',
        'telepon',
        'aktivitas',
        'aktivitas_val',
        'tinggi_badan',
        'berat_badan',
        'imt',
        'imt_val',
        'tekanan_darah',
        'td_val',
        'hipertensi',
        'hipertensi_val',
        'gula_darah',
        'gula_darah_val',
        'kardiovaskular',
        'kardio_val',
        'hasil'
    ];
}

