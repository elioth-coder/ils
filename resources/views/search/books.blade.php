<x-layout>
    <x-header />
    <main class="d-flex flex-column align-items-center justify-content-center w-100 bg-light">
        <x-search.searchbar :$books />
        <div class="container pb-3">
            @foreach ($filters as $filter)
                @php
                    $key = $filter[0];
                    $value = $filter[1];
                    $disabled = $key == 'library' && $value == $library;
                @endphp
                <button {{ $disabled ? 'disabled' : '' }}
                    onclick="removeFilter('{{ $key }}', '{{ $value }}');"
                    class="btn btn-outline-dark btn-sm">
                    {{ $value }}
                    <i class="bi bi-x-lg"></i>
                </button>
            @endforeach
        </div>
        <div class="container py-2 d-flex">
            <x-search.sidebar :$libraries :$publishers :$genres :$formats :$statuses :$tags :$filters />
            <div class="w-100 ps-4">
                @forelse ($books as $book)
                    <section class="d-flex w-100">
                        <div class="px-4">
                            <section style="height: 150px;" class="card p-1">
                                @php $book_cover = ($book->cover_image) ? "/storage/images/books/$book->cover_image" : '/images/book_cover_not_available.jpg'; @endphp
                                <img class="h-100 d-block" src="{{ asset($book_cover) }}" alt="">
                            </section>
                        </div>
                        <div class="w-100 px-1">
                            <section class="d-flex">
                                <div class="w-100">
                                    <a href="/collections/books/{{ $book->isbn }}/detail" class="link-primary">
                                        <h4>{{ $book->title }}</h4>
                                    </a>
                                </div>
                                @if(request('isbn'))
                                    <div style="min-width: 80px;" class="text-end">
                                        <a href="/collections/books/{{ $book->id }}/edit#books-form" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                @endif
                            </section>
                            <p>
                                @if(request('isbn'))
                                    Barcode: [ {{ $book->barcode_number ?? '--' }} ] <br>
                                @endif
                                ISBN: {{ $book->isbn }} <br>
                                Author: {{ $book->author }} <br>
                                Published in: {{ $book->publisher }} ({{ $book->publication_year }}) <br>
                                Format: <span class="text-capitalize">{{ $book->format }}</span> <br>
                                @if(request('isbn'))
                                    Library: {{ $book->library }} <br>
                                @else
                                    @php
                                        $copies_url = "/search/books?isbn=$book->isbn";

                                        if(request()->input('library')) {
                                            $copies_url .= "&library=" . request()->input('library');
                                        }
                                    @endphp
                                    Copies: <a href="{{ $copies_url }}">({{ $book->copies }})</a><br>
                                @endif

                                <br>
                                @if(request('isbn'))
                                    @php
                                    $colors = [
                                        'available'   => 'success',
                                        'checked out' => 'warning',
                                        'damaged'     => 'warning',
                                        'missing'     => 'danger',
                                    ];
                                    @endphp

                                    <i class="bi bi-circle-fill text-{{ $colors[$book->status] }} me-2"></i>
                                    <span class="text-capitalize">{{ $book->status }}</span>
                                @else
                                    @if ($book->available > 0)
                                        <i class="bi bi-circle-fill text-success me-2"></i> Available
                                    @else
                                        <i class="bi bi-circle-fill text-danger me-2"></i> Not Available
                                    @endif
                                @endif

                                @if ($book->tags)
                                    <p>
                                        @php
                                            $tags = explode(',', $book->tags) ?? [];
                                        @endphp
                                        @foreach ($tags as $tag)
                                            <a onclick="appendFilter('{{ $tag }}', 'tag')" style="cursor:pointer;" class="badge text-bg-secondary link-light">
                                                {{ $tag }}
                                            </a>
                                        @endforeach
                                    </p>
                                @endif
                            </p>
                        </div>
                    </section>
                    @if (!$loop->last)
                        <hr>
                    @endif
                @empty
                    <h3 class="text-center">No results found.</h3>
                @endforelse
            </div>
        </div>
    </main>
    <x-footer />
    <x-slot:script>
        <script>
            function applyYearFilter() {
                $from = document.getElementById('from').value.trim();
                $to = document.getElementById('to').value.trim();

                if ($from == '' || $to == '') {
                    alert('Set both START and END value of publication year to apply filter');
                    return;
                }

                if (parseInt($to) < parseInt($from)) {
                    alert("The END publication year can't be less than the START");
                    return;
                }

                let parsed = queryString.parse(location.search);
                parsed['year'] = `${$from}-${$to}`;
                delete parsed['isbn'];

                location.search = queryString.stringify(parsed);
            }

            function clearYearFilter() {
                let parsed = queryString.parse(location.search);
                delete parsed['year'];
                delete parsed['isbn'];

                location.search = queryString.stringify(parsed);
            }

            function removeFilter(parameter, value) {
                let parsed = queryString.parse(location.search);

                let parameters = parsed[parameter].split(',');
                parameters.splice(parameters.indexOf(value), 1);

                if (parameters.length) {
                    parsed[parameter] = parameters.join(',');
                } else {
                    delete parsed[parameter];
                }

                location.search = queryString.stringify(parsed);
            }

            function appendFilter(value, parameter) {
                let parsed = queryString.parse(location.search);

                if(parsed[parameter]) {
                    let values = parsed[parameter].split(',');
                    let index = values.indexOf(value);

                    if(index < 0) {
                        values.push(value);
                    }

                    parsed[parameter] = values.join(',');
                } else {
                    parsed[parameter] = value;
                }

                console.log(parsed);

                delete parsed['isbn'];
                location.search = queryString.stringify(parsed);
            }

            function addFilter(checkbox, parameter) {
                let parsed = queryString.parse(location.search);

                if (checkbox.checked) {
                    if (parsed[parameter]) {
                        parsed[parameter] += ',' + checkbox.value;
                    } else {
                        parsed[parameter] = checkbox.value;
                    }

                } else {
                    let parameters = parsed[parameter].split(',');
                    parameters.splice(parameters.indexOf(checkbox.value), 1);
                    parsed[parameter] = parameters.join(',');
                }

                delete parsed['isbn'];
                location.search = queryString.stringify(parsed);
            }
        </script>
    </x-slot:script>
</x-layout>
