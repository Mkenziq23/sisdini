 @extends('layouts.app')

 @section('title', 'Hasil')

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

         <section class="hasil">
             <!-- Gambar di atas judul -->
             <div class="hasil-icon">
                 <img src="{{ asset('img/checkhasil.png') }}" alt="Check Hasil">
             </div>

             <h2 class="hasil-title">Hasil Deteksi Dini</h2>

             <!-- Tingkat Risiko -->
             <div class="risiko-section">
                 <div class="risiko-header">
                     <span class="label">Tingkat Risiko</span>
                     <span class="status">Tidak Berisiko</span>
                     <span class="status">Berisiko</span>
                 </div>
                 <div class="progress-bar">
                     @php
                         // Tentukan lebar dan warna berdasarkan hasil
                         if (strtolower(trim($latest->hasil)) === 'tidak berisiko') {
                             $width = '50%'; // Tengah
                             $color = '#27ae60'; // Hijau
                         } elseif (strtolower(trim($latest->hasil)) === 'berisiko') {
                             $width = '100%'; // Penuh
                             $color = '#e74c3c'; // Merah
                         } else {
                             // default fallback
                             $width = '0%';
                             $color = '#ccc';
                         }
                     @endphp
                     <div class="progress-fill-hasil"
                         style="width: {{ $width }}; background-color: {{ $color }};"></div>
                 </div>
             </div>

             <!-- Deskripsi -->
             <p class="hasil-desc">
                 Berdasarkan informasi yang Anda berikan, Anda memiliki beberapa faktor risiko untuk diabetes mellitus.
                 Ini bukan diagnosis, tetapi indikasi bahwa Anda perlu memperhatikan kesehatan Anda.
             </p>

             <!-- Peringatan -->
             <div class="peringatan">
                 <img src="{{ asset('img/warningblue.png') }}" alt="Info Icon" class="icon-info">
                 <span>Hasil ini bukan pengganti konsultasi medis profesional. Silakan konsultasikan dengan dokter untuk
                     evaluasi lebih lanjut.</span>
             </div>

             <!-- Faktor Risiko -->
             <div class="faktor-container">
                 <div class="faktor negatif">
                     <h3>
                         <img src="{{ asset('img/warningblue.png') }}" alt="Warning" class="faktor-icon">
                         Faktor Risiko Teridentifikasi
                     </h3>
                     <ul>
                         <li class="@if ($latest->imt_val == 2) check @else not @endif">
                             Berat badan berlebih
                         </li>
                         <li
                             class="
                            @if ($latest->td_val == 1) warning
                            @elseif($latest->td_val == 2 || $latest->td_val == 3) check
                            @else not @endif">
                             Tekanan darah tinggi
                         </li>
                         <li class="@if ($latest->kardio_val == 1) check @else not @endif">
                             Riwayat penyakit kardiovaskuler
                         </li>
                     </ul>

                 </div>

                 <div class="faktor positif">
                     <h3>
                         <img src="{{ asset('img/warningblue.png') }}" alt="Warning" class="faktor-icon">
                         Faktor Risiko Teridentifikasi
                     </h3>
                     <ul>
                         <li class="@if ($latest->imt_val == 2) check @else not @endif">
                             Konsultasikan dengan dokter untuk pemeriksaan lebih lanjut
                         </li>
                         <li
                             class="
                            @if ($latest->td_val == 1) warning
                            @elseif($latest->td_val == 2 || $latest->td_val == 3) check
                            @else not @endif">
                             Lakukan pemeriksaan gula darah secara berkala
                         </li>
                         <li>
                         <li class="@if ($latest->kardio_val == 1) check @else not @endif">
                             Perbaiki pola makan dengan mengurangi gula dan karbohidrat olahan
                         </li>
                     </ul>
                 </div>
             </div>

             <!-- Tombol Aksi -->
             <div class="hasil-actions">
                 <a href="{{ route('hasil.cetak') }}" target="_blank" class="btn-primary-hasil">
                     <img src="{{ asset('img/iconprint.png') }}" alt="Cetak" class="btn-icon">
                     Cetak Hasil
                 </a>
                 <a href="{{ route('data-pribadi') }}" class="btn-secondary-hasil">
                     <img src="{{ asset('img/iconloop.png') }}" alt="Mulai Ulang" class="btn-icon">
                     Mulai Ulang
                 </a>
             </div>
         </section>


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
