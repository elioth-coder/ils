@component('staffs.layout', [
    'staffs' => $staffs,
])
    @slot('breadcrumb')
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 border py-2 px-3 bg-white rounded">
                <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                <li class="breadcrumb-item"><a href="/users">Users</a></li>
                <li class="breadcrumb-item active" aria-current="page">Staffs</li>
            </ol>
        </nav>
    @endslot
    @slot('form')
        <style>
        #profile-container {
          width: 225px;
          height: 225px;
          display: flex;
          justify-content: center;
          align-items: center;
          overflow: hidden;
          position: relative;
        }

        #profile-container img {
          height: 100%;
          width: auto;
          object-fit: cover;
          position: absolute;
        }
        </style>
        <form id="patron-form" action="/users/staffs" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <h4 class="text-body-secondary">Create new staff</h4>
            <hr>
            <div class="d-flex column-gap-4">
                <div class="w-100">
                    <div class="d-flex column-gap-2">
                        <div class="mb-2 w-100">
                            <label for="card_number" class="form-label">Card No. / ID No.</label>
                            <input type="text" class="form-control form-control-sm" placeholder="--" name="card_number" id="card_number" value="{{ old('card_number') ?? '' }}">
                            @error('card_number')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex mb-2 w-100">
                            <div class="w-50"></div>
                            <div class="w-50">
                                <label for="suffix" class="form-label">Suffix</label>
                                <select class="form-control form-control-sm" name="suffix" id="suffix">
                                    <option value="">--</option>
                                    @foreach($suffixes as $suffix)
                                        <option {{ $suffix==old('suffix') ? "selected" : "" }} value="{{ $suffix }}">{{ $suffix }}</option>
                                    @endforeach
                                </select>
                                @error('suffix')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="first_name" class="form-label">
                            First Name
                        </label>
                        <input type="text" class="form-control form-control-sm" placeholder="--" name="first_name" id="first_name" value="{{ old('first_name') ?? '' }}">
                        @error('first_name')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex column-gap-2">
                        <div class="mb-2 w-100">
                            <label for="middle_name" class="form-label">Middle Name</label>
                            <input type="text" class="form-control form-control-sm" placeholder="--" name="middle_name" id="middle_name" value="{{ old('middle_name') ?? '' }}">
                            @error('middle_name')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2 w-100">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control form-control-sm" placeholder="--" name="last_name" id="last_name" value="{{ old('last_name') ?? '' }}">
                            @error('last_name')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex column-gap-2">
                        <div class="mb-2 w-100">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-control form-control-sm text-capitalize" name="gender" id="gender">
                                <option value="">--</option>
                                @foreach($genders as $gender)
                                    <option {{ $gender==old('gender') ? "selected" : "" }} value="{{ $gender }}">{{ $gender }}</option>
                                @endforeach
                            </select>
                            @error('gender')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2 w-100">
                            <label for="birthday" class="form-label">Birthday</label>
                            <input type="date" class="form-control form-control-sm" placeholder="--" name="birthday" id="birthday" value="{{ old('birthday') ?? '' }}">
                            @error('birthday')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex column-gap-2">
                        <div class="mb-2 w-100">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control form-control-sm" placeholder="--" name="email" id="email" value="{{ old('email') ?? '' }}">
                            @error('email')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2 w-100">
                            <label for="mobile_number" class="form-label">Mobile no.</label>
                            <input type="text" class="form-control form-control-sm" placeholder="--" name="mobile_number" id="mobile_number" value="{{ old('mobile_number') ?? '' }}">
                            @error('mobile_number')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex column-gap-2">
                        <div class="mb-2 w-100">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control form-control-sm" placeholder="--" name="password" id="password" value="{{ old('password') ?? '' }}">
                            @error('password')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2 w-100">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control form-control-sm" placeholder="--" name="password_confirmation" id="password_confirmation" value="{{ old('password_confirmation') ?? '' }}">
                            @error('password_confirmation')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="w-100 d-flex flex-column">
                    <div class="flex-grow-1 rounded d-flex align-items-center justify-content-center">
                        <div id="profile-container" class="border text-center shadow">
                            <img id="profile" class="h-100 d-block" src="{{ asset('images/profile.jpg') }}" alt="">
                        </div>
                        <input class="d-none" type="file" name="file" id="file">
                    </div>
                    <div class="mb-2 w-100">
                        <label for="library" class="form-label">Library</label>
                        <select class="form-control form-control-sm" name="library" id="library">
                            <option value="">--</option>
                            @foreach ($libraries as $library)
                                <option {{ $library->code==old('library') ? "selected" : "" }} value="{{ $library->code }}">{{ $library->name }} - ({{ $library->code }})</option>
                            @endforeach
                        </select>
                        @error('library')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex column-gap-2">
                        <div class="mb-2 w-100">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control form-control-sm text-uppercase" name="status" id="status">
                                <option value="">--</option>
                                @foreach ($statuses as $status)
                                    <option {{ $status==old('status') ? "selected" : "" }} value="{{ $status }}">{{ $status }}</option>
                                @endforeach
                            </select>
                            @error('status')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2 w-100">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-control form-control-sm text-uppercase" name="role" id="role">
                                <option value="">--</option>
                                @foreach ($roles as $role)
                                    <option {{ $role==old('role') ? "selected" : "" }} value="{{ $role }}">{{ $role }}</option>
                                @endforeach
                            </select>
                            @error('role')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="d-flex flex-row-reverse">
                <button id="submit_proxy" type="button" onclick="addEncoding();" class="w-25 btn btn-primary px-3">Submit</button>
                <button id="submit" type="submit" class="d-none w-25 btn btn-primary px-3">Submit</button>
            </div>
        </form>
    @endslot
@endcomponent
