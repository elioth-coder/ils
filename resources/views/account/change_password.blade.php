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
                <form action="/account/update_password" method="POST">
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
                const passwordInput = document.getElementById("password");
                const strengthMessage = document.getElementById("strengthMessage");
                const passwordErrors = document.getElementById("passwordErrors");

                const lengthRequirement = document.getElementById("lengthRequirement");
                const numberRequirement = document.getElementById("numberRequirement");
                const specialCharRequirement = document.getElementById("specialCharRequirement");

                passwordInput.addEventListener("input", () => {
                    const password = passwordInput.value;
                    const strength = checkPasswordStrength(password);
                    const errors = validatePassword(password);
                    console.log("-------------");
                    

                    // Update message and style based on strength
                    if (strength === "Weak") {
                        strengthMessage.textContent = "Weak Password";
                        strengthMessage.className = "strength weak";
                    } else if (strength === "Medium") {
                        strengthMessage.textContent = "Medium Strength Password";
                        strengthMessage.className = "strength medium";
                    } else if (strength === "Strong") {
                        strengthMessage.textContent = "Strong Password";
                        strengthMessage.className = "strength strong";
                    } else {
                        strengthMessage.textContent = "";
                        strengthMessage.className = "strength";
                    }
                    validatePassword(password);
                });

                function checkPasswordStrength(password) {
                    if (password.length === 0) return "";

                    let strengthScore = 0;

                    // Check password length
                    if (password.length >= 8) strengthScore++;

                    // Check for lowercase letters
                    if (/[a-z]/.test(password)) strengthScore++;

                    // Check for uppercase letters
                    if (/[A-Z]/.test(password)) strengthScore++;

                    // Check for numbers
                    if (/\d/.test(password)) strengthScore++;

                    // Check for special characters
                    if (/[\W_]/.test(password)) strengthScore++;

                    // Determine strength
                    if (strengthScore <= 2) return "Weak";
                    if (strengthScore === 3) return "Medium";
                    return "Strong";
                }
                function validatePassword(password) {
                    // Check length requirement
                    if (password.length >= 8) {
                        lengthRequirement.classList.remove("text-secondary");
                        lengthRequirement.classList.add("text-success");
                    } else {
                        lengthRequirement.classList.remove("text-success");
                        lengthRequirement.classList.add("text-secondary");
                    }

                    // Check number requirement
                    if (/\d/.test(password)) {
                        numberRequirement.classList.remove("text-secondary");
                        numberRequirement.classList.add("text-success");
                    } else {
                        numberRequirement.classList.remove("text-success");
                        numberRequirement.classList.add("text-secondary");
                    }

                    // Check special character requirement
                    if (/[\W_]/.test(password)) {
                        specialCharRequirement.classList.remove("text-secondary");
                        specialCharRequirement.classList.add("text-success");
                    } else {
                        specialCharRequirement.classList.remove("text-success");
                        specialCharRequirement.classList.add("text-secondary");
                    }
                }
                });
            </script>
    </x-slot:script>
</x-layout>
