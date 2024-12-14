<x-layout>
    <header>
        <nav class="navbar bg-primary">
            <div class="container">
                <x-navbar-brand />
            </div>
        </nav>
        <section class="bg-light w-100">
            <div class="w-100 border-light-subtle border-bottom">
                <section class="container py-2 d-flex align-items-center justify-content-end">
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
        <div class="container py-5 d-flex">
            <section class="d-flex w-100 h-100 align-items-center justify-content-center">
                <img src="{{ asset('images/login-cartoon.png') }}" class="w-75 h-75" />
            </section>
            <section class="d-flex flex-column w-100 h-100 align-items-center justify-content-center">
                @error('credential')
                    <div style="width: 400px;" class="mx-auto alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @enderror
                <div style="width: 400px;" class="p-3 mx-auto card">
                    <div class="card-body">
                        <form action="{{ route('password.update') }}" method="POST" autocomplete="off">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="token" value="{{ $token }}">
                            <input type="hidden" name="email" value="{{ request('email') }}">
                            <h3 class="text-body-secondary">Reset Password</h3>
                            <br>
                        
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="mb-3 input-group" x-data="{ show: false }">
                                    <input x-bind:type="(show) ? 'text' : 'password'" name="password" id="password" class="form-control">
                                    <button x-on:click="show = !show" class="btn btn-outline-secondary" type="button">
                                        <i class="bi" x-bind:class="(show) ? 'bi-eye-fill' : 'bi-eye-slash-fill'"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <div class="mb-3 input-group" x-data="{ show: false }">
                                    <input x-bind:type="(show) ? 'text' : 'password'" name="password_confirmation" id="password_confirmation" class="form-control">
                                    <button x-on:click="show = !show" class="btn btn-outline-secondary" type="button">
                                        <i class="bi" x-bind:class="(show) ? 'bi-eye-fill' : 'bi-eye-slash-fill'"></i>
                                    </button>
                                </div>
                            </div>
                            
                    
                            <div class="d-flex">
                                <button type="submit" class="px-3 w-100 btn btn-primary">OK</button>
                            </div>

                            @if (session('status'))
                                <div class="alert alert-success">{{ session('status') }}</div>
                            @endif
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <x-footer />
</x-layout>
