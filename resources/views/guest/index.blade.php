<x-layout>
    <x-header-guest />
    <main class="d-flex flex-column min-vh-100 min-vw-100 bg-primary-subtle">
        <section class="d-flex bg-info-subtle w-100 position-relative">
            <img src="{{ asset('images/landscape-cover.png') }}" style="height: 420px;" class="bg-info w-100 d-block" />
            <div style="background-color: rgba(0,0,0,0.15)" class="d-flex flex-column row-gap-4 align-items-center justify-content-center position-absolute top-0 start-0 bottom-0 end-0 w-100 h-100">
                <section class="font-bolder" style="text-shadow: 2px 2px 2px rgba(0,0,0,0.5)">
                    <h1 class="text-center text-white mb-3">Get into your library</h1>
                    <h3 class="text-center text-white">A wealth of knowledge just a click away</h3>
                </section>
                <form action="/search" class="mb-4" style="width: 700px;">
                    <div class="input-group input-group-lg bg-white rounded-3 shadow">
                        <input type="text" name="q" class="form-control" placeholder="What are you looking for?">
                        <button class="btn btn-light border" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </section>
        <section class="d-flex bg-white w-100">
            <div class="container d-flex flex-column py-5 column-gap-5">
                <section class="w-100 column-gap-4 d-flex mb-2">
                    <div class="w-100">
                        <h4>NEUST ILI Catalogue</h4>
                        <p>You can discover, search and request documents. The global catalogue contains the collections of the NEUST ILI Libraries.
                    </div>
                    <div class="w-100">
                        <h4>Useful Links</h4>
                        <ul>
                            <li>
                                <a href="/services/attendance">
                                    Library Attendance
                                </a>
                            </li>
                            <li><a href="/register">Library Registration</a></li>
                        </ul>
                    </div>
                    <div class="w-100">
                        <h4>Get in Touch</h4>
                        <ul>
                            <li><a href="/">support@neust.ils.gov.ph</a></li>
                            <li><a href="/">(+63)919 885 2357</a></li>
                        </ul>
                    </div>
                </section>
                <section class="w-100 column-gap-4 d-flex">
                    <div class="w-100">
                        <h4>About NEUST ILI</h4>
                        <p>NEUST ILI is a competence and service centre for NEUST libraries. It is a thesis project of one of its graduate student.</p>
                    </div>
                    <div class="w-100">
                        <h4>NEUST ILI Libraries</h4>
                        <ul>
                            <li>
                                <span>General Tinio (Papaya) Off-Campus Library</span><br>
                            </li>
                            <li>
                                <span>Peñaranda Off-Campus Library</span><br>
                            </li>
                        </ul>
                    </div>
                    <div class="w-100">
                        <a href="/services/attendance" class="btn btn-lg btn-success">
                            <i class="bi bi-card-checklist"></i>
                            Library Attendance
                        </a>
                    </div>
                </section>
            </div>
        </section>
    </main>
    <x-footer />
</x-layout>
