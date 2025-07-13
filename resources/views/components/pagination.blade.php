@php
    $currentPage = $data->currentPage();
    $lastPage = $data->lastPage();
@endphp

<div class="flex items-center justify-center mt-6">
    <nav class="flex items-center gap-0.5 bg-white rounded-full px-1 py-0.5 shadow-sm border border-gray-100" aria-label="Pagination">

        {{-- Previous --}}
        <a href="{{ $data->previousPageUrl() ?? '#' }}"
           class="flex items-center justify-center w-7 h-7 rounded-full transition-all duration-200 {{ $data->onFirstPage() ? 'text-gray-300 cursor-not-allowed' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>

        {{-- First Page --}}
        @if ($currentPage > 2)
            <a href="{{ $data->url(1) }}" class="flex items-center justify-center text-xs text-gray-700 rounded-full w-7 h-7 hover:bg-gray-100 hover:text-gray-900">1</a>
        @endif

        {{-- Left Ellipsis --}}
        @if ($currentPage > 3)
            <span class="flex items-center justify-center text-xs text-gray-400 w-7 h-7">…</span>
        @endif

        {{-- Current -1 --}}
        @if ($currentPage > 1)
            <a href="{{ $data->url($currentPage - 1) }}" class="flex items-center justify-center text-xs text-gray-700 rounded-full w-7 h-7 hover:bg-gray-100 hover:text-gray-900">{{ $currentPage - 1 }}</a>
        @endif

        {{-- Current --}}
        <span class="flex items-center justify-center text-xs text-white bg-purple-600 rounded-full shadow-sm w-7 h-7">{{ $currentPage }}</span>

        {{-- Current +1 --}}
        @if ($currentPage < $lastPage)
            <a href="{{ $data->url($currentPage + 1) }}" class="flex items-center justify-center text-xs text-gray-700 rounded-full w-7 h-7 hover:bg-gray-100 hover:text-gray-900">{{ $currentPage + 1 }}</a>
        @endif

        {{-- Right Ellipsis --}}
        @if ($currentPage < $lastPage - 2)
            <span class="flex items-center justify-center text-xs text-gray-400 w-7 h-7">…</span>
        @endif

        {{-- Last Page --}}
        @if ($currentPage < $lastPage - 1)
            <a href="{{ $data->url($lastPage) }}" class="flex items-center justify-center text-xs text-gray-700 rounded-full w-7 h-7 hover:bg-gray-100 hover:text-gray-900">{{ $lastPage }}</a>
        @endif

        {{-- Next --}}
        <a href="{{ $data->nextPageUrl() ?? '#' }}"
           class="flex items-center justify-center w-7 h-7 rounded-full transition-all duration-200 {{ !$data->hasMorePages() ? 'text-gray-300 cursor-not-allowed' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>

    </nav>
</div>
