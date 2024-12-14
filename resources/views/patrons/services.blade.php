<x-layout>
    <x-slot:head>
        <link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.bootstrap5.min.css">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/2.1.4/js/dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/2.1.4/js/dataTables.bootstrap5.min.js"></script>
    </x-slot:head>
    <x-header />
    <main class="d-flex flex-column align-items-center justify-content-center w-100 bg-body-secondary">
        <section class="container d-flex py-3 align-items-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 border py-2 px-3 bg-white rounded">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item"><a href="/services">Services</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Patrons</li>
                </ol>
            </nav>
        </section>
        <div class="container d-flex flex-column pb-5">
            <section>
                <div class="">
                    <h3 class="mb-4">Library Patrons</h3>
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="active-patrons-tab" data-bs-toggle="tab"
                                data-bs-target="#active-patrons" type="button" role="tab" aria-controls="active-patrons"
                                aria-selected="true">
                                Active
                                @if (count($active_patrons))
                                    <span class="badge text-bg-primary">{{ count($active_patrons) }}</span>
                                @endif
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="inactive-patrons-tab" data-bs-toggle="tab"
                                data-bs-target="#inactive-patrons" type="button" role="tab" aria-controls="inactive-patrons"
                                aria-selected="false">
                                Inactive
                                @if (count($inactive_patrons))
                                    <span class="badge text-bg-primary">{{ count($inactive_patrons) }}</span>
                                @endif
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content p-4 bg-white border border-top-0 rounded rounded-top-0">
                        <div class="tab-pane active" id="active-patrons" role="tabpanel" aria-labelledby="active-patrons-tab" tabindex="0">
                            <table id="active-patrons-table" class="table">
                                <thead>
                                    <tr>
                                    <th class="bg-body-secondary">#</th>
                                    <th class="bg-body-secondary">Card No.</th>
                                    <th class="bg-body-secondary">Patron Details</th>
                                    <th class="bg-body-secondary">Contacts</th>
                                    <th class="bg-body-secondary text-center">Loans</th>
                                    <th class="bg-body-secondary text-center">Requests</th>
                                    <th class="bg-body-secondary text-center">Returned</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($active_patrons as $patron)
                                    <tr>
                                    <td>
                                        @if($patron->role=='teacher')
                                            <i title="Teacher" class="bi bi-circle-fill text-warning"></i>
                                        @endif
                                        @if($patron->role=='student')
                                            <i title="Student" class="bi bi-circle-fill text-primary"></i>
                                        @endif
                                    </td>
                                    <td style="min-width: 150px;">
                                        <a href="/services/checkouts/{{ $patron->card_number }}/patron" class="text-capitalize link-primary">
                                            {{ $patron->card_number }}
                                        </a>
                                    </td>
                                    <td class="w-100">
                                        <div class="d-flex">
                                            <section style="height: 90px;" class="me-3">
                                                @php $profile = ($patron->profile) ? "/storage/images/users/$patron->profile" : '/images/profile.jpg'; @endphp
                                                <object class="h-100 d-block rounded-circle" data="{{ asset($profile) }}" type="image/png">
                                                    <img class="h-100 d-block rounded-circle" src="/images/profile.jpg" alt="">
                                                </object>
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
                                                    <b>Gender :</b> <span class="text-capitalize">{{ $patron->gender }}</span> <br>
                                                    <b>Role :</b> <span class="text-capitalize">{{ $patron->role }}</span> <br>
                                                </p>
                                            </section>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $patron->email }} <br>
                                        {{ $patron->mobile_number ?? '--' }}
                                    </td>
                                    <td class="text-center">{{ $patron->loans }}</td>
                                    <td class="text-center">{{ $patron->requests }}</td>
                                    <td class="text-center">{{ $patron->returns }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="inactive-patrons" role="tabpanel" aria-labelledby="inactive-patrons-tab" tabindex="0">
                            <table id="inactive-patrons-table" class="table">
                                <thead>
                                    <tr>
                                    <th class="bg-body-secondary">#</th>
                                    <th class="bg-body-secondary">Card No.</th>
                                    <th class="bg-body-secondary">Patron Details</th>
                                    <th class="bg-body-secondary">Contacts</th>
                                    <th class="bg-body-secondary text-center">Loans</th>
                                    <th class="bg-body-secondary text-center">Requests</th>
                                    <th class="bg-body-secondary text-center">Returned</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($inactive_patrons as $patron)
                                    <tr>
                                    <td>
                                        @if($patron->role=='teacher')
                                            <i title="Teacher" class="bi bi-circle-fill text-warning"></i>
                                        @endif
                                        @if($patron->role=='student')
                                            <i title="Student" class="bi bi-circle-fill text-primary"></i>
                                        @endif
                                    </td>
                                    <td style="min-width: 150px;">{{ $patron->card_number }}</td>
                                    <td class="w-100">
                                        <div class="d-flex">
                                            <section style="height: 90px;" class="me-3">
                                                @php $profile = ($patron->profile) ? "/storage/images/users/$patron->profile" : '/images/profile.jpg'; @endphp
                                                <object class="h-100 d-block rounded-circle" data="{{ asset($profile) }}" type="image/png">
                                                    <img class="h-100 d-block rounded-circle" src="/images/profile.jpg" alt="">
                                                </object>
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
                                                    <b>Gender :</b> <span class="text-capitalize">{{ $patron->gender }}</span> <br>
                                                    <b>Birthday :</b> {{ $patron->birthday }} <br>
                                                </p>
                                            </section>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $patron->email }} <br>
                                        {{ $patron->mobile_number ?? '--' }}
                                    </td>
                                    <td class="text-center">{{ $patron->loans }}</td>
                                    <td class="text-center">{{ $patron->requests }}</td>
                                    <td class="text-center">{{ $patron->returns }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <x-footer />
    <x-slot:script>
        <script>
            new DataTable('#active-patrons-table');
            new DataTable('#inactive-patrons-table');
        </script>
    </x-slot>
</x-layout>
