<x-layout>
    <x-header />
    <main class="d-flex flex-column align-items-center justify-content-center w-100 bg-body-secondary">
        <section class="container d-flex py-3 align-items-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 border py-2 px-3 bg-white rounded">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Sections</li>
                </ol>
            </nav>
        </section>
        <div class="container d-flex flex-column pb-5 flex-wrap">
            <h1 class="text-center"><i class="bi bi-layers-fill me-3"></i>Library Sections</h1>
            <hr>
            <style>
                a.card:hover {
                    background-color: #eee;
                }
            </style>
            <div class="d-block mb-4">
                @php
                    $links = [
                        [
                            'icon' => 'arrow-clockwise',
                            'href' => '/sections/circulation',
                            'title' => 'Circulation',
                            'count' => $count['circulation'],
                            'color' => 'primary',
                        ],
                        [
                            'icon' => 'flag',
                            'href' => '/sections/filipiniana',
                            'title' => 'Filipiniana',
                            'count' => $count['filipiniana'],
                            'color' => 'primary-subtle',
                        ],
                        [
                            'icon' => 'newspaper',
                            'href' => '/sections/periodical',
                            'title' => 'Periodical',
                            'count' => $count['periodical'],
                            'color' => 'success',
                        ],
                        [
                            'icon' => 'bookmark',
                            'href' => '/sections/reference',
                            'title' => 'Reference',
                            'count' => $count['reference'],
                            'color' => 'success-subtle',
                        ],
                        [
                            'icon' => 'pc-display',
                            'href' => '/sections/e-library',
                            'title' => 'E-Library',
                            'count' => $count['e-library'],
                            'color' => 'warning',
                        ],
                        [
                            'icon' => 'film',
                            'href' => '/sections/audio-visual',
                            'title' => 'Audio Visual',
                            'count' => $count['audio-visual'],
                            'color' => 'warning-subtle',
                        ],
                        [
                            'icon' => 'journal',
                            'href' => '/sections/thesis',
                            'title' => 'Thesis',
                            'count' => $count['thesis'],
                            'color' => 'danger-subtle',
                        ],
                    ];
                @endphp

                @foreach($links as $link)
                    <a href="{{ $link['href'] }}" class="card bg-{{ $link['color'] }} text-decoration-none p-3 d-block float-start me-3 mb-3" style="height: 170px; width: 250px;">
                        <h3>{{ $link['title'] }}</h3>
                        <h1>
                            {{ $link['count'] }}
                            <i class="bi bi-{{ $link['icon'] }}" style="font-size: 60px;"></i>
                        </h1>
                    </a>
                @endforeach
            </div>
        </div>
    </main>
    <x-footer />
</x-layout>
