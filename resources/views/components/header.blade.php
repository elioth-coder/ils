<header>
    <nav class="navbar bg-primary">
        <div class="container d-flex column-gap-5">
            <x-navbar-brand />
            @if (str_starts_with(request()->path(), 'search'))
                <div class="flex-grow-1"></div>
            @else
                <form action="/search" class="flex-grow-1" method="GET">
                    <div class="input-group bg-white rounded-3">
                        <input type="text" class="form-control" name="q" value="{{ request('q') ?? '' }}">
                        <button class="btn btn-light border" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </nav>
    <section>
        @auth
            <section class="bg-light w-100 border-light-subtle border-bottom" x-data="{ open: false }">
                <div class="w-100">
                    <section class="container d-flex align-items-center py-2">
                        <div class="d-flex flex-grow-1">
                            @php
                                $reports = [
                                    [
                                        'icon' => 'list-stars',
                                        'url' => '/reports/patron_list',
                                        'title' => 'List of patron',
                                    ],
                                    [
                                        'icon' => 'list-stars',
                                        'url' => '/reports/item_list',
                                        'title' => 'List of items',
                                    ],
                                    [
                                        'icon' => 'list-stars',
                                        'url' => '/reports/item_count',
                                        'title' => 'List of item count',
                                    ],
                                    [
                                        'icon' => 'list-stars',
                                        'url' => '/reports/attendance_list',
                                        'title' => ' List of attendance',
                                    ],
                                ];

                                $services = [
                                    [
                                        'icon' => 'arrow-left-right',
                                        'url' => '/services/checkouts',
                                        'title' => 'Check-out/check-in',
                                    ],
                                    [
                                        'icon' => 'basket',
                                        'url' => '/services/item_requests',
                                        'title' => 'Item Requests',
                                    ],
                                    [
                                        'icon' => 'card-checklist',
                                        'url' => '/services/current_loans',
                                        'title' => 'Current Loans',
                                    ],
                                    [
                                        'icon' => 'exclamation-circle',
                                        'url' => '/services/report_item',
                                        'title' => 'Report item',
                                    ],
                                    [
                                        'icon' => 'people',
                                        'url' => '/services/patrons',
                                        'title' => 'Users/Patrons',
                                    ],
                                ];

                                // $sections = [
                                //     [
                                //         'icon' => 'arrow-clockwise',
                                //         'url' => '/sections/circulation',
                                //         'title' => 'Circulation Section',
                                //     ],
                                //     [
                                //         'icon' => 'flag',
                                //         'url' => '/sections/filipiniana',
                                //         'title' => 'Filipiniana Section',
                                //     ],
                                //     [
                                //         'icon' => 'newspaper',
                                //         'url' => '/sections/periodical',
                                //         'title' => 'Periodical Section',
                                //     ],
                                //     [
                                //         'icon' => 'bookmark',
                                //         'url' => '/sections/reference',
                                //         'title' => 'Reference Section',
                                //     ],
                                //     [
                                //         'icon' => 'pc-display',
                                //         'url' => '/sections/e-library',
                                //         'title' => 'E-Library Section',
                                //     ],
                                //     [
                                //         'icon' => 'film',
                                //         'url' => '/sections/audio-visual',
                                //         'title' => 'Audio Visual Section',
                                //     ],
                                //     [
                                //         'icon' => 'journal',
                                //         'url' => '/sections/thesis',
                                //         'title' => 'Thesis Section',
                                //     ],

                                // ];

                                $users = [
                                    [
                                        'icon' => 'people',
                                        'url' => '/users/teachers',
                                        'title' => 'Teachers',
                                    ],
                                    [
                                        'icon' => 'people',
                                        'url' => '/users/students',
                                        'title' => 'Students',
                                    ],
                                ];

                                if (Auth::user()->role == 'admin') {
                                    $users[] = [
                                        'icon' => 'people',
                                        'url' => '/users/staffs',
                                        'title' => 'Library Staffs',
                                    ];

                                }

                                $collections = [
                                    [
                                        'icon' => 'book',
                                        'url' => '/collections/book',
                                        'title' => 'Books',
                                    ],
                                    [
                                        'icon' => 'journals',
                                        'url' => '/collections/research',
                                        'title' => 'Research',
                                    ],
                                    [
                                        'icon' => 'music-note-beamed',
                                        'url' => '/collections/audio',
                                        'title' => 'Audio',
                                    ],
                                    [
                                        'icon' => 'film',
                                        'url' => '/collections/video',
                                        'title' => 'Video',
                                    ],
                                ];

                                $tools = [
                                    [
                                        'icon' => 'filetype-csv',
                                        'url' => '/tools/csv_import',
                                        'title' => 'CSV Import',
                                    ],
                                    [
                                        'icon' => 'person-vcard',
                                        'url' => '/tools/id_card_maker',
                                        'title' => 'ID Card Maker',
                                    ],
                                    [
                                        'icon' => 'upc-scan',
                                        'url' => '/tools/barcode_maker',
                                        'title' => 'Barcode Maker',
                                    ],
                                    [
                                        'icon' => 'database-check',
                                        'url' => '/tools/backup_db',
                                        'title' => 'DB Backup/Restore',
                                    ],

                                ];

                                $settings = [];

                                if (Auth::user()->role == 'admin') {
                                    $settings[] = [
                                        'icon' => 'stack-overflow',
                                        'url' => '/settings/libraries',
                                        'title' => 'Libraries',
                                    ];
                                    $settings[] = [
                                        'icon' => 'bank',
                                        'url' => '/settings/campuses',
                                        'title' => 'Campuses',
                                    ];
                                }

                                $settings[] = [
                                    'icon' => 'buildings',
                                    'url' => '/settings/colleges',
                                    'title' => 'Colleges',
                                ];
                                $settings[] = [
                                    'icon' => 'building',
                                    'url' => '/settings/programs',
                                    'title' => 'Programs',
                                ];

                            @endphp
                            <a href="/" class="btn {{ str_starts_with(request()->path(), 'dashboard') ? 'btn-warning' : '' }} text-decoration-none">
                                <i class="bi bi-bell-fill me-1"></i>
                                Dashboard
                            </a>
                            @if (in_array(Auth::user()->role, ['admin', 'librarian', 'staff', 'clerk']))
                                <div x-data="notification" class="dropdown">
                                    <button class="btn  {{ str_starts_with(request()->path(), 'services') ? 'btn-warning' : '' }} dropdown-toggle text-decoration-none"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-grid-fill me-1"></i>
                                        Services
                                        <template x-if="count > 0">
                                            <span class="badge text-bg-danger" x-text="count"></span>
                                        </template>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        @foreach ($services as $service)
                                            <li>
                                                <a class="dropdown-item position-relative" href="{{ $service['url'] }}">
                                                    <i class="bi bi-{{ $service['icon'] }} me-1"></i>
                                                    {{ $service['title'] }}
                                                    @if ($service['title']=='Item Requests')
                                                        <template x-if="request_count > 0">
                                                            <span class="badge text-bg-danger position-absolute end-0 me-3" x-text="request_count"></span>
                                                        </template>
                                                    @endif
                                                    @if ($service['title']=='Current Loans')
                                                        <template x-if="loan_count > 0">
                                                            <span class="badge text-bg-danger position-absolute end-0 me-3" x-text="loan_count"></span>
                                                        </template>
                                                    @endif
                                                </a>
                                            </li>
                                        @endforeach
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="/services">
                                                <i class="bi bi-grid me-1"></i> Services
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                {{-- <div class="dropdown">
                                    <button class="btn {{ str_starts_with(request()->path(), 'sections') ? 'btn-warning' : '' }} dropdown-toggle text-decoration-none"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-grid-1x2-fill me-1"></i>
                                        Sections
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        @foreach ($sections as $section)
                                            <li>
                                                <a class="dropdown-item" href="{{ $section['url'] }}">
                                                    <i class="bi bi-{{ $section['icon'] }} me-1"></i> {{ $section['title'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="/sections">
                                                <i class="bi bi-grid-1x2 me-1"></i> Library Sections
                                            </a>
                                        </li>
                                    </ul>
                                </div> --}}

                                <div class="dropdown">
                                    <button class="btn {{ str_starts_with(request()->path(), 'collections') ? 'btn-warning' : '' }} dropdown-toggle text-decoration-none"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-layers-fill me-1"></i>
                                        Collections
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        @foreach ($collections as $collection)
                                            <li>
                                                <a class="dropdown-item" href="{{ $collection['url'] }}">
                                                    <i class="bi bi-{{ $collection['icon'] }} me-1"></i>
                                                    {{ $collection['title'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="/collections/new">
                                                <i class="bi bi-plus-square me-1"></i> Newly Added
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="/collections">
                                                <i class="bi bi-layers me-1"></i> Collections
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="dropdown">
                                    <button class="btn {{ str_starts_with(request()->path(), 'reports') ? 'btn-warning' : '' }} dropdown-toggle text-decoration-none"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-bar-chart-line-fill me-1"></i>
                                        Reports
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        @foreach ($reports as $report)
                                            <li>
                                                <a class="dropdown-item" href="{{ $report['url'] }}">
                                                    <i class="bi bi-{{ $report['icon'] }} me-1"></i> {{ $report['title'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <div class="dropdown">
                                    <button class="btn  {{ str_starts_with(request()->path(), 'users') ? 'btn-warning' : '' }} dropdown-toggle text-decoration-none"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-people-fill me-1"></i>
                                        Patrons
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        @foreach ($users as $user)
                                            <li>
                                                <a class="dropdown-item" href="{{ $user['url'] }}">
                                                    <i class="bi bi-{{ $user['icon'] }} me-1"></i> {{ $user['title'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="/users/visited">
                                                <i class="bi bi-people me-1"></i> Patrons (Visited)
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="/users">
                                                <i class="bi bi-people me-1"></i> Patrons
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="dropdown">
                                    <button class="btn {{ str_starts_with(request()->path(), 'tools') ? 'btn-warning' : '' }} dropdown-toggle text-decoration-none"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-tools me-1"></i>
                                        Tools
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        @foreach ($tools as $tool)
                                            <li>
                                                <a class="dropdown-item" href="{{ $tool['url'] }}">
                                                    <i class="bi bi-{{ $tool['icon'] }} me-1"></i>
                                                    {{ $tool['title'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <div class="dropdown">
                                    <button class="btn  {{ str_starts_with(request()->path(), 'settings') ? 'btn-warning' : '' }} dropdown-toggle text-decoration-none"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-gear-fill me-1"></i>
                                        Settings
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        @foreach ($settings as $setting)
                                            <li>
                                                <a class="dropdown-item" href="{{ $setting['url'] }}">
                                                    <i class="bi bi-{{ $setting['icon'] }} me-1"></i>
                                                    {{ $setting['title'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="/settings">
                                                <i class="bi bi-gear me-1"></i> Settings
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div class="w-auto">
                            <button x-on:click="open = !open" class="btn btn-success btn-sm">
                                <i class="bi bi-person"></i>
                                <span class="text-capitalize">{{ strtolower(Auth::user()->name) }}</span>
                                <i x-show="!open" class="bi bi-caret-right-fill"></i>
                                <i x-show="open" class="bi bi-caret-down-fill"></i>
                            </button>
                        </div>
                    </section>
                </div>
                <div class="w-100 bg-white" x-show="open" x-collapse.duration.500ms>
                    <section class="container text-end py-2">
                        <a href="/account" class="btn btn-link text-decoration-none">
                            <i class="bi bi-person-fill me-1"></i> My Account
                        </a>
                        <a href="/account/edit" class="text-decoration-none link-secondary me-3">
                            <i class="bi bi-person-fill-gear me-1"></i> Edit profile
                        </a>
                        <a href="/account/change_password" class="text-decoration-none link-secondary me-3">
                            <i class="bi bi-key-fill me-1"></i> Change pass
                        </a>
                        <a href="/account/change_pin" class="text-decoration-none link-secondary me-3">
                            <i class="bi bi-unlock-fill me-1"></i> Change PIN
                        </a>
                        <form action="/logout" id="logout-form" class="d-inline" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="text-decoration-none p-0 link-secondary me-3 btn btn-link">
                                <i class="bi bi-box-arrow-right me-1"></i> Logout
                            </button>
                        </form>
                    </section>
                </div>
            </section>
        @endauth
        @guest
            <section class="bg-light w-100 border-light-subtle border-bottom" x-data="{ open: false }">
                <div class="w-100">
                    <section class="container d-flex align-items-center justify-content-end py-2">
                        <button x-on:click="open = !open" class="btn btn-success btn-sm">
                            <i class="bi bi-person"></i>
                            My Account
                            <i x-show="!open" class="bi bi-caret-right-fill"></i>
                            <i x-show="open" class="bi bi-caret-down-fill"></i>
                        </button>
                    </section>
                </div>
                <div class="w-100 bg-white" x-show="open" x-collapse.duration.500ms>
                    <section class="container text-end py-2">
                        <a href="/login" class="fw-semibold text-decoration-none me-2">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Login
                        </a>
                        <a href="/register" class="fw-semibold text-decoration-none">
                            <i class="bi bi-person-plus me-2"></i>Signup
                        </a>
                    </section>
                </div>
            </section>
        @endguest
    </section>
</header>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('notification', () => ({
            async init() {
                let response = await fetch('/notifications/library_services');
                let { status, request_count, loan_count } = await response.json();

                console.log({
                    status,
                    request_count,
                    loan_count,
                });
                this.request_count = request_count;
                this.loan_count = loan_count;
                this.count = request_count + loan_count;
            },
            request_count: 0,
            loan_count: 0,
            count: 0,
        }))
    });
</script>
