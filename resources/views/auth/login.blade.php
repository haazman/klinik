<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Klinik Bidan Yulis Setiawan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .glass-effect {
            backdrop-filter: blur(16px) saturate(180%);
            background-color: rgba(255, 255, 255, 0.75);
            border: 1px solid rgba(209, 213, 219, 0.3);
        }
        .hero-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="min-h-screen gradient-bg hero-pattern">
    <div class="min-h-screen flex">
        <!-- Left Side - Information Panel -->
        <div class="hidden lg:flex lg:w-1/2 flex-col justify-center px-12 text-white">
            <div class="max-w-md mx-auto">
                <!-- Logo & Title -->
                <div class="text-center mb-12">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <i class="fas fa-heartbeat text-3xl text-blue-600"></i>
                    </div>
                    <h1 class="text-4xl font-bold mb-2">Klinik Bidan Yulis Setiawan</h1>
                    <p class="text-xl text-blue-100">Solusi Kesehatan Digital</p>
                </div>

                <!-- Features -->
                <div class="space-y-6">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-md text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Manajemen Dokter</h3>
                            <p class="text-blue-100">Kelola jadwal dan praktik dokter dengan mudah</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar-check text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Booking Online</h3>
                            <p class="text-blue-100">Reservasi janji temu kapan saja, dimana saja</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-prescription-bottle-alt text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Manajemen Obat</h3>
                            <p class="text-blue-100">Kelola stok dan resep obat secara digital</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-chart-line text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Laporan Digital</h3>
                            <p class="text-blue-100">Dashboard dan analitik kesehatan real-time</p>
                        </div>
                    </div>
                </div>

                <!-- Stats -->
                <div class="mt-12 grid grid-cols-3 gap-6 text-center">
                    <div>
                        <div class="text-2xl font-bold">24/7</div>
                        <div class="text-sm text-blue-100">Layanan Online</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold">100%</div>
                        <div class="text-sm text-blue-100">Secure</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold">Easy</div>
                        <div class="text-sm text-blue-100">To Use</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-12">
            <div class="max-w-md w-full">
                <!-- Mobile Logo (visible on small screens) -->
                <div class="lg:hidden text-center mb-8">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <i class="fas fa-heartbeat text-2xl text-blue-600"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-white mb-1">Klinik Bidan Yulis Setiawan</h1>
                    <p class="text-blue-100">Masuk ke akun Anda</p>
                </div>

                <!-- Login Card -->
                <div class="glass-effect rounded-2xl shadow-2xl p-8">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Selamat Datang</h2>
                        <p class="text-gray-600">Masuk untuk mengakses Klinik Bidan Yulis Setiawan</p>
                    </div>

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-red-400"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">Terjadi kesalahan:</h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <ul class="list-disc pl-5 space-y-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Status Message -->
                    @session('status')
                        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle text-green-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-800">{{ $value }}</p>
                                </div>
                            </div>
                        </div>
                    @endsession

                    <!-- Login Form -->
                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-envelope mr-2 text-gray-400"></i>Email Address
                            </label>
                            <input id="email" 
                                   type="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autofocus 
                                   autocomplete="username"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 bg-white bg-opacity-50"
                                   placeholder="Masukkan email Anda">
                        </div>

                        <!-- Password Field -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-lock mr-2 text-gray-400"></i>Password
                            </label>
                            <div class="relative">
                                <input id="password" 
                                       type="password" 
                                       name="password" 
                                       required 
                                       autocomplete="current-password"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 bg-white bg-opacity-50 pr-12"
                                       placeholder="Masukkan password Anda">
                                <button type="button" 
                                        onclick="togglePassword()" 
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <i id="password-icon" class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center justify-between">
                            <label for="remember_me" class="flex items-center">
                                <input id="remember_me" 
                                       type="checkbox" 
                                       name="remember" 
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">Ingat saya</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" 
                                   class="text-sm text-blue-600 hover:text-blue-500 transition duration-200">
                                    Lupa password?
                                </a>
                            @endif
                        </div>

                        <!-- Login Button -->
                        <button type="submit" 
                                class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 font-medium">
                            <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                        </button>
                    </form>

                    <!-- Demo Accounts -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <p class="text-center text-sm text-gray-600 mb-4">Demo Accounts:</p>
                        <div class="grid grid-cols-1 gap-2 text-xs">
                            <div class="bg-blue-50 p-3 rounded-lg">
                                <strong class="text-blue-800">Admin:</strong> 
                                <span class="text-blue-600">admin@klinik.com / admin123</span>
                            </div>
                            <div class="bg-green-50 p-3 rounded-lg">
                                <strong class="text-green-800">Dokter:</strong> 
                                <span class="text-green-600">doctor@klinik.com / doctor123</span>
                            </div>
                            <div class="bg-purple-50 p-3 rounded-lg">
                                <strong class="text-purple-800">Pasien:</strong> 
                                <span class="text-purple-600">patient@klinik.com / patient123</span>
                            </div>
                        </div>
                    </div>

                    <!-- Register Link -->
                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-600">
                            Belum punya akun? 
                            <a href="{{ route('register') }}" 
                               class="text-blue-600 hover:text-blue-500 font-medium transition duration-200">
                                Daftar sekarang
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const passwordIcon = document.getElementById('password-icon');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }

        // Auto-fill demo accounts
        function fillDemo(role) {
            const emailField = document.getElementById('email');
            const passwordField = document.getElementById('password');
            
            switch(role) {
                case 'admin':
                    emailField.value = 'admin@klinik.com';
                    passwordField.value = 'admin123';
                    break;
                case 'doctor':
                    emailField.value = 'doctor@klinik.com';
                    passwordField.value = 'doctor123';
                    break;
                case 'patient':
                    emailField.value = 'patient@klinik.com';
                    passwordField.value = 'patient123';
                    break;
            }
        }

        // Add click handlers to demo accounts
        document.addEventListener('DOMContentLoaded', function() {
            const demoBoxes = document.querySelectorAll('.bg-blue-50, .bg-green-50, .bg-purple-50');
            demoBoxes.forEach((box, index) => {
                box.style.cursor = 'pointer';
                box.addEventListener('click', function() {
                    const roles = ['admin', 'doctor', 'patient'];
                    fillDemo(roles[index]);
                });
            });
        });
    </script>
</body>
</html>
