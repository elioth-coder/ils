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
        <div class="container d-flex flex-column pb-5">
            <h1 class="text-center"><i class="bi bi-layers-fill me-3"></i>Collections</h1>
            <hr>
            <div class="d-flex align-items-center justify-content-center gap-3 py-5">
                @php
                    $links = [
                        [
                            'icon'  => 'book',
                            'href'  => '/collections/book',
                            'title' => 'Books',
                        ],
                        [
                            'icon'  => 'file-earmark-text',
                            'href'  => '/collections/research_papers',
                            'title' => 'Researches',
                        ],
                        [
                            'icon'  => 'file-earmark-richtext',
                            'href'  => '/collections/print_periodicals',
                            'title' => 'Periodicals',
                        ],                        [
                            'icon'  => 'disc',
                            'href'  => '/collections/cd_dvds',
                            'title' => 'CD/DVDs',
                        ],                        [
                            'icon'  => 'file-earmark-pdf',
                            'href'  => '/collections/pdfs',
                            'title' => 'PDFs',
                        ],
                    ];
                @endphp

                @foreach($links as $link)
                    <a class="card link-secondary text-decoration-none" href="{{ $link['href'] }}">
                        <div class="card-body d-flex">
                            <h3>
                                <i class="bi bi-{{ $link['icon'] }} me-2"></i>
                                {{ $link['title'] }}
                            </h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </main>
    <x-footer />
</x-layout>
