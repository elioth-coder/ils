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
                    <li class="breadcrumb-item active" aria-current="page">Check-outs</li>
                </ol>
            </nav>
        </section>
        <div class="container d-flex flex-column pb-5">
            <section>
                <div class="w-50">
                    <h3>Check-out/check-in</h3>
                    <p class="fw-bold">Please enter a patron card number or an item barcode.</p>
                    <form onsubmit="return findBarcode(event);" class="flex-grow-1" method="GET">
                        <div class="input-group bg-white rounded-3">
                            <input type="text" class="form-control" name="barcode" placeholder="--">
                            <button class="btn btn-light border" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </section>
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

                let { status, message, patron, item } = await response.json();

                if(status=='error') {
                    Swal.fire({
                        title: message,
                        icon: status,
                        showConfirmButton: false,
                        timer: 2000,
                    });
                } else {
                    if(patron) {
                        window.location.href = `/services/checkouts/${patron.card_number}/patron`;
                    }
                    if(item) {
                        window.location.href = `/services/checkouts/${item.barcode}/item`;
                    }
                }
                return false;
            }
        </script>
    </x-slot>
</x-layout>
