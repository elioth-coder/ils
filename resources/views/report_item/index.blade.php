<x-layout>
    <x-slot:head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.bootstrap5.min.css">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/2.1.4/js/dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/2.1.4/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </x-slot:head>
    <x-header />
    <main class="d-flex flex-column align-items-center justify-content-center w-100 bg-body-secondary">
        <section class="container d-flex py-3 align-items-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 border py-2 px-3 bg-white rounded">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item"><a href="/services">Services</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Report Item</li>
                </ol>
            </nav>
        </section>
        <div class="container d-flex flex-column pb-5">
            <section>
                <div class="">
                    <h3 class="mb-4">Report Item</h3>
                    @if (session('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <section class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill fs-4 me-2"></i>
                                {{ session('message') }}
                            </section>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="items-tab" data-bs-toggle="tab" data-bs-target="#items"
                                type="button" role="tab" aria-controls="items" aria-selected="true">
                                Items
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reported-items-tab" data-bs-toggle="tab"
                                data-bs-target="#reported-items" type="button" role="tab"
                                aria-controls="reported-items" aria-selected="true">
                                Reported Items
                                @if (count($reported_items))
                                    <span class="badge text-bg-danger">{{ count($reported_items) }}</span>
                                @endif
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content p-4 bg-white border border-top-0 rounded rounded-top-0">
                        <div class="tab-pane active" id="items" role="tabpanel" aria-labelledby="items-tab"
                            tabindex="0">
                            <table id="items-table" class="table">
                                <thead>
                                    <tr>
                                        <th class="bg-body-secondary">#</th>
                                        <th class="bg-body-secondary text-start">Item</th>
                                        <th class="bg-body-secondary">Document title</th>
                                        <th class="bg-body-secondary">Status</th>
                                        <th class="bg-body-secondary text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $item)
                                        <tr>
                                            <td class="text-center" style="min-width: 60px !important;">
                                                @if ($item->type == 'book')
                                                    <i class="bi bi-book text-secondary fs-3"></i>
                                                @elseif($item->type == 'research')
                                                    <i class="bi bi-journal text-secondary fs-3"></i>
                                                @elseif($item->type == 'video')
                                                    <i class="bi bi-film text-secondary fs-3"></i>
                                                @elseif($item->type == 'audio')
                                                    <i class="bi bi-music-note-beamed text-secondary fs-3"></i>
                                                @else
                                                    <i class="bi bi-question-circle text-secondary fs-3"></i>
                                                @endif
                                            </td>
                                            <td class="text-start" style="width: 150px;">
                                                <a
                                                    href="/collections/items/{{ $item->title }}/copy/{{ $item->barcode }}">
                                                    {{ $item->barcode }}
                                                </a>
                                            </td>
                                            <td class="w-50">
                                                <div class="d-flex">
                                                    <section style="height: 110px;" class="card p-1 me-2">
                                                        @php $item_cover = ($item->cover_image) ? "/storage/images/$item->type/$item->cover_image" : '/images/cover_not_available.jpg'; @endphp
                                                        <object class="h-100 d-block" data="{{ asset($item_cover) }}"
                                                            type="image/png">
                                                            <img class="h-100 d-block"
                                                                src="/images/cover_not_available.jpg" alt="">
                                                        </object>
                                                    </section>
                                                    <section>
                                                        <div class="d-flex">
                                                            <div class="w-100">
                                                                <a href="/collections/items/{{ $item->title }}/detail"
                                                                    class="link-primary">
                                                                    <h5>{{ $item->title }}</h5>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <p>
                                                            <b>Author:</b> {{ $item->author }} <br>
                                                            <b>Published:</b> {{ $item->publisher }}
                                                            ({{ $item->publication_year }}) <br>
                                                        </p>
                                                    </section>
                                                </div>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge text-bg-secondary text-capitalize">{{ $item->status }}</span>
                                            </td>
                                            <td class="text-center" style="max-width: 120px;">
                                                <a href="/services/report_item/{{ $item->id }}"
                                                    class="btn btn-danger">Report Item</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="reported-items" role="tabpanel" aria-labelledby="reported-items-tab"
                            tabindex="0">
                            <table id="items-table" class="table">
                                <thead>
                                    <tr>
                                        <th class="bg-body-secondary">#</th>
                                        <th class="bg-body-secondary text-start">Item</th>
                                        <th class="bg-body-secondary">Document title</th>
                                        <th class="bg-body-secondary">Status</th>
                                        <th class="bg-body-secondary">Reported by</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reported_items as $item)
                                        <tr>
                                            <td class="text-center" style="min-width: 60px !important;">
                                                @if ($item->type == 'book')
                                                    <i class="bi bi-book text-secondary fs-3"></i>
                                                @elseif($item->type == 'research')
                                                    <i class="bi bi-journal text-secondary fs-3"></i>
                                                @elseif($item->type == 'video')
                                                    <i class="bi bi-film text-secondary fs-3"></i>
                                                @elseif($item->type == 'audio')
                                                    <i class="bi bi-music-note-beamed text-secondary fs-3"></i>
                                                @else
                                                    <i class="bi bi-question-circle text-secondary fs-3"></i>
                                                @endif
                                            </td>
                                            <td class="text-start" style="width: 150px;">
                                                <a
                                                    href="/collections/items/{{ $item->title }}/copy/{{ $item->barcode }}">
                                                    {{ $item->barcode }}
                                                </a>
                                            </td>
                                            <td class="w-50">
                                                <div class="d-flex">
                                                    <section style="height: 110px;" class="card p-1 me-2">
                                                        @php $item_cover = ($item->cover_image) ? "/storage/images/$item->type/$item->cover_image" : '/images/cover_not_available.jpg'; @endphp
                                                        <object class="h-100 d-block" data="{{ asset($item_cover) }}"
                                                            type="image/png">
                                                            <img class="h-100 d-block"
                                                                src="/images/cover_not_available.jpg" alt="">
                                                        </object>
                                                    </section>
                                                    <section>
                                                        <div class="d-flex">
                                                            <div class="w-100">
                                                                <a href="/collections/items/{{ $item->title }}/detail"
                                                                    class="link-primary">
                                                                    <h5>{{ $item->title }}</h5>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <p>
                                                            <b>Author:</b> {{ $item->author }} <br>
                                                            <b>Published:</b> {{ $item->publisher }}
                                                            ({{ $item->publication_year }}) <br>
                                                        </p>
                                                    </section>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge text-bg-secondary text-capitalize">
                                                    {{ $item->status }}
                                                </span><br>
                                                <p>{{ $item->details }}</p>
                                            </td>
                                            <td class="" style="min-width: 170px;">
                                                <p class="text-capitalize m-0">
                                                    <a href="/services/checkouts/{{ $item->reporter->card_number }}/patron">
                                                        {{ strtolower($item->reporter->first_name) }}
                                                        {{ strtolower($item->reporter->last_name) }}
                                                    </a>
                                                </p>
                                                {{ $item->created_at }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <x-footer />
    <x-slot:script>
        <script>
            new DataTable('#items-table');
            new DataTable('#reported-items-table');
        </script>
    </x-slot>
</x-layout>
