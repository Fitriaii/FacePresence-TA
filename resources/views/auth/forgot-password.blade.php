<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lupa Password - PresenSee</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>

  <body class="flex items-center justify-center min-h-screen font-sans bg-gradient-to-br from-orange-300 to-purple-300">

    <!-- Card -->
    <div class="w-full max-w-md p-8 mx-4 bg-white shadow-2xl rounded-3xl">
      <!-- Header -->
      <div class="mb-6 text-center text-gray-800">
        <h1 class="text-3xl font-bold leading-tight font-heading">
          <span class="font-black text-purple-600">PresenSee</span>
        </h1>
        <h2 class="mt-1 text-xl font-bold text-orange-600 font-heading">
          SMP Islamiyah Widodaren
        </h2>
        <p class="mt-2 text-sm font-light text-gray-500">
          Masukkan email untuk reset password
        </p>
      </div>

      <!-- Alert sukses jika berhasil -->
      @if (session('status'))
        <div class="p-3 mb-4 text-sm text-green-800 bg-green-100 border border-green-300 rounded-lg">
          {{ session('status') }}
        </div>
      @endif

      <!-- Form -->
      <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block mb-1 text-sm font-bold text-gray-700 font-heading">Email</label>
            <div class="relative">
                <svg class="absolute h-5 transform -translate-y-1/2 opacity-40 left-3 top-1/2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g stroke-linejoin="round" stroke-linecap="round" stroke-width="1.5" fill="none" stroke="purple"><rect width="20" height="16" x="2" y="4" rx="2"></rect><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path></g></svg>
                <input
                    type="email"
                    name="email"
                    id="email"
                    required
                    placeholder="Email Pengguna"
                    class="w-full py-3 pl-12 pr-4 font-sans text-sm text-gray-700 border border-purple-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400"
                />
            </div>
        </div>
        @error('email')
          <div class="mt-2 text-sm text-red-600">
            {{ $message }}
          </div>
        @enderror
        <!-- Submit -->
        <button
          type="submit"
          class="w-full py-3 font-semibold text-white transition-all duration-300 shadow-lg rounded-xl bg-gradient-to-r from-orange-400 to-purple-500 hover:from-orange-500 hover:to-purple-600"
        >
          Kirim Link Reset
        </button>

        <!-- Kembali ke login -->
        <p class="mt-4 text-sm text-center text-gray-500">
          Sudah ingat password?
          <a href="{{ route('login') }}" class="font-medium text-purple-600 hover:underline">
            Login di sini
          </a>
        </p>
      </form>
    </div>
  </body>
</html>
