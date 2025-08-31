@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <div class="auth-page">
        <div class="auth-container">
            <div class="auth-header">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" width="50" height="50">
                <div class="brand-text-auth">
                    <span class="brand-name-auth">SISDINI</span>
                    <small class="brand-tagline-auth">Sistem Deteksi Dini Diabetes Mellitus</small>
                </div>
            </div>

            <h2>Daftar Akun</h2>

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" required placeholder="Masukkan nama lengkap">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required placeholder="Masukkan email">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required placeholder="Masukkan password">
                </div>
                <div class="form-group">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required placeholder="Ulangi password">
                </div>
                <button type="submit" class="btn-primary-auth">Daftar</button>
            </form>

            <!-- Role tersembunyi -->
            <input type="hidden" name="role" value="user">

            <p class="auth-footer">
                Sudah punya akun? <a href="{{ route('login') }}">Login Sekarang</a>
            </p>
        </div>
    </div>
@endsection
