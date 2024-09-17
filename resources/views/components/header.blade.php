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
                        Patrons
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="/patrons/teachers">
                                <i class="bi bi-people me-1"></i> Teachers
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/patrons/students">
                                <i class="bi bi-people me-1"></i> Students
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="/patrons">
                                <i class="bi bi-people me-1"></i> Patrons
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
                        <li>
                            <a class="dropdown-item" href="/collections/books">
                                <i class="bi bi-book me-1"></i> Books
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/collections/researh_papers">
                                <i class="bi bi-file-earmark-text me-1"></i> Research Papers
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/collections/print_periodicals">
                                <i class="bi bi-file-earmark-richtext me-1"></i> Print Periodicals
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/collections/cd_dvds">
                                <i class="bi bi-disc me-1"></i> CD/DVDs
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/collections/pdfs">
                                <i class="bi bi-file-earmark-pdf me-1"></i> PDFs
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="/collections">
                                <i class="bi bi-layers me-1"></i> Collections
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
                        <li>
                            <a class="dropdown-item" href="/settings/libraries">
                                <i class="bi bi-stack-overflow me-1"></i> Libraries
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/settings/campuses">
                                <i class="bi bi-bank me-1"></i> Campuses
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/settings/colleges">
                                <i class="bi bi-buildings me-1"></i> Colleges
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/settings/programs">
                                <i class="bi bi-building me-1"></i> Programs
                            </a>
                        </li>
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
