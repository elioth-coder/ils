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
                            <a href="/dashboard" class="btn {{ request()->path() == "dashboard" ? 'btn-warning' : '' }} text-decoration-none">
                                <i class="bi bi-house me-1"></i>
                                Dashboard
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
                            <a title="Frequently Asked Questions" href="/faq" class="btn {{ str_starts_with(request()->path(), 'faq') ? 'btn-warning' : '' }} text-decoration-none">
                                <i class="bi bi-question-circle me-1"></i>
                                FAQs
                            </a>
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
                        <button onclick="confirmLogout()"
                            class="text-decoration-none p-0 link-secondary me-3 btn btn-link">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </button>
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
                let {
                    status,
                    request_count,
                    loan_count
                } = await response.json();

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
