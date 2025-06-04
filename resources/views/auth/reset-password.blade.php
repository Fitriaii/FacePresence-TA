<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password - PresenSee</title>

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
          Reset Password
        </h2>
        <p class="mt-2 text-sm font-light text-gray-500">Masukkan password baru untuk akun Anda</p>
      </div>

      <!-- Form -->
      <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
        @csrf

        {{-- Success Message --}}
        @if (session('success'))
            <div role="alert" class="mb-4 font-sans alert alert-success rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 stroke-current shrink-0" fill="none"
                    viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- Error Message --}}
        @if (session('error'))
            <div role="alert" class="mb-4 font-sans alert alert-error rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 stroke-current shrink-0" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- Laravel Default Validation Errors --}}
        @if ($errors->any())
            <div role="alert" class="mb-4 font-sans alert alert-error rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 stroke-current shrink-0" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
                <div class="flex flex-col space-y-1">
                    @foreach ($errors->all() as $error)
                        <span class="text-sm">{{ $error }}</span>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

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

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block mb-1 text-sm font-bold text-gray-700 font-heading">Password</label>
            <div class="relative">
                <svg class="absolute h-5 transform -translate-y-1/2 opacity-40 left-3 top-1/2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g stroke-linejoin="round" stroke-linecap="round" stroke-width="1.5" fill="none" stroke="orange"><path d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z"></path><circle cx="16.5" cy="7.5" r=".5" fill="currentColor"></circle></g></svg>
                <input
                    type="password"
                    name="password"
                    required
                    placeholder="Kata Sandi"
                    class="w-full px-4 py-3 pl-12 pr-4 font-sans text-sm text-gray-700 border border-orange-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500"
                />
            </div>
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
          <label for="confirm-password" class="block mb-1 text-sm font-bold text-gray-700 font-heading">Konfirmasi Kata Sandi</label>
          <div class="relative">
            <svg class="absolute h-5 transform -translate-y-1/2 opacity-40 left-3 top-1/2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g stroke-linejoin="round" stroke-linecap="round" stroke-width="1.5" fill="none" stroke="orange"><path d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z"></path><circle cx="16.5" cy="7.5" r=".5" fill="currentColor"></circle></g></svg>
            <input
                type="password"
                name="password_confirmation"
                required
                placeholder="Konfirmasi Kata Sandi"
                autocomplete="new-password"
                class="w-full px-4 py-3 pl-12 pr-4 font-sans text-sm text-gray-700 border border-purple-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-400"
            />
          </div>
        </div>

        <!-- Submit -->
        <button
          type="submit"
          class="w-full py-3 font-semibold text-white transition-all duration-300 shadow-lg rounded-xl bg-gradient-to-r from-orange-400 to-purple-500 hover:from-orange-500 hover:to-purple-600"
        >
          Reset Password
        </button>
      </form>
    </div>
  </body>
</html>
