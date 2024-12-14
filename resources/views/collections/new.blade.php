<x-layout>
    <x-slot:head>
        <link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.bootstrap5.min.css">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/2.1.4/js/dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/2.1.4/js/dataTables.bootstrap5.min.js"></script>
    </x-slot:head>
    <x-header />
    <main class="d-flex flex-column align-items-center justify-content-center w-100 bg-light">
        <section class="container d-flex py-3 align-items-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 border py-2 px-3 bg-white rounded">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item"><a href="/collections">Collections</a></li>
                    <li class="breadcrumb-item active" aria-current="page">New</li>
                </ol>
            </nav>
        </section>
        <div class="container d-flex flex-column pb-5">
            <section>
                <div class="">
                    @php
                        $_items = collect($items);
                        $book_count = $_items->where('type', 'book')->count();
                        $research_count = $_items->where('type', 'research')->count();
                        $audio_count = $_items->where('type', 'audio')->count();
                        $video_count = $_items->where('type', 'video')->count();
                    @endphp
                    <h3 class="mb-3">New Collections</h3>
                    <section class="mb-4">
                        <ul class="nav nav-tabs mb-4">
                            <li class="nav-item">
                                <a class="nav-link active"
                                    aria-current="page"
                                    href="/collections/new">
                                    General
                                    @if(count($items))
                                        <span class="badge text-bg-danger">{{ count($items) }}</span>
                                    @endif
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                    href="/collections/new/book">
                                    Books
                                    @if($book_count)
                                        <span class="badge text-bg-danger">{{ $book_count }}</span>
                                    @endif
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                href="/collections/new/research">
                                Research
                                @if($research_count)
                                    <span class="badge text-bg-danger">{{ $research_count }}</span>
                                @endif
                            </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                    href="/collections/new/book">
                                    Audio
                                    @if($audio_count)
                                        <span class="badge text-bg-danger">{{ $audio_count }}</span>
                                    @endif
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                href="/collections/new/video">
                                Video
                                @if($video_count)
                                    <span class="badge text-bg-danger">{{ $video_count }}</span>
                                @endif
                            </a>
                            </li>
                        </ul>
                    </section>
                    <table id="new-collections-table" class="table">
                        <thead>
                            <tr>
                            <th class="bg-body-secondary text-center">
                                <i class="bi bi-question-circle text-secondary"></i>
                            </th>
                            <th class="bg-body-secondary text-start">Item</th>
                            <th class="bg-body-secondary">Document title</th>
                            <th class="bg-body-secondary">Date Acquired</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td class="text-center" style="min-width: 60px !important;">
                                        @if($item->type=='book')
                                            <i class="bi bi-book text-secondary fs-3"></i>
                                        @elseif($item->type=='research')
                                            <i class="bi bi-journal text-secondary fs-3"></i>
                                        @elseif($item->type=='video')
                                            <i class="bi bi-film text-secondary fs-3"></i>
                                        @elseif($item->type=='audio')
                                            <i class="bi bi-music-note-beamed text-secondary fs-3"></i>
                                        @else
                                            <i class="bi bi-question-circle text-secondary fs-3"></i>
                                        @endif
                                    </td>
                                    <td class="text-start" style="min-width: 150px !important;">
                                        @if($item->barcode)
                                            <a href="/collections/items/{{ $item->title }}/copy/{{ $item->barcode }}">
                                                {{ $item->barcode }}
                                            </a>
                                        @else
                                            <span>--</span>
                                        @endif
                                    </td>
                                    <td style="width: 100%;">
                                        <div class="d-flex">
                                            <section style="height: 110px;" class="card p-1 me-2">
                                                @php $item_cover = ($item->cover_image) ? "/storage/images/$item->type/$item->cover_image" : '/images/cover_not_available.jpg'; @endphp
                                                <object class="h-100 d-block" data="{{ asset($item_cover) }}" type="image/png">
                                                    <img class="h-100 d-block" src="/images/cover_not_available.jpg" alt="">
                                                </object>
                                            </section>
                                            <section>
                                                <div class="d-flex">
                                                    <div class="w-100">
                                                        <a href="/collections/items/{{ $item->title }}/detail" class="link-primary">
                                                            <h5>{{ $item->title }}</h5>
                                                        </a>
                                                    </div>
                                                </div>
                                                <p>
                                                    <b>Author:</b> {{ $item->author }} <br>
                                                    <b>Published:</b> {{ $item->publisher }} ({{ $item->publication_year }}) <br>
                                                    <b>Item type:</b> <span class="text-capitalize">{{ $item->type }}</span>
                                                </p>
                                            </section>
                                        </div>
                                    </td>
                                    <td style="min-width: 150px !important;">
                                        {{ $item->date_acquired }}
                                        <span class="badge text-bg-secondary text-capitalize">{{ $item->status }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>
    <x-footer />
    <x-slot:script>
        <script>
            new DataTable('#new-collections-table');
        </script>
    </x-slot>
</x-layout>
