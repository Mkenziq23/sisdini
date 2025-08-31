@extends('layouts.app')

@section('content')
    <div class="container my-5" style="margin-bottom: 200px">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-5">
                <!-- Judul -->
                <h2 class="fw-bold mb-3 text-primary text-center">
                    <i class="bi bi-envelope-fill me-2"></i> Kontak
                </h2>
                <p class="text-muted text-center mb-4" style="font-size: 1.05rem">
                    Jika Anda memiliki pertanyaan, saran, atau ingin berkomunikasi dengan kami, silakan isi form berikut
                    atau gunakan informasi kontak yang tersedia.
                </p>

                <hr class="my-4">

                <div class="row">
                    <!-- Form Kontak -->
                    <div class="col-md-7">
                        <form action="{{ route('contactStore') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama"
                                    placeholder="Masukkan nama Anda" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Masukkan email Anda" required>
                            </div>
                            <div class="mb-3">
                                <label for="subjek" class="form-label">Subjek</label>
                                <input type="text" class="form-control" id="subjek" name="subjek"
                                    placeholder="Judul pesan" required>
                            </div>
                            <div class="mb-3">
                                <label for="pesan" class="form-label">Pesan</label>
                                <textarea class="form-control" id="pesan" name="pesan" rows="5" placeholder="Tulis pesan Anda di sini..."
                                    required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Kirim Pesan</button>
                        </form>
                    </div>

                    <!-- Info Kontak -->
                    <div class="col-md-5">
                        <div class="p-4 border rounded-3 bg-light">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-telephone-fill me-2"></i> Informasi Kontak
                            </h5>
                            <p class="mb-2"><i class="bi bi-envelope-fill me-2"></i> email@example.com</p>
                            <p class="mb-2"><i class="bi bi-telephone-fill me-2"></i> +62 812-3456-7890</p>
                            <p class="mb-2"><i class="bi bi-geo-alt-fill me-2"></i> Jember, Jawa Timur, Indonesia</p>
                            <hr>
                            <h6 class="fw-bold mb-2">Jam Operasional</h6>
                            <p class="mb-0">Senin - Jumat: 08:00 - 17:00</p>
                            <p class="mb-0">Sabtu - Minggu: Libur</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
