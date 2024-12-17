<x-layout>
    <x-slot:head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </x-slot:head>
    <x-header-guest />
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
                        <form id="login-form" action="/login" method="POST" autocomplete="off">
                            @csrf
                            @method('POST')

                            <h3 class="text-body-secondary">Sign in to our platform</h3>
                            <br>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email" required
                                    value="{{ old('email') ?? '' }}">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="mb-3 input-group" x-data="{ show: false }">
                                    <input x-bind:type="(show) ? 'text' : 'password'" name="password" id="password" required
                                        class="form-control">
                                    <button x-on:click="show = !show" class="btn btn-outline-secondary" type="button">
                                        <i class="bi"
                                            x-bind:class="(show) ? 'bi-eye-fill' : 'bi-eye-slash-fill'"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">Keep me signed in</label>
                            </div>
                            <div class="d-flex">
                                <button type="submit" class="px-3 w-100 btn btn-primary">Sign in</button>
                            </div>

                            <p class="mt-4 text-center "><a href="/forgot-password">Forgot password?</a></p>

                            <p class="mt-4 text-center">Do not have an account? Sign up <a href="/register">here</a>.
                            </p>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <x-footer />
    <x-slot:script>
        <script>
            window.onload = function() {
                document.getElementById('login-form').addEventListener('submit', async function(event) {
                    event.preventDefault();

                    let formData = new FormData(event.target);

                    Swal.fire({
                        title: "Logging in...",
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        timer: 2000,
                    });

                    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    let response = await fetch('/login', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                    });
                    let {
                        status, message
                    } = await response.json();

                    if (status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            timer: 1000,
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: message,
                            icon: 'error',
                            showConfirmButton: false,
                            timer: 2000,
                        });
                    }
                });
            }
        </script>
    </x-slot:script>
</x-layout>
