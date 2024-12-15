<x-layout>
    <x-header />
    <main class="d-flex flex-column align-items-center justify-content-center w-100 bg-body-secondary">
        <section class="container py-3 d-flex align-items-center">
            <nav aria-label="breadcrumb">
                <ol class="px-3 py-2 mb-0 bg-white border rounded breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item"><a href="/account">Account</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Password</li>
                </ol>
            </nav>
        </section>

        <div class="container py-1 d-flex flex-column">
            <h2 class="mb-4">Change password</h2>

            <div class="p-4 mb-4 card w-50">
                @if (session('message'))
                    @php $message = session('message'); @endphp
                    <div class="alert alert-{{ $message['type'] }} alert-dismissible fade show" role="alert">
                        <section class="d-flex align-items-center">
                            <i class="bi bi-{{ ($message['type']=='success') ? 'check' : 'x' }}-circle-fill fs-4 me-2"></i>
                            {{ $message['content'] }}
                        </section>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
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
                <form id="form" action="/account/update_password" method="POST">
                    @csrf
                    @method('POST')
                    <div class="mb-2">
                        <label for="current_password" class="form-label">Current password</label>
                        <input type="password" class="form-control form-control-sm" placeholder="--" name="current_password" id="current_password" value="{{ old('current_password') ?? '' }}">
                        @error('current_password')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="password" class="form-label">New password</label>
                        <input type="password" class="form-control form-control-sm" placeholder="--" name="password" id="password" value="{{ old('password') ?? '' }}">
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
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm new password</label>
                        <input type="password" class="form-control form-control-sm" placeholder="--" name="password_confirmation" id="password_confirmation" value="{{ old('password_confirmation') ?? '' }}">
                        @error('password_confirmation')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div id="errorMessage" class="error form-text"></div>

                    <div class="flex-row-reverse gap-2 mb-2 d-flex">
                        <a href="/dashboard" class="px-3 w-25 btn btn-outline-dark">Cancel</a>
                        <button type="submit" class="px-3 w-25 btn btn-primary">Update</button>
                    </div>
                            
                </form>
            </div>
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
