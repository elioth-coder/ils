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
            <div class="d-flex column-gap-3">
                <div class="" style="width: 60%;">
                    <h4 class="my-3">Data this month</h4>
                    <div class="d-flex column-gap-3 row-gap-3 flex-wrap">
                        <a href="/services/current_loans" class="card text-decoration-none p-3 text-center" style="max-width: 150px; min-width: 150px;">
                            <h1 class="m-0 bg-warning-subtle border p-2">
                                <i class="bi bi-arrow-up-right-square" style="font-size: 60px;"></i><br>
                            </h1>
                            <h2 class="m-0">{{ $on_loan_count }}</h2>
                            <span style="font-size: 12px;">On loan items this month</span>
                        </a>
                        <a href="/services/item_requests" class="card text-decoration-none p-3 text-center" style="max-width: 150px; min-width: 150px;">
                            <h1 class="m-0 bg-danger-subtle border p-2">
                                <i class="bi bi-ban" style="font-size: 60px;"></i><br>
                            </h1>
                            <h2 class="m-0">{{ $on_reserve_count }}</h2>
                            <span style="font-size: 12px;">On reserve items this month</span>
                        </a>

                        <a href="/collections/new" class="card text-decoration-none p-3 text-center" style="max-width: 150px; min-width: 150px;">
                            <h1 class="m-0 bg-info border p-2">
                                <i class="bi bi-layers" style="font-size: 60px;"></i><br>
                            </h1>
                            <h2 class="m-0">{{ count($new_collections) }}</h2>
                            <span style="font-size: 12px;">New collections this month</span>
                        </a>
                        <a href="/users/visited" class="card text-decoration-none p-3 text-center" style="max-width: 150px; min-width: 150px;">
                            <h1 class="m-0 bg-warning border p-2">
                                <i class="bi bi-people" style="font-size: 60px;"></i><br>
                            </h1>
                            <h2 class="m-0">{{ $visitor_count }}</h2>
                            <span style="font-size: 12px;">Visitors this month</span>
                        </a>
                        <a href="/services/item_requests" class="card text-decoration-none p-3 text-center" style="max-width: 150px; min-width: 150px;">
                            <h1 class="m-0 bg-success-subtle border p-2">
                                <i class="bi bi-basket" style="font-size: 60px;"></i><br>
                            </h1>
                            <h2 class="m-0">{{ count($new_requests) }}</h2>
                            <span style="font-size: 12px;">Requests this month</span>
                        </a>
                        <a href="/services/current_loans" class="card text-decoration-none p-3 text-center" style="max-width: 150px; min-width: 150px;">
                            <h1 class="m-0 bg-success border p-2">
                                <i class="bi bi-arrow-left-right" style="font-size: 60px;"></i><br>
                            </h1>
                            <h2 class="m-0">{{ count($new_checkouts) }}</h2>
                            <span style="font-size: 12px;">Checkouts this month</span>
                        </a>
                        <a href="/collections/new/audio" class="card text-decoration-none p-3 text-center" style="max-width: 150px; min-width: 150px;">
                            <h1 class="m-0 bg-secondary border p-2">
                                <i class="bi bi-music-note-beamed" style="font-size: 60px;"></i><br>
                            </h1>
                            <h2 class="m-0">{{ count($new_audios) }}</h2>
                            <span style="font-size: 12px;">New audios this month</span>
                        </a>
                        <a href="/collections/new/video" class="card text-decoration-none p-3 text-center" style="max-width: 150px; min-width: 150px;">
                            <h1 class="m-0 bg-danger border p-2">
                                <i class="bi bi-film" style="font-size: 60px;"></i><br>
                            </h1>
                            <h2 class="m-0">{{ count($new_videos) }}</h2>
                            <span style="font-size: 12px;">New videos this month</span>
                        </a>
                        <a href="/collections/new/book" class="card text-decoration-none p-3 text-center" style="max-width: 150px; min-width: 150px;">
                            <h1 class="m-0 bg-primary border p-2">
                                <i class="bi bi-book" style="font-size: 60px;"></i><br>
                            </h1>
                            <h2 class="m-0">{{ count($new_books) }}</h2>
                            <span style="font-size: 12px;">New books this month</span>
                        </a>
                        <a href="/collections/new/research" class="card text-decoration-none p-3 text-center" style="max-width: 150px; min-width: 150px;">
                            <h1 class="m-0 bg-light border p-2">
                                <i class="bi bi-journal" style="font-size: 60px;"></i><br>
                            </h1>
                            <h2 class="m-0">{{ count($new_researches) }}</h2>
                            <span style="font-size: 12px;">New research this month</span>
                        </a>
                    </div>
                </div>
                <div class="" style="width: 40%;">
                    <div class="py-3">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th colspan="2" class="text-center">
                                        <h4>Top Collections</h4>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($top_collections as $item)
                                    <tr>
                                        <td class="text-center">
                                            <section style="height: 110px;" class="card p-1 mx-auto position-relative">
                                                @php $item_cover = ($item->cover_image) ? "/storage/images/$item->type/$item->cover_image" : '/images/cover_not_available.jpg'; @endphp
                                                <object class="h-100 d-block" data="{{ asset($item_cover) }}"
                                                    type="image/png">
                                                    <img class="h-100 d-block" src="/images/cover_not_available.jpg"
                                                        alt="">
                                                </object>
                                                <h5 style="width: 30px;"
                                                    class="mb-1 me-1 d-block position-absolute top-0 z-10 bg-white">
                                                    #{{ $loop->index + 1 }}
                                                </h5>
                                            </section>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <section>
                                                    <div class="d-flex">
                                                        <div class="w-100">
                                                            <a href="/collections/items/{{ $item->title }}/detail"
                                                                class="link-primary">
                                                                <h6>{{ $item->title }}</h6>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <p>
                                                        Author: {{ $item->author }} <br>
                                                        <i>Checked out {{ $item->count }}
                                                            {{ $item->count > 1 ? 'times' : 'time' }}</i>
                                                    </p>
                                                </section>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
