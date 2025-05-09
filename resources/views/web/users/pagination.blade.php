@if ($paginator->hasPages())
    <div class="dash-pagination d-flex justify-content-end mt-30">
        <ul class="style-none d-flex align-items-center">
            {{-- Previous Page Link --}}
            @if (!$paginator->onFirstPage())
                <li><a href="{{ $paginator->previousPageUrl() }}"><i class="bi bi-chevron-left"></i></a></li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            {{-- Current Page --}}
                            <li><a href="#" class="active">{{ $page }}</a></li>
                        @elseif ($page == 1 || $page == 2 || $page == $paginator->lastPage() || $page == $paginator->lastPage() - 1 || abs($paginator->currentPage() - $page) <= 1)
                            {{-- Show first 2 pages, last 2 pages, and pages near current --}}
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @elseif ($page == 3 && $paginator->currentPage() > 4)
                            {{-- Show "..." after the first few pages --}}
                            <li>..</li>
                        @elseif ($page == $paginator->lastPage() - 2 && $paginator->currentPage() < $paginator->lastPage() - 3)
                            {{-- Show "..." before the last few pages --}}
                            <li>..</li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li><a href="{{ $paginator->nextPageUrl() }}"><i class="bi bi-chevron-right"></i></a></li>
            @endif
        </ul>
    </div>
@endif
