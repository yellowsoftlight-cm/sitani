@if ($paginator->hasPages())
    <nav class="st-pagination" role="navigation" aria-label="Navigasi Halaman">
        <div style="display:flex; align-items:center; gap:6px;">
            @if ($paginator->onFirstPage())
                <span class="st-filter-tab" style="opacity:0.5;">&laquo; Sebelumnya</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="st-filter-tab">&laquo; Sebelumnya</a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="st-filter-tab" style="opacity:0.5;">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="st-filter-tab is-active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="st-filter-tab">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="st-filter-tab">Berikutnya &raquo;</a>
            @else
                <span class="st-filter-tab" style="opacity:0.5;">Berikutnya &raquo;</span>
            @endif
        </div>
    </nav>
@endif
