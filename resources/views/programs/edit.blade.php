@component('programs.layout', [
    'colleges' => $colleges,
    'programs' => $programs,
    'selected'  => $selected,
])
    @slot('breadcrumb')
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 border py-2 px-3 bg-white rounded">
                <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                <li class="breadcrumb-item"><a href="/settings">Settings</a></li>
                <li class="breadcrumb-item"><a href="/settings/programs">Programs</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $selected->code }}</li>
            </ol>
        </nav>
    @endslot
    @slot('form')
        <form action="/settings/programs/{{ $selected->id }}" method="POST">
            @csrf
            @method('PATCH')

            <h4 class="text-body-secondary">Edit this program</h4>
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
                <label for="name" class="form-label">Name of Program</label>
                <input type="text"
                    class="form-control form-control-sm"
                    placeholder="--"
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
                    id="description" rows="4">{{ $description }}</textarea>
                @error('description')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-2">
                @php
                    if($errors->has('college')) {
                        $college = old('college');
                    } else {
                        $college = (old('college')) ? old('college') : $selected->college;
                    }
                @endphp
                <label for="college" class="form-label">College</label>
                <select class="form-control form-control-sm" name="college" id="college" required>
                    <option value="">--</option>
                    @foreach($colleges as $_college)
                        <option value="{{ $_college->code }}" {{ ($_college->code==$college) ? 'selected':'' }}>
                            {{ $_college->code }} -
                            {{ $_college->name }}
                        </option>
                    @endforeach
                </select>
                @error('college')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-2">
                @php
                    if($errors->has('program_length')) {
                        $program_length = old('program_length');
                    } else {
                        $program_length = (old('program_length')) ? old('program_length') : $selected->program_length;
                    }
                @endphp
                <label for="program_length" class="form-label">Program Length (in years)</label>
                <select class="form-control form-control-sm" placeholder="--" name="program_length" id="program_length" required>
                    <option value="">--</option>
                    @for ($i=1; $i<=10; $i++)
                        <option value="{{ $i }}" {{ ($program_length==$i) ? 'selected':'' }}>
                            {{ $i }} {{ ($i>1) ? 'years' : 'year' }}
                        </option>
                    @endfor
                </select>
                @error('program_length')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <br>
            <div class="d-flex gap-2">
                <button type="submit" class="w-100 btn btn-primary px-3">Update</button>
                <a href="{{ url()->previous() }}" class="w-100 btn btn-outline-secondary px-3">Cancel</a>
            </div>
        </form>
    @endslot
@endcomponent
