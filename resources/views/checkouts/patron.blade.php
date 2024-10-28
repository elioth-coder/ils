<x-layout>
    <x-slot:head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </x-slot:head>
    <x-header />
    <main class="d-flex flex-column align-items-center justify-content-center w-100 bg-body-secondary">
        <section class="container d-flex py-3 align-items-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 border py-2 px-3 bg-white rounded">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item"><a href="/services">Services</a></li>
                    <li class="breadcrumb-item"><a href="/services/checkouts">Check-outs</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $patron->card_number }}</li>
                </ol>
            </nav>
        </section>
        <div class="container d-flex flex-column pb-4">
            <div class="d-flex">
                <section class="card w-50 p-3 d-flex flex-row mb-4 position-relative">
                    <div class="p-1 pe-4">
                        @php $profile = ($patron->profile) ? "/storage/images/teachers/$patron->profile" : '/images/profile.jpg'; @endphp
                        <img class="d-block rounded-circle" style="height: 100px;" src="{{ asset($profile) }}"
                            alt="">
                    </div>
                    <div class="p-1">
                        <h2 class="text-capitalize">{{ strtolower($patron->last_name) }}, {{ strtolower($patron->first_name) }}</h2>
                        <b>Birthday : </b> {{ $patron->birthday }} ({{ $patron->age }} years old) <br>
                        <b>Card No. : </b> {{ $patron->card_number }}
                        <p class="m-0 mt-2">
                            <a href="/users/{{ $patron->role }}s/{{ $patron->id }}/edit#{{ $patron->role }}s-form"
                                class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-pencil-fill"></i> Edit
                            </a>
                            <a href="#" class="disabled btn btn-outline-danger btn-sm ms-1">
                                <i class="bi bi-trash-fill"></i> Delete
                            </a>
                        </p>
                    </div>

                    <a href="{{ url()->previous() }}" class="btn-sm btn btn-danger position-absolute top-0 end-0 m-2">
                        <i class="bi bi-x-lg"></i>
                    </a>
                </section>
                <section class="w-50 p-2"></section>
            </div>


            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="on-loan-tab" data-bs-toggle="tab"
                        data-bs-target="#on-loan" type="button" role="tab" aria-controls="on-loan"
                        aria-selected="true">
                        On loan
                        @if (count($loaned_books))
                            <span class="badge text-bg-primary">{{ count($loaned_books) }}</span>
                        @endif
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pick-up-tab" data-bs-toggle="tab"
                        data-bs-target="#pick-up" type="button" role="tab" aria-controls="pick-up"
                        aria-selected="false">
                        To pickup
                        @if (count($for_pickup_books))
                            <span class="badge text-bg-primary">{{ count($for_pickup_books) }}</span>
                        @endif
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pending-tab" data-bs-toggle="tab"
                        data-bs-target="#pending" type="button" role="tab" aria-controls="pending"
                        aria-selected="false">
                        Pending
                        @if (count($pending_books))
                            <span class="badge text-bg-primary">{{ count($pending_books) }}</span>
                        @endif
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="history-tab" data-bs-toggle="tab"
                        data-bs-target="#history" type="button" role="tab" aria-controls="history"
                        aria-selected="false">
                        History
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                        data-bs-target="#profile" type="button" role="tab" aria-controls="profile"
                        aria-selected="false">Patron Profile</button>
                </li>
            </ul>
            <div class="tab-content p-3 bg-white border border-top-0 rounded rounded-top-0">
                <div class="tab-pane active" id="on-loan" role="tabpanel" aria-labelledby="on-loan-tab"
                    tabindex="0">
                    <div class="w-50 mb-3">
                        <p class="fw-bold mb-2">Check-out/check-in: please enter an item barcode.</p>
                        <form onsubmit="return findBarcode(event);" class="flex-grow-1" method="GET">
                            <div class="input-group bg-white rounded-3">
                                <input type="hidden" name="user_id" value="{{ $patron->user_id }}">
                                <input type="text" class="form-control" name="barcode" placeholder="--">
                                <button class="btn btn-light border" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div>
                        <table class="table">
                            <thead>
                                <tr>
                                <th class="bg-body-secondary">#</th>
                                <th class="bg-body-secondary">Item</th>
                                <th class="bg-body-secondary">Document title</th>
                                <th class="bg-body-secondary">Return until</th>
                                <th class="bg-body-secondary"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($loaned_books as $book)
                                    <tr>
                                        <td>
                                            @php
                                            $color = [
                                                'available'   => 'success',
                                                'reserved'    => 'warning',
                                                'checked out' => 'danger',
                                            ];
                                            @endphp
                                            <i title="{{ strtoupper($book->status) }}" class="bi bi-circle-fill text-{{ $color[$book->status] }}"></i>
                                        </td>
                                        <td>
                                            {{ $book->barcode }}
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <section style="height: 110px;" class="card p-1 me-2">
                                                    @php $book_cover = ($book->cover_image) ? "/storage/images/books/$book->cover_image" : '/images/book_cover_not_available.jpg'; @endphp
                                                    <img class="h-100 d-block" src="{{ asset($book_cover) }}" alt="">
                                                </section>
                                                <section>
                                                    <div class="d-flex">
                                                        <div class="w-100">
                                                            <a href="/collections/books/{{ $book->isbn }}/detail" class="link-primary">
                                                                <h5>{{ $book->title }}</h5>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <p>
                                                        <b>Author(s):</b> {{ $book->author }} <br>
                                                        <b>Published:</b> {{ $book->publisher }} ({{ $book->publication_year }}) <br>
                                                        <b>ISBN:</b> {{ $book->isbn }}
                                                    </p>
                                                </section>
                                            </div>
                                        </td>
                                        @php
                                            $today = strtotime(date('Y-m-d'));
                                            $duedate = strtotime($book->due_date);
                                        @endphp
                                        <td>
                                            {{ $book->due_date }}
                                            @if($today > $duedate)
                                                <span class="badge text-bg-danger">Overdue</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $data = "{ barcode: $book->barcode, loaner_id: $patron->user_id }";
                                            @endphp
                                            <button onclick="returnItem({{ $data }});" class="mt-1 btn btn-success">
                                                Return
                                            </button>
                                            @if($today > $duedate)
                                                <button onclick="renewItem({{ $data }});" class="mt-1 btn btn-danger">
                                                    Renew
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center fs-5 text-secondary">No data found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="pick-up" role="tabpanel" aria-labelledby="pick-up-tab" tabindex="0">
                    <table class="table">
                        <thead>
                            <tr>
                            <th class="bg-body-secondary">#</th>
                            <th class="bg-body-secondary">Item</th>
                            <th class="bg-body-secondary">Document title</th>
                            <th class="bg-body-secondary">Pickup until</th>
                            <th class="bg-body-secondary"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($for_pickup_books as $book)
                                <tr>
                                    <td>
                                        @php
                                        $color = [
                                            'available'   => 'success',
                                            'reserved'    => 'warning',
                                            'checked out' => 'danger',
                                        ];
                                        @endphp
                                        <i title="{{ strtoupper($book->status) }}" class="bi bi-circle-fill text-{{ $color[$book->status] }}"></i>
                                    </td>
                                    <td>
                                        {{ $book->barcode }}
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <section style="height: 110px;" class="card p-1 me-2">
                                                @php $book_cover = ($book->cover_image) ? "/storage/images/books/$book->cover_image" : '/images/book_cover_not_available.jpg'; @endphp
                                                <img class="h-100 d-block" src="{{ asset($book_cover) }}" alt="">
                                            </section>
                                            <section>
                                                <div class="d-flex">
                                                    <div class="w-100">
                                                        <a href="/collections/books/{{ $book->isbn }}/detail" class="link-primary">
                                                            <h5>{{ $book->title }}</h5>
                                                        </a>
                                                    </div>
                                                </div>
                                                <p>
                                                    <b>Author(s):</b> {{ $book->author }} <br>
                                                    <b>Published:</b> {{ $book->publisher }} ({{ $book->publication_year }}) <br>
                                                    <b>ISBN:</b> {{ $book->isbn }}
                                                </p>
                                            </section>
                                        </div>
                                    </td>
                                    @php
                                        $today = strtotime(date('Y-m-d'));
                                        $duedate = strtotime($book->due_date);
                                    @endphp
                                    <td class="text-capitalize">
                                        {{ $book->due_date }}
                                        @if($today > $duedate)
                                            <span class="badge text-bg-danger">Overdue</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $data = "{ barcode: $book->barcode, requester_id: $patron->user_id }";
                                        @endphp
                                        <button style="width: 100px;" onclick="checkoutItem({{ $data }});" class="mt-1 btn btn-success">
                                            Check-out
                                        </button>
                                        @if($today > $duedate)
                                            <button style="width: 100px;" onclick="cancelItem({{ $data }});" class="mt-1 btn btn-danger">
                                                Cancel
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center fs-5 text-secondary">No data found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="pending" role="tabpanel" aria-labelledby="pending-tab" tabindex="0">
                    <table class="table">
                        <thead>
                            <tr>
                            <th class="bg-body-secondary">#</th>
                            <th class="bg-body-secondary">Item</th>
                            <th class="bg-body-secondary">Document title</th>
                            <th class="bg-body-secondary">Date requested</th>
                            <th class="bg-body-secondary">Status</th>
                            <th class="bg-body-secondary"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pending_books as $book)
                                <tr>
                                    <td>
                                        @php
                                        $color = [
                                            'available'   => 'success',
                                            'reserved'    => 'warning',
                                            'checked out' => 'danger',
                                        ];
                                        @endphp
                                        <i title="{{ strtoupper($book->status) }}" class="bi bi-circle-fill text-{{ $color[$book->status] }}"></i>
                                    </td>
                                    <td>
                                        {{ $book->barcode }}
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <section style="height: 110px;" class="card p-1 me-2">
                                                @php $book_cover = ($book->cover_image) ? "/storage/images/books/$book->cover_image" : '/images/book_cover_not_available.jpg'; @endphp
                                                <img class="h-100 d-block" src="{{ asset($book_cover) }}" alt="">
                                            </section>
                                            <section>
                                                <div class="d-flex">
                                                    <div class="w-100">
                                                        <a href="/collections/books/{{ $book->isbn }}/detail" class="link-primary">
                                                            <h5>{{ $book->title }}</h5>
                                                        </a>
                                                    </div>
                                                </div>
                                                <p>
                                                    <b>Author(s):</b> {{ $book->author }} <br>
                                                    <b>Published:</b> {{ $book->publisher }} ({{ $book->publication_year }}) <br>
                                                    <b>ISBN:</b> {{ $book->isbn }}
                                                </p>
                                            </section>
                                        </div>
                                    </td>
                                    <td class="text-capitalize">{{ $book->date_requested }}</td>
                                    <td class="text-capitalize">{{ $book->request_status }}</td>
                                    <td class="text-center">
                                        @php
                                            $data = "{ barcode: $book->barcode, requester_id: $patron->user_id }";
                                        @endphp
                                        <button onclick="reserveItem({{ $data }});" class="mt-1 btn btn-success">
                                            Reserve
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center fs-5 text-secondary">No data found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="history" role="tabpanel" aria-labelledby="history-tab" tabindex="0">
                    <table class="table">
                        <thead>
                            <tr>
                            <th class="bg-body-secondary">#</th>
                            <th class="bg-body-secondary">Item</th>
                            <th class="bg-body-secondary">Document title</th>
                            <th class="bg-body-secondary">Date loaned</th>
                            <th class="bg-body-secondary">Date returned</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($returned_books as $book)
                                <tr>
                                    <td>
                                        @php
                                        $color = [
                                            'available'   => 'success',
                                            'reserved'    => 'warning',
                                            'checked out' => 'danger',
                                        ];
                                        @endphp
                                        <i title="{{ strtoupper($book->status) }}" class="bi bi-circle-fill text-{{ $color[$book->status] }}"></i>
                                    </td>
                                    <td>
                                        {{ $book->barcode }}
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <section style="height: 110px;" class="card p-1 me-2">
                                                @php $book_cover = ($book->cover_image) ? "/storage/images/books/$book->cover_image" : '/images/book_cover_not_available.jpg'; @endphp
                                                <img class="h-100 d-block" src="{{ asset($book_cover) }}" alt="">
                                            </section>
                                            <section>
                                                <div class="d-flex">
                                                    <div class="w-100">
                                                        <a href="/collections/books/{{ $book->isbn }}/detail" class="link-primary">
                                                            <h5>{{ $book->title }}</h5>
                                                        </a>
                                                    </div>
                                                </div>
                                                <p>
                                                    <b>Author(s):</b> {{ $book->author }} <br>
                                                    <b>Published:</b> {{ $book->publisher }} ({{ $book->publication_year }}) <br>
                                                    <b>ISBN:</b> {{ $book->isbn }}
                                                </p>
                                            </section>
                                        </div>
                                    </td>
                                    <td class="text-capitalize">{{ $book->date_loaned }}</td>
                                    <td class="text-capitalize">{{ $book->date_returned }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center fs-5 text-secondary">No data found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                    <section class="bg-body-secondary p-2 mb-4">
                        <h5 class="mb-0">Patron Profile</h5>
                    </section>
                    <table class="mx-3">
                        <tbody>
                            <tr>
                                <th class="px-3">Card No. / ID No.</th>
                                <td>{{ $patron->card_number }}</td>
                            </tr>
                            <tr>
                                <th class="px-3">Gender</th>
                                <td class="text-capitalize">{{ $patron->gender }}</td>
                            </tr>
                            <tr>
                                <th class="px-3">Birthday</th>
                                <td>{{ $patron->birthday }}</td>
                            </tr>
                            <tr>
                                <th class="px-3">Email address</th>
                                <td>{{ $patron->email }}</td>
                            </tr>
                            <tr>
                                <th class="px-3">Mobile No.</th>
                                <td>{{ $patron->mobile_number }}</td>
                            </tr>
                            <tr>
                                <th class="px-3">Home address</th>
                                <td>
                                    {{ $patron->barangay }}
                                    {{ $patron->municipality }}
                                    {{ $patron->province }}
                                </td>
                            </tr>
                            <tr>
                                <th class="px-3">Mobile no.</th>
                                <td>{{ $patron->mobile_number }}</td>
                            </tr>
                            <tr>
                                <th class="px-3">Status</th>
                                <td class="text-capitalize">{{ $patron->status }}</td>
                            </tr>
                            @if($patron->campus)
                                <tr>
                                    <th class="px-3">Campus Code</th>
                                    <td>{{ $patron->campus }}</td>
                                </tr>
                            @endif
                            @if($patron->library)
                                <tr>
                                    <th class="px-3">Library Code</th>
                                    <td>{{ $patron->library }}</td>
                                </tr>
                            @endif
                            @if($patron->department)
                                <tr>
                                    <th class="px-3">Department</th>
                                    <td>{{ $patron->department }}</td>
                                </tr>
                            @endif
                            @if($patron->academic_rank)
                                <tr>
                                    <th class="px-3">Academic rank</th>
                                    <td class="text-uppercase">{{ $patron->academic_rank }}</td>
                                </tr>
                            @endif
                            @if($patron->program)
                                <tr>
                                    <th class="px-3">Program</th>
                                    <td class="text-uppercase">{{ $patron->program }}</td>
                                </tr>
                            @endif
                            @if($patron->year)
                                <tr>
                                    <th class="px-3">Year & Section</th>
                                    <td class="text-uppercase">{{ $patron->year }} {{ $patron->section }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <x-footer />
    <x-slot:script>
        <script>
            async function findBarcode(event) {
                event.preventDefault();

                let $form = event.target;
                let formData = new FormData($form);
                let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                let response = await fetch('/services/checkouts/find_barcode', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                });

                let {
                    status,
                    message,
                    patron,
                    item
                } = await response.json();

                if (status == 'error') {
                    Swal.fire({
                        title: message,
                        icon: status,
                        showConfirmButton: false,
                        timer: 2000,
                    });
                } else {
                    if (patron) {
                        window.location.href = `/services/checkouts/${patron.card_number}/patron`;
                    }
                    if (item) {
                        if (item.status == 'available') {
                            return checkoutItem({
                                barcode: item.barcode,
                                requester_id: item.requester_id,
                            });
                        }
                        if (item.status == 'checked out') {
                            return returnItem({
                                barcode : item.barcode,
                                loaner_id : item.loaner_id,
                            });
                        }
                        if (item.status == 'reserved') {
                            if(item.requester_id == $formData.get('user_id')) {
                                return checkoutItem({
                                    barcode: item.barcode,
                                    requester_id: item.requester_id,
                                });
                            }
                        }

                        Swal.fire({
                            title: `The item is [${item.status.toUpperCase()}] and cannot be checked out`,
                            icon: 'error',
                            showConfirmButton: false,
                            timer: 3000,
                        }).then(() => {
                            window.location.reload();
                        });
                    }
                }
                return false;
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

            function returnItem(data) {
                Swal.fire({
                    title: "Returning item...",
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

            function renewItem(data) {
                Swal.fire({
                    title: "Renewing item...",
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
        </script>
    </x-slot>
</x-layout>
