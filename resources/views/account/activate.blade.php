<x-layout>
    <header>
        <nav class="navbar bg-primary">
            <div class="container">
                <x-navbar-brand />
            </div>
        </nav>
        <section class="bg-light w-100">
            <div class="w-100 border-light-subtle border-bottom">
                <section class="container d-flex align-items-center justify-content-end py-2">
                    <a href="/" class="btn btn-success btn-sm">
                        <i class="bi bi-arrow-left"></i>
                        Go Back
                        <i class="bi bi-house"></i>
                    </a>
                </section>
            </div>
        </section>
    </header>
    <main class="d-flex align-items-center justify-content-center w-100 bg-success-subtle">
        <div class="container d-flex py-5">
            <section class="d-flex w-100 h-100 align-items-center justify-content-center">
                @if(!empty($error))
                    <img src="{{ asset('images/no-data-cartoon.png') }}" class="w-75" />
                @else
                    <img src="{{ asset('images/ok-cartoon.png') }}" class="w-75" />
                @endif
            </section>
            <section class="d-flex flex-column w-100 h-100 align-items-center justify-content-center">
                <div style="width: 470px;" class="card mx-auto p-3">
                    @if(!empty($error))
                        <div class="card-body text-center">
                            <img src="{{ asset('images/warning-cartoon.png') }}" class="w-50" />
                            <h2 class="text-danger">Activation failed!</h2>
                            <br>
                            <p>
                                {{ $error }}<br>
                            </p>
                        </div>
                    @else
                        <div class="card-body text-center">
                            <img src="{{ asset('images/green-pencil-cartoon.png') }}" class="w-50" />
                            <h2 class="text-success">Account activated successfully!</h2>
                            <br>
                            <p>
                                You can now login to your account<br>
                                Click this <a href="/login">link</a> to login<br>
                            </p>
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </main>
    <x-footer />
</x-layout>
