@extends('layouts.app')

@section('title', 'Home')

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


        <!-- INFO CARDS -->
        <section class="cards-container">
            <div class="box">
                <div class="overlap-group">
                    <div class="rectangle-wrapper">
                        <div class="rectangle"></div>
                    </div>
                    <div class="text-wrapper">Apa itu Diabetes?</div>
                    <p class="description">
                        Diabetes mellitus adalah kondisi kronis yang ditandai dengan kadar gula darah tinggi karena tubuh
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
