@extends('layouts.app')

@section('content')

<div class="container p-6 mx-auto">
    {{-- Header Section --}}
    <div class="z-50 p-4 mb-4 bg-white rounded-sm shadow font-heading">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold text-purple-800 font-heading">Tambah Data Guru</h2>
            <div class="flex space-x-1 font-sans text-xs text-gray-500">
                <a href="{{ route('admindashboard') }}" class="text-indigo-600 underline underline-offset-2 hover:text-indigo-700">Beranda</a>
                <span>/</span>
                <a href="{{ route('guru.index') }}" class="text-indigo-600 underline underline-offset-2 hover:text-indigo-700">Daftar Guru</a>
                <span>/</span>
                <span class="text-gray-400">Tambah Guru</span>
            </div>
        </div>
    </div>

    {{-- Input Form --}}
    <div class="p-6 mb-2 bg-white border border-gray-200 rounded-sm shadow-lg">
        <!-- Info Alert -->
        <div x-data="{ show: true }" x-show="show" x-transition class="p-4 mb-6 text-blue-500 bg-blue-100 border border-blue-200 rounded-lg">
            <div class="flex items-start justify-between">
                <div class="w-full">
                    <h1 class="mb-1 text-base font-bold text-blue-600 font-heading">Tambah Data Guru</h1>
                    <hr class="mb-2 border-blue-300">
                    <div class="flex items-center gap-2 font-sans text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 stroke-current shrink-0" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Silakan isi data guru dengan lengkap dan benar.</span>
                    </div>
                </div>
                <button @click="show = false" class="ml-4 text-blue-600 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mt-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Form -->
        <form id="guruForm" class="space-y-4" method="POST" action="{{ route('guru.store') }}" enctype="multipart/form-data">
            @csrf
            <!-- Personal Information Section -->
            <div class="space-y-6">
                <h3 class="pb-2 text-lg font-semibold text-purple-800 border-b border-gray-200 font-heading">Informasi Personal</h3>

                <!-- Nama -->
                <div class="grid items-start grid-cols-1 gap-4 lg:grid-cols-3">
                    <div class="lg:text-right">
                        <label for="nama_guru" class="block mb-1 text-sm font-semibold text-gray-700 font-heading">
                            Nama <span class="text-red-500">*</span>
                        </label>
                    </div>
                    <div class="lg:col-span-2">
                        <input
                            type="text"
                            id="nama_guru"
                            name="nama_guru"
                            value="{{ old('nama_guru', isset($guru) ? $guru->nama_guru : '') }}"
                            required
                            placeholder="Masukkan nama lengkap"
                            class="w-full px-4 py-3 text-sm transition-colors duration-200 border border-gray-300 rounded-lg outline-none hover:border-purple-400 dark:bg-white dark:text-gray-900 dark:border-gray-300 focus:ring-purple-500/20 focus:border-purple-500"
                        />
                    </div>
                </div>

                <!-- NIP -->
                <div class="grid items-start grid-cols-1 gap-4 lg:grid-cols-3">
                    <div class="lg:text-right">
                        <label for="nip" class="block mb-1 text-sm font-semibold text-gray-700 font-heading">
                            NIP <span class="text-red-500">*</span>
                        </label>
                    </div>
                    <div class="lg:col-span-2">
                        <input
                            type="text"
                            id="nip"
                            name="nip"
                            value="{{ old('nip', isset($guru) ? $guru->nip : '') }}"
                            required
                            placeholder="Masukkan NIP"
                            class="w-full px-4 py-3 text-sm transition-colors duration-200 border border-gray-300 rounded-lg outline-none hover:border-purple-400 dark:bg-white dark:text-gray-900 dark:border-gray-300 focus:ring-purple-500/20 focus:border-purple-500"
                        />
                    </div>
                </div>

                <!-- Email -->
                <div class="grid items-start grid-cols-1 gap-4 lg:grid-cols-3">
                    <div class="lg:text-right">
                        <label for="email" class="block mb-1 text-sm font-semibold text-gray-700 font-heading">
                            Email <span class="text-red-500">*</span>
                        </label>
                    </div>
                    <div class="lg:col-span-2">
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email', isset($guru) ? $guru->email : '') }}"
                            required
                            placeholder="guru@example.com"
                            class="w-full px-4 py-3 text-sm transition-colors duration-200 border border-gray-300 rounded-lg outline-none hover:border-purple-400 dark:bg-white dark:text-gray-900 dark:border-gray-300 focus:ring-purple-500/20 focus:border-purple-500"
                        />
                        <p class="mt-2 text-xs text-gray-500">Masukkan dengan format email yang valid</p>
                    </div>
                </div>

                <!-- No Telepon -->
                <div class="grid items-start grid-cols-1 gap-4 lg:grid-cols-3">
                    <div class="lg:text-right">
                        <label for="no_hp" class="block mb-1 text-sm font-semibold text-gray-700 font-heading">
                            No Telepon <span class="text-red-500">*</span>
                        </label>
                    </div>
                    <div class="lg:col-span-2">
                        <input
                            type="text"
                            id="no_hp"
                            name="no_hp"
                            value="{{ old('no_hp', isset($guru) ? $guru->no_hp : '') }}"
                            required
                            placeholder="Masukkan nomor telepon"
                            class="w-full px-4 py-3 text-sm transition-colors duration-200 border border-gray-300 rounded-lg outline-none hover:border-purple-400 dark:bg-white dark:text-gray-900 dark:border-gray-300 focus:ring-purple-500/20 focus:border-purple-500"
                        />
                    </div>
                </div>

                <!-- Alamat -->
                <div class="grid items-start grid-cols-1 gap-4 lg:grid-cols-3">
                    <div class="lg:text-right">
                        <label for="alamat" class="block mb-1 text-sm font-semibold text-gray-700 font-heading">
                            Alamat <span class="text-red-500">*</span>
                        </label>
                    </div>
                    <div class="lg:col-span-2">
                        <textarea
                            id="alamat"
                            name="alamat"
                            required
                            rows="3"
                            placeholder="Masukkan alamat lengkap"
                            class="w-full px-4 py-3 text-sm transition-colors duration-200 border border-gray-300 rounded-lg outline-none resize-none hover:border-purple-400 dark:bg-white dark:text-gray-900 dark:border-gray-300 focus:ring-purple-500/20 focus:border-purple-500"
                        >{{ old('alamat', isset($guru) ? $guru->alamat : '') }}</textarea>
                    </div>
                </div>

                <!-- Jenis Kelamin -->
                <div class="grid items-start grid-cols-1 gap-4 lg:grid-cols-3">
                    <div class="lg:text-right">
                        <label for="jenis_kelamin" class="block mb-1 text-sm font-semibold text-gray-700 font-heading">
                            Jenis Kelamin <span class="text-red-500">*</span>
                        </label>
                    </div>
                    <div class="lg:col-span-2">
                        <select
                            id="jenis_kelamin"
                            name="jenis_kelamin"
                            required
                            class="w-full px-4 py-3 text-sm transition-colors duration-200 border border-gray-300 rounded-lg outline-none hover:border-purple-400 dark:bg-white dark:text-gray-900 dark:border-gray-300 focus:ring-purple-500/20 focus:border-purple-500"
                        >
                            <option value="" disabled selected>Pilih jenis kelamin</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin', isset($guru) ? $guru->jenis_kelamin : '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin', isset($guru) ? $guru->jenis_kelamin : '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>

                <!-- Status Keaktifan -->
                <div class="grid items-start grid-cols-1 gap-4 lg:grid-cols-3">
                    <div class="lg:text-right">
                        <label for="status_keaktifan" class="block mb-1 text-sm font-semibold text-gray-700 font-heading">
                            Status Keaktifan <span class="text-red-500">*</span>
                        </label>
                    </div>
                    <div class="lg:col-span-2">
                        <select
                            id="status_keaktifan"
                            name="status_keaktifan"
                            required
                            class="w-full px-4 py-3 text-sm transition-colors duration-200 border border-gray-300 rounded-lg outline-none hover:border-purple-400 dark:bg-white dark:text-gray-900 dark:border-gray-300 focus:ring-purple-500/20 focus:border-purple-500"
                        >
                            <option value="" disabled selected>Pilih status keaktifan</option>
                            <option value="Aktif" {{ old('status_keaktifan', isset($guru) ? $guru->status_keaktifan : '') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Tidak Aktif" {{ old('status_keaktifan', isset($guru) ? $guru->status_keaktifan : '') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Account Information Section -->
            <div class="space-y-6">
                <h3 class="pb-2 text-lg font-semibold text-purple-800 border-b border-gray-200 font-heading">Keamanan Akun</h3>

                <!-- Password -->
                <div class="grid items-start grid-cols-1 gap-4 lg:grid-cols-3">
                    <div class="lg:text-right">
                        <label for="password" class="block mb-1 text-sm font-semibold text-gray-700 font-heading">
                            Kata Sandi <span class="text-red-500">*</span>
                        </label>
                    </div>
                    <div class="lg:col-span-2">
                        <div class="relative">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                placeholder="Masukkan kata sandi"
                                class="w-full px-4 py-3 pr-12 text-sm transition-colors duration-200 border border-gray-300 rounded-lg outline-none hover:border-purple-400 dark:bg-white dark:text-gray-900 dark:border-gray-300 focus:ring-purple-500/20 focus:border-purple-500"
                            />
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 transition-colors hover:text-purple-600">
                                <svg id="eyeIcon1" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">Minimal 8 karakter, gunakan kombinasi huruf dan angka</p>
                    </div>
                </div>

                <!-- Konfirmasi Password -->
                <div class="grid items-start grid-cols-1 gap-4 lg:grid-cols-3">
                    <div class="lg:text-right">
                        <label for="password_confirmation" class="block mb-1 text-sm font-semibold text-gray-700 font-heading">
                            Konfirmasi Kata Sandi <span class="text-red-500">*</span>
                        </label>
                    </div>
                    <div class="lg:col-span-2">
                        <div class="relative">
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                required
                                placeholder="Masukkan ulang kata sandi"
                                class="w-full px-4 py-3 pr-12 text-sm transition-colors duration-200 border border-gray-300 rounded-lg outline-none hover:border-purple-400 dark:bg-white dark:text-gray-900 dark:border-gray-300 focus:ring-purple-500/20 focus:border-purple-500"
                            />
                            <button type="button" onclick="toggleConfirmPassword()" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 transition-colors hover:text-purple-600">
                                <svg id="eyeIcon2" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">Kata sandi harus sama dengan yang di atas</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col justify-end gap-4 pt-8 border-t border-gray-200 sm:flex-row">
                <a href="{{ route('guru.index') }}" type="button"
                    class="px-6 py-3 text-sm font-medium text-gray-700 transition-colors duration-200 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-200">
                    Batal
                </a>
                <button type="submit" id="submitBtn"
                    class="px-6 py-3 text-sm font-semibold text-white transition-colors duration-200 bg-purple-600 rounded-lg shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-200 hover:shadow-md">
                    <span class="flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Data Guru
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Include SweetAlert2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.1/sweetalert2.all.min.js"></script>

<script>
    // Toggle Password Functions
    function togglePassword() {
        const passwordInput = document.getElementById("password");
        const eyeIcon = document.getElementById("eyeIcon1");

        const isPassword = passwordInput.type === "password";
        passwordInput.type = isPassword ? "text" : "password";

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

    function toggleConfirmPassword() {
        const confirmPasswordInput = document.getElementById("password_confirmation");
        const eyeIcon = document.getElementById("eyeIcon2");

        const isConfirmPassword = confirmPasswordInput.type === "password";
        confirmPasswordInput.type = isConfirmPassword ? "text" : "password";

        eyeIcon.innerHTML = isConfirmPassword
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

@endsection
