@extends('layouts.app')

@section('content')

<div class="container p-6 mx-auto">
    <div class="flex flex-col items-center justify-center">
        <!-- Error Icon -->
        <div class="mb-2">
            <svg class="text-gray-400" width="200" height="200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
        </div>

        <!-- 404 Number -->
        <h1 class="mb-2 text-4xl font-bold text-gray-800" >404</h1>

        <!-- Error Message -->
        <h2 class="mb-2 text-2xl font-semibold text-gray-600">Halaman Tidak Ditemukan</h2>
        <p class="max-w-md mb-8 text-gray-500">
            Maaf, halaman yang Anda cari tidak dapat ditemukan. Mungkin halaman telah dipindahkan atau dihapus.
        </p>

        <!-- Back Button -->
        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-6 py-3 font-medium text-white transition duration-200 bg-blue-600 rounded-lg hover:bg-blue-700">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Beranda
        </a>
    </div>
</div>

@endsection
