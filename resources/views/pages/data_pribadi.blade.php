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
                        <a href="link-yang-dituju" class="btn-outline">Pelajari Lebih Lanjut</a>
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
                        <label>Usia</label>
                        <input type="number" name="usia">
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
                        <label>Berat Badan (kg)</label>
                        <input type="number" name="berat_badan">
                    </div>
                    <div class="form-group">
                        <label>Tinggi Badan (cm)</label>
                        <input type="number" name="tinggi_badan">
                    </div>
                    <div class="form-group">
                        <label>Index Massa Tubuh</label>
                        <input type="number" step="0.01" name="imt">
                    </div>
                    <div class="form-group">
                        <label>Tekanan Darah (mmHg)</label>
                        <div class="blood-pressure-group">
                            <input type="number" name="sistol" placeholder="Sistol">
                            <input type="number" name="diastol" placeholder="Diastol">
                        </div>
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
                        <label>Hasil Laboratorium Terbaru</label>
                        <input type="number" name="gula_darah" placeholder="Gula darah acak (mg/dL)">
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

@endsection
