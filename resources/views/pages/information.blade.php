@extends('layouts.app')

@section('content')
    <div class="container my-5" style="margin-bottom: 200px">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-5">
                <!-- Judul -->
                <h2 class="fw-bold mb-3 text-primary text-center">
                    <i class="bi bi-info-square-fill me-2"></i> Informasi
                </h2>
                <p class="text-muted text-center mb-4" style="font-size: 1.05rem">
                    Halaman ini berisi informasi penting seputar kesehatan dan panduan penggunaan aplikasi untuk membantu
                    pengguna memahami kondisi kesehatannya secara lebih baik.
                </p>

                <hr class="my-4">

                <!-- Informasi Penting -->
                <h5 class="fw-bold text-secondary mb-3 text-center">
                    <i class="bi bi-exclamation-circle-fill me-2"></i> Tips & Panduan
                </h5>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="p-3 border rounded-3 bg-light d-flex align-items-center">
                            <i class="bi bi-heart-fill text-danger fs-3 me-3"></i>
                            <span>Jaga pola makan sehat dan seimbang setiap hari</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 border rounded-3 bg-light d-flex align-items-center">
                            <i class="bi bi-clock-fill text-warning fs-3 me-3"></i>
                            <span>Lakukan olahraga ringan secara rutin untuk kesehatan jantung</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 border rounded-3 bg-light d-flex align-items-center">
                            <i class="bi bi-droplet-fill text-primary fs-3 me-3"></i>
                            <span>Cukup minum air putih setiap hari untuk menjaga hidrasi</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 border rounded-3 bg-light d-flex align-items-center">
                            <i class="bi bi-person-check-fill text-success fs-3 me-3"></i>
                            <span>Periksa kondisi kesehatan secara berkala ke tenaga medis profesional</span>
                        </div>
                    </div>
                </div>

                <hr class="my-5">

                <!-- Panduan Menggunakan Aplikasi -->
                <div class="text-center">
                    <h5 class="fw-bold text-secondary mb-3">
                        <i class="bi bi-gear-fill me-2"></i> Cara Menggunakan Aplikasi
                    </h5>
                    <p class="text-muted mb-2" style="font-size: 1.05rem">
                        1. Klik tombol "Deteksi" pada halaman beranda untuk analisis.
                    </p>
                    <p class="text-muted mb-2" style="font-size: 1.05rem">
                        2. Masukkan data diri dan kesehatan dengan lengkap.
                    </p>
                    <p class="text-muted mb-2" style="font-size: 1.05rem">
                        3. Periksa hasil yang muncul dan ikuti rekomendasi atau tips yang diberikan.
                    </p>
                    <p class="text-muted mb-0" style="font-size: 1.05rem">
                        4. Hasil dapat dicetak dalam format PDF untuk arsip pribadi atau dibagikan.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
