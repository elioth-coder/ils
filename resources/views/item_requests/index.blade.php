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
                    <li class="breadcrumb-item active" aria-current="page">Item Requests</li>
                </ol>
            </nav>
        </section>
        <div class="container d-flex flex-column pb-5">
            <section>
                <div class="">
                    <h3 class="mb-4">Item Requests</h3>
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pending-items-tab" data-bs-toggle="tab"
                                data-bs-target="#pending-items" type="button" role="tab"
                                aria-controls="pending-items" aria-selected="true">
                                Requests
                                @if (count($pending_items))
                                    <span class="badge text-bg-primary">{{ count($pending_items) }}</span>
                                @endif
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="for_pickup-items-tab" data-bs-toggle="tab"
                                data-bs-target="#for_pickup-items" type="button" role="tab"
                                aria-controls="for_pickup-items" aria-selected="true">
                                For Pickup
                                @if (count($for_pickup_items))
                                    <span class="badge text-bg-primary">{{ count($for_pickup_items) }}</span>
                                @endif
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="cancelled-items-tab" data-bs-toggle="tab"
                                data-bs-target="#cancelled-items" type="button" role="tab"
                                aria-controls="cancelled-items" aria-selected="false">
                                Cancelled
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content p-4 bg-white border border-top-0 rounded rounded-top-0">
                        <div class="tab-pane active" id="pending-items" role="tabpanel"
                            aria-labelledby="pending-items-tab" tabindex="0">
                            <table id="pending-items-table" class="table">
                                <thead>
                                    <tr>
                                        <th class="bg-body-secondary">#</th>
                                        <th class="bg-body-secondary">Item</th>
                                        <th class="bg-body-secondary">Document title</th>
                                        <th class="bg-body-secondary">Requested by</th>
                                        <th class="bg-body-secondary">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pending_items as $item)
                                        @php
                                            $today = strtotime(date('Y-m-d'));
                                            $duedate = strtotime($item->due_date);
                                        @endphp
                                        <tr>
                                            <td style="width: 60px;">
                                                <i class="bi bi-circle-fill text-secondary"></i>
                                            </td>
                                            <td style="width: 150px;">
                                                <a
                                                    href="/collections/items/{{ $item->title }}/copy/{{ $item->barcode }}">
                                                    {{ $item->barcode }}
                                                </a>
                                                <br>
                                                <span class="badge text-bg-secondary">
                                                    {{ $item->request_status }}
                                                </span>
                                                @if ($item->request_status == 'for pickup')
                                                    <br><i>until {{ $item->due_date }}</i>
                                                @endif
                                                @if ($today > $duedate && $item->request_status == 'for pickup')
                                                    <span class="badge text-bg-danger">Overdue</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <section style="height: 110px; min-width: 80px;"
                                                        class="card p-1 me-2">
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
                                                            <b>Status:</b> <span
                                                                class="badge text-bg-secondary">{{ $item->status }}</span>
                                                        </p>
                                                    </section>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-capitalize m-0" style="width: 160px;">
                                                    <a
                                                        href="/services/checkouts/{{ $item->patron->card_number }}/patron">
                                                        {{ strtolower($item->patron->first_name) }}
                                                        {{ strtolower($item->patron->last_name) }}
                                                    </a>
                                                </p>
                                                {{ $item->date_requested }} <br>
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    $requester_id = $item->patron->user_id;
                                                    $data = "{ barcode: $item->barcode, requester_id: $requester_id }";
                                                @endphp
                                                @if ($item->request_status == 'pending')
                                                    <button onclick="reserveItem({{ $data }});"
                                                        style="width: 100px;" class="mt-1 btn btn-primary">
                                                        Reserve
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="for_pickup-items" role="tabpanel"
                            aria-labelledby="for_pickup-items-tab" tabindex="0">
                            <table id="for_pickup-items-table" class="table">
                                <thead>
                                    <tr>
                                        <th class="bg-body-secondary">#</th>
                                        <th class="bg-body-secondary text-start">Item</th>
                                        <th class="bg-body-secondary">Document title</th>
                                        <th class="bg-body-secondary">Requested by</th>
                                        <th class="bg-body-secondary">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($for_pickup_items as $item)
                                        @php
                                            $today = strtotime(date('Y-m-d'));
                                            $duedate = strtotime($item->due_date);
                                        @endphp
                                        <tr>
                                            <td style="min-width: 60px !important;">
                                                <i class="bi bi-circle-fill text-secondary"></i>
                                            </td>
                                            <td class="text-start" style="min-width: 150px !important;">
                                                <a
                                                    href="/collections/items/{{ $item->title }}/copy/{{ $item->barcode }}">
                                                    {{ $item->barcode }}
                                                </a>
                                            </td>
                                            <td style="width: 100%;">
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
                                                            <b>Status:</b> <span
                                                                class="badge text-bg-secondary">{{ $item->status }}</span>
                                                        </p>
                                                    </section>
                                                </div>
                                            </td>
                                            <td style="min-width: 150px !important;">
                                                <p class="text-capitalize m-0">
                                                    <a
                                                        href="/services/checkouts/{{ $item->patron->card_number }}/patron">
                                                        {{ strtolower($item->patron->first_name) }}
                                                        {{ strtolower($item->patron->last_name) }}
                                                    </a>
                                                </p>
                                                {{ $item->date_requested }} <br>
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    $requester_id = $item->patron->user_id;
                                                    $data = "{ barcode: $item->barcode, requester_id: $requester_id }";
                                                @endphp
                                                <button onclick="notifyPickup({{ $data }});"
                                                    style="width: 100px;" class="mt-1 btn btn-warning">
                                                    Notify
                                                </button>
                                                @if ($item->request_status == 'for pickup')
                                                    <button onclick="checkoutItem({{ $data }});"
                                                        style="width: 100px;" class="mt-1 btn btn-primary">
                                                        Check-out
                                                    </button>
                                                    @if ($today > $duedate)
                                                        <button style="width: 100px;"
                                                            onclick="cancelItem({{ $data }});"
                                                            class="mt-1 btn btn-danger">
                                                            Cancel
                                                        </button>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="cancelled-items" role="tabpanel"
                            aria-labelledby="cancelled-items-tab" tabindex="0">
                            <table id="cancelled-items-table" class="table">
                                <thead>
                                    <tr>
                                        <th class="bg-body-secondary">#</th>
                                        <th class="bg-body-secondary text-start">Item</th>
                                        <th class="bg-body-secondary">Document title</th>
                                        <th class="bg-body-secondary">Requested by</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cancelled_items as $item)
                                        @php
                                            $today = strtotime(date('Y-m-d'));
                                            $duedate = strtotime($item->due_date);
                                        @endphp
                                        <tr>
                                            <td style="min-width: 60px !important;">
                                                <i class="bi bi-circle-fill text-secondary"></i>
                                            </td>
                                            <td class="text-start" style="min-width: 150px !important;">
                                                <a
                                                    href="/collections/items/{{ $item->title }}/copy/{{ $item->barcode }}">
                                                    {{ $item->barcode }}
                                                </a>
                                            </td>
                                            <td style="width: 100%;">
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
                                                            <b>Status:</b> <span
                                                                class="badge text-bg-secondary">{{ $item->status }}</span>
                                                        </p>
                                                    </section>
                                                </div>
                                            </td>
                                            <td style="min-width: 150px !important;">
                                                <p class="text-capitalize m-0">
                                                    <a
                                                        href="/services/checkouts/{{ $item->patron->card_number }}/patron">
                                                        {{ strtolower($item->patron->first_name) }}
                                                        {{ strtolower($item->patron->last_name) }}
                                                    </a>
                                                </p>
                                                {{ $item->date_requested }} <br>
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
            new DataTable('#pending-items-table');
            new DataTable('#for_pickup-items-table');
            new DataTable('#cancelled-items-table');

            function notifyPickup(data) {
                Swal.fire({
                    title: "Notifying patron..",
                    showConfirmButton: false,
                    timer: 2000,
                }).then(async () => {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    let formData = new FormData();
                    formData.set('barcode', data.barcode);
                    formData.set('requester_id', data.requester_id);

                    let response = await fetch('/services/checkouts/notify_pickup', {
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
                });
            }

            function checkoutItem(data) {
                Swal.fire({
                    title: "Checking out item..",
                    showConfirmButton: false,
                    timer: 2000,
                }).then(async () => {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    let formData = new FormData();
                    formData.set('barcode', data.barcode);
                    formData.set('requester_id', data.requester_id);

                    let response = await fetch('/services/checkouts/checkout_item', {
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

            function reserveItem(data) {
                Swal.fire({
                    title: "Reserving item...",
                    showConfirmButton: false,
                    timer: 2000,
                }).then(async () => {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    let formData = new FormData();
                    formData.set('barcode', data.barcode);
                    formData.set('requester_id', data.requester_id);

                    let response = await fetch('/services/checkouts/reserve_item', {
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

            function cancelItem(data) {
                Swal.fire({
                    title: "Cancelling item...",
                    showConfirmButton: false,
                    timer: 2000,
                }).then(async () => {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    let formData = new FormData();
                    formData.set('barcode', data.barcode);
                    formData.set('requester_id', data.requester_id);

                    let response = await fetch('/services/checkouts/cancel_item', {
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
