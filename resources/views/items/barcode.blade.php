<x-layout>
    <x-slot:head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </x-slot:head>
    <x-header />
    <main class="d-flex flex-column align-items-center justify-content-center w-100 bg-light">
        <div class="container py-2 d-flex">

            <style>
                .multiline-ellipsis {
                    display: -webkit-box;
                    -webkit-box-orient: vertical;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    -webkit-line-clamp: 2;
                    line-height: 1.5em;
                    max-height: 3em;
                }
            </style>
            <div class="w-100 ps-4">
                <section class="d-flex w-100 py-4">
                    <div class="w-50">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-success btn-sm">
                            <i class="bi bi-arrow-left"></i>
                            Back
                        </a>
                    </div>
                    @if(in_array(Auth::user()->role, ['admin','librarian','staff','clerk']))
                        <div class="w-50 text-end">
                            <a href="/collections/{{ $item->type }}/{{ $item->id }}/copy#{{ $item->type }}-form" class="btn btn-outline-secondary btn-sm">
                                Duplicate
                                <i class="bi bi-copy"></i>
                            </a>
                            <a href="/collections/{{ $item->type }}/{{ $item->id }}/edit#{{ $item->type }}-form" class="btn btn-outline-primary btn-sm">
                                Edit
                                <i class="bi bi-pencil"></i>
                            </a>
                        </div>
                    @endif
                </section>

                <section class="d-flex w-100">
                    <div class="px-4">
                        <section style="height: 200px;" class="card p-1 mt-2">
                            @php $item_cover = ($item->cover_image) ? "/storage/images/$item->type/$item->cover_image" : '/images/cover_not_available.jpg'; @endphp
                            <img class="h-100 d-block" src="{{ asset($item_cover) }}" alt="">
                        </section>
                    </div>
                    <div class="w-100 px-1">
                        <section class="d-flex flex-column">
                            <div class="w-100">
                                <h3 class="text-success">[{{ $item->barcode }}]</h3>
                            </div>
                            <div class="w-100">
                                <h2>{{ $item->title }}</h2>
                            </div>
                        </section>
                        <hr style="margin-top: 0; margin-bottom: 12px;">
                        <p style="margin: 0;">
                            @php
                            $requests_count = count($item->requests);
                            @endphp
                            <b>Author:</b> {{ $item->author }} <br>
                            <b>Published:</b> {{ $item->publisher }} ({{ $item->publication_year }}) <br>
                            <b>ISBN:</b> {{ $item->isbn }} <br>
                            <b>Status:</b> <span class="text-capitalize">{{ $item->status }}</span> <br>

                            @if($requests_count > 0)
                                <b>Requested by: </b> {{ $requests_count }} patron <br>
                            @endif
                            @if($item->status=='reserved')
                                <b>Reserved for: </b>
                                <a href="/services/checkouts/{{ $item->reserved_for->card_number }}/patron">
                                    {{ $item->reserved_for->name }}
                                </a> <br>
                            @endif
                            @if($item->status=='checked out')
                                <b>Loaned by: </b>
                                <a href="/services/checkouts/{{ $item->loaned_by->card_number }}/patron">
                                    {{ $item->loaned_by->name }}
                                </a> <br>
                            @endif
                        </p>
                        @if ($item->tags)
                            <p class="mt-2">
                                @php
                                    $tags = explode(',', $item->tags) ?? [];
                                @endphp
                                @foreach ($tags as $tag)
                                    <a class="badge text-bg-secondary">
                                        {{ $tag }}
                                    </a>
                                @endforeach
                            </p>
                        @endif
                    </div>
                </section>
                <br>
                <ul class="nav nav-tabs" style="font-size: 17px;" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="history-tab" data-bs-toggle="tab" data-bs-target="#history"
                            type="button" role="tab" aria-controls="history" aria-selected="true">
                            <i class="bi bi-basket me-1"></i>
                            History
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="requests-tab" data-bs-toggle="tab" data-bs-target="#requests"
                            type="button" role="tab" aria-controls="requests" aria-selected="true">
                            <i class="bi bi-basket me-1"></i>
                            Requests
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="description-tab" data-bs-toggle="tab" data-bs-target="#description"
                            type="button" role="tab" aria-controls="description" aria-selected="false">
                            <i class="bi bi-list me-1"></i>
                            Description
                        </button>
                    </li>
                </ul>
                <div class="tab-content p-3">
                    <div class="tab-pane active" id="history" role="tabpanel" tabindex="0">
                        <table id="item-patrons-table" class="table">
                            <thead>
                                <tr>
                                <th class="bg-body-secondary">#</th>
                                <th class="bg-body-secondary">Loaned by</th>
                                <th class="bg-body-secondary">Contacts</th>
                                <th class="bg-body-secondary">Status</th>
                                <th class="bg-body-secondary">Duration</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse ($item_patrons as $patron)
                                <tr>
                                <td>
                                    @if($patron->status=='checked out')
                                        <i title="Checked out" class="bi bi-circle-fill text-danger"></i>
                                    @endif
                                    @if($patron->status=='returned')
                                        <i title="Returned" class="bi bi-circle-fill text-success"></i>
                                    @endif
                                </td>
                                <td class="w-100">
                                    <div class="d-flex">
                                        <section style="height: 90px;" class="me-3">
                                            @php $profile = ($patron->profile) ? "/storage/images/users/$patron->profile" : '/images/profile.jpg'; @endphp
                                            <img class="h-100 d-block rounded-circle shadow" src="{{ asset($profile) }}" alt="">
                                        </section>
                                        <section>
                                            <div class="d-flex">
                                                <div class="w-100">
                                                    <a href="/services/checkouts/{{ $patron->card_number }}/patron" class="text-capitalize link-primary">
                                                        <h5>{{ strtolower($patron->first_name) }} {{ strtolower($patron->last_name) }}</h5>
                                                    </a>
                                                </div>
                                            </div>
                                            <p>
                                                <b>Patron Type :</b> <span class="text-capitalize">{{ $patron->role }}</span> <br>
                                                <b>Card No. :</b>
                                                <a href="/services/checkouts/{{ $patron->card_number }}/patron" class="text-capitalize link-primary">
                                                    {{ $patron->card_number }}
                                                </a> <br>
                                            </p>
                                        </section>
                                    </div>
                                </td>
                                <td>
                                    {{ $patron->email }} <br>
                                    {{ $patron->mobile_number }}
                                </td>
                                <td class="text-capitalize">
                                    @if($patron->status=='checked out')
                                        <span class="badge text-bg-danger text-capitalize">{{ $patron->status }}</span>
                                    @endif
                                    @if($patron->status=='returned')
                                        <span class="badge text-bg-success text-capitalize">{{ $patron->status }}</span>
                                    @endif
                                </td>
                                <td style="min-width: 220px;">
                                    {{ $patron->date_loaned }}
                                    <i class="bi bi-arrow-right"></i>
                                    {{ $patron->date_returned }}
                                </td>
                                </tr>
                            @empty
                                <tr><td colspan="5"><h4 class="text-center text-secondary my-2">No data found.</h4></td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="requests" role="tabpanel" tabindex="0">
                        <table id="item-requests-table" class="table">
                            <thead>
                                <tr>
                                <th class="bg-body-secondary">#</th>
                                <th class="bg-body-secondary">Requested by</th>
                                <th class="bg-body-secondary">Contacts</th>
                                <th class="bg-body-secondary">Status</th>
                                <th class="bg-body-secondary">Date Requested</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse ($item_requests as $patron)
                                <tr>
                                <td>
                                    @if($patron->status=='pending')
                                        <i title="Pending" class="bi bi-circle-fill text-danger"></i>
                                    @endif
                                    @if($patron->status=='for pickup')
                                        <i title="For Pickup" class="bi bi-circle-fill text-success"></i>
                                    @endif
                                </td>
                                <td class="w-100">
                                    <div class="d-flex">
                                        <section style="height: 90px;" class="me-3">
                                            @php $profile = ($patron->profile) ? "/storage/images/users/$patron->profile" : '/images/profile.jpg'; @endphp
                                            <img class="h-100 d-block rounded-circle shadow" src="{{ asset($profile) }}" alt="">
                                        </section>
                                        <section>
                                            <div class="d-flex">
                                                <div class="w-100">
                                                    <a href="/services/checkouts/{{ $patron->card_number }}/patron" class="text-capitalize link-primary">
                                                        <h5>{{ strtolower($patron->first_name) }} {{ strtolower($patron->last_name) }}</h5>
                                                    </a>
                                                </div>
                                            </div>
                                            <p>
                                                <b>Patron Type :</b> <span class="text-capitalize">{{ $patron->role }}</span> <br>
                                                <b>Card No. :</b>
                                                <a href="/services/checkouts/{{ $patron->card_number }}/patron" class="text-capitalize link-primary">
                                                    {{ $patron->card_number }}
                                                </a> <br>
                                            </p>
                                        </section>
                                    </div>
                                </td>
                                <td>
                                    {{ $patron->email }} <br>
                                    {{ $patron->mobile_number }}
                                </td>
                                <td class="text-capitalize">
                                    @if($patron->status=='pending')
                                        <span class="badge text-bg-danger text-capitalize">{{ $patron->status }}</span>
                                    @endif
                                    @if($patron->status=='for pickup')
                                        <span class="badge text-bg-success text-capitalize">{{ $patron->status }}</span>
                                    @endif
                                </td>
                                <td style="min-width: 220px;">
                                    {{ $patron->date_requested }}
                                </td>
                                </tr>
                            @empty
                                <tr><td colspan="5"><h4 class="text-center text-secondary my-2">No data found.</h4></td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="description" role="tabpanel" tabindex="0">
                        <table>
                            <tbody class="align-top">
                                <tr>
                                    <th class="text-nowrap px-2">No. of copies</th>
                                    <td class="text px-2">{{ $item->copies ?? '--' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap px-2">Title</th>
                                    <td class="text px-2">{{ $item->title }}</td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap px-2">ISBN</th>
                                    <td class="text px-2">{{ $item->isbn }}</td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap px-2">Author</th>
                                    <td class="text px-2">{{ $item->author ?? '--' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap px-2">Publisher</th>
                                    <td class="text px-2">{{ $item->publisher ?? '--' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap px-2">Year Published</th>
                                    <td class="text px-2">{{ $item->publication_year ?? '--' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap px-2">Genre</th>
                                    <td class="text-capitalize px-2">{{ $item->genre }}</td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap px-2">Abstract / Summary</th>
                                    <td class="px-2" style="text-align: justify;">
                                        <div id="summary" class="multiline-ellipsis">
                                            {{ $item->summary ?? '--' }}
                                        </div>
                                        @if(strlen($item->summary > 200))
                                            <a href="javascript:showSummary()" id="show-summary">See more.</a>
                                            <a href="javascript:hideSummary()" style="display: none;" id="hide-summary">See less.</a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap px-2">No. of pages</th>
                                    <td class="text px-2">{{ $item->number_of_pages ?? '--' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap px-2">Price</th>
                                    <td class="text px-2">{{ $item->price ?? '--' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap px-2">Format</th>
                                    <td class="text-capitalize px-2">{{ $item->format }}</td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap px-2">Language</th>
                                    <td class="text-capitalize px-2">{{ $item->language ?? '--' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-nowrap px-2">Tag(s)</th>
                                    <td class="px-2">{{ $item->tags }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-footer />
    <x-slot:script>
        <script>
        function requestItem(barcode) {
            if(barcode==null) {
                Swal.fire({
                    title: "No Barcode",
                    text: "Item is not yet available for loan ",
                    icon: "error",
                    showConfirmButton: false,
                    timer: 2000,
                });
            } else {
                Swal.fire({
                    title: "Request this item for loan?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: "Confirm"
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        let formData = new FormData();
                        formData.set('barcode', barcode);

                        let response = await fetch('/collections/items/request', {
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

                        if(status=='success') {
                            window.location.reload();
                        }
                    }
                });
            }
        }

        function showSummary() {
            let $showSummary = document.getElementById('show-summary');
            let $hideSummary = document.getElementById('hide-summary');
            let $summary     = document.getElementById('summary');

            $summary.classList.remove('multiline-ellipsis');
            $showSummary.style.display = 'none';
            $hideSummary.style.display = 'inline';
        }

        function hideSummary() {
            let $showSummary = document.getElementById('show-summary');
            let $hideSummary = document.getElementById('hide-summary');
            let $summary     = document.getElementById('summary');

            $summary.classList.add('multiline-ellipsis');
            $showSummary.style.display = 'inline';
            $hideSummary.style.display = 'none';
        }
        </script>
    </x-slot:script>
</x-layout>
