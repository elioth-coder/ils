<x-layout>
    <x-header />
    <main class="d-flex flex-column align-items-center justify-content-center w-100 bg-light">
        <x-search.searchbar :$totalItems :$limit :$sort_by :$order />
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
                @forelse ($items as $item)
                    <section class="d-flex w-100">
                        <div class="px-4">
                            <section style="height: 150px;" class="card p-1">
                                @php $item_cover = ($item->cover_image) ? "/storage/images/$item->type/$item->cover_image" : '/images/cover_not_available.jpg'; @endphp
                                <object class="h-100 d-block" data="{{ asset($item_cover) }}" type="image/png">
                                    <img class="h-100 d-block" src="/images/cover_not_available.jpg" alt="">
                                </object>
                            </section>
                        </div>
                        <div class="w-100 px-1">
                            <section class="d-flex">
                                <div class="w-100">
                                    <a href="/collections/items/{{ $item->title }}/detail" class="link-primary">
                                        <h4 class="d-inline">{{ $item->title }}</h4></a>
                                    @php
                                    $text = "Title: " . $item->title
                                        . ", Author: " . $item->author
                                        . ", Published: " . $item->publisher . " " . $item->publication_year
                                        . ", Genre: " . $item->genre;
                                    @endphp
                                    <button class="btn btn-outline-dark btn-sm" onclick="textToSpeech('{{ $text }}')">
                                        <i class="bi bi-volume-up-fill text-decoration-none"></i>
                                    </button>
                                </div>
                            </section>
                            <p>
                                <b>Author:</b> {{ $item->author }} <br>
                                <b>Published:</b> {{ $item->publisher }} ({{ $item->publication_year }}) <br>
                                <b>Genre:</b> <span class="badge text-bg-info">{{ $item->genre }}</span> <br>
                                *
                                @if ($item->type == 'book')
                                    <i class="bi bi-book"></i>
                                @endif
                                @if ($item->type == 'research')
                                    <i class="bi bi-journals"></i>
                                @endif
                                @if ($item->type == 'audio')
                                    <i class="bi bi-music-note-beamed"></i>
                                @endif
                                @if ($item->type == 'video')
                                    <i class="bi bi-film"></i>
                                @endif

                                <i class="text-capitalize">{{ $item->type }}</i>
                                <br>

                            <p class="my-1">
                                @if ($item->available > 0)
                                    <i class="bi bi-circle-fill text-success me-1"></i> Available
                                @else
                                    <i class="bi bi-circle-fill text-danger me-1"></i> Not Available
                                @endif
                            </p>

                            @if ($item->tags)
                                <p>
                                    @php
                                        $tags = explode(',', $item->tags) ?? [];
                                    @endphp
                                    @foreach ($tags as $tag)
                                        <a onclick="appendFilter('{{ $tag }}', 'tag')" style="cursor:pointer;"
                                            class="badge text-bg-secondary link-light">
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

                <x-search.pagination :$totalPages :$currentPage :$items :$totalItems :$offset :$limit />
            </div>
        </div>
    </main>
    <x-footer />
    <x-slot:script>
        <script>
            function textToSpeech(text) {
                if ('speechSynthesis' in window) {
                    const utterance = new SpeechSynthesisUtterance(text);
                    window.speechSynthesis.speak(utterance);
                } else {
                    console.error('Text-to-Speech is not supported in this browser.');
                }
            }

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

                if (parsed[parameter]) {
                    let values = parsed[parameter].split(',');
                    let index = values.indexOf(value);

                    if (index < 0) {
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

                delete parsed['page'];
                location.search = queryString.stringify(parsed);
            }
        </script>
    </x-slot:script>
</x-layout>
