@if ($paginator->hasPages())
    <div class="mu-pagination">
        <nav aria-label="Pagination Navigation">
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="disabled">
                        <span aria-label="Previous">
                            <span class="fa fa-angle-left"></span> Prev
                        </span>
                    </li>
                @else
                    <li>
                        <a href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
                            <span class="fa fa-angle-left"></span> Prev
                        </a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="disabled">
                            <span>{{ $element }}</span>
                        </li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="active">
                                    <a href="#">{{ $page }}</a>
                                </li>
                            @else
                                <li>
                                    <a href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li>
                        <a href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
                            Next <span class="fa fa-angle-right"></span>
                        </a>
                    </li>
                @else
                    <li class="disabled">
                        <span aria-label="Next">
                            Next <span class="fa fa-angle-right"></span>
                        </span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
@endif