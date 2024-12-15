<x-layout>
    <x-header />
    <main class="d-flex align-items-center justify-content-center w-100 bg-light">
        <div class="container d-flex flex-column py-4">
            <form action="/reports/item_list" method="GET" class="card p-3">
                @method('GET')
                <div class="d-flex column-gap-2 mb-1">
                    <div class="w-25">
                        @php
                            $date_acquired_start = request('date_acquired_start') ?? '';
                        @endphp
                        <label for="date_acquired_start" class="form-label">Date acquired (From)</label>
                        <input type="date" value="{{ $date_acquired_start }}" name="date_acquired_start" id="date_acquired_start" class="form-control form-control-sm">
                    </div>
                    <div class="w-25">
                        @php
                            $date_acquired_end = request('date_acquired_end') ?? '';
                        @endphp
                        <label for="date_acquired_end" class="form-label">Date acquired (Until)</label>
                        <input type="date" value="{{ $date_acquired_end }}" name="date_acquired_end" id="date_acquired_end" class="form-control form-control-sm">
                    </div>
                    <div class="w-25">
                        @php
                            $_publisher = request('publisher') ?? '';
                        @endphp
                        <label for="publisher" class="form-label">Publisher</label>
                        <select name="publisher" id="publisher" class="form-control form-control-sm">
                            <option value="">--</option>
                            @foreach ($publishers as $publisher)
                                <option {{ $publisher == $_publisher ? 'selected' : '' }} value="{{ $publisher }}">
                                    {{ $publisher }}</option>
                            @endforeach
                        </select>
                    </div>
                    @php
                        $year = request('publication_year');
                        $years = explode('-', $year);
                        $max_year = (int) date('Y');
                        $min_year = 1500;
                        $from = $year ? $years[0] : '';
                        $to = $year ? $years[1] : '';
                        $is_filtered = $year ? true : false;
                        $_publication_year = request('publication_year') ?? '';
                    @endphp
                    <div class="w-25">
                        <label for="" class="form-label">Publication year</label>
                        <input type="hidden" id="publication_year" name="publication_year"
                            value="{{ $_publication_year }}">
                        <div class="input-group input-group-sm">
                            <select onchange="updatePublicationYear();" id="from"
                                class="form-control form-control-sm form-control form-control-sm-sm">
                                <option value="">-- From --</option>
                                @for ($i = $max_year; $i >= $min_year; $i--)
                                    <option {{ $from == $i ? 'selected' : '' }} value="{{ $i }}">
                                        {{ $i }}</option>
                                @endfor
                            </select>
                            <span class="input-group-text">
                                <>
                            </span>
                            <select onchange="updatePublicationYear();" id="to"
                                class="form-control form-control-sm form-control form-control-sm-sm">
                                <option value="">-- Until --</option>
                                @for ($i = $max_year; $i >= $min_year; $i--)
                                    <option {{ $to == $i ? 'selected' : '' }} value="{{ $i }}">
                                        {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
                <div class="d-flex column-gap-2 mb-2">
                    <div class="w-25">
                        @php
                            $types = ['book', 'research', 'audio', 'video'];

                            $_type = request('type') ?? '';
                        @endphp
                        <label for="type" class="form-label">Type</label>
                        <select class="form-control form-control-sm text-capitalize" name="type" id="type">
                            <option value="">--</option>
                            @foreach ($types as $type)
                                <option {{ $type == $_type ? 'selected' : '' }} value="{{ $type }}">
                                    {{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-25">
                        @php
                            $formats = ['hardcover', 'paperback', 'ebook', 'cd', 'dvd'];

                            $_format = request('format') ?? '';
                        @endphp
                        <label for="format" class="form-label">Format</label>
                        <select class="form-control form-control-sm text-capitalize" name="format" id="format">
                            <option value="">--</option>
                            @foreach ($formats as $format)
                                <option {{ $format == $_format ? 'selected' : '' }} value="{{ $format }}">
                                    {{ $format }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-25">
                        @php
                            $genres = [
                                'fiction',
                                'non-fiction',
                                'mystery',
                                'thriller',
                                'science fiction',
                                'fantasy',
                                'romance',
                                'horror',
                                'biography',
                                'autobiography',
                                'history',
                                'philosophy',
                                'science',
                                'self-help',
                                'health & wellness',
                                'travel',
                                'children’s',
                                'young adult',
                                'graphic novel',
                                'poetry',
                                'drama',
                                'classic',
                                'adventure',
                                'crime',
                                'cooking',
                                'art',
                                'business',
                                'comics',
                                'humor',
                                'religious',
                                'short stories',
                                'developmental',
                                'descriptive',
                                'analytical',
                                'exploratory',
                                'explanatory',
                                'experimental',
                                'correlational',
                                'comparative',
                                'action',
                                'case study',
                                'phenomenological',
                                'ethnographic',
                                'historical',
                            ];

                            $_genre = request('genre') ?? '';
                        @endphp
                        <label for="genre" class="form-label">Genre</label>
                        <select class="form-control form-control-sm text-capitalize" name="genre" id="genre">
                            <option value="">--</option>
                            @foreach ($genres as $genre)
                                <option {{ $genre == $_genre ? 'selected' : '' }} value="{{ $genre }}">
                                    {{ $genre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-25">
                        @php
                            $statuses = [
                                'available',
                                'checked out',
                                'reserved',
                                'no barcode',
                                'missing',
                                'damaged',
                                'reference only',
                            ];

                            $_status = request('status') ?? '';
                        @endphp
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control form-control-sm text-capitalize" name="status" id="status">
                            <option value="">--</option>
                            @foreach ($statuses as $status)
                                <option {{ $status == $_status ? 'selected' : '' }} value="{{ $status }}">
                                    {{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-sm btn-primary">Apply Filter</button>
                    <a href="/{{ request()->path() }}" class="btn btn-sm btn-danger">Clear Filter</a>
                </div>
            </form>

            <h2 class="text-center my-3">List of Inventory Items</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-end">#</th>
                        <th>Date Acquired</th>
                        <th>Barcode</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Publisher</th>
                        <th>Year</th>
                        <th>Genre</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                        <tr>
                            <td class="text-end">{{ $loop->index + 1 }}.</td>
                            <td style="width: 120px;">{{ $item->date_acquired ? date('Y-M-d', strtotime($item->date_acquired)) : '' }}</td>
                            <td>{{ $item->barcode }}</td>
                            <td>{{ $item->title }}</td>
                            <td class="text-capitalize">{{ $item->type }}</td>
                            <td>{{ $item->publisher }}</td>
                            <td>{{ $item->publication_year }}</td>
                            <td class="text-capitalize">{{ $item->genre }}</td>
                            <td class="text-capitalize">{{ $item->status }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">
                                <h1 class="text-center text-muted">No data found.</h1>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- <div class="w-full text-end">
                <a href="/reports/item_list/print?{{ request()->getQueryString() }}" class="btn btn-warning">
                    <i class="bi bi-print"></i>
                    Print Report
                </a>
            </div>
            <div class="d-flex justify-content-end pe-5 w-100 mb-3"> -->

        </div>
    </main>
    <div class="d-flex justify-content-end pe-5 w-100 mb-3">
                <button id="printButton" class="btn btn-primary">Print</button>
            </div>
            </div>
    <x-footer />
    <x-slot:script>
        <script>
            function updatePublicationYear() {
                let $publication_year = document.querySelector('#publication_year');
                let $from = document.querySelector('#from');
                let $to = document.querySelector('#to');

                let date = new Date();
                console.log(date.getFullYear());
                console.log($from.value, $to.value);
                let from = $from.value ? $from.value : '1950';
                let to = $to.value ? $to.value : date.getFullYear();
                let year = `${from}-${to}`;
                $publication_year.value = year;
            }


            document.getElementById('printButton').addEventListener('click', () => {
                    const params = new URLSearchParams({
                        date_acquired_start: document.getElementById('date_acquired_start').value,
                        date_acquired_end: document.getElementById('date_acquired_end').value,
                        publisher: document.getElementById('publisher').value,
                        publication_year: document.getElementById('publication_year').value,
                        type: document.getElementById('type').value,
                        format: document.getElementById('format').value,
                        genre: document.getElementById('genre').value,
                        status: document.getElementById('status').value
                    });
                    window.location.href = `/reports/item_list/print?_method=GET&${params.toString()}`;
                });
        </script>
    </x-slot>
</x-layout>
