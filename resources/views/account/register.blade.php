    <x-layout>
        <x-header-guest />
        <main class="d-flex align-items-center justify-content-center w-100 bg-success-subtle">
            <div class="container py-5 d-flex">
                <section class="d-flex w-100 h-100 align-items-center justify-content-center">
                    <img src="{{ asset('images/signup-cartoon.png') }}" class="w-75 h-75" />
                </section>
                <section class="d-flex flex-column w-100 h-100 align-items-center justify-content-center">
                    <div style="width: 470px;" class="p-3 mx-auto card">
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
                            <form autocomplete="off" action="/account" method="POST">
                                @csrf
                                @method('POST')

                                <h3 class="text-body-secondary">Create Patron Account</h3>
                                <br>
                                <div class="mb-3 d-flex column-gap-3">
                                    <section>
                                        <label for="first_name" class="form-label">First name</label>
                                        <input type="text" class="form-control" name="first_name" id="first_name"
                                            value="{{ old('first_name') ?? '' }}">
                                        @error('first_name')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </section>
                                    <section>
                                        <label for="last_name" class="form-label">Last name</label>
                                        <input type="text" class="form-control" name="last_name" id="last_name"
                                            value="{{ old('last_name') ?? '' }}">
                                        @error('last_name')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </section>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input autocomplete="off" name="email" class="form-control" name="email"
                                        id="email" value="{{ old('email') ?? '' }}">

                                    @error('email')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input autocomplete="off" type="password" class="form-control" name="password"
                                        id="password" value="{{ old('password') ?? '' }}">
                                    @error('password')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                    <div id="strengthMessage" class="strength form-text"></div>
                                    <div id="passwordRequirements" class="form-text">
                                        <ul id="passwordErrors" class="list-unstyled">
                                            <li id="lengthRequirement" class="text-secondary"><small>*Password must be
                                                    at least 8 characters long</small></li>
                                            <li id="numberRequirement" class="text-secondary"><small>*Password must
                                                    include at least one number (0-9)</small></li>
                                            <li id="specialCharRequirement" class="text-secondary"><small>*Password must
                                                    include at least one special symbol (e.g., @, #, $, !)</small></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" name="password_confirmation"
                                        id="password_confirmation" value="{{ old('password_confirmation') ?? '' }}">
                                    @error('password_confirmation')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="d-flex">
                                    <button type="submit" class="px-3 w-100 btn btn-primary">Create patron
                                        account</button>
                                </div>
                                <p class="mt-4 text-center">Already have an account? <a href="/login">Sign in</a>.</p>
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
                            errorMessage.textContent =
                                "Password must be at least Medium or Strong to submit the form.";
                            passwordInput.focus();
                        } else {
                            errorMessage.textContent = "";
                        }
                    });
                });
            </script>
        </x-slot>
    </x-layout>
