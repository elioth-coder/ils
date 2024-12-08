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
                    <li class="breadcrumb-item active" aria-current="page">My Account</li>
                </ol>
            </nav>
        </section>
        <div class="container d-flex flex-column pb-4">
            <div class="d-flex">
                <section class="card w-50 p-3 d-flex flex-row mb-4 position-relative">
                    <div class="p-1 pe-4">
                        @php $profile = ($patron->profile) ? "/storage/images/users/$patron->profile" : '/images/profile.jpg'; @endphp
                        <object class="d-block rounded-circle border" style="height: 100px;" data="{{ asset($profile) }}" type="image/png">
                            <img class="d-block rounded-circle border" style="height: 100px;" src="/images/profile.jpg" alt="">
                        </object>
                    </div>
                    <div class="p-1">
                        <h2 class="text-capitalize">{{ strtolower($patron->last_name) }}, {{ strtolower($patron->first_name) }}</h2>
                        <b>Birthday : </b> {{ $patron->birthday }} ({{ $patron->age }} years old) <br>
                        <b>Card No. : </b> {{ $patron->card_number }}
                        <p class="m-0 mt-2">
                            <a href="/account/edit"
                                class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-pencil-fill"></i> Edit Profile
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
                        @if (count($loaned_items))
                            <span class="badge text-bg-primary">{{ count($loaned_items) }}</span>
                        @endif
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pick-up-tab" data-bs-toggle="tab"
                        data-bs-target="#pick-up" type="button" role="tab" aria-controls="pick-up"
                        aria-selected="false">
                        To pickup
                        @if (count($for_pickup_items))
                            <span class="badge text-bg-primary">{{ count($for_pickup_items) }}</span>
                        @endif
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pending-tab" data-bs-toggle="tab"
                        data-bs-target="#pending" type="button" role="tab" aria-controls="pending"
                        aria-selected="false">
                        Pending
                        @if (count($pending_items))
                            <span class="badge text-bg-primary">{{ count($pending_items) }}</span>
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
                    <table class="table">
                        <thead>
                            <tr>
                            <th class="bg-body-secondary">#</th>
                            <th class="bg-body-secondary">Item</th>
                            <th class="bg-body-secondary">Document title</th>
                            <th class="bg-body-secondary">Return until</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($loaned_items as $item)
                                <tr>
                                    <td>
                                        <i class="bi bi-circle-fill text-secondary"></i>
                                    </td>
                                    <td>
                                        <a href="/collections/items/{{ $item->title }}/copy/{{ $item->barcode }}" class="link-primary">
                                            {{ $item->barcode }}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <section style="height: 110px;" class="card p-1 me-2">
                                                @php $item_cover = ($item->cover_image) ? "/storage/images/$item->type/$item->cover_image" : '/images/cover_not_available.jpg'; @endphp
                                                <object class="h-100 d-block" style="height: 100px;" data="{{ asset($item_cover) }}" type="image/png">
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
                                                    <b>Status:</b> <span class="badge text-bg-secondary">{{ $item->status }}</span>
                                                </p>
                                            </section>
                                        </div>
                                    </td>
                                    @php
                                        $today = strtotime(date('Y-m-d'));
                                        $duedate = strtotime($item->due_date);
                                    @endphp
                                    <td>
                                        {{ $item->due_date }} {{ date('h:i A', strtotime($item->created_at)) }} <br>
                                        @if($today > $duedate)
                                            <span class="badge text-bg-danger">Overdue</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center fs-5 text-secondary">No data found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="pick-up" role="tabpanel" aria-labelledby="pick-up-tab" tabindex="0">
                    <table class="table">
                        <thead>
                            <tr>
                            <th class="bg-body-secondary">#</th>
                            <th class="bg-body-secondary">Item</th>
                            <th class="bg-body-secondary">Document title</th>
                            <th class="bg-body-secondary">Pickup until</th>
                            <th class="bg-body-secondary">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($for_pickup_items as $item)
                                <tr>
                                    <td>
                                        <i class="bi bi-circle-fill text-secondary"></i>
                                    </td>
                                    <td>
                                        <a href="/collections/items/{{ $item->title }}/copy/{{ $item->barcode }}" class="link-primary">
                                            {{ $item->barcode }}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <section style="height: 110px;" class="card p-1 me-2">
                                                @php $item_cover = ($item->cover_image) ? "/storage/images/$item->type/$item->cover_image" : '/images/cover_not_available.jpg'; @endphp
                                                <object class="h-100 d-block" style="height: 100px;" data="{{ asset($item_cover) }}" type="image/png">
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
                                                    <b>Status:</b> <span class="badge text-bg-secondary">{{ $item->status }}</span>
                                                </p>
                                            </section>
                                        </div>
                                    </td>
                                    @php
                                        $today = strtotime(date('Y-m-d'));
                                        $duedate = strtotime($item->due_date);
                                    @endphp
                                    <td class="text-capitalize" style="width: 120px;">
                                        {{ $item->due_date }} {{ date('h:i A', strtotime($item->created_at)) }}
                                        @if($today > $duedate)
                                            <span class="badge text-bg-danger">Overdue</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $data = "{ barcode: $item->barcode, requester_id: $patron->user_id }";
                                        @endphp
                                        <button style="width: 100px;" onclick="cancelItem({{ $data }});" class="mt-1 btn btn-danger">
                                            Cancel
                                        </button>
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
                            <th class="bg-body-secondary text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pending_items as $item)
                                <tr>
                                    <td>
                                        <i class="bi bi-circle-fill text-secondary"></i>
                                    </td>
                                    <td>
                                        <a href="/collections/items/{{ $item->title }}/copy/{{ $item->barcode }}" class="link-primary">
                                            {{ $item->barcode }}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <section style="height: 110px;" class="card p-1 me-2">
                                                @php $item_cover = ($item->cover_image) ? "/storage/images/$item->type/$item->cover_image" : '/images/cover_not_available.jpg'; @endphp
                                                <object class="h-100 d-block" style="height: 100px;" data="{{ asset($item_cover) }}" type="image/png">
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
                                                    <b>Status:</b> <span class="badge text-bg-secondary">{{ $item->status }}</span>
                                                </p>
                                            </section>
                                        </div>
                                    </td>
                                    <td class="text-capitalize" style="width: 150px;">
                                        {{ $item->date_requested }} {{ date('h:i A', strtotime($item->created_at)) }}
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $data = "{ barcode: $item->barcode, requester_id: $patron->user_id }";
                                        @endphp
                                        <button style="width: 100px;" onclick="cancelItem({{ $data }});" class="mt-1 btn btn-danger">
                                            Cancel
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
                            <th class="bg-body-secondary">Duration</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($returned_items as $item)
                                <tr>
                                    <td>
                                        <i class="bi bi-circle-fill text-secondary"></i>
                                    </td>
                                    <td>
                                        <a href="/collections/items/{{ $item->title }}/copy/{{ $item->barcode }}" class="link-primary">
                                            {{ $item->barcode }}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <section style="height: 110px;" class="card p-1 me-2">
                                                @php $item_cover = ($item->cover_image) ? "/storage/images/$item->type/$item->cover_image" : '/images/cover_not_available.jpg'; @endphp
                                                <object class="h-100 d-block" style="height: 100px;" data="{{ asset($item_cover) }}" type="image/png">
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
                                                    <b>Status:</b> <span class="badge text-bg-secondary">{{ $item->status }}</span>
                                                </p>
                                            </section>
                                        </div>
                                    </td>
                                    <td class="text-capitalize">
                                        {{ $item->date_loaned }} {{ date('h:i A', strtotime($item->created_at)) }}
                                        <i class="bi bi-arrow-right"></i>
                                        {{ $item->date_returned }} {{ date('h:i A', strtotime($item->updated_at)) }}
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center fs-5 text-secondary">No data found.</td></tr>
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
                            <tr>
                                <th class="px-3">Status</th>
                                <td class="text-capitalize">{{ $patron->status }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <x-footer />
    <x-slot:script>
        <script>
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
