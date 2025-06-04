<div class="flex items-center justify-center mt-6">
    <nav class="flex items-center gap-0.5 bg-white rounded-full px-1 py-0.5 shadow-sm border border-gray-100" aria-label="Pagination">

      {{-- Previous --}}
      <a href="{{ $data->previousPageUrl() ?? '#' }}"
         class="flex items-center justify-center w-7 h-7 rounded-full transition-all duration-200 {{ $data->onFirstPage() ? 'text-gray-300 cursor-not-allowed' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
      </a>

      {{-- Page numbers --}}
      <div class="flex items-center gap-0.5 px-0.5">
        @foreach ($data->links()->elements[0] as $page => $url)
          @if (is_string($page))
            <span class="flex items-center justify-center text-xs text-gray-400 w-7 h-7">⋯</span>
          @else
            <a href="{{ $url }}"
               class="flex items-center justify-center w-7 h-7 text-xs rounded-full font-medium transition-all duration-200 {{ $data->currentPage() == $page ? 'bg-purple-600 text-white shadow-sm' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
              {{ $page }}
            </a>
          @endif
        @endforeach
      </div>

      {{-- Next --}}
      <a href="{{ $data->nextPageUrl() ?? '#' }}"
         class="flex items-center justify-center w-7 h-7 rounded-full transition-all duration-200 {{ !$data->hasMorePages() ? 'text-gray-300 cursor-not-allowed' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </a>

    </nav>
</div>
