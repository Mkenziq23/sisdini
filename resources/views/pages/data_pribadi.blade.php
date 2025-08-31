@extends('layouts.app')

@section('title', 'Deteksi')

@section('content')
    <div class="home">
        <!-- HERO SECTION -->
        <section class="hero">
            <div class="hero-content">
                <div class="hero-text">
                    <h1>Deteksi Dini Diabetes Mellitus</h1>
                    <p>Sistem ini membantu Anda mendeteksi risiko diabetes mellitus secara dini melalui analisis faktor
                        risiko.</p>
                    <div class="hero-buttons">
                        <a href="{{ route('data-pribadi') }}" class="btn-primary">Mulai Deteksi</a>
                        <a href="#" class="btn-outline">Pelajari Lebih Lanjut</a>
                    </div>
                </div>
                <div class="hero-image">
                    <img src="{{ asset('img/desain-interface-sistem-deteksi-dini-diabetes-mellitus-1.png') }}"
                        alt="Tes Gula Darah">
                </div>
            </div>
        </section>

        <form action="{{ route('deteksi.store') }}" method="POST">
            @csrf
            {{-- Step 1 --}}
            <section class="detail-pribadi" id="step-1">
                <div class="detail-header">
                    <span>Progres</span>
                    <span class="progress-count" id="progress-text">1/3</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" id="progress-fill" style="width: 33%;"></div>
                </div>

                <h2 class="form-title">Detail Pribadi</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama">
                    </div>

                    <div class="form-group">
                        <label for="usia" class="font-weight-bold">Usia</label>
                        <input type="number" name="usia" id="usia" class="form-control"
                            placeholder="Masukkan usia (tahun)" required>

                        <!-- Hasil kategori usia (hanya tampilan, tidak masuk database) -->
                        <div id="kategori-box" class="mt-3" style="display: none;">
                            <div class="alert" id="kategori-usia" role="alert"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin">
                            <option value="">Pilih</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nomor Telepon</label>
                        <input type="tel" name="telepon">
                    </div>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn-primary-next" id="next-btn-1">Selanjutnya</button>
                </div>
            </section>

            {{-- Step 2 --}}
            <section class="detail-pribadi" id="step-2" style="display:none;">
                <div class="detail-header">
                    <span>Progres</span>
                    <span class="progress-count" id="progress-text-2">2/3</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 66%;"></div>
                </div>

                <h2 class="form-title">Pengukuran Fisik</h2>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Aktivitas</label>
                        <select name="aktivitas" required>
                            <option value="">-- Pilih Aktivitas --</option>
                            <option value="cukup">Cukup</option>
                            <option value="kurang">Kurang</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tinggi Badan (cm)</label>
                        <input type="number" step="0.1" name="tinggi_badan" id="tinggi_badan"
                            placeholder="contoh: 170">
                    </div>
                    <div class="form-group">
                        <label>Berat Badan (kg)</label>
                        <input type="number" step="0.1" name="berat_badan" id="berat_badan" placeholder="contoh: 65">
                    </div>
                    <div class="form-group">
                        <label>Index Massa Tubuh</label>
                        <input type="number" step="0.01" name="imt" id="imt" readonly>
                    </div>
                    <div class="form-group">
                        <label>Tekanan Darah (mmHg)</label>
                        <input type="text" name="tekanan_darah" placeholder="contoh: 150/90">
                    </div>
                </div>

                <div class="form-actions" style="justify-content: space-between;">
                    <button type="button" class="btn-secondary" id="prev-btn-2">Sebelumnya</button>
                    <button type="button" class="btn-primary-next" id="next-btn-2">Selanjutnya</button>
                </div>
            </section>

            {{-- Step 3 --}}
            <section class="detail-pribadi" id="step-3" style="display:none;">
                <div class="detail-header">
                    <span>Progres</span>
                    <span class="progress-count">3/3</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 100%;"></div>
                </div>

                <h2 class="form-title">Riwayat Kesehatan</h2>
                <div class="form-grid">
                    <!-- Pertanyaan 1 -->
                    <div class="form-group">
                        <label>Apakah Anda pernah didiagnosis memiliki tekanan darah tinggi (Hipertensi)?</label>
                        <div class="radio-group">
                            <label><input type="radio" name="hipertensi" value="Ya"> Ya</label>
                            <label><input type="radio" name="hipertensi" value="Tidak"> Tidak</label>
                        </div>
                    </div>

                    <!-- Hasil Laboratorium -->
                    <div class="form-group">
                        <label>Gula Darah</label>
                        <input type="number" name="gula_darah" placeholder="Gula darah (mg/dL)" min="0">
                        <small class="form-text text-muted">
                            Masukkan hasil pemeriksaan gula darah dalam satuan mg/dL.
                            Nilai normal biasanya berkisar antara <strong>70–140 mg/dL</strong>.
                            Konsultasikan ke dokter jika hasil jauh di luar rentang normal.
                        </small>
                    </div>

                    <!-- Pertanyaan 2 -->
                    <div class="form-group">
                        <label>Apakah Anda pernah didiagnosis memiliki penyakit jantung (Kardiovaskular)?</label>
                        <div class="radio-group">
                            <label><input type="radio" name="kardiovaskular" value="Ya"> Ya</label>
                            <label><input type="radio" name="kardiovaskular" value="Tidak"> Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="form-actions" style="justify-content: space-between;">
                    <button type="button" class="btn-secondary" id="prev-btn-3">Sebelumnya</button>
                    <button type="submit" class="btn-primary-next">Lihat Hasil</button>
                </div>
            </section>
        </form>


        <!-- INFO CARDS -->
        <section class="cards-container">
            <div class="box">
                <div class="overlap-group">
                    <div class="rectangle-wrapper">
                        <div class="rectangle"></div>
                    </div>
                    <div class="text-wrapper">Apa itu Diabetes?</div>
                    <p class="description">
                        Diabetes mellitus adalah kondisi kronis yang ditandai dengan kadar gula darah tinggi karena
                        tubuh
                        tidak dapat memproduksi atau menggunakan insulin dengan baik.
                    </p>
                    <div class="learn-link">
                        Pelajari lebih lanjut
                        <img class="vector" src="{{ asset('img/row.png') }}" alt="arrow" />
                    </div>
                </div>
            </div>

            <div class="box">
                <div class="overlap-group">
                    <div class="rectangle-wrapper">
                        <div class="rectangle"></div>
                    </div>
                    <div class="text-wrapper">Faktor Risiko</div>
                    <ul class="description">
                        <li>Kelebihan berat badan</li>
                        <li>Tensi darah tinggi</li>
                        <li>Kadar gula darah tinggi</li>
                    </ul>
                    <div class="learn-link">
                        Pelajari lebih lanjut
                        <img class="vector" src="{{ asset('img/row.png') }}" alt="arrow" />
                    </div>
                </div>
            </div>

            <div class="box">
                <div class="overlap-group">
                    <div class="rectangle-wrapper">
                        <div class="rectangle"></div>
                    </div>
                    <div class="text-wrapper">Pencegahan</div>
                    <ul class="description">
                        <li>Pola makan sehat</li>
                        <li>Olahraga secara teratur</li>
                        <li>Pemeriksaan rutin</li>
                    </ul>
                    <div class="learn-link">
                        Pelajari lebih lanjut
                        <img class="vector" src="{{ asset('img/row.png') }}" alt="arrow" />
                    </div>
                </div>
            </div>
        </section>
    </div>


    <script>
        document.getElementById('usia').addEventListener('input', function() {
            let usia = parseInt(this.value);
            let kategori = '';
            let warna = 'alert-secondary'; // default warna

            if (isNaN(usia) || usia <= 0) {
                document.getElementById('kategori-box').style.display = 'none';
                return;
            } else if (usia < 18) {
                kategori = 'Anak-anak / Remaja';
                warna = 'alert-info';
            } else if (usia >= 18 && usia <= 40) {
                kategori = 'Dewasa Awal';
                warna = 'alert-success';
            } else if (usia >= 41 && usia <= 59) {
                kategori = 'Dewasa Akhir';
                warna = 'alert-primary';
            } else if (usia >= 60 && usia <= 74) {
                kategori = 'Lansia Awal';
                warna = 'alert-warning';
            } else if (usia >= 75 && usia <= 90) {
                kategori = 'Lansia Akhir';
                warna = 'alert-danger';
            } else if (usia > 90) {
                kategori = 'Manula';
                warna = 'alert-dark';
            }

            let kategoriBox = document.getElementById('kategori-box');
            let kategoriUsia = document.getElementById('kategori-usia');

            kategoriBox.style.display = 'block';
            kategoriUsia.textContent = kategori;
            kategoriUsia.className = `alert ${warna}`;
        });

        document.addEventListener("DOMContentLoaded", function() {
            const tinggiInput = document.getElementById("tinggi_badan");
            const beratInput = document.getElementById("berat_badan");
            const imtInput = document.getElementById("imt");

            function hitungIMT() {
                let tinggi = parseFloat(tinggiInput.value);
                let berat = parseFloat(beratInput.value);

                if (!isNaN(tinggi) && !isNaN(berat) && tinggi > 0) {
                    let tinggiMeter = tinggi / 100;
                    let imt = berat / (tinggiMeter * tinggiMeter);
                    imtInput.value = imt.toFixed(2);
                } else {
                    imtInput.value = "";
                }
            }

            tinggiInput.addEventListener("input", hitungIMT);
            beratInput.addEventListener("input", hitungIMT);
        });
    </script>
@endsection
