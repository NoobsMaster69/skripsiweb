<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Luaran | Login</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('sb-admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('sb-admin/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            min-height: 100vh;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .login-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 450px;
            width: 100%;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            color: white;
            padding: 2.5rem 2rem;
            text-align: center;
        }

        .logo-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            backdrop-filter: blur(10px);
        }

        .logo-icon i {
            font-size: 1.8rem;
            color: white;
        }

        .login-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .login-subtitle {
            opacity: 0.9;
            font-size: 0.95rem;
            font-weight: 300;
        }

        .login-body {
            padding: 2.5rem 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-control-custom {
            border: 2px solid #e3e6f0;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fc;
        }

        .form-control-custom:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.1);
            background: white;
        }

        .form-control-custom.is-invalid {
            border-color: #e74c3c;
        }

        .btn-login {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            border: none;
            border-radius: 12px;
            color: white;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(78, 115, 223, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 115, 223, 0.4);
            background: linear-gradient(135deg, #224abe 0%, #1e3a8a 100%);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .error-message {
            color: #e74c3c;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .login-footer {
            background: #f8f9fc;
            padding: 1.5rem 2rem;
            text-align: center;
            border-top: 1px solid #e3e6f0;
        }

        .login-footer a {
            color: #4e73df;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .login-footer a:hover {
            color: #224abe;
            text-decoration: underline;
        }

        /* Simple loading animation */
        .btn-loading {
            pointer-events: none;
            opacity: 0.8;
        }

        @media (max-width: 768px) {
            .login-header {
                padding: 2rem 1.5rem;
            }

            .login-body {
                padding: 2rem 1.5rem;
            }

            .login-title {
                font-size: 1.6rem;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-card">
            <!-- Header -->
            <div class="login-header">
                <div class="logo-icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <h1 class="login-title">Luaran</h1>
                <p class="login-subtitle">Sistem Informasi Luaran Akademik</p>
            </div>

            <!-- Body -->
            <div class="login-body">
                <form method="POST" action="{{ route('loginProses') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="text-gray-700 font-weight-600 mb-2">Email</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            placeholder="Masukkan email Anda"
                            class="form-control form-control-custom @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            required
                        >
                        @error('email')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="text-gray-700 font-weight-600 mb-2">Password</label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="Masukkan password Anda"
                            class="form-control form-control-custom @error('password') is-invalid @enderror"
                            required
                        >
                        @error('password')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-login" id="loginBtn">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Masuk
                    </button>
                </form>
            </div>

            <!-- Footer -->
            <div class="login-footer">
                <small class="text-muted">
                    <i class="fas fa-home mr-1"></i>
                    Kembali ke
                    <a href="{{ route('welcome') }}">Beranda</a>
                </small>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('sb-admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('sb-admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('sb-admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('sb-admin/js/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('sweetalert2/dist/sweetalert2.all.min.js') }}"></script>

    <script>
        // Simple loading state
        document.querySelector('form').addEventListener('submit', function() {
            const btn = document.getElementById('loginBtn');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
            btn.classList.add('btn-loading');
        });

        // SweetAlert notifications
        @if (session('success'))
            Swal.fire({
                title: "Berhasil!",
                text: "{{ session('success') }}",
                icon: "success",
                confirmButtonColor: '#4e73df',
                timer: 3000,
                timerProgressBar: true
            });
        @endif

        @if (session('error'))
            Swal.fire({
                title: "Gagal!",
                text: "{{ session('error') }}",
                icon: "error",
                confirmButtonColor: '#e74c3c'
            });
        @endif
    </script>
</body>

</html>
