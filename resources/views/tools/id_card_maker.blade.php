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
                    <li class="breadcrumb-item active" aria-current="page">ID Card Maker</li>
                </ol>
            </nav>
        </section>
        <div class="container d-flex flex-column pb-5 flex-wrap">
            <h1 class="text-center"><i class="bi bi-person-vcard me-3"></i>ID Card Maker</h1>
            <hr>
            <div class="d-block mb-4 bg-white p-5 border rounded">
                <form action="/tools/id_card_maker/print" method="POST">
                    @csrf
                    @method('POST')
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">
                                    <input type="checkbox" onchange="handleSelectAll(this)" />
                                </th>
                                <th class="text-center">Card Number</th>
                                <th>Full Name</th>
                                <th>Contact No.</th>
                                <th>Program</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($patrons as $patron)
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" value="{{ $patron->card_number }}" name="card_numbers[]" />
                                    </td>
                                    <td class="text-center">{{ $patron->card_number }}</td>
                                    <td>{{ $patron->first_name }} {{ $patron->last_name }}</td>
                                    <td>{{ $patron->mobile_number }}</td>
                                    <td class="text-center">{{ $patron->program }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-printer"></i>
                        Print ID Cards
                    </button>
                </form>
            </div>
        </div>
    </main>
    <x-footer />
    <x-slot:script>
        <script>
            const handleSelectAll = (selectAllElement) => {
                const checkboxes = document.querySelectorAll('[name="card_numbers[]"]');
                if (selectAllElement.checked) {
                    checkboxes.forEach((checkbox) => {
                        checkbox.checked = true;
                        if (!cardNumbers.includes(checkbox.value)) {
                            cardNumbers.push(checkbox.value);
                        }
                    });
                } else {
                    checkboxes.forEach((checkbox) => {
                        checkbox.checked = false;
                    });
                    cardNumbers = [];
                }
            };
        </script>
    </x-slot:script>
</x-layout>
