<x-layout>
    <x-slot:head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </x-slot:head>
    <x-header />
    <main class="d-flex align-items-center justify-content-center w-100 bg-light">
        <div class="container py-2">
            <h2 class="mb-4 text-capitalize">{{ strtolower(Auth::user()->name) }}</h2>

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active bg-transparent"
                        id="loans-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#loans"
                        type="button"
                        role="tab"
                        aria-controls="loans"
                        aria-selected="true">Loans</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link bg-transparent"
                        id="requests-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#requests"
                        type="button"
                        role="tab"
                        aria-controls="requests"
                        aria-selected="false">
                        Requests
                        @if(count($requested_books))
                            <span class="badge text-bg-primary">{{ count($requested_books) }}</span>
                        @endif
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link bg-transparent"
                        id="history-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#history"
                        type="button"
                        role="tab"
                        aria-controls="history"
                        aria-selected="false">History</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link bg-transparent"
                        id="personal-data-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#personal-data"
                        type="button"
                        role="tab"
                        aria-controls="personal-data"
                        aria-selected="false">Personal data</button>
                </li>
            </ul>

            <div class="tab-content py-3">
                <div class="tab-pane active" id="loans"
                    role="tabpanel"
                    aria-labelledby="loans-tab"
                    tabindex="0">
                </div>
                <div class="tab-pane" id="requests" role="tabpanel" aria-labelledby="requests-tab" tabindex="0">
                    <table class="table">
                        <thead>
                            <tr>
                            <th class="bg-body-secondary">#</th>
                            <th class="bg-body-secondary">Item</th>
                            <th class="bg-body-secondary">Document Title</th>
                            <th class="bg-body-secondary">Date Requested</th>
                            <th class="bg-body-secondary">Status</th>
                            <th class="bg-body-secondary"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($requested_books as $book)
                                <tr>
                                    <td>
                                        @php
                                        $color = [
                                            'available'   => 'success',
                                            'reserved'    => 'warning',
                                            'checked out' => 'danger',
                                        ];
                                        @endphp
                                        <i class="bi bi-circle-fill text-{{ $color[$book->status] }}"></i>
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
                                                            <h4>{{ $book->title }}</h4>
                                                        </a>
                                                    </div>
                                                </div>
                                                <p>
                                                    <b>Author(s):</b> {{ $book->author }} <br>
                                                    <b>Published:</b> {{ $book->publisher }} ({{ $book->publication_year }}) <br>
                                                    <span class="d-inline-block w-50 text-capitalize"><b>Status:</b> {{ $book->status }} </span>
                                                    <b>ISBN:</b> {{ $book->isbn }}
                                                </p>
                                            </section>
                                        </div>
                                    </td>
                                    <td class="text-capitalize">{{ $book->date_requested }}</td>
                                    <td class="text-capitalize">{{ $book->request_status }}</td>
                                    <td class="text-center">
                                        <button onclick="cancelRequest({{ $book->barcode ?? 'null' }});" class="btn btn-outline-danger">
                                            Cancel
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr><td class="text-center fs-5 text-secondary">No data found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="history" role="tabpanel" aria-labelledby="history-tab" tabindex="0">

                </div>
                <div class="tab-pane" id="personal-data" role="tabpanel" aria-labelledby="personal-data-tab" tabindex="0">
                    <section class="bg-body-secondary p-2 rounded-1 mb-4">
                        <h5 class="mb-0">Personal data</h5>
                    </section>
                    <table class="mx-3">
                        <tbody>
                            <tr>
                                <th class="px-3">Card No. / ID No.</th>
                                <td>{{ $user->card_number }}</td>
                            </tr>
                            <tr>
                                <th class="px-3">Gender</th>
                                <td class="text-capitalize">{{ $user->gender }}</td>
                            </tr>
                            <tr>
                                <th class="px-3">Birthday</th>
                                <td>{{ $user->birthday }}</td>
                            </tr>
                            <tr>
                                <th class="px-3">Email address</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th class="px-3">Mobile No.</th>
                                <td>{{ $user->mobile_number }}</td>
                            </tr>
                            <tr>
                                <th class="px-3">Home address</th>
                                <td>
                                    {{ $user->barangay }}
                                    {{ $user->municipality }}
                                    {{ $user->province }}
                                </td>
                            </tr>
                            <tr>
                                <th class="px-3">Mobile no.</th>
                                <td>{{ $user->mobile_number }}</td>
                            </tr>
                            <tr>
                                <th class="px-3">Status</th>
                                <td class="text-capitalize">{{ $user->status }}</td>
                            </tr>
                            @if($user->campus)
                                <tr>
                                    <th class="px-3">Campus Code</th>
                                    <td>{{ $user->campus }}</td>
                                </tr>
                            @endif
                            @if($user->library)
                                <tr>
                                    <th class="px-3">Library Code</th>
                                    <td>{{ $user->library }}</td>
                                </tr>
                            @endif
                            @if($user->department)
                                <tr>
                                    <th class="px-3">Department</th>
                                    <td>{{ $user->department }}</td>
                                </tr>
                            @endif
                            @if($user->academic_rank)
                                <tr>
                                    <th class="px-3">Academic rank</th>
                                    <td class="text-uppercase">{{ $user->academic_rank }}</td>
                                </tr>
                            @endif
                            @if($user->program)
                                <tr>
                                    <th class="px-3">Program</th>
                                    <td class="text-uppercase">{{ $user->program }}</td>
                                </tr>
                            @endif
                            @if($user->year)
                                <tr>
                                    <th class="px-3">Year & Section</th>
                                    <td class="text-uppercase">{{ $user->year }} {{ $user->section }}</td>
                                </tr>
                            @endif

                            <tr>
                                <th class="px-3">
                                    <a href="/account/edit" class="btn btn-primary btn-sm">Edit</a>
                                    <a href="/account/change_password" class="btn btn-primary btn-sm">Change password</a>
                                </th>
                                <td></td>
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
            function cancelRequest(barcode) {
                Swal.fire({
                    title: "Cancel this request?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: "Confirm"
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        let formData = new FormData();
                        formData.set('barcode', barcode);

                        let response = await fetch('/collections/books/cancel_request', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                        });

                        let { status, message } = await response.json();

                        await Swal.fire({
                            title: message,
                            icon: status,
                            showConfirmButton: false,
                            timer: 2000,
                        });

                        window.location.reload();
                    }
                });
            }
        </script>
    </x-slot>
</x-layout>
