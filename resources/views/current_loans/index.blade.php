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
                    <li class="breadcrumb-item active" aria-current="page">Current Loans</li>
                </ol>
            </nav>
        </section>
        <div class="container d-flex flex-column pb-5">
            <section>
                <div class="">
                    <h3 class="mb-4">Current Loans</h3>
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="loaned-items-tab" data-bs-toggle="tab"
                                data-bs-target="#loaned-items" type="button" role="tab" aria-controls="loaned-items"
                                aria-selected="true">
                                On Loan
                                @if (count($loaned_items))
                                    <span class="badge text-bg-primary">{{ count($loaned_items) }}</span>
                                @endif
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="returned-items-tab" data-bs-toggle="tab"
                                data-bs-target="#returned-items" type="button" role="tab" aria-controls="returned-items"
                                aria-selected="false">
                                Returned Items
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content p-4 bg-white border border-top-0 rounded rounded-top-0">
                        <div class="tab-pane active" id="loaned-items" role="tabpanel" aria-labelledby="loaned-items-tab" tabindex="0">
                            <table id="loaned-items-table" class="table">
                                <thead>
                                    <tr>
                                    <th class="bg-body-secondary">#</th>
                                    <th class="bg-body-secondary">Item / Status</th>
                                    <th class="bg-body-secondary">Document title</th>
                                    <th class="bg-body-secondary">Loaned by</th>
                                    <th class="bg-body-secondary">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($loaned_items as $item)
                                        @php
                                            $today = strtotime(date('Y-m-d'));
                                            $duedate = strtotime($item->due_date);
                                        @endphp
                                        <tr>
                                            <td style="width: 60px;">
                                                @if($today > $duedate)
                                                    <i title="Overdue" class="bi bi-circle-fill text-danger"></i>
                                                @else
                                                    <i title="{{ strtoupper($item->status) }}" class="bi bi-circle-fill text-success"></i>
                                                @endif
                                            </td>
                                            <td style="width: 150px;">
                                                @if($today > $duedate)
                                                    <span class="badge text-bg-danger">Overdue</span>
                                                @endif
                                                <span class="text-capitalize badge text-bg-success">
                                                    {{ $item->loan_status }}
                                                </span>
                                                <br>
                                                {{ $item->barcode }} <br>
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <section style="height: 110px;" class="card p-1 me-2">
                                                        @php $item_cover = ($item->cover_image) ? "/storage/images/books/$item->cover_image" : '/images/book_cover_not_available.jpg'; @endphp
                                                        <img class="h-100 d-block" src="{{ asset($item_cover) }}" alt="">
                                                    </section>
                                                    <section>
                                                        <div class="d-flex">
                                                            <div class="w-100">
                                                                <a href="/collections/books/{{ $item->isbn }}/detail" class="link-primary">
                                                                    <h5>{{ $item->title }}</h5>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <p>
                                                            <b>Author(s):</b> {{ $item->author }} <br>
                                                            <b>Published:</b> {{ $item->publisher }} ({{ $item->publication_year }}) <br>
                                                            <b>ISBN:</b> {{ $item->isbn }}
                                                        </p>
                                                    </section>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-capitalize m-0">
                                                    <a href="/services/checkouts/{{ $item->patron->card_number }}/patron">
                                                        {{ strtolower($item->patron->first_name) }}
                                                        {{ strtolower($item->patron->last_name) }}
                                                    </a>
                                                </p>
                                                {{ $item->date_loaned }}
                                                <b>
                                                    <i class="bi bi-arrow-right"></i>
                                                    {{ $item->due_date }}
                                                </b>
                                                <br>
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    $loaner_id = $item->patron->user_id;
                                                    $data = "{ barcode: $item->barcode, loaner_id: $loaner_id }";
                                                @endphp
                                                @if($today > $duedate)
                                                    <button onclick="renewItem({{ $data }});"
                                                        style="width: 100px;"
                                                        class="mt-1 btn btn-danger">
                                                        Renew
                                                    </button>
                                                @endif
                                                <button onclick="returnItem({{ $data }});"
                                                    style="width: 100px;"
                                                    class="mt-1 btn btn-success">
                                                    Return
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="text-center fs-5 text-secondary">No data found.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="returned-items" role="tabpanel" aria-labelledby="returned-items-tab" tabindex="0">
                            <table id="returned-items-table" class="table">
                                <thead>
                                    <tr>
                                    <th class="bg-body-secondary">#</th>
                                    <th class="bg-body-secondary">Item</th>
                                    <th class="bg-body-secondary">Document title</th>
                                    <th class="bg-body-secondary">Returned by</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($returned_items as $item)
                                        @php
                                            $today = strtotime(date('Y-m-d'));
                                            $duedate = strtotime($item->due_date);
                                        @endphp
                                        <tr>
                                            <td style="width: 60px;">
                                                @if($today > $duedate)
                                                    <i title="Overdue" class="bi bi-circle-fill text-danger"></i>
                                                @else
                                                    <i title="{{ strtoupper($item->status) }}" class="bi bi-circle-fill text-success"></i>
                                                @endif
                                            </td>
                                            <td style="width: 150px;">
                                                {{ $item->barcode }} <br>
                                            </td>
                                            <td class="w-100">
                                                <div class="d-flex">
                                                    <section style="height: 110px;" class="card p-1 me-2">
                                                        @php $item_cover = ($item->cover_image) ? "/storage/images/books/$item->cover_image" : '/images/book_cover_not_available.jpg'; @endphp
                                                        <img class="h-100 d-block" src="{{ asset($item_cover) }}" alt="">
                                                    </section>
                                                    <section>
                                                        <div class="d-flex">
                                                            <div class="w-100">
                                                                <a href="/collections/books/{{ $item->isbn }}/detail" class="link-primary">
                                                                    <h5>{{ $item->title }}</h5>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <p>
                                                            <b>Author(s):</b> {{ $item->author }} <br>
                                                            <b>Published:</b> {{ $item->publisher }} ({{ $item->publication_year }}) <br>
                                                            <b>ISBN:</b> {{ $item->isbn }}
                                                        </p>
                                                    </section>
                                                </div>
                                            </td>
                                            <td style="min-width: 170px;">
                                                <p class="text-capitalize m-0">
                                                    <a href="/services/checkouts/{{ $item->patron->card_number }}/patron">
                                                        {{ strtolower($item->patron->first_name) }}
                                                        {{ strtolower($item->patron->last_name) }}
                                                    </a>
                                                </p>
                                                {{ $item->date_returned }}
                                                <br>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="text-center fs-5 text-secondary">No data found.</td></tr>
                                    @endforelse
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
            new DataTable('#loaned-items-table');
            new DataTable('#returned-items-table');

            function renewItem(data) {
                Swal.fire({
                    title: "Renewing item..",
                    showConfirmButton: false,
                    timer: 2000,
                }).then(async () => {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    let formData = new FormData();
                    formData.set('barcode', data.barcode);
                    formData.set('loaner_id', data.loaner_id);

                    let response = await fetch('/services/checkouts/renew_item', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                    });

                    let {
                        status,
                        message
                    } = await response.json();

                    await Swal.fire({
                        title: message,
                        icon: status,
                        showConfirmButton: false,
                        timer: 2000,
                    });

                    if (status == 'success') {
                        window.location.reload();
                    }

                });
            }

            function returnItem(data) {
                Swal.fire({
                    title: "Returning item..",
                    showConfirmButton: false,
                    timer: 2000,
                }).then(async () => {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    let formData = new FormData();
                    formData.set('barcode', data.barcode);
                    formData.set('loaner_id', data.loaner_id);

                    let response = await fetch('/services/checkouts/return_item', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                    });

                    let {
                        status,
                        message
                    } = await response.json();

                    await Swal.fire({
                        title: message,
                        icon: status,
                        showConfirmButton: false,
                        timer: 2000,
                    });

                    if (status == 'success') {
                        window.location.reload();
                    }

                });
            }
        </script>
    </x-slot>
</x-layout>
