<aside
    class="fixed inset-y-0 z-30 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-white md:hidden"
    x-show="isSideMenuOpen"
    x-cloak
    x-transition:enter="transition ease-in-out duration-150"
    x-transition:enter-start="transform -translate-x-full"
    x-transition:enter-end="transform translate-x-0"
    x-transition:leave="transition ease-in-out duration-150"
    x-transition:leave-start="transform translate-x-0"
    x-transition:leave-end="transform -translate-x-full"
    >
    <!-- Logo Section -->
    <div class="flex justify-center px-6 mt-4 mb-8">
        <a class="text-2xl font-bold tracking-tight text-purple-600 transition-colors duration-200 hover:text-purple-700" href="#">
            PresenSee
        </a>
    </div>

    <!-- Navigation Menu -->
    <nav class="space-y-1" x-data x-init="
        const path = window.location.pathname;
        if (path.includes('dashboard')) activeMenu = 'dashboard';
        else if (path.match(/(akademik|jadwal|room|mapel|tahunajaran)/)) activeMenu = 'akademik';
        else if (path.includes('siswa')) activeMenu = 'siswa';
        else if (path.includes('laporan')) activeMenu = 'laporan';
        else if (path.match(/(users|guru|admin)/)) activeMenu = 'users';
    ">

        <!-- Dashboard -->
        <div class="px-3">
            <a href="{{ route('dashboard') }}" @click="activeMenu = 'dashboard'"
                class="flex items-center px-4 py-3 text-sm font-medium transition-all duration-200 ease-in-out rounded-lg group"
                :class="activeMenu === 'dashboard'
                    ? 'bg-purple-50 text-purple-700 border-r-3 border-purple-600 shadow-sm'
                    : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'">
                <svg class="flex-shrink-0 w-5 h-5 mr-3 transition-colors duration-200"
                    :class="activeMenu === 'dashboard' ? 'text-purple-500' : 'text-gray-400 group-hover:text-gray-500'"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="7" height="9" x="3" y="3" rx="1"></rect>
                    <rect width="7" height="5" x="14" y="3" rx="1"></rect>
                    <rect width="7" height="9" x="14" y="12" rx="1"></rect>
                    <rect width="7" height="5" x="3" y="16" rx="1"></rect>
                </svg>
                Dashboard
            </a>
        </div>

        <!-- Data Akademik -->
        <div class="px-3">
            <div x-data="{ isOpen: false }" class="space-y-1">
                <button @click="isOpen = !isOpen; activeMenu = 'akademik'"
                    class="flex items-center justify-between w-full px-4 py-3 text-sm font-medium transition-all duration-200 ease-in-out rounded-lg group"
                    :class="activeMenu === 'akademik'
                        ? 'bg-purple-50 text-purple-700 border-r-3 border-purple-600 shadow-sm'
                        : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'">
                    <div class="flex items-center">
                        <svg class="flex-shrink-0 w-5 h-5 mr-3 transition-colors duration-200"
                            :class="activeMenu === 'akademik' ? 'text-purple-500' : 'text-gray-400 group-hover:text-gray-500'"
                            fill="none" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                        </svg>
                        Data Akademik
                    </div>
                    <svg class="w-4 h-4 ml-2 transition-transform duration-200 ease-in-out"
                        :class="{ 'rotate-180': isOpen }"
                        :style="activeMenu === 'akademik' ? 'color: rgb(147 51 234)' : ''"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>

                <!-- Submenu -->
                <div x-show="isOpen" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform -translate-y-2"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 transform translate-y-0"
                    x-transition:leave-end="opacity-0 transform -translate-y-2"
                    class="pl-6 ml-4 space-y-1 border-l border-gray-200">
                    <a class="block px-4 py-2 text-sm text-gray-600 transition-colors duration-150 rounded-md hover:bg-purple-50 hover:text-purple-700" href="{{ route('jadwal.index') }}">
                        Jadwal Pelajaran
                    </a>
                    <a class="block px-4 py-2 text-sm text-gray-600 transition-colors duration-150 rounded-md hover:bg-purple-50 hover:text-purple-700" href="{{ route('room.index') }}">
                        Kelas
                    </a>
                    <a class="block px-4 py-2 text-sm text-gray-600 transition-colors duration-150 rounded-md hover:bg-purple-50 hover:text-purple-700" href="{{ route('mapel.index') }}">
                        Mata Pelajaran
                    </a>
                    <a class="block px-4 py-2 text-sm text-gray-600 transition-colors duration-150 rounded-md hover:bg-purple-50 hover:text-purple-700" href="{{ route('tahunajaran.index') }}">
                        Tahun Ajaran
                    </a>
                </div>
            </div>
        </div>

        <!-- Daftar Siswa -->
        <div class="px-3">
            <a href="{{ route('siswa.index') }}" @click="activeMenu = 'siswa'"
                class="flex items-center px-4 py-3 text-sm font-medium transition-all duration-200 ease-in-out rounded-lg group"
                :class="activeMenu === 'siswa'
                    ? 'bg-purple-50 text-purple-700 border-r-3 border-purple-600 shadow-sm'
                    : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'">
                <svg class="flex-shrink-0 w-5 h-5 mr-3 transition-colors duration-200"
                    :class="activeMenu === 'siswa' ? 'text-purple-500' : 'text-gray-400 group-hover:text-gray-500'"
                    fill="none" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5"></path>
                </svg>
                Daftar Siswa
            </a>
        </div>

        <!-- Laporan Presensi -->
        <div class="px-3">
            <a href="{{ route('laporan.index') }}" @click="activeMenu = 'laporan'"
                class="flex items-center px-4 py-3 text-sm font-medium transition-all duration-200 ease-in-out rounded-lg group"
                :class="activeMenu === 'laporan'
                    ? 'bg-purple-50 text-purple-700 border-r-3 border-purple-600 shadow-sm'
                    : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'">
                <svg class="flex-shrink-0 w-5 h-5 mr-3 transition-colors duration-200"
                    :class="activeMenu === 'laporan' ? 'text-purple-500' : 'text-gray-400 group-hover:text-gray-500'"
                    fill="none" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                </svg>
                Laporan Presensi
            </a>
        </div>

        <!-- Section Divider -->
        <div class="px-6 py-4">
            <div class="border-t border-gray-200"></div>
        </div>

        <!-- Section Header -->
        <div class="px-6 pb-2">
            <h3 class="text-xs font-semibold tracking-wider text-gray-500 uppercase">
                Manajemen Pengguna
            </h3>
        </div>

        <!-- Daftar Pengguna -->
        <div class="px-3">
            <div x-data="{ isOpen: false }" class="space-y-1">
                <button @click="isOpen = !isOpen; activeMenu = 'users'"
                    class="flex items-center justify-between w-full px-4 py-3 text-sm font-medium transition-all duration-200 ease-in-out rounded-lg group"
                    :class="activeMenu === 'users'
                        ? 'bg-purple-50 text-purple-700 border-r-3 border-purple-600 shadow-sm'
                        : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'">
                    <div class="flex items-center">
                        <svg class="flex-shrink-0 w-5 h-5 mr-3 transition-colors duration-200"
                            :class="activeMenu === 'users' ? 'text-purple-500' : 'text-gray-400 group-hover:text-gray-500'"
                            fill="none" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                        Daftar Pengguna
                    </div>
                    <svg class="w-4 h-4 ml-2 transition-transform duration-200 ease-in-out"
                        :class="{ 'rotate-180': isOpen }"
                        :style="activeMenu === 'users' ? 'color: rgb(147 51 234)' : ''"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>

                <!-- Submenu -->
                <div x-show="isOpen" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform -translate-y-2"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 transform translate-y-0"
                    x-transition:leave-end="opacity-0 transform -translate-y-2"
                    class="pl-6 ml-4 space-y-1 border-l border-gray-200">
                    <a class="block px-4 py-2 text-sm text-gray-600 transition-colors duration-150 rounded-md hover:bg-purple-50 hover:text-purple-700" href="{{ route('guru.index') }}">
                        Daftar Guru
                    </a>
                    <a class="block px-4 py-2 text-sm text-gray-600 transition-colors duration-150 rounded-md hover:bg-purple-50 hover:text-purple-700" href="{{ route('admin.index') }}">
                        Daftar Admin
                    </a>
                </div>
            </div>
        </div>

    </nav>
</aside>

