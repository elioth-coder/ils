@component('colleges.layout', [
    'colleges' => $colleges,
    'selected'  => $selected,
])
    @slot('breadcrumb')
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 border py-2 px-3 bg-white rounded">
                <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                <li class="breadcrumb-item"><a href="/settings">Settings</a></li>
                <li class="breadcrumb-item"><a href="/settings/colleges">Colleges</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $selected->code }}</li>
            </ol>
        </nav>
    @endslot
    @slot('form')
        <form action="/settings/colleges/{{ $selected->id }}" method="POST">
            @csrf
            @method('PATCH')

            <h4 class="text-body-secondary">Edit this college</h4>
            <br>
            <div class="mb-2">
                @php
                    if($errors->has('code')) {
                        $code = old('code');
                    } else {
                        $code = (old('code')) ? old('code') : $selected->code;
                    }
                @endphp
                <label for="code" class="form-label">Code</label>
                <input
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
                <label for="name" class="form-label">Name of College</label>
                <input type="text"
                    class="form-control form-control-sm"
                    placeholder="Name of College"
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
                    id="description" rows="3">{{ $description }}</textarea>
                @error('description')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="w-100 btn btn-primary px-3">Update</button>
                <a href="/settings/colleges" class="w-100 btn btn-outline-secondary px-3">Cancel</a>
            </div>
        </form>
    @endslot
@endcomponent
