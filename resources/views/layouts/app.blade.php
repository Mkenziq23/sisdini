<!DOCTYPE html>
<html lang="id">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <title>@yield('title', 'SISDINI')</title>
    <link rel="stylesheet" href="{{ asset('css/globals.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    @stack('styles')
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <!-- Logo dan Brand -->
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" width="50" height="50">
                <div class="brand-text">
                    <span class="brand-name">SISDINI</span>
                    <small class="brand-tagline">Sistem Deteksi Dini Diabetes Mellitus</small>
                </div>
            </a>

            <!-- Tombol Toggle Mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon">
                    <div></div>
                </span>
            </button>

            <!-- Menu -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="#">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Informasi</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Kontak</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="home">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Tempat push script dari halaman lain --}}
    @stack('scripts')
    {{-- <script>
        // Step 1 -> Step 2
        document.getElementById('next-btn-1').addEventListener('click', function() {
            document.getElementById('step-1').style.display = 'none';
            document.getElementById('step-2').style.display = 'block';
        });

        // Step 2 -> Step 1
        document.getElementById('prev-btn-2').addEventListener('click', function() {
            document.getElementById('step-2').style.display = 'none';
            document.getElementById('step-1').style.display = 'block';
        });

        // Step 2 -> Step 3
        document.getElementById('next-btn-2').addEventListener('click', function() {
            document.getElementById('step-2').style.display = 'none';
            document.getElementById('step-3').style.display = 'block';
        });

        // Step 3 -> Step 2
        document.getElementById('prev-btn-3').addEventListener('click', function() {
            document.getElementById('step-3').style.display = 'none';
            document.getElementById('step-2').style.display = 'block';
        });
    </script> --}}

    <script>
        const totalSteps = 3;
        let currentStep = 1;

        function showStep(step, direction = 'next') {
            const steps = document.querySelectorAll('.detail-pribadi');
            const activeStep = document.querySelector(`#step-${currentStep}`);
            const nextStep = document.querySelector(`#step-${step}`);

            // Animasikan step yang keluar
            if (direction === 'next') {
                activeStep.classList.add('slide-out-left');
            } else {
                activeStep.classList.add('slide-out-right');
            }

            setTimeout(() => {
                // Sembunyikan semua step
                steps.forEach(s => {
                    s.classList.remove('active', 'slide-out-left', 'slide-out-right');
                    s.style.display = 'none';
                });

                // Tampilkan step berikutnya
                nextStep.style.display = 'block';
                setTimeout(() => {
                    nextStep.classList.add('active');
                }, 10);

                // Update currentStep
                currentStep = step;

                // Update progress bar
                const progressFill = document.querySelector('#progress-fill') || document.querySelector(
                    '.progress-fill');
                const progressTexts = document.querySelectorAll('.progress-count');
                const progressPercent = (step / totalSteps) * 100;
                progressFill.style.width = progressPercent + '%';

                progressTexts.forEach(pt => pt.textContent = `${step}/${totalSteps}`);
            }, 300);
        }

        // Event listeners
        document.getElementById('next-btn-1').addEventListener('click', function() {
            showStep(2, 'next');
        });

        document.getElementById('next-btn-2').addEventListener('click', function() {
            showStep(3, 'next');
        });

        document.getElementById('prev-btn-2').addEventListener('click', function() {
            showStep(1, 'prev');
        });

        document.getElementById('prev-btn-3').addEventListener('click', function() {
            showStep(2, 'prev');
        });

        // Tampilkan step awal
        document.getElementById('step-1').style.display = 'block';
        setTimeout(() => {
            document.getElementById('step-1').classList.add('active');
        }, 10);
    </script>




</body>

</html>
