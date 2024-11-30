<x-layout>
    <x-header />
    <main class="d-flex flex-column align-items-center justify-content-center w-100 bg-body-secondary">
        <section class="container d-flex py-3 align-items-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 border py-2 px-3 bg-white rounded">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Collections</li>
                </ol>
            </nav>
        </section>
        <div class="container d-flex flex-column pb-5 flex-wrap">
            <h1 class="text-center"><i class="bi bi-layers-fill me-3"></i>Library Collections</h1>
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
                            'icon'  => 'plus-square',
                            'href'  => '/collections/new',
                            'title' => 'New',
                            'count' => $new_collections_count,
                        ],
                        [
                            'icon'  => 'book',
                            'href'  => '/collections/book',
                            'title' => 'Books',
                            'count' => $books_count,
                        ],
                        [
                            'icon'  => 'journal',
                            'href'  => '/collections/research',
                            'title' => 'Research',
                            'count' => $research_count,
                        ],
                        [
                            'icon'  => 'music-note-beamed',
                            'href'  => '/collections/audio',
                            'title' => 'Audio',
                            'count' => $audios_count,
                        ],
                        [
                            'icon'  => 'film',
                            'href'  => '/collections/video',
                            'title' => 'Video',
                            'count' => $videos_count,
                        ],
                    ];
                @endphp

                @foreach($links as $link)
                    <a href="{{ $link['href'] }}" class="card text-decoration-none p-3 d-block float-start me-3 mb-3" style="height: 150px; width: 200px;">
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
