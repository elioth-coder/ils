@component('libraries.layout', [
    'libraries' => $libraries,
])
    @slot('breadcrumb')
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 border py-2 px-3 bg-white rounded">
                <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                <li class="breadcrumb-item"><a href="/settings">Settings</a></li>
                <li class="breadcrumb-item active" aria-current="page">Libraries</li>
            </ol>
        </nav>
    @endslot
    @slot('form')
        <form action="/settings/libraries" method="POST">
            @csrf
            @method('POST')

            <h4 class="text-body-secondary">Create new library</h4>
            <hr class="">
            <div class="mb-2">
                <label for="code" class="form-label">Code</label>
                <input type="text" class="form-control form-control-sm" placeholder="--" name="code" id="code" value="{{ old('code') ?? '' }}">
                @error('code')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-2">
                <label for="name" class="form-label">Name of Library</label>
                <input type="text" class="form-control form-control-sm" placeholder="--" name="name" id="name" value="{{ old('name') ?? '' }}">
                @error('name')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-2">
                <label for="host" class="form-label">Host or Domain</label>
                <input type="text" class="form-control form-control-sm" placeholder="--" name="host" id="host" value="{{ old('host') ?? '' }}">
                @error('host')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-2">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control form-control-sm" placeholder="--" name="address" id="address" rows="4">{{ old('address') ?? '' }}</textarea>
                @error('address')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-2">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control form-control-sm" placeholder="--" name="description" id="description" rows="4">{{ old('description') ?? '' }}</textarea>
                @error('description')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <br>
            <div class="d-flex flex-row-reverse">
                <button type="submit" class="w-50 btn btn-primary px-3">Submit</button>
            </div>
        </form>
    @endslot
@endcomponent
