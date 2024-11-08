<x-layout>
    <x-header />
    <main class="d-flex flex-column align-items-center justify-content-center w-100 bg-body-secondary">
        <section class="container d-flex py-3 align-items-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 border py-2 px-3 bg-white rounded">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item"><a href="/account">Account</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Password</li>
                </ol>
            </nav>
        </section>

        <div class="container d-flex flex-column py-1">
            <h2 class="mb-4">Change password</h2>

            <div class="card p-4 w-50 mb-4">
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
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm new password</label>
                        <input type="password" class="form-control form-control-sm" placeholder="--" name="password_confirmation" id="password_confirmation" value="{{ old('password_confirmation') ?? '' }}">
                        @error('password_confirmation')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex gap-2 flex-row-reverse mb-2">
                        <a href="/dashboard" class="w-25 btn btn-outline-dark px-3">Cancel</a>
                        <button type="submit" class="w-25 btn btn-primary px-3">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <x-footer />

    <x-slot:script>
        @if (session('message'))
        @php $message = session('message'); @endphp
        @if($message['type']=='success')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    setTimeout(() => {
                        let $logoutForm = document.getElementById('logout-form');
                        $logoutForm.submit();
                    }, 2000);
                });
            </script>
        @endif
    @endif
    </x-slot>
</x-layout>
