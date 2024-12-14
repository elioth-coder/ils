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
                        <style>
                            .strength {
                                font-size: 1rem;
                                font-weight: bold;
                                margin-top: 10px;
                            }
                            .error {
                                    font-size: .8rem;
                                    margin-top: 10px;
                                    color: red;
                                }

                            .weak {
                                color: red;
                            }

                            .medium {
                                color: orange;
                            }

                            .strong {
                                color: green;
                            }
                        </style>
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
                                    @error('password')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                                <div id="strengthMessage" class="strength form-text"></div>
                                <div id="passwordRequirements" class="form-text">
                                    <ul id="passwordErrors" class="list-unstyled">
                                        <li id="lengthRequirement" class="text-secondary"><small>*Password must be at least 8 characters long</small></li>
                                        <li id="numberRequirement" class="text-secondary"><small>*Password must include at least one number (0-9)</small></li>
                                        <li id="specialCharRequirement" class="text-secondary"><small>*Password must include at least one special symbol (e.g., @, #, $, !)</small></li>
                                    </ul>
                                </div>
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
                            <div id="errorMessage" class="error form-text"></div>
                            

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
    <x-slot:script>
        <script>
             document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById("form");
                const passwordInput = document.getElementById("password");
                const strengthMessage = document.getElementById("strengthMessage");
                const errorMessage = document.getElementById("errorMessage");

                const lengthRequirement = document.getElementById("lengthRequirement");
                const numberRequirement = document.getElementById("numberRequirement");
                const specialCharRequirement = document.getElementById("specialCharRequirement");

                let currentStrength = "";

                passwordInput.addEventListener("input", () => {
                    const password = passwordInput.value;
                    currentStrength = checkPasswordStrength(password);
                    validatePassword(password);

                    if (currentStrength === "Weak") {
                        strengthMessage.textContent = "Weak Password";
                        strengthMessage.className = "strength weak";
                    } else if (currentStrength === "Medium") {
                        strengthMessage.textContent = "Medium Strength Password";
                        strengthMessage.className = "strength medium";
                    } else if (currentStrength === "Strong") {
                        strengthMessage.textContent = "Strong Password";
                        strengthMessage.className = "strength strong";
                    } else {
                        strengthMessage.textContent = "";
                        strengthMessage.className = "strength";
                    }
                });

                function checkPasswordStrength(password) {
                    if (password.length === 0) return "";

                    let strengthScore = 0;

                    if (password.length >= 8) strengthScore++;
                    if (/[a-z]/.test(password)) strengthScore++;
                    if (/[A-Z]/.test(password)) strengthScore++;
                    if (/\d/.test(password)) strengthScore++;
                    if (/[\W_]/.test(password)) strengthScore++;

                    if (strengthScore <= 2) return "Weak";
                    if (strengthScore === 3) return "Medium";
                    return "Strong";
                }

                function validatePassword(password) {
                    lengthRequirement.classList.toggle("text-success", password.length >= 8);
                    lengthRequirement.classList.toggle("text-secondary", password.length < 8);

                    numberRequirement.classList.toggle("text-success", /\d/.test(password));
                    numberRequirement.classList.toggle("text-secondary", !/\d/.test(password));

                    specialCharRequirement.classList.toggle("text-success", /[\W_]/.test(password));
                    specialCharRequirement.classList.toggle("text-secondary", !/[\W_]/.test(password));
                }

                form.addEventListener("submit", (e) => {
                    if (currentStrength === "Weak" || currentStrength === "") {
                        e.preventDefault();
                        errorMessage.textContent = "Password must be at least Medium or Strong to submit the form.";
                        passwordInput.focus();
                    } else {
                        errorMessage.textContent = "";
                    }
                });
            });
        </script>
    </x-slot:script>
</x-layout>
