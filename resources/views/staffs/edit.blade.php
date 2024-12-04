@component('staffs.layout', [
    'staffs' => $staffs,
])
    @slot('breadcrumb')
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 border py-2 px-3 bg-white rounded">
                <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                <li class="breadcrumb-item"><a href="/users">Users</a></li>
                <li class="breadcrumb-item"><a href="/users/staffs">Staffs</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $selected->id }}</li>
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
        <form id="patron-form" action="/users/staffs/{{ $selected->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <h4 class="text-body-secondary">Edit this staff</h4>
            <hr>
            <div class="d-flex column-gap-4">
                <div class="w-100">
                    <div class="d-flex column-gap-2">
                        <div class="mb-2 w-100">
                            @php
                                if($errors->has('card_number')) {
                                    $card_number = old('card_number');
                                } else {
                                    $card_number = (old('card_number')) ? old('card_number') : $selected->card_number;
                                }
                            @endphp
                            <label for="card_number" class="form-label">Card No. / ID No.</label>
                            <input type="text" class="form-control form-control-sm" placeholder="--" name="card_number" id="card_number" value="{{ $card_number }}">
                            @error('card_number')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex mb-2 w-100">
                            <div class="w-50"></div>
                            <div class="w-50">
                                @php
                                    if($errors->has('suffix')) {
                                        $suffix = old('suffix');
                                    } else {
                                        $suffix = (old('suffix')) ? old('suffix') : $selected->suffix;
                                    }
                                @endphp
                                <label for="suffix" class="form-label">Suffix</label>
                                <select class="form-control form-control-sm" name="suffix" id="suffix">
                                    <option value="">--</option>
                                    @foreach($suffixes as $_suffix)
                                        <option {{ $_suffix==$suffix ? "selected" : "" }} value="{{ $_suffix }}">{{ $_suffix }}</option>
                                    @endforeach
                                </select>
                                @error('suffix')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-2">
                        @php
                            if($errors->has('first_name')) {
                                $first_name = old('first_name');
                            } else {
                                $first_name = (old('first_name')) ? old('first_name') : $selected->first_name;
                            }
                        @endphp
                        <label for="first_name" class="form-label">
                            First Name
                        </label>
                        <input type="text" class="form-control form-control-sm" placeholder="--" name="first_name" id="first_name" value="{{ $first_name }}">
                        @error('first_name')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex column-gap-2">
                        <div class="mb-2 w-100">
                            @php
                                if($errors->has('middle_name')) {
                                    $middle_name = old('middle_name');
                                } else {
                                    $middle_name = (old('middle_name')) ? old('middle_name') : $selected->middle_name;
                                }
                            @endphp
                            <label for="middle_name" class="form-label">Middle Name</label>
                            <input type="text" class="form-control form-control-sm" placeholder="--" name="middle_name" id="middle_name" value="{{ $middle_name }}">
                            @error('middle_name')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2 w-100">
                            @php
                                if($errors->has('last_name')) {
                                    $last_name = old('last_name');
                                } else {
                                    $last_name = (old('last_name')) ? old('last_name') : $selected->last_name;
                                }
                            @endphp
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control form-control-sm" placeholder="--" name="last_name" id="last_name" value="{{ $last_name }}">
                            @error('last_name')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex column-gap-2">
                        <div class="mb-2 w-100">
                            @php
                                if($errors->has('gender')) {
                                    $gender = old('gender');
                                } else {
                                    $gender = (old('gender')) ? old('gender') : $selected->gender;
                                }
                            @endphp
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-control form-control-sm text-capitalize" name="gender" id="gender">
                                <option value="">--</option>
                                @foreach($genders as $_gender)
                                    <option {{ $_gender==$gender ? "selected" : "" }} value="{{ $_gender }}">{{ $_gender }}</option>
                                @endforeach
                            </select>
                            @error('gender')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2 w-100">
                            @php
                                if($errors->has('birthday')) {
                                    $birthday = old('birthday');
                                } else {
                                    $birthday = (old('birthday')) ? old('birthday') : $selected->birthday;
                                }
                            @endphp
                            <label for="birthday" class="form-label">Birthday</label>
                            <input type="date" class="form-control form-control-sm" placeholder="--" name="birthday" id="birthday" value="{{ $birthday }}">
                            @error('birthday')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex column-gap-2">
                        <div class="mb-2 w-100">
                            @php
                                if($errors->has('email')) {
                                    $email = old('email');
                                } else {
                                    $email = (old('email')) ? old('email') : $selected->email;
                                }
                            @endphp

                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control form-control-sm" placeholder="--" name="email" id="email" value="{{ $email }}">
                            @error('email')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2 w-100">
                            @php
                                if($errors->has('mobile_number')) {
                                    $mobile_number = old('mobile_number');
                                } else {
                                    $mobile_number = (old('mobile_number')) ? old('mobile_number') : $selected->mobile_number;
                                }
                            @endphp

                            <label for="mobile_number" class="form-label">Mobile No.</label>
                            <input type="text" class="form-control form-control-sm" placeholder="--" name="mobile_number" id="mobile_number" value="{{ $mobile_number }}">
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
                            <input type="password_confirmation" class="form-control form-control-sm" placeholder="--" name="password_confirmation" id="password_confirmation" value="{{ old('password_confirmation') ?? '' }}">
                            @error('password_confirmation')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="w-100 d-flex flex-column">
                    <div class="flex-grow-1 rounded d-flex align-items-center justify-content-center">
                        <div id="profile-container" class="border text-center shadow">
                            @php $profile = ($selected->profile) ? "/storage/images/users/$selected->profile" : '/images/profile.jpg'; @endphp
                            <img id="profile" class="h-100 d-block" src="{{ asset($profile) }}" alt="">
                        </div>
                        <input class="d-none" type="file" name="file" id="file">
                    </div>
                    <div class="mb-2 w-100">
                        @php
                            if($errors->has('library')) {
                                $library = old('library');
                            } else {
                                $library = (old('library')) ? old('library') : $selected->library;
                            }
                        @endphp
                        <label for="library" class="form-label">Library</label>
                        <select class="form-control form-control-sm" name="library" id="library">
                            <option value="">--</option>
                            @foreach ($libraries as $_library)
                                <option {{ $library==$_library->code ? "selected" : "" }} value="{{ $_library->code }}">{{ $_library->name }} - ({{ $_library->code }})</option>
                            @endforeach
                        </select>
                        @error('library')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex column-gap-2">
                        <div class="mb-2 w-100">
                            @php
                                if($errors->has('status')) {
                                    $status = old('status');
                                } else {
                                    $status = (old('status')) ? old('status') : $selected->status;
                                }
                            @endphp
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control form-control-sm text-capitalize" name="status" id="status">
                                <option value="">--</option>
                                @foreach ($statuses as $_status)
                                    <option {{ $_status==$status ? "selected" : "" }} value="{{ $_status }}">{{ $_status }}</option>
                                @endforeach
                            </select>
                            @error('status')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-2 w-100">
                            @php
                                if($errors->has('role')) {
                                    $role = old('role');
                                } else {
                                    $role = (old('role')) ? old('role') : $selected->role;
                                }
                            @endphp
                            <label for="role" class="form-label">Role</label>
                            <select class="form-control form-control-sm text-uppercase" name="role" id="role">
                                <option value="">--</option>
                                @foreach ($roles as $_role)
                                    <option {{ $_role==$role ? "selected" : "" }} value="{{ $_role }}">{{ $_role }}</option>
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
            <div class="d-flex gap-2 flex-row-reverse">
                <a href="{{ url()->previous() }}" class="w-25 btn btn-outline-dark px-3">Cancel</a>
                <button id="submit_proxy" type="button" onclick="addEncoding();" class="w-25 btn btn-primary px-3">Submit</button>
                <button id="submit" type="submit" class="d-none w-25 btn btn-primary px-3">Submit</button>
            </div>
        </form>
    @endslot
@endcomponent
