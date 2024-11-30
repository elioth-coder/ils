<x-layout>
    <x-slot:head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <style>
            a.card:hover {
                background-color: #eee;
            }
        </style>
    </x-slot:head>
    <x-header />
    <main class="d-flex w-100 bg-light">
        <div class="container d-flex flex-column">
            <h2 class="text-center my-4">NEUST Library Dashboard</h2>
            @if(!in_array(Auth::user()->role, ['teacher','student']))
                <div class="d-flex column-gap-3 mb-4">
                    <div class="card p-3 w-50">
                        <canvas id="patrons-chart"></canvas>
                    </div>
                    <div class="card p-3 w-50">
                        <canvas id="collections-chart"></canvas>
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

                @foreach($library_sections_data as $item)
                    @if($loop->index == 0 || $loop->index == 4)
                        <div class="d-flex gap-3 mb-4">
                    @endif
                        <a href="{{ $item['href'] }}"
                            class="card text-decoration-none p-3 w-25 bg-{{ $item['color'] }}">
                            <h4>{{ $item['title'] }}</h4>
                            <h1>
                                <i class="bi bi-{{ $item['icon'] }}" style="font-size: 60px;"></i>
                                {{ $item['count'] }}
                            </h1>
                        </a>
                    @if($loop->last)
                        <div class="p-3 w-25"></div>
                    @endif
                    @if($loop->index==3 || $loop->last)
                        </div>
                    @endif
                @endforeach

            </div>
            <div class="d-flex column-gap-3">
                <div class="" style="width: 60%;">
                    <div class="w-full">
                        @php
                            $data_this_month = [
                                // [
                                //     'href'  => '/services/current_loans',
                                //     'icon'  => 'arrow-up-right-square',
                                //     'color' => 'warning-subtle',
                                //     'count' => $on_loan_count,
                                //     'label' => 'On loan items this month',
                                // ],
                                [
                                    'href'  => '/services/item_requests',
                                    'icon'  => 'ban',
                                    'color' => 'danger-subtle',
                                    'count' => $on_reserve_count,
                                    'label' => 'On reserve items this month',
                                ],
                                [
                                    'href'  => '/collections/new',
                                    'icon'  => 'layers',
                                    'color' => 'info',
                                    'count' => count($new_collections),
                                    'label' => 'New collections this month',
                                ],
                                // [
                                //     'href'  => '/users/visited',
                                //     'icon'  => 'people',
                                //     'color' => 'warning',
                                //     'count' => $visitor_count,
                                //     'label' => 'Visitors this month',
                                // ],
                                [
                                    'href'  => '/services/item_requests',
                                    'icon'  => 'people',
                                    'color' => 'success-subtle',
                                    'count' => count($new_requests),
                                    'label' => 'Requests this month',
                                ],
                                [
                                    'href'  => '/services/current_loans',
                                    'icon'  => 'arrow-left-right',
                                    'color' => 'success',
                                    'count' => count($new_checkouts),
                                    'label' => 'Checkouts this month',
                                ],
                                [
                                    'href'  => '/collections/new/audio',
                                    'icon'  => 'music-note-beamed',
                                    'color' => 'secondary',
                                    'count' => count($new_audios),
                                    'label' => 'New audios this month',
                                ],
                                [
                                    'href'  => '/collections/new/video',
                                    'icon'  => 'film',
                                    'color' => 'danger',
                                    'count' => count($new_videos),
                                    'label' => 'New vides this month',
                                ],
                                [
                                    'href'  => '/collections/new/book',
                                    'icon'  => 'book',
                                    'color' => 'primary',
                                    'count' => count($new_books),
                                    'label' => 'New books this month',
                                ],
                                [
                                    'href'  => '/collections/new/researches',
                                    'icon'  => 'journal',
                                    'color' => 'light',
                                    'count' => count($new_researches),
                                    'label' => 'New research this month',
                                ],
                            ]
                        @endphp
                        <h4 class="my-3">Data this month</h4>
                        <div class="d-flex column-gap-3 row-gap-3 flex-wrap">
                            @foreach($data_this_month as $item)
                                <a href="{{ $item['href'] }}" class="card text-decoration-none p-3 text-center" style="max-width: 150px; min-width: 150px;">
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
            const patronsChart = document.getElementById('patrons-chart');
            const patrons_data = {!! json_encode($patrons_per_program) !!};

            new Chart(patronsChart, {
                type: 'bar',
                data: {
                    labels: patrons_data.map(item => item.program),
                    datasets: [{
                        label: 'Number of Patrons',
                        data: patrons_data.map(item => item.count),
                        backgroundColor: [
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
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            const collectionsChart = document.getElementById('collections-chart');
            const collections_data = [
                { label: 'On Loan',    value: {{ $on_loan_count }} },
                { label: 'On Reserve', value: {{ $on_reserve_count }} },
                { label: 'Available',  value: {{ $available_count }} },
                { label: 'Others',     value: {{ $others_count }} },
            ];

            new Chart(collectionsChart, {
                type: 'bar',
                data: {
                    labels: collections_data.map(item => item.label),
                    datasets: [{
                        label: 'Number of Collections',
                        data: collections_data.map(item => item.value),
                        backgroundColor: [
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
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    </x-slot>
</x-layout>
