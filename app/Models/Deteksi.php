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
        'jenis_kelamin',
        'telepon',
        'berat_badan',
        'tinggi_badan',
        'imt',
        'sistol',
        'diastol',
        'hipertensi',
        'gula_darah',
        'kardiovaskular',
    ];
}
