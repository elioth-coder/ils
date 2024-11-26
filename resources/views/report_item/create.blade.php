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
                    <li class="breadcrumb-item"><a href="/report_item">Report Item</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $selected->barcode }}</li>
                </ol>
            </nav>
        </section>
        <div class="container d-flex flex-column pb-5">
            <section>
                <div class="">
                    <div class="w-50 mb-3">
                        <a href="/services/report_item" class="btn btn-outline-success btn-sm">
                            <i class="bi bi-arrow-left"></i>
                            Back
                        </a>
                    </div>

                    <div class="d-flex column-gap-3">
                        <div class="w-100 card p-3">
                            <div class="card-body">
                                <h3 class="text-body-secondary">Report Item</h3>
                                <hr>
                                <div class="d-flex">
                                    <section style="height: 150px;" class="card p-1 me-2">
                                        @php $item_cover = ($selected->cover_image) ? "/storage/images/$selected->type/$selected->cover_image" : '/images/cover_not_available.jpg'; @endphp
                                        <object class="h-100 d-block" data="{{ asset($item_cover) }}" type="image/png">
                                            <img class="h-100 d-block" src="/images/cover_not_available.jpg"
                                                alt="">
                                        </object>
                                    </section>
                                    <section>
                                        <div class="d-flex">
                                            <div class="w-100">
                                                <a href="/collections/items/{{ $selected->title }}/detail"
                                                    class="link-primary">
                                                    <h5>{{ $selected->title }}</h5>
                                                </a>
                                            </div>
                                        </div>
                                        <p>
                                            <b>Barcode: </b>
                                            <a
                                                href="/collections/items/{{ $selected->title }}/copy/{{ $selected->barcode }}">
                                                {{ $selected->barcode }}
                                            </a> <br>
                                            <b>Author:</b> {{ $selected->author }} <br>
                                            <b>Published:</b> {{ $selected->publisher }}
                                            ({{ $selected->publication_year }}) <br>
                                            <b>Item type:</b> *
                                            @if ($selected->type == 'book')
                                                <i class="bi bi-book"></i>
                                            @endif
                                            @if ($selected->type == 'research')
                                                <i class="bi bi-journals"></i>
                                            @endif
                                            @if ($selected->type == 'audio')
                                                <i class="bi bi-music-note-beamed"></i>
                                            @endif
                                            @if ($selected->type == 'video')
                                                <i class="bi bi-film"></i>
                                            @endif

                                            <i class="text-capitalize">{{ $selected->type }}</i>
                                            <br>
                                        </p>
                                    </section>
                                </div>
                                <form action="/services/report_item/{{ $selected->id }}" method="POST">
                                    @csrf
                                    @method('POST')

                                    <input type="hidden" name="item_id" value="{{ $selected->id }}">
                                    <input type="hidden" name="barcode" value="{{ $selected->barcode }}">
                                    <div class="mb-2">
                                        @php
                                            $statuses = ['missing', 'damaged'];
                                        @endphp
                                        <label for="status" class="form-label">Status </label>
                                        <select class="form-control form-control-sm text-capitalize" name="status"
                                            id="status">
                                            <option value="">--</option>
                                            @foreach ($statuses as $status)
                                                <option {{ $status == old('status') ? 'selected' : '' }}
                                                    value="{{ $status }}">{{ $status }}</option>
                                            @endforeach
                                        </select>
                                        @error('status')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-2">
                                        <label for="details" class="form-label">Details </label>
                                        <textarea class="form-control form-control-sm" placeholder="--" rows="8" name="details" id="details">{{ old('details') ?? '' }}</textarea>
                                        @error('details')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <hr>
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </form>
                            </div>
                        </div>
                        <div class="w-100">

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
