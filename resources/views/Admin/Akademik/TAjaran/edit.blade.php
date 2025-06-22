@extends('layouts.app')

@section('content')

<div class="container p-6 mx-auto">
    {{-- Header Section --}}
    <div class="z-50 p-4 mb-4 bg-white rounded-sm shadow font-heading">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold text-purple-800 font-heading">Edit Data Tahun Ajaran</h2>
            <div class="flex space-x-1 font-sans text-xs text-gray-500">
                <a href="{{ route('admindashboard') }}" class="text-indigo-600 underline underline-offset-2 hover:text-indigo-700">Beranda</a>
                <span>/</span>
                <a href="{{ route('tahunajaran.index') }}" class="text-indigo-600 underline underline-offset-2 hover:text-indigo-700">Tahun Ajaran</a>
                <span>/</span>
                <span class="text-gray-400">Edit Tahun Ajaran</span>
            </div>
        </div>
    </div>


    {{-- Input Form --}}
    <div class="w-full p-6 mb-8 bg-white border border-gray-200 rounded-lg shadow-sm drop-shadow">

        <form id="userForm" action="{{ route('tahunajaran.update', $ta) }}" method="POST" class="space-y-3">
            @csrf
            @method('PATCH')

            <div class="space-y-6">
                <h3 class="pb-4 text-lg font-semibold text-purple-800 border-b border-gray-200 font-heading">Informasi Tahun Ajaran</h3>

                <div class="grid items-start grid-cols-1 gap-4 lg:grid-cols-3">
                    <div class="lg:text-right">
                        <label class="block mb-1 text-sm font-semibold text-gray-700 font-heading">
                            Tahun Ajaran <span class="text-red-500">*</span>
                        </label>
                    </div>
                    <div class="lg:col-span-2">
                        <div class="flex items-center gap-2">
                            <!-- Start Year Input -->
                            <div class="relative w-1/2">
                                <input
                                    type="number"
                                    id="tahun_mulai"
                                    name="tahun_mulai"
                                    min="2000"
                                    max="2099"
                                    required
                                    placeholder="Contoh: 2024"
                                    value="{{ old('tahun_mulai', explode('/', $ta->tahun_ajaran ?? '')[0]) }}"
                                    class="w-full px-4 py-3 pr-8 text-sm transition-colors duration-200 border border-gray-300 rounded-lg outline-none hover:border-purple-400 dark:bg-white dark:text-gray-900 dark:border-gray-300 focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500"
                                />
                                <div class="absolute inset-y-0 flex flex-col justify-center right-2">
                                    <button
                                        type="button"
                                        onclick="adjustYearStart(1)"
                                        class="w-5 h-4 text-xs text-purple-600 transition-colors hover:text-purple-800 dark:text-purple-600 dark:hover:text-purple-800"
                                    >▲</button>
                                    <button
                                        type="button"
                                        onclick="adjustYearStart(-1)"
                                        class="w-5 h-4 text-xs text-purple-600 transition-colors hover:text-purple-800 dark:text-purple-600 dark:hover:text-purple-800"
                                    >▼</button>
                                </div>
                            </div>

                            <!-- Separator -->
                            <span class="text-xl font-light text-gray-400 dark:text-gray-600">/</span>

                            <!-- End Year Input -->
                            <div class="relative w-1/2">
                                <input
                                    type="number"
                                    id="tahun_akhir"
                                    name="tahun_akhir"
                                    min="2000"
                                    max="2099"
                                    required
                                    placeholder="Contoh: 2025"
                                    value="{{ old('tahun_akhir', explode('/', $ta->tahun_ajaran ?? '')[1]) }}"
                                    class="w-full px-4 py-3 pr-8 text-sm transition-colors duration-200 border border-gray-300 rounded-lg outline-none hover:border-purple-400 dark:bg-white dark:text-gray-900 dark:border-gray-300 focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500"
                                />
                                <div class="absolute inset-y-0 flex flex-col justify-center right-2">
                                    <button
                                        type="button"
                                        onclick="adjustYearEnd(1)"
                                        class="w-5 h-4 text-xs text-purple-600 transition-colors hover:text-purple-800 dark:text-purple-600 dark:hover:text-purple-800"
                                    >▲</button>
                                    <button
                                        type="button"
                                        onclick="adjustYearEnd(-1)"
                                        class="w-5 h-4 text-xs text-purple-600 transition-colors hover:text-purple-800 dark:text-purple-600 dark:hover:text-purple-800"
                                    >▼</button>
                                </div>
                            </div>
                        </div>

                        <!-- Help Text & Errors: Diletakkan setelah .flex -->
                        <div class="mt-2 space-y-1">
                            <p class="text-xs text-gray-500 dark:text-gray-600">
                                Masukkan tahun mulai, tahun akhir akan otomatis terisi.
                            </p>

                            @error('tahun_mulai')
                                <p class="text-xs text-red-500 dark:text-red-400">{{ $message }}</p>
                            @enderror

                            @error('tahun_akhir')
                                <p class="text-xs text-red-500 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

            </div>


            <div class="flex flex-col justify-end gap-4 pt-6 border-t border-gray-200 sm:flex-row">
                <a href="{{ route('tahunajaran.index') }}" type="button"
                    class="px-6 py-3 text-sm font-medium text-gray-700 transition-colors duration-200 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-200">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-3 text-sm font-semibold text-white transition-colors duration-200 bg-purple-600 rounded-lg shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-200 hover:shadow-md">
                    <span class="flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                        Perbarui Data Tahun Ajaran
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    const tahunMulaiInput = document.getElementById('tahun_mulai');
    const tahunAkhirInput = document.getElementById('tahun_akhir');

    function updateTahunAkhir() {
        const tahunMulai = parseInt(tahunMulaiInput.value);
        tahunAkhirInput.value = !isNaN(tahunMulai) ? tahunMulai + 1 : '';
    }

    tahunMulaiInput.addEventListener('input', updateTahunAkhir);

    function adjustYearStart(amount) {
        let current = parseInt(tahunMulaiInput.value || new Date().getFullYear());
        let nextValue = current + amount;

        if (nextValue >= 2000 && nextValue <= 2099) {
            tahunMulaiInput.value = nextValue;
            updateTahunAkhir(); // pastikan akhir ikut berubah
        }
    }

    function adjustYearEnd(amount) {
        let current = parseInt(tahunAkhirInput.value || new Date().getFullYear());
        let nextValue = current + amount;

        if (nextValue >= 2000 && nextValue <= 2099) {
            tahunAkhirInput.value = nextValue;
        }
    }

        // Tampilkan alert sukses/error dari session
        @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: @json(session('success')),
            showConfirmButton: false,
            timer: 2000
        });
    @endif

    @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: @json(session('error')),
            showConfirmButton: true
        });
    @endif
</script>
@endsection
