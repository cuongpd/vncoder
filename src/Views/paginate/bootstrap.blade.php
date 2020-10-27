@if ($paginator->hasPages())
    <nav aria-label="Page Navigation">
        <ul class="pagination success">
            @if ($paginator->onFirstPage())
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0);" rel="prev"><i class="icon-chevron-left1"></i>Prev</a>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="icon-chevron-left1"></i>Prev</a>
                </li>
            @endif
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Next <i class="icon-chevron-right1"></i></a>
                </li>
            @else
                <li class="page-item disabled">
                    <a class="page-link" href="javascript:void(0);" rel="next">Next <i class="icon-chevron-right1"></i></a>
                </li>
            @endif
        </ul>
    </nav>
@endif
