@if ($paginator->hasPages())
    <ul class="products-simple-paginate">
        @if ($paginator->onFirstPage())
            <li class="disabled"><i class="fa-solid fa-chevron-left"></i></li>
        @else
            <li class="clickable"><a href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fa-solid fa-chevron-left"></i></a></li>
        @endif
        @if ($paginator->hasMorePages())
            <li class="clickable"><a href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="fa-solid fa-chevron-right"></i></a></li>
        @else
            <li class="disabled"><i class="fa-solid fa-chevron-right"></i></li>
        @endif
    </ul>
@endif
