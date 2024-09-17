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
                <img src="{{ asset('images/signup-cartoon.png') }}" class="w-75 h-75" />
            </section>
            <section class="d-flex flex-column w-100 h-100 align-items-center justify-content-center">
                <div style="width: 470px;" class="card mx-auto p-3">
                    <div class="card-body">
                        <form action="/register" method="POST">
                            @csrf
                            @method('POST')

                            <h3 class="text-body-secondary">Create Patron Account</h3>
                            <br>
                            <div class="mb-3 d-flex column-gap-3">
                                <section>
                                    <label for="first_name" class="form-label">First name</label>
                                    <input type="text" class="form-control" name="first_name" id="first_name">
                                    @error('first_name')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </section>
                                <section>
                                    <label for="last_name" class="form-label">Last name</label>
                                    <input type="text" class="form-control" name="last_name" id="last_name">
                                    @error('last_name')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </section>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" class="form-control" name="email" id="email">
                                @error('email')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" id="password">
                                @error('password')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                                @error('password_confirmation')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-flex">
                                <button type="submit" class="w-100 btn btn-primary px-3">Create patron account</button>
                            </div>
                            <p class="text-center mt-4">Already have an account? <a href="/login">Sign in</a>.</p>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <x-footer />
</x-layout>
