@component('programs.layout', [
    'programs' => $programs,
    'colleges' => $colleges,
])
    @slot('breadcrumb')
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 border py-2 px-3 bg-white rounded">
                <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                <li class="breadcrumb-item"><a href="/settings">Settings</a></li>
                <li class="breadcrumb-item active" aria-current="page">Programs</li>
            </ol>
        </nav>
    @endslot
    @slot('form')
        <form action="/settings/programs" method="POST">
            @csrf
            @method('POST')

            <h4 class="text-body-secondary">Create new program</h4>
            <hr>
            <div class="mb-2">
                <label for="code" class="form-label">Code</label>
                <input
                    class="form-control form-control-sm"
                    placeholder="--"
                    name="code"
                    id="code"
                    value="{{ old('code') ?? '' }}"
                />
                @error('code')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-2">
                <label for="name" class="form-label">Name of Program</label>
                <input type="text" class="form-control form-control-sm" placeholder="--" name="name" id="name" value="{{ old('name') ?? '' }}">
                @error('name')
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
            <div class="mb-2">
                <label for="college" class="form-label">College</label>
                <select class="form-control form-control-sm" name="college" id="college" required>
                    <option value="">--</option>
                    @foreach($colleges as $college)
                        <option value="{{ $college->code }}">
                            {{ $college->code }} -
                            {{ $college->name }}
                        </option>
                    @endforeach
                </select>
                @error('college')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-2">
                <label for="program_length" class="form-label">Program Length (in years)</label>
                <select class="form-control form-control-sm" placeholder="--" name="program_length" id="program_length" required>
                    <option value="">--</option>
                    @for ($i=1; $i<=10; $i++)
                        <option value="{{ $i }}" {{ (old('program_length')==$i) ? 'selected':'' }}>
                            {{ $i }} {{ ($i>1) ? 'years' : 'year' }}
                        </option>
                    @endfor
                </select>
                @error('program_length')
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
