<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
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
Route::get('hasil/cetak', [DeteksiController::class, 'cetak'])->name('hasil.cetak');
Route::get('hasil/download', [DeteksiController::class, 'download'])->name('hasil.download');


Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);

Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::post('register', [AuthController::class, 'register']);

Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin,dokter'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/hasil-deteksi', [DashboardController::class, 'HasilDeteksi'])->name('hasil-deteksi');
    Route::delete('/hasil-deteksi/{id}', [DashboardController::class, 'deleteHasil'])->name('hasil-deteksi.delete');
    Route::get('/kelola-akun', [DashboardController::class, 'KelolaAkun'])->name('kelola-akun');
    Route::get('/kelola-akun/create', [DashboardController::class, 'CreateAkun'])->name('kelola-akun.create');
    Route::post('/kelola-akun/store', [DashboardController::class, 'StoreAkun'])->name('kelola-akun.store');
    Route::get('/kelola-akun/{id}/edit', [DashboardController::class, 'EditAkun'])->name('kelola-akun.edit');
    Route::put('/kelola-akun/{id}', [DashboardController::class, 'UpdateAkun'])->name('kelola-akun.update');
    Route::delete('/kelola-akun/{id}', [DashboardController::class, 'DeleteAkun'])->name('kelola-akun.delete');
});

