<x-layout>
    <x-slot:head>
        <link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.bootstrap5.min.css">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/2.1.4/js/dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/2.1.4/js/dataTables.bootstrap5.min.js"></script>
    </x-slot:head>
    <x-header />
    @php
        $sections = [
            'circulation' => [
                'icon' => 'arrow-clockwise',
                'title' => 'Circulation Section',
            ],
            'filipiniana' => [
                'icon' => 'flag',
                'title' => 'Filipiniana Section',
            ],
            'periodical' => [
                'icon' => 'newspaper',
                'title' => 'Periodical Section',
            ],
            'reference' => [
                'icon' => 'bookmark',
                'title' => 'Reference Section',
            ],
            'e-library' => [
                'icon' => 'pc-display',
                'title' => 'E-Library Section',
            ],
            'audio-visual' => [
                'icon' => 'film',
                'title' => 'Audio Visual Section',
            ],
            'thesis' => [
                'icon' => 'journal',
                'title' => 'Thesis Section',
            ],
        ];
        $section = $sections[$selected];
    @endphp
    <main class="d-flex flex-column align-items-center justify-content-center w-100 bg-body-secondary">
        <section class="container d-flex py-3 align-items-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 border py-2 px-3 bg-white rounded">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item"><a href="/sections">Library Sections</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $section['title'] }}</li>
                </ol>
            </nav>
        </section>
        <div class="container d-flex flex-column pb-5">
            <section>
                <div class="">
                    @if ($section)
                        <h3 class="mb-3 text-center p-3  text-decoration-underline">
                            <i class="bi bi-{{ $section['icon'] }}"></i>
                            {{ $section['title'] }}
                        </h3>
                    @endif

                    <div class="">
                        <table id="items-table" class="table">
                            <thead>
                                <tr>
                                    <th class="bg-body-secondary">#</th>
                                    <th class="bg-body-secondary text-start">Item</th>
                                    <th class="bg-body-secondary">Document title</th>
                                    <th class="bg-body-secondary text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td style="width: 60px;">
                                            <i class="bi bi-circle-fill text-secondary"></i>
                                        </td>
                                        <td class="text-start" style="width: 150px;">
                                            <a href="/collections/items/{{ $item->title }}/copy/{{ $item->barcode }}">
                                                {{ $item->barcode }}
                                            </a>
                                        </td>
                                        <td class="w-75">
                                            <div class="d-flex">
                                                <section style="height: 110px;" class="card p-1 me-2">
                                                    @php $item_cover = ($item->cover_image) ? "/storage/images/$item->type/$item->cover_image" : '/images/cover_not_available.jpg'; @endphp
                                                    <object class="h-100 d-block" data="{{ asset($item_cover) }}"
                                                        type="image/png">
                                                        <img class="h-100 d-block" src="/images/cover_not_available.jpg"
                                                            alt="">
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
                                                        ({{ $item->publication_year }})
                                                        <br>
                                                        <b>Status:</b> <span
                                                            class="badge text-bg-secondary">{{ $item->status }}</span>
                                                    </p>
                                                </section>
                                            </div>
                                        </td>
                                        <td class="text-center" style="min-width: 140px;">
                                            @if (in_array(Auth::user()->role, ['teacher', 'student']) && $item->status=='available')
                                                <button onclick="requestItem({{ $item->barcode }});"
                                                    class="mt-1 btn btn-success">
                                                    Request Item
                                                </button>
                                            @else
                                                <a href="/collections/items/{{ $item->title }}/copy/{{ $item->barcode }}"
                                                    class="mt-1 btn btn-primary">
                                                    View Item
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <x-footer />
    <x-slot:script>
        <script>
            new DataTable('#items-table');

            function requestItem(barcode) {
                if (barcode == null) {
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
                            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content');
                            let formData = new FormData();
                            formData.set('barcode', barcode);

                            let response = await fetch('/collections/items/request', {
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
                        }
                    });
                }
            }
        </script>
    </x-slot>
</x-layout>
