@extends('layouts.app')

@section('title', 'Login')

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

            <h2>Login</h2>

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required placeholder="Masukkan email">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required placeholder="Masukkan password">
                </div>
                <button type="submit" class="btn-primary-auth">Login</button>
            </form>

            <p class="auth-footer">
                Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
            </p>
        </div>
    </div>
@endsection
