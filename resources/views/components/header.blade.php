@php
    $reports = [
        [
            'icon' => 'list-stars',
            'url' => '/reports/patron_list',
            'title' => 'List of Patron',
        ],
        [
            'icon' => 'list-stars',
            'url' => '/reports/item_list',
            'title' => 'List of Items',
        ],
        [
            'icon' => 'list-ol',
            'url' => '/reports/item_count',
            'title' => 'Count of Items',
        ],
    ];

    $services = [
        [
            'icon' => 'person-bounding-box',
            'url' => '/services/attendance',
            'title' => 'Attendance Checker',
        ],
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
            'title' => 'Current loans',
        ],
        [
            'icon' => 'people',
            'url' => '/services/patrons',
            'title' => 'Users/Patrons',
        ],
    ];

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
        <section class="bg-light w-100 border-light-subtle border-bottom" x-data="{ open: false }">
            <div class="w-100">
                <section class="container d-flex align-items-center py-2">
                    <div class="d-flex flex-grow-1">
                        <a href="/" class="btn btn-link text-decoration-none text-black-50">
                            <i class="bi bi-bell-fill me-1"></i>
                            Dashboard
                        </a>
                        @auth
                            @if (in_array(Auth::user()->role, ['admin', 'librarian', 'staff', 'clerk']))
                                <div class="dropdown">
                                    <button class="btn btn-link dropdown-toggle text-decoration-none text-black-50" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
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
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="/reports">
                                                <i class="bi bi-people me-1"></i> View Reports
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="dropdown">
                                    <button class="btn btn-link dropdown-toggle text-decoration-none text-black-50" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-grid-fill me-1"></i>
                                        Library Services
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        @foreach ($services as $service)
                                            <li>
                                                <a class="dropdown-item" href="{{ $service['url'] }}">
                                                    <i class="bi bi-{{ $service['icon'] }} me-1"></i> {{ $service['title'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="/services">
                                                <i class="bi bi-people me-1"></i> View Services
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="dropdown">
                                    <button class="btn btn-link dropdown-toggle text-decoration-none text-black-50" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-people-fill me-1"></i>
                                        Users / Patrons
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
                                            <a class="dropdown-item" href="/users">
                                                <i class="bi bi-people me-1"></i> View Users
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-link dropdown-toggle text-decoration-none text-black-50" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-layers-fill me-1"></i>
                                        Collections
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        @foreach ($collections as $collection)
                                            <li>
                                                <a class="dropdown-item" href="{{ $collection['url'] }}">
                                                    <i class="bi bi-{{ $collection['icon'] }} me-1"></i> {{ $collection['title'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="/collections">
                                                <i class="bi bi-layers me-1"></i> View Collections
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-link dropdown-toggle text-decoration-none text-black-50" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-gear-fill me-1"></i>
                                        Settings
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        @foreach ($settings as $setting)
                                            <li>
                                                <a class="dropdown-item" href="{{ $setting['url'] }}">
                                                    <i class="bi bi-{{ $setting['icon'] }} me-1"></i> {{ $setting['title'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="/settings">
                                                <i class="bi bi-gear me-1"></i> View Settings
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        @endauth
                    </div>
                    <div class="w-auto">
                        @auth
                            <button x-on:click="open = !open" class="btn btn-success btn-sm">
                                <i class="bi bi-person"></i>
                                <span class="text-capitalize">{{ strtolower(Auth::user()->name) }}</span>
                                <i x-show="!open" class="bi bi-caret-right-fill"></i>
                                <i x-show="open" class="bi bi-caret-down-fill"></i>
                            </button>
                        @endauth
                    </div>
                </section>
            </div>
            <div class="w-100 bg-white" x-show="open" x-collapse.duration.500ms>
                @auth
                    <section class="container text-end py-2">
                        <a href="/account" class="btn btn-link text-decoration-none text-black-50">
                            <i class="bi bi-person-fill me-1"></i> My Account
                        </a>
                        <a href="/account/edit" class="text-decoration-none link-secondary me-3">
                            <i class="bi bi-person-fill-gear me-1"></i> Edit profile
                        </a>
                        <a href="/account/change_password" class="text-decoration-none link-secondary me-3">
                            <i class="bi bi-key-fill me-1"></i> Change pass
                        </a>
                        <form action="/logout" id="logout-form" class="d-inline" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="text-decoration-none p-0 link-secondary me-3 btn btn-link">
                                <i class="bi bi-box-arrow-right me-1"></i> Logout
                            </button>
                        </form>
                    </section>
                @endauth
            </div>
        </section>
    </section>
</header>
