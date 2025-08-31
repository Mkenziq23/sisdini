<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('pages.home');
    }
    public function about()
    {
        return view('pages.about');
    }
    public function information()
    {
        return view('pages.information');
    }
    public function contact()
    {
        return view('pages.contact');
    }

    public function contactStore(Request $request){
        
        $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'subjek' => 'required|string|max:255',
        'pesan' => 'required|string',
    ]);

    // Simpan ke database
    Kontak::create($validated);

    return redirect()->route('contact')->with('success', 'Pesan berhasil dikirim!');
    }
}
