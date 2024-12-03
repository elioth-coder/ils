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
                        <a href="/search/{{ $item->type }}" class="btn btn-outline-success btn-sm">
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
                            <object class="h-100 d-block" data="{{ asset($item_cover) }}" type="image/png">
                                <img class="h-100 d-block" src="/images/cover_not_available.jpg" alt="">
                            </object>
                        </section>
                    </div>
                    <div class="w-100 px-1">
                        <section class="d-flex">
                            <div class="w-100">
                                <h2>{{ $item->title }}</h2>
                            </div>
                        </section>
                        <hr style="margin-top: 0; margin-bottom: 12px;">
                        <p style="margin: 0;">
                            <b>Author:</b> {{ $item->author }} <br>
                            <b>Published:</b> {{ $item->publisher }} ({{ $item->publication_year }}) <br>
                            <b>ISBN:</b> {{ $item->isbn }} <br>
                        </p>
                        <p class="multiline-ellipsis my-0 mb-2" style="text-align: justify;">
                            <b>Abstract:</b> <i>{{ $item->summary }}</i></p>
                        @if ($item->tags)
                            <p>
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
                        <button class="nav-link active bg-transparent" id="copies-tab" data-bs-toggle="tab" data-bs-target="#copies"
                            type="button" role="tab" aria-controls="copies" aria-selected="true">
                            <i class="bi bi-basket me-1"></i>
                            Get
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link bg-transparent" id="description-tab" data-bs-toggle="tab" data-bs-target="#description"
                            type="button" role="tab" aria-controls="description" aria-selected="false">
                            <i class="bi bi-list me-1"></i>
                            Description
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link bg-transparent" id="messages-tab" data-bs-toggle="tab" data-bs-target="#messages"
                            type="button" role="tab" aria-controls="messages"
                            aria-selected="false">
                            <i class="bi bi-boxes me-1"></i>
                            Related Entities
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link bg-transparent" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings"
                            type="button" role="tab" aria-controls="settings"
                            aria-selected="false">
                            <i class="bi bi-file-earmark me-1"></i>
                            Files
                        </button>
                    </li>
                </ul>
                <div class="tab-content p-3">
                    <div class="tab-pane active" id="copies" role="tabpanel" tabindex="0">
                        @foreach($libraries as $library)
                            <div class="accordion mb-2" id="libray-{{ $library->code }}">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" aria-expanded="false" data-bs-target="#libray-{{ $library->code }}-content"  aria-controls="libray-{{ $library->code }}-content">
                                            <div class="w-50">[{{ $library->code ?? '--' }}] - {{ $library->name ?? '--' }}</div>
                                            <div class="w-50">Items: {{ count($library->items) }}</div>
                                        </button>
                                    </h2>
                                    <div id="libray-{{ $library->code }}-content" class="accordion-collapse collapse" data-bs-parent="#libray-{{ $library->code }}">
                                        <div class="accordion-body">
                                            <div class="d-flex mb-1 border m-3 p-3">
                                                <table class="w-100">
                                                <tbody>
                                                    @forelse($library->items as $library_item)
                                                        <tr>
                                                            <th class="text-nowrap px-2">Barcode: </th>
                                                            <td>
                                                                @if($library_item->barcode)
                                                                <a href="/collections/items/{{ $library_item->title }}/copy/{{ $library_item->barcode }}">
                                                                    {{ $library_item->barcode ?? '--'}}
                                                                </a>
                                                                @else
                                                                    --
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <div class="text-end" style="min-width: 200px;">
                                                                    @php
                                                                    $requests = collect($library_item->requests)->filter(function($request_item) {
                                                                        return $request_item->requester_id == Auth::user()->id;
                                                                    });
                                                                    $requests_count = count($requests);
                                                                    $is_requested = ($requests_count > 0) ? true : false;
                                                                    @endphp

                                                                    @if($library_item->status=='available' && !in_array(Auth::user()->role, ['admin','librarian','clerk','staff']))
                                                                        @if ($is_requested)
                                                                            <span class="badge text-bg-warning">Request pending</span>
                                                                        @else
                                                                            <button onclick="requestItem({{ $library_item->barcode ?? 'null' }})" title="Request item" class="btn btn-outline-success">
                                                                                <i class="bi bi-basket"></i>
                                                                            </button>
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                            </td>
                                                        </tr>

                                                        @if(!in_array(Auth::user()->role, ['student','teacher']))
                                                            <tr>
                                                                <th class="text-nowrap px-2">Price: </th>
                                                                <td class="text-capitalize">{{ $library_item->price ?? '--'}}</td>
                                                                <td></td>
                                                            </tr>
                                                        @endif

                                                        <tr>
                                                            <th class="text-nowrap px-2">Status: </th>
                                                            <td class="text-capitalize">{{ $library_item->status ?? '--'}}</td>
                                                            <td></td>
                                                        </tr>
                                                        @if($requests_count > 0)
                                                            <tr>
                                                                <th class="text-nowrap px-2">Requested by: </th>
                                                                <td class="">{{ $requests_count }} patron</td>
                                                                <td></td>
                                                            </tr>
                                                        @endif
                                                        @if($library_item->status=='reserved')
                                                            <tr>
                                                                <th class="text-nowrap px-2">Reserved for: </th>
                                                                <td class="text-capitalize">
                                                                    <a href="/services/checkouts/{{ $library_item->reserved_for->card_number }}/patron">
                                                                        {{ $library_item->reserved_for->name }}
                                                                    </a>
                                                                </td>
                                                                <td></td>
                                                            </tr>
                                                        @endif
                                                        @if($library_item->status=='checked out')
                                                            <tr>
                                                                <th class="text-nowrap px-2">Loaned by: </th>
                                                                <td class="text-capitalize">
                                                                    <a href="/services/checkouts/{{ $library_item->loaned_by->card_number }}/patron">
                                                                        {{ $library_item->loaned_by->name }}
                                                                    </a>
                                                                </td>
                                                                <td></td>
                                                            </tr>
                                                        @endif
                                                        <tr><td colspan="3"><hr></td></tr>
                                                    @empty
                                                        <tr><td colspan="3"><h5 class="text-center my-3 text-secondary">No data found.</h5></td></tr>
                                                    @endforelse
                                                </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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
                    <div class="tab-pane" id="related_entities" role="tabpanel" aria-labelledby="related_entities-tab" tabindex="0">

                    </div>
                    <div class="tab-pane" id="files" role="tabpanel" aria-labelledby="files-tab" tabindex="0">

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
