@php
    $users = [
        [
            'icon'  => 'people',
            'url'   => '/users/teachers',
            'title' => 'Teachers',
        ],
        [
            'icon'  => 'people',
            'url'   => '/users/students',
            'title' => 'Students',
        ],
        [
            'icon'  => 'people',
            'url'   => '/users/staffs',
            'title' => 'Library Staffs',
        ],
    ];
    $collections = [
        [
            'icon'  => 'book',
            'url'   => '/collections/books',
            'title' => 'Books',
        ],
        [
            'icon'  => 'file-earmark-text',
            'url'   => '/collections/research_papers',
            'title' => 'Research Papers',
        ],
        [
            'icon'  => 'file-earmark-richtext',
            'url'   => '/collections/print_periodicals',
            'title' => 'Print Periodicals',
        ],
        [
            'icon'  => 'disc',
            'url'   => '/collections/cd_dvds',
            'title' => 'CD/DVDs',
        ],
    ];

    $settings = [
        [
            'icon'  => 'stack-overflow',
            'url'   => '/settings/libraries',
            'title' => 'Libraries',
        ],
        [
            'icon'  => 'bank',
            'url'   => '/settings/campuses',
            'title' => 'Campuses',
        ],
        [
            'icon'  => 'buildings',
            'url'   => '/settings/colleges',
            'title' => 'Colleges',
        ],
        [
            'icon'  => 'building',
            'url'   => '/settings/programs',
            'title' => 'Programs',
        ],
    ];
@endphp

<header>
    <nav class="navbar bg-primary">
        <div class="container d-flex column-gap-5">
            <x-navbar-brand />
            <form action="/search" class="flex-grow-1">
                <div class="input-group bg-white rounded-3">
                    <input type="text" class="form-control" placeholder="Search">
                    <button class="btn btn-light" type="button">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </nav>
    <section class="bg-light w-100">
        <div class="w-100 border-light-subtle border-bottom">
            <section class="container d-flex align-items-center justify-content-end py-2">
                <div class="dropdown">
                    <button class="btn btn-link dropdown-toggle text-decoration-none text-black-50" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-people-fill me-1"></i>
                        Users
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
                                <i class="bi bi-people me-1"></i> All Users
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
                                <i class="bi bi-layers me-1"></i> All Collections
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
                                <i class="bi bi-gear me-1"></i> All Settings
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="dropdown">
                    <button class="btn btn-link dropdown-toggle text-decoration-none text-black-50" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-fill me-1"></i>
                        {{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">
                                <i class="bi bi-bag me-1"></i> Loan Requests
                            </a>
                        </li>
                        <li><a class="dropdown-item" href="#">
                                <i class="bi bi-person-gear me-1"></i> Edit my profile
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="/logout">
                                @csrf
                                @method('DELETE')
                                <button class="dropdown-item">
                                    <i class="bi bi-box-arrow-right me-1"></i> Log Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </section>
        </div>
    </section>
</header>
