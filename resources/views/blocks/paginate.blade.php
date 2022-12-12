@if ($paginator->hasPages())

    <nav aria-label="Page navigation example">
        <ul class="pagination">
        @if ($paginator->onFirstPage())

            <li class="page-item disabled" >
                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                &laquo;</a></li>

        @else

            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>

        @endif
        @foreach ($elements as $element)
            @if (is_string($element))

                <li class="page-item disabled"><span>{{ $element }}</span></li>

            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())

                        <li class="page-item active" aria-current="page"><a class="page-link" href="#">{{ $page }}</a></li>

                    @else

                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>

                    @endif
                @endforeach
            @endif
        @endforeach
        @if ($paginator->hasMorePages())

            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>

        @else

            <li class="page-item disabled"><a class="page-link" href="#" aria-disabled="true">&raquo;</a></li>

        @endif
        </ul>
    </nav>


@endif

<style>
/*    .pagination li{
        list-style-type: none;
        float: left;
        margin-left: 10px;
    }
    .pagination li span {
        color: #000;
    }
    .pagination li a {
        color: #000;
        text-decoration: none;
    }*/
</style>
