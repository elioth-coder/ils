<x-layout>
    <x-header />
    <main class="d-flex align-items-center justify-content-center w-100 bg-light">
        @if (in_array(Auth::user()->role, ['admin', 'librarian', 'staff', 'clerk']))
            <div class="container d-flex py-5">
                <h1>You are in dashboard page</h1>
            </div>
        @else
            <div class="container py-2">
                <h2 class="mb-4">{{ Auth::user()->name }}</h2>
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
                            aria-selected="false">Requests</button>
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

                <div class="tab-content p-3">
                    <div class="tab-pane active" id="loans" role="tabpanel" aria-labelledby="loans-tab"
                        tabindex="0">...</div>
                    <div class="tab-pane" id="requests" role="tabpanel" aria-labelledby="requests-tab" tabindex="0">
                        ...</div>
                    <div class="tab-pane" id="history" role="tabpanel" aria-labelledby="history-tab" tabindex="0">
                        ...</div>
                    <div class="tab-pane" id="personal-data" role="tabpanel" aria-labelledby="personal-data-tab" tabindex="0">
                        <section class="bg-info p-2 rounded-1 mb-4">
                            <h5 class="mb-0">Personal data</h5>
                        </section>
                        <table class="mx-3">
                            <tbody>
                                <tr>
                                    <th class="px-3">Campus</th>
                                    <td>{{ $user->campus }}</td>
                                </tr>
                                <tr>
                                    <th class="px-3">Department</th>
                                    <td>{{ $user->college }}</td>
                                </tr>
                                <tr>
                                    <th class="px-3">Academic rank</th>
                                    <td class="text-uppercase">{{ $user->academic_rank }}</td>
                                </tr>
                                <tr>
                                    <th class="px-3">Employee no.</th>
                                    <td>{{ $user->employee_number }}</td>
                                </tr>
                                <tr>
                                    <th class="px-3">Email address</th>
                                    <td>{{ $user->email }}</td>
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
                                    <th class="px-3">Home address</th>
                                    <td>
                                        {{ $user->barangay }},
                                        {{ $user->municipality }},
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
                                <tr>
                                    <th class="px-3">
                                        <a href="/accounts/profile" class="btn btn-primary btn-sm">Edit</a>
                                        <a href="/accounts/password" class="btn btn-primary btn-sm">Change password</a>
                                    </th>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </main>
    <x-footer />
</x-layout>
