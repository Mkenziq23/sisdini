@extends('layouts.app')

@section('content')
    <div class="container my-5" style="margin-bottom: 200px">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-5">
                <!-- Judul -->
                <h2 class="fw-bold mb-3 text-primary text-center">
                    <i class="bi bi-info-circle-fill me-2"></i> Tentang Aplikasi
                </h2>
                <p class="text-muted text-center mb-4" style="font-size: 1.05rem">
                    Aplikasi ini dirancang untuk membantu <strong>mendeteksi faktor risiko kesehatan</strong> berdasarkan
                    data yang dimasukkan pengguna, sehingga hasil yang diperoleh lebih jelas dan mudah dipahami.
                </p>

                <hr class="my-4">

                <!-- Fitur Utama -->
                <h5 class="fw-bold text-secondary mb-3 text-center">
                    <i class="bi bi-stars me-2"></i> Fitur Utama
                </h5>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="p-3 border rounded-3 bg-light d-flex align-items-center">
                            <i class="bi bi-activity text-success fs-3 me-3"></i>
                            <span>Deteksi faktor risiko kesehatan secara cepat</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 border rounded-3 bg-light d-flex align-items-center">
                            <i class="bi bi-gear-wide-connected text-primary fs-3 me-3"></i>
                            <span>Analisis hasil secara akurat</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 border rounded-3 bg-light d-flex align-items-center">
                            <i class="bi bi-lightbulb-fill text-warning fs-3 me-3"></i>
                            <span>Rekomendasi hasil yang mudah dipahami</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 border rounded-3 bg-light d-flex align-items-center">
                            <i class="bi bi-file-earmark-pdf-fill text-danger fs-3 me-3"></i>
                            <span>Laporan hasil dapat dicetak dalam format PDF</span>
                        </div>
                    </div>
                </div>

                <hr class="my-5">

                <!-- Tujuan Aplikasi -->
                <div class="text-center">
                    <h5 class="fw-bold text-secondary mb-3">
                        <i class="bi bi-flag-fill me-2"></i> Tujuan Aplikasi
                    </h5>
                    <p class="text-muted mb-0" style="font-size: 1.05rem">
                        Aplikasi ini bertujuan untuk membantu pengguna memahami kondisi kesehatannya,
                        mengidentifikasi faktor risiko secara cepat, dan memberikan panduan sederhana
                        agar dapat mengambil langkah pencegahan yang tepat.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
