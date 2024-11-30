<header>
    <nav class="navbar bg-primary">
        <div class="container">
            <x-navbar-brand />
        </div>
    </nav>
    <section class="bg-light w-100 border-light-subtle border-bottom" x-data="{ open: false }">
        <div class="w-100">
            <section class="container d-flex align-items-center justify-content-end py-2">
                <div class="d-flex flex-grow-1">
                    <a href="/" class="btn {{ request()->path() == "/" ? 'btn-warning' : '' }} text-decoration-none">
                        <i class="bi bi-house me-1"></i>
                        Home
                    </a>
                    <a href="/about" class="btn {{ str_starts_with(request()->path(), 'about') ? 'btn-warning' : '' }} text-decoration-none">
                        <i class="bi bi-info-square me-1"></i>
                        About NEUST ILI
                    </a>
                    <a href="/rules" class="btn {{ str_starts_with(request()->path(), 'rules') ? 'btn-warning' : '' }} text-decoration-none">
                        <i class="bi bi-list-ul me-1"></i>
                        Rules &amp; Regulations
                    </a>
                    <a href="/resources" class="btn {{ str_starts_with(request()->path(), 'resources') ? 'btn-warning' : '' }} text-decoration-none">
                        <i class="bi bi-gear-wide-connected me-1"></i>
                        E-Resources
                    </a>
                </div>

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
                <a href="/login" class="fw-semibold text-decoration-none text-black-50 me-2">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Login
                </a>
                <a href="/register" class="fw-semibold text-decoration-none text-black-50">
                    <i class="bi bi-person-plus me-2"></i>Signup
                </a>
            </section>
        </div>
    </section>
</header>
