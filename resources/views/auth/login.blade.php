<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Login - PresenSee</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            'sans': ['Inter', 'system-ui', 'sans-serif'],
                            'heading': ['Inter', 'system-ui', 'sans-serif']
                        },
                        animation: {
                            'fade-in': 'fadeIn 0.6s ease-out',
                            'slide-up': 'slideUp 0.5s ease-out',
                            'float': 'float 6s ease-in-out infinite'
                        },
                        keyframes: {
                            fadeIn: {
                                '0%': { opacity: '0', transform: 'translateY(10px)' },
                                '100%': { opacity: '1', transform: 'translateY(0)' }
                            },
                            slideUp: {
                                '0%': { opacity: '0', transform: 'translateY(20px)' },
                                '100%': { opacity: '1', transform: 'translateY(0)' }
                            },
                            float: {
                                '0%, 100%': { transform: 'translateY(0px)' },
                                '50%': { transform: 'translateY(-10px)' }
                            }
                        }
                    }
                }
            }
        </script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    </head>

    <body class="relative flex items-center justify-center min-h-screen p-4 overflow-hidden font-sans">

        <!-- Background Image -->
        <div class="fixed inset-0 z-0">
            @if (file_exists(public_path('images/lgpages/bg.png')))
                <img src="{{ asset('images/lgpages/bg.png') }}" alt="Background" class="object-cover w-full h-full" />
                <!-- Overlay untuk memberikan efek blur dan darkening -->
                <div class="absolute inset-0 bg-black/20 backdrop-blur-sm"></div>
            @else
                <!-- Fallback gradient background jika gambar tidak ada -->
                <div class="w-full h-full bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100"></div>
            @endif
        </div>

        <!-- Background Decorations -->
        <div class="fixed inset-0 z-10 overflow-hidden pointer-events-none">
            <div class="absolute rounded-full -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-purple-200 to-indigo-200 mix-blend-multiply filter blur-xl opacity-30 animate-float"></div>
            <div class="absolute rounded-full -bottom-40 -left-40 w-80 h-80 bg-gradient-to-br from-orange-200 to-pink-200 mix-blend-multiply filter blur-xl opacity-30 animate-float" style="animation-delay: 2s;"></div>
        </div>

        <!-- Main Container -->
        <div class="relative z-20 w-full max-w-3xl mx-auto sm:max-w-4xl animate-fade-in">

            <!-- Login Card -->
            <div class="overflow-hidden border shadow-2xl bg-white/90 backdrop-blur-xl rounded-3xl border-white/30">
                <div class="grid lg:grid-cols-2 min-h-[350px]">

                    <!-- Left Side - Image/Illustration -->
                    <div class="relative hidden lg:flex bg-gradient-to-br from-indigo-600/90 via-purple-600/90 to-indigo-800/90">

                        <!-- Overlay untuk semua kondisi -->
                        <div class="absolute inset-0 bg-gradient-to-br from-indigo-600/80 via-purple-600/80 to-indigo-800/80"></div>

                        <!-- Content overlay -->
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center text-white animate-slide-up">
                                <div class="flex items-center justify-center w-24 h-24 mx-auto mb-6 rounded-full bg-white/20 backdrop-blur-sm">
                                    <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                    </svg>
                                </div>
                                <h3 class="mb-4 text-3xl font-bold">Selamat Datang!</h3>
                                <p class="max-w-sm mx-auto text-lg leading-relaxed text-indigo-100">
                                    Sistem presensi digital yang memudahkan pengelolaan kehadiran siswa
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side - Login Form -->
                    <div class="flex flex-col justify-center p-4 lg:p-6">

                        <!-- Header -->
                        <div class="mb-6 text-center">
                            <div class="mb-6">
                                <h1 class="mb-2 text-4xl font-bold text-gray-900 font-heading">
                                    Login <span class="font-black text-transparent bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text font-heading">PresenSee</span>
                                </h1>
                                <h2 class="text-xl font-bold text-orange-600 font-heading">SMP Islamiyah Widodaren</h2>
                            </div>
                            <p class="font-sans text-sm font-light text-gray-500">Silakan login untuk mengakses sistem presensi</p>
                        </div>

                        {{-- Success Message --}}
                        @if (session('success'))
                            <div role="alert" class="p-4 mb-6 font-sans border border-green-200 bg-green-50 rounded-xl animate-fade-in">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 text-green-500 shrink-0" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="text-sm font-medium text-green-800">{{ session('success') }}</span>
                                </div>
                            </div>
                        @endif

                        {{-- Error Message --}}
                        @if (session('error'))
                            <div role="alert" class="p-4 mb-6 font-sans border border-red-200 bg-red-50 rounded-xl animate-fade-in">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 text-red-500 shrink-0" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    <span class="text-sm font-medium text-red-800">{{ session('error') }}</span>
                                </div>
                            </div>
                        @endif

                        {{-- Laravel Default Validation Errors --}}
                        @if ($errors->any())
                            <div role="alert" class="p-4 mb-6 font-sans border border-red-200 bg-red-50 rounded-xl animate-fade-in">
                                <div class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500 mr-3 shrink-0 mt-0.5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    <div class="flex flex-col space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <span class="text-sm text-red-800">{{ $error }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Login Form -->
                        <form method="POST" action="{{ route('login') }}" class="space-y-4">
                            @csrf

                            <!-- Email -->
                            <div class="space-y-2">
                                <label for="email" class="block text-sm font-bold text-gray-700 font-heading">Email</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                        <svg class="w-5 h-5 text-purple-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <g stroke-linejoin="round" stroke-linecap="round" stroke-width="1.5">
                                                <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                            </g>
                                        </svg>
                                    </div>
                                    <input
                                        type="email"
                                        name="email"
                                        id="email"
                                        required
                                        placeholder="Email Pengguna"
                                        class="w-full pl-12 pr-4 py-3.5 font-sans text-sm text-gray-700 bg-gray-50 border border-purple-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent transition-all duration-200 hover:bg-white hover:border-purple-300"
                                    />
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="space-y-2">
                                <label for="password" class="block text-sm font-bold text-gray-700 font-heading">Kata Sandi</label>
                                <div class="relative">
                                    {{-- Ikon di kiri --}}
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                        <svg class="w-5 h-5 text-orange-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <g stroke-linejoin="round" stroke-linecap="round" stroke-width="1.5">
                                                <path d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z"></path>
                                                <circle cx="16.5" cy="7.5" r=".5" fill="currentColor"></circle>
                                            </g>
                                        </svg>
                                    </div>

                                    {{-- Input Password --}}
                                    <input
                                        type="password"
                                        name="password"
                                        id="password"
                                        required
                                        placeholder="Kata Sandi"
                                        class="w-full pl-12 pr-12 py-3.5 font-sans text-sm text-gray-700 bg-gray-50 border border-orange-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent transition-all duration-200 hover:bg-white hover:border-orange-300"
                                    />

                                    {{-- Eye Icon (Toggle Button) --}}
                                    <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 flex items-center pr-4 text-orange-400 transition-colors hover:text-orange-500 focus:outline-none">
                                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path id="eyeOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path id="eyeOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Role -->
                            <div class="space-y-2">
                                <label class="block text-sm font-bold text-gray-700 font-heading">Masuk sebagai</label>
                                <select name="role" required
                                    class="w-full px-4 py-3.5 font-sans text-sm text-gray-700 bg-gray-50 border border-purple-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent transition-all duration-200 hover:bg-white hover:border-purple-300">
                                    <option value="" disabled selected>Pilih Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="guru">Guru</option>
                                </select>
                            </div>

                            <!-- Forgot Password -->
                            <div class="flex justify-end">
                                <a href="{{ route('password.request') }}" class="text-sm font-medium text-purple-600 transition-colors hover:text-purple-500 hover:underline">
                                    Lupa password?
                                </a>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit"
                                class="w-full py-4 font-semibold text-white transition-all duration-300 transform shadow-lg rounded-xl bg-gradient-to-r from-orange-400 to-purple-500 hover:from-orange-500 hover:to-purple-600 hover:scale-[1.02] active:scale-[0.98] hover:shadow-xl">
                                Masuk
                            </button>
                        </form>

                        <!-- Footer -->
                        <div class="mt-8 text-center">
                            <p class="text-xs text-gray-400">
                                © {{ date('Y') }} PresenSee. Sistem Presensi Digital.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function togglePassword() {
                const passwordInput = document.getElementById("password");
                const eyeIcon = document.getElementById("eyeIcon");

                const isPassword = passwordInput.type === "password";
                passwordInput.type = isPassword ? "text" : "password";

                // Ganti icon (opsional, di sini hanya ganti stroke)
                eyeIcon.innerHTML = isPassword
                    ? `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.965 9.965 0 011.284-2.618m3.923-3.923A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.965 9.965 0 01-1.284 2.618M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3l18 18" />`
                    : `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
            }
        </script>
    </body>
</html>
