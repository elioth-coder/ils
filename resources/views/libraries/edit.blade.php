@component('libraries.layout', [
    'libraries' => $libraries,
    'selected'  => $selected,
])
    @slot('breadcrumb')
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 border py-2 px-3 bg-white rounded">
                <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                <li class="breadcrumb-item"><a href="/settings">Settings</a></li>
                <li class="breadcrumb-item"><a href="/settings/libraries">Libraries</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $selected->code }}</li>
            </ol>
        </nav>
    @endslot
    @slot('form')
        <form action="/settings/libraries/{{ $selected->id }}" method="POST">
            @csrf
            @method('PATCH')

            <h4 class="text-body-secondary">Edit this library</h4>
            <hr>
            <div class="mb-2">
                @php
                    if($errors->has('code')) {
                        $code = old('code');
                    } else {
                        $code = (old('code')) ? old('code') : $selected->code;
                    }
                @endphp
                <label for="code" class="form-label">Code</label>
                <input type="text"
                    class="form-control form-control-sm"
                    placeholder="--"
                    name="code"
                    id="code"
                    value="{{ $code }}"
                />

                @error('code')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-2">
                @php
                    if($errors->has('name')) {
                        $name = old('name');
                    } else {
                        $name = (old('name')) ? old('name') : $selected->name;
                    }
                @endphp
                <label for="name" class="form-label">Name of Library</label>
                <input type="text"
                    class="form-control form-control-sm"
                    placeholder="Name of Library"
                    name="name"
                    id="name"
                    value="{{ $name }}"
                />

                @error('name')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-2">
                @php
                    if($errors->has('host')) {
                        $host = old('host');
                    } else {
                        $host = (old('host')) ? old('host') : $selected->host;
                    }
                @endphp
                <label for="host" class="form-label">Host or Domain</label>
                <input type="text"
                    class="form-control form-control-sm"
                    placeholder="Host or Domain"
                    name="host"
                    id="host"
                    value="{{ $host }}"
                />
                @error('host')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-2">
                @php
                    if($errors->has('address')) {
                        $address = old('address');
                    } else {
                        $address = (old('address')) ? old('address') : $selected->address;
                    }
                @endphp
                <label for="address" class="form-label">Address</label>
                <textarea
                    class="form-control form-control-sm"
                    placeholder="Address"
                    name="address"
                    rows="4"
                    id="address">{{ $address }}</textarea>
                @error('address')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-2">
                @php
                    if($errors->has('description')) {
                        $description = old('description');
                    } else {
                        $description = (old('description')) ? old('description') : $selected->description;
                    }
                @endphp
                <label for="description" class="form-label">Description</label>
                <textarea
                    class="form-control form-control-sm"
                    placeholder="Description"
                    name="description"
                    id="description" rows="4">{{ $description }}</textarea>
                @error('description')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="w-100 btn btn-primary px-3">Update</button>
                <a href="{{ url()->previous() }}" class="w-100 btn btn-outline-secondary px-3">Cancel</a>
            </div>
        </form>
    @endslot
@endcomponent
