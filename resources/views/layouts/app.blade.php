<!DOCTYPE html>
<html x-data="data()" lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'PresenSee') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.1/dist/cdn.min.js"></script>

        <!-- DataTables CSS -->
        <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">

        <!-- jQuery (Required for DataTables.js) -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script type="module" src="https://unpkg.com/cally"></script>

    </head>
    <body class="h-screen overflow-hidden">
        @include('sweetalert::alert')

        <div class="flex h-screen bg-gray-100">

            <!-- Desktop sidebar - Fixed di sebelah kiri -->
            @if (Auth::user()->hasRole('admin'))
                @include('layouts.dekstop-sidebar')
            @elseif (Auth::user()->hasRole('guru'))
                @include('layouts.guru-dekstop-sidebar')
            @endif

            <!-- Mobile sidebar overlay -->
            <div
                x-show="isSideMenuOpen"
                x-cloak
                @click="closeSideMenu"
                class="fixed inset-0 z-50 bg-black bg-opacity-50 md:hidden"
                x-transition:enter="transition ease-in-out duration-150"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in-out duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
            ></div>

            <!-- Mobile sidebar -->
            @if (Auth::user()->hasRole('admin'))
                @include('layouts.mobile-sidebar')
            @elseif (Auth::user()->hasRole('guru'))
                @include('layouts.guru-mobile-sidebar')
            @endif

            <!-- Main content area -->
            <div class="flex flex-col flex-1 min-w-0">
                <!-- Navigation bar - Fixed di atas -->
                <div class="flex-shrink-0 bg-white border-b border-gray-200">
                    @if (Auth::user()->hasRole('admin'))
                        @include('layouts.navbar-admin')
                    @elseif (Auth::user()->hasRole('guru'))
                        @include('layouts.navbar-guru')
                    @endif
                </div>

                <!-- Content area - Yang bisa di-scroll -->
                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
                    <div class="h-full">
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
