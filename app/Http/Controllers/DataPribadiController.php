<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataPribadiController extends Controller
{
     public function index()
    {
        // Menampilkan halaman home
        return view('pages.data_pribadi');
    }
}
