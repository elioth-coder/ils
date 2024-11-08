@if ($totalPages > 1)
    <section class="d-flex">
        <div class="w-100 py-2 px-3 text-end">
            @php
            $offset_limit = $offset + $limit;
            $start = $offset+1;
            $end   = ($offset_limit > $totalItems) ? $totalItems : $offset_limit;
            @endphp
            <span style="font-size: 16px;">Showing {{ $start }}-{{ $end }} of {{ $totalItems }} results</span>
        </div>
        <nav aria-label="Page navigation" class="w-auto">
            @php
                $queries = request()->except('page');
                $queryString = http_build_query($queries);
            @endphp
            <ul class="pagination justify-content-end">
                <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                    <a class="page-link" href="?{{ $queryString }}&page={{ $currentPage - 1 }}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>

                @for ($page = 1; $page <= $totalPages; $page++)
                    <li class="page-item {{ $currentPage == $page ? 'active' : '' }}">
                        <a class="page-link" href="?{{ $queryString }}&page={{ $page }}">{{ $page }}</a>
                    </li>
                @endfor

                <li class="page-item {{ $currentPage == $totalPages ? 'disabled' : '' }}">
                    <a class="page-link" href="?{{ $queryString }}&page={{ $currentPage + 1 }}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </section>
@endif
