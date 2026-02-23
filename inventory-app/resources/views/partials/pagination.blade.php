@if($paginator->hasPages())
<ul class="pagination">
    {{-- Previous --}}
    @if($paginator->onFirstPage())
        <li><span>‹</span></li>
    @else
        <li><a href="{{ $paginator->previousPageUrl() }}">‹</a></li>
    @endif

    {{-- Pages --}}
    @foreach($elements as $element)
        @if(is_string($element))
            <li><span>{{ $element }}</span></li>
        @endif
        @if(is_array($element))
            @foreach($element as $page => $url)
                @if($page == $paginator->currentPage())
                    <li class="active"><span>{{ $page }}</span></li>
                @else
                    <li><a href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next --}}
    @if($paginator->hasMorePages())
        <li><a href="{{ $paginator->nextPageUrl() }}">›</a></li>
    @else
        <li><span>›</span></li>
    @endif
</ul>
@endif
