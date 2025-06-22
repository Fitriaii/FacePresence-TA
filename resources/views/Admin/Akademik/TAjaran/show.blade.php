@extends('layouts.app')

@section('content')

<div class="container p-6 mx-auto">
    {{-- Header Section --}}
    <div class="z-50 p-4 mb-4 bg-white rounded-sm shadow font-heading">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold text-purple-800 font-heading">Detail Data Tahun Ajaran</h2>
            <div class="flex space-x-1 font-sans text-xs text-gray-500">
                <a href="{{ route('admindashboard') }}" class="text-indigo-600 underline underline-offset-2 hover:text-indigo-700">Beranda</a>
                <span>/</span>
                <a href="{{ route('tahunajaran.index') }}" class="text-indigo-600 underline underline-offset-2 hover:text-indigo-700">Tahun Ajaran</a>
                <span>/</span>
                <span class="text-gray-400">Detail Tahun Ajaran</span>
            </div>
        </div>
    </div>

    {{-- Show Form --}}
    <div class="w-full p-6 mb-8 bg-white border border-gray-200 rounded-lg shadow-sm drop-shadow">
        {{-- Back Page --}}
        <a href="{{ route('tahunajaran.index') }}" class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-600 transition-all duration-200 bg-white border border-gray-300 group rounded-xl hover:bg-gray-50 hover:text-gray-900 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transition-transform duration-200 group-hover:-translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
            <span class="text-sm">Kembali</span>
        </a>

        <!-- Grid Layout -->
        <div class="w-full">
            <div class="p-4">
                <div class="mb-8">
                    <h2 class="pb-2 mb-6 text-lg font-semibold text-purple-900 border-b border-gray-200">Informasi Tahun Ajaran</h2>

                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                        <!-- Tahun Ajaran -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700">Tahun Ajaran</label>
                            <div class="p-3 border rounded-lg bg-gray-50">
                                <p class="text-sm text-gray-900">{{ $tahunajaran->tahun_ajaran }}</p>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700">Status</label>
                            <div class="p-3 border rounded-lg bg-gray-50">
                                <p class="text-sm text-gray-900">{{ $tahunajaran->status }}</p>
                            </div>
                        </div>

                        <!-- Tanggal Mulai -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700">Tanggal Mulai</label>
                            <div class="p-3 border rounded-lg bg-gray-50">
                                <p class="text-sm text-gray-900">{{ $tahunajaran->tanggal_mulai }}</p>
                            </div>
                        </div>

                        <!-- Tanggal Selesai -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700">Tanggal Selesai</label>
                            <div class="p-3 border rounded-lg bg-gray-50">
                                <p class="text-sm text-gray-900">{{ $tahunajaran->tanggal_selesai }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <h2 class="pb-2 mb-6 text-lg font-semibold text-purple-900 border-b border-gray-200">Informasi Sistem</h2>

                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                        <!-- Dibuat Pada -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700">Dibuat Pada</label>
                            <div class="p-3 border rounded-lg bg-gray-50">
                                <p class="text-sm text-gray-900">{{ $tahunajaran->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>

                        <!-- Terakhir Diperbarui -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700">Terakhir Diperbarui</label>
                            <div class="p-3 border rounded-lg bg-gray-50">
                                <p class="text-sm text-gray-900">{{ $tahunajaran->updated_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
