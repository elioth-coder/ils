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
                            <input type="text" class="form-control" name="barcode" placeholder="--" autofocus="on">
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
                    if (patron) {
                        window.location.href = `/services/checkouts/${patron.card_number}/patron`;
                    }
                    if (item) {
                        if (item.status == 'available') {
                            return checkoutWithPatron(item.barcode);
                        }
                        if (item.status == 'checked out') {
                            return returnItem({
                                barcode : item.barcode,
                                loaner_id : item.loaner_id,
                            });
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

                    if(status=='success') {
                        window.location.href = `/services/checkouts/${data.card_number}/patron`;
                    }
                });
            }

            async function checkoutWithPatron(barcode) {
                Swal.fire({
                    title: "Enter Patron No. of the person that will loan the item",
                    input: "text",
                    inputAttributes: {
                        autocapitalize: "off"
                    },
                    showCancelButton: true,
                    confirmButtonText: "Submit",
                    showLoaderOnConfirm: true,
                    preConfirm: async (barcode) => {
                        try {
                            let formData = new FormData();
                            let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                                formData.set('barcode', barcode)

                            let response = await fetch('/services/checkouts/find_barcode', {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken
                                },
                            });

                            if (!response.ok) {
                                return Swal.showValidationMessage(`
                                    ${JSON.stringify(await response.json())}
                                `);
                            }

                            let {
                                status,
                                message,
                                patron,
                                item
                            } = await response.json();

                            if(status == 'error') {
                                throw 'Card No. not found';
                            }

                            if(!patron) {
                                throw 'Card No. not found';
                            }

                            return { patron }
                        } catch (error) {
                            Swal.showValidationMessage(`
                                Error: ${error}
                            `);
                        }
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if(result.isConfirmed) {
                        checkoutItem({
                            'barcode': barcode,
                            'requester_id': result.value.patron.user_id,
                            'card_number': result.value.patron.card_number,
                        });
                    } else {
                        window.location.reload();
                    }
                });
            }
        </script>
    </x-slot>
</x-layout>
