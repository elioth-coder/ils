<x-layout>
    <x-slot:head>
        <script src="https://cdn.canvasjs.com/ga/canvasjs.min.js"></script>
        <style>
            a.card:hover {
                background-color: #eee;
            }
        </style>
    </x-slot:head>
    @if(in_array(Auth::user()->role, ['admin','librarian']))
        <x-header />
    @else
        <x-header-patron />
    @endif
    <main class="d-flex w-100 bg-light">
        <div class="container d-flex flex-column">
            <h2 class="text-center my-4">NEUST Library Dashboard</h2>
            @if (!in_array(Auth::user()->role, ['teacher', 'student']))
                <div class="d-flex column-gap-3 mb-4">
                    <div class="card p-3 w-50">
                        <div id="patron-chart" style="height: 300px; width: 100%;"></div>
                    </div>
                    <div class="card p-3 w-50">
                        <div id="collection-chart" style="height: 300px; width: 100%;"></div>
                    </div>
                </div>
                <div class="d-flex column-gap-3 mb-4">
                    <a href="/services/patrons" class="card text-decoration-none p-3 w-25">
                        <h4>Patrons</h4>
                        <h1>
                            <i class="bi bi-people-fill" style="font-size: 60px;"></i>
                            {{ $patron_count }}
                        </h1>
                    </a>
                    <a href="/collections" class="card text-decoration-none p-3 w-25">
                        <h4>Collections</h4>
                        <h1>
                            <i class="bi bi-layers-fill" style="font-size: 60px;"></i>
                            {{ $collections_count }}
                        </h1>
                    </a>
                    <a href="/users/visited" class="card text-decoration-none p-3 w-25">
                        <h4>Patrons (Visited)</h4>
                        <h1>
                            <i class="bi bi-people" style="font-size: 60px;"></i>
                            {{ $visitor_count }}
                        </h1>
                    </a>
                    <a href="/services/current_loans" class="card text-decoration-none p-3 w-25">
                        <h4>Collections (On loan)</h4>
                        <h1>
                            <i class="bi bi-layers" style="font-size: 60px;"></i>
                            {{ $on_loan_count }}
                        </h1>
                    </a>
                </div>
            @endif
            <div class="w-full d-flex flex-column">
                <h4 class="my-3">Library Sections</h4>

                @php
                    $library_sections_data = [
                        [
                            'icon' => 'arrow-clockwise',
                            'href' => '/sections/circulation',
                            'title' => 'Circulation',
                            'count' => $library_section_count['circulation'],
                            'color' => 'primary',
                        ],
                        [
                            'icon' => 'flag',
                            'href' => '/sections/filipiniana',
                            'title' => 'Filipiniana',
                            'count' => $library_section_count['filipiniana'],
                            'color' => 'primary-subtle',
                        ],
                        [
                            'icon' => 'newspaper',
                            'href' => '/sections/periodical',
                            'title' => 'Periodical',
                            'count' => $library_section_count['periodical'],
                            'color' => 'success',
                        ],
                        [
                            'icon' => 'bookmark',
                            'href' => '/sections/reference',
                            'title' => 'Reference',
                            'count' => $library_section_count['reference'],
                            'color' => 'success-subtle',
                        ],
                        [
                            'icon' => 'pc-display',
                            'href' => '/sections/e-library',
                            'title' => 'E-Library',
                            'count' => $library_section_count['e-library'],
                            'color' => 'warning',
                        ],
                        [
                            'icon' => 'film',
                            'href' => '/sections/audio-visual',
                            'title' => 'Audio Visual',
                            'count' => $library_section_count['audio-visual'],
                            'color' => 'warning-subtle',
                        ],
                        [
                            'icon' => 'journal',
                            'href' => '/sections/thesis',
                            'title' => 'Thesis',
                            'count' => $library_section_count['thesis'],
                            'color' => 'danger-subtle',
                        ],
                    ];
                @endphp

                @foreach ($library_sections_data as $item)
                    @if ($loop->index == 0 || $loop->index == 4)
                        <div class="d-flex gap-3 mb-4">
                    @endif
                    <a href="{{ $item['href'] }}" class="card text-decoration-none p-3 w-25 bg-{{ $item['color'] }}">
                        <h4>{{ $item['title'] }}</h4>
                        <h1>
                            <i class="bi bi-{{ $item['icon'] }}" style="font-size: 60px;"></i>
                            {{ $item['count'] }}
                        </h1>
                    </a>
                    @if ($loop->last)
                        <div class="p-3 w-25"></div>
                    @endif
                    @if ($loop->index == 3 || $loop->last)
            </div>
            @endif
            @endforeach

        </div>
        <div class="d-flex column-gap-3">
            <div class="" style="width: 60%;">
                <div class="w-full">
                    @php
                        $data_this_month = [
                            [
                                'href' => '/services/item_requests',
                                'icon' => 'ban',
                                'color' => 'danger-subtle',
                                'count' => $on_reserve_count,
                                'label' => 'On reserve items this month',
                            ],
                            [
                                'href' => '/collections/new',
                                'icon' => 'layers',
                                'color' => 'info',
                                'count' => count($new_collections),
                                'label' => 'New collections this month',
                            ],
                            [
                                'href' => '/services/item_requests',
                                'icon' => 'people',
                                'color' => 'success-subtle',
                                'count' => count($new_requests),
                                'label' => 'Requests this month',
                            ],
                            [
                                'href' => '/services/current_loans',
                                'icon' => 'arrow-left-right',
                                'color' => 'success',
                                'count' => count($new_checkouts),
                                'label' => 'Checkouts this month',
                            ],
                            [
                                'href' => '/collections/new/audio',
                                'icon' => 'music-note-beamed',
                                'color' => 'secondary',
                                'count' => count($new_audios),
                                'label' => 'New audios this month',
                            ],
                            [
                                'href' => '/collections/new/video',
                                'icon' => 'film',
                                'color' => 'danger',
                                'count' => count($new_videos),
                                'label' => 'New videos this month',
                            ],
                            [
                                'href' => '/collections/new/book',
                                'icon' => 'book',
                                'color' => 'primary',
                                'count' => count($new_books),
                                'label' => 'New books this month',
                            ],
                            [
                                'href' => '/collections/new/researches',
                                'icon' => 'journal',
                                'color' => 'light',
                                'count' => count($new_researches),
                                'label' => 'New research this month',
                            ],
                        ];
                    @endphp
                    <h4 class="my-3">Data this month</h4>
                    <div class="d-flex column-gap-3 row-gap-3 flex-wrap">
                        @foreach ($data_this_month as $item)
                            <a class="card text-decoration-none p-3 text-center"
                                @if(in_array(Auth::user()->role, ['admin','librarian'])) href="{{ $item['href'] }}" @endif
                                style="max-width: 150px; min-width: 150px;">
                                <h1 class="m-0 bg-{{ $item['color'] }} border p-2">
                                    <i class="bi bi-{{ $item['icon'] }}" style="font-size: 60px;"></i><br>
                                </h1>
                                <h2 class="m-0">{{ $item['count'] }}</h2>
                                <span style="font-size: 12px;">{{ $item['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="" style="width: 40%;">
                <div class="py-3">
                    <x-dashboard.top-collections :items="$top_collections" />
                </div>
            </div>
        </div>
        </div>
    </main>
    <x-footer />
    <x-slot:script>
        @php
            $others_count = $collections_count - ($on_loan_count + $on_reserve_count + $available_count);
        @endphp
        <script>
            const patrons_data = {!! json_encode($patrons_per_program) !!};
            const patronDataPoints = patrons_data.map(data => ({
                y: data.count,
                label: data.program
            }));
            const collectionDataPoints = [
                { label: 'On Loan',    y: {{ $on_loan_count }} },
                { label: 'On Reserve', y: {{ $on_reserve_count }} },
                { label: 'Available',  y: {{ $available_count }} },
                { label: 'Other Status',     y: {{ $others_count }} },
            ];

            window.onload = function() {
                CanvasJS.addColorSet("bootstrap5",
                    [
                        '#0d6efd',
                        '#198754',
                        '#dc3545',
                        '#ffc107',
                        '#0dcaf0',
                        '#cfe2ff',
                        '#d1e7dd',
                        '#f8d7da',
                        '#fff3cd',
                        '#cff4fc',
                    ]);

                var patronChart = new CanvasJS.Chart("patron-chart", {
                    animationEnabled: true,
                    colorSet: 'bootstrap5',
                    title: {
                        text: "Patron Count per Program"
                    },
                    axisY: {
                        title: "Patron Count"
                    },
                    data: [{
                        type: "column",
                        showInLegend: true,
                        legendMarkerColor: "grey",
                        legendText: "Programs",
                        dataPoints: patronDataPoints,
                    }]
                });
                patronChart.render();

                var collectionChart = new CanvasJS.Chart("collection-chart", {
                    animationEnabled: true,
                    colorSet: 'bootstrap5',
                    title: {
                        text: "Number of Collections"
                    },
                    axisY: {
                        title: "Collection Count"
                    },
                    data: [{
                        type: "column",
                        showInLegend: true,
                        legendMarkerColor: "grey",
                        legendText: "Status of Collections",
                        dataPoints: collectionDataPoints,
                    }]
                });
                collectionChart.render();
            }
        </script>
    </x-slot>
</x-layout>
