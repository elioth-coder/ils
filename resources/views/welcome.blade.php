<x-layout>
    <x-slot:head>
        <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </x-slot:head>
    <header>
        <nav class="navbar bg-primary">
            <div class="container">
                <x-navbar-brand />
            </div>
        </nav>
        <section class="bg-light w-100" x-data="{ open: false }">
            <div class="w-100 border-light-subtle border-bottom">
                <section class="container d-flex align-items-center justify-content-end py-2">
                    <button @click="open = !open" class="btn btn-success btn-sm">
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
                        <i class="bi bi-box-arrow-in-right me-1"></i>Sign In
                    </a>
                    <a href="/register" class="fw-semibold text-decoration-none text-black-50">
                        <i class="bi bi-person-plus me-1"></i>Sign Up
                    </a>
                </section>
            </div>
        </section>
    </header>
    <main class="d-flex flex-column min-vh-100 min-vw-100 bg-primary-subtle">
        <section class="d-flex bg-info-subtle w-100 position-relative">
            <img src="{{ asset('images/landscape-cover.png') }}" class="w-100 d-block" />
            <div style="background-color: rgba(0,0,0,0.15)" class="d-flex flex-column row-gap-4 align-items-center justify-content-center position-absolute top-0 start-0 bottom-0 end-0 w-100 h-100">
                <section class="font-bolder" style="text-shadow: 2px 2px 2px rgba(0,0,0,0.5)">
                    <h1 class="text-center text-white mb-1">Get into your library</h1>
                    <h2 class="text-center text-white">A wealth of knowledge just a click away</h2>
                </section>
                <form action="/search" style="width: 700px;">
                    <div class="input-group input-group-lg bg-white rounded-3 shadow">
                        <input type="text" class="form-control" placeholder="What are you looking for?" aria-label="Recipient's username" aria-describedby="button-addon2">
                        <button class="btn btn-light" type="button" id="button-addon2">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </section>
        <section class="d-flex bg-white w-100">
            <div class="container d-flex py-5 column-gap-5">
                <section class="w-100 row-gap-4 d-flex flex-column">
                    <div>
                        <h4>NEUST ILS Catalogue</h4>
                        <p>You can discover, search and request documents. The global catalogue contains the collections of the NEUST ILS Libraries.
                    </div>
                    <div>
                        <h4>About NEUST ILS</h4>
                        <p>NEUST ILS is a competence and service centre for NEUST libraries. It is a thesis project of one of its graduate student.</p>
                    </div>
                </section>
                <section class="w-100 row-gap-4 d-flex flex-column">
                    <div>
                        <h4>Useful Links</h4>
                        <a href="/login">Library Loan Request</a><br>
                        <a href="/how_to#register">How to Register</a>
                    </div>
                    <div>
                        <h4>NEUST ILS Libraries</h4>
                        <a href="/login">San Isidro Campus Library</a><br>
                        <a href="/login">General Tinio (Papaya) Off-Campus Library</a><br>
                        <a href="/login">Peñaranda Off-Campus Library</a><br>
                    </div>
                </section>
                <section class="w-100 row-gap-4 d-flex flex-column">
                    <div>
                        <h4>Get in Touch</h4>
                        <a href="/">support@neust.ils.gov.ph</a><br>
                        <a href="/">(+63)919 885 2357</a><br>
                    </div>
                </section>
            </div>
        </section>
    </main>
    <x-footer />
</x-layout>
