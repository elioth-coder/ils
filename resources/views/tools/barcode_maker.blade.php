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
                    <li class="breadcrumb-item"><a href="/tools">Tools</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Barcode Maker</li>
                </ol>
            </nav>
        </section>
        <div class="container d-flex flex-column pb-5 flex-wrap">
            <h1 class="text-center"><i class="bi bi-upc-scan me-3"></i>Barcode Maker</h1>
            <hr>
            <style>
                .multiline-ellipsis {
                    display: -webkit-box;
                    -webkit-box-orient: vertical;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    -webkit-line-clamp: 2;
                    font-size: 12px;
                    height: 36px;
                    line-height: 1.5em;
                    max-height: 3em;
                    color: black;
                }
            </style>
            <div class="w-50 mb-4 mx-auto">
                <form onsubmit="return findBarcode(event);" class="flex-grow-1" method="GET">
                    <div class="input-group bg-white rounded-3">
                        <input type="text" class="form-control form-control-lg" name="barcode"
                            placeholder="Scan printed barcodes" autofocus="on">
                        <button class="btn btn-light border" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="d-block mb-4 bg-white">
                @foreach ($items as $item)
                    <div class="float-start m-3 border border-dark p-1" style="width: 200px;">
                        <span class="multiline-ellipsis">{{ $item->title }}</span>
                        <img src="data:image/png;base64,{!! DNS1D::getBarcodePNG($item->barcode, 'EAN13', 2, 70, [0, 0, 0], true) !!}" alt="barcode" /><br>
                    </div>
                @endforeach
            </div>

            <a href="/tools/barcode_maker/print" target="_blank" class="btn btn-primary btn-lg">
                <i class="bi bi-printer"></i>
                Print Barcodes
            </a>
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
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    if (item) {
                        if (item.status == 'no barcode') {
                            return setStatusToAvailable(item.barcode);
                        }

                        Swal.fire({
                            title: `The item status is [${item.status.toUpperCase()}] and cannot be marked as printed and available`,
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

            async function setStatusToAvailable(barcode) {
                let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                let formData = new FormData();
                formData.set('barcode', barcode);
                formData.set('status', 'available');

                let response = await fetch('/collections/items/set_status', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                });

                let {
                    status,
                    message,
                } = await response.json();

                Swal.fire({
                    title: message,
                    icon: status,
                    showConfirmButton: false,
                    timer: 3000,
                }).then(() => {
                    window.location.reload();
                });
            }
        </script>
    </x-slot:script>
</x-layout>
