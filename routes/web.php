<?php

use App\Http\Controllers\DataPribadiController;
use App\Http\Controllers\DeteksiController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('Data-Pribadi', [DataPribadiController::class, 'index'])->name('data-pribadi');
Route::get('hasil', [DeteksiController::class, 'index'])->name('hasil');
Route::post('deteksi', [DeteksiController::class, 'store'])->name('deteksi.store');
