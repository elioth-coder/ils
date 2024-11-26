<x-layout>
    <x-header />
    <main class="d-flex flex-column align-items-center justify-content-center w-100 bg-body-secondary">
        <section class="container d-flex py-3 align-items-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 border py-2 px-3 bg-white rounded">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item"><a href="/account">Account</a></li>
                    <li class="breadcrumb-item active" aria-current="page">PIN</li>
                </ol>
            </nav>
        </section>

        <div class="container d-flex flex-column py-1">
            <h2 class="mb-4">Change PIN</h2>

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
                <form action="/account/update_pin" method="POST">
                    @csrf
                    @method('POST')
                    <div class="mb-2">
                        <label for="current_pin" class="form-label">Current PIN</label>
                        <input type="password" class="form-control form-control-sm" placeholder="--" name="current_pin" id="current_pin" value="{{ old('current_pin') ?? '' }}">
                        @error('current_pin')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="pin" class="form-label">New PIN</label>
                        <input type="password" class="form-control form-control-sm" placeholder="--" name="pin" id="pin" value="{{ old('pin') ?? '' }}">
                        @error('pin')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="pin_confirmation" class="form-label">Confirm new PIN</label>
                        <input type="password" class="form-control form-control-sm" placeholder="--" name="pin_confirmation" id="pin_confirmation" value="{{ old('pin_confirmation') ?? '' }}">
                        @error('pin_confirmation')
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
    </x-slot>
</x-layout>
