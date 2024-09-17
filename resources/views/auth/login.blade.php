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
                <img src="{{ asset('images/login-cartoon.png') }}" class="w-75 h-75" />
            </section>
            <section class="d-flex flex-column w-100 h-100 align-items-center justify-content-center">
                @error('credential')
                    <div style="width: 400px;" class="mx-auto alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        Incorrect username or password provided
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @enderror
                <div style="width: 400px;" class="card mx-auto p-3">
                    <div class="card-body">
                        <form action="/login" method="POST">
                            @csrf
                            @method('POST')

                            <h3 class="text-body-secondary">Sign in to our platform</h3>
                            <br>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" id="password">
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">Keep me signed in</label>
                            </div>
                            <div class="d-flex">
                                <button type="submit" class="w-100 btn btn-primary px-3">Sign in</button>
                            </div>
                            <p class="text-center mt-4">Do not have an account? Sign up <a href="/register">here</a>.</p>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <x-footer />
</x-layout>
