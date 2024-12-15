<x-layout>
    @if(in_array(Auth::user()->role, ['admin','librarian']))
        <x-header />
    @else
        <x-header-patron />
    @endif
    <main class="d-flex flex-column align-items-center justify-content-center w-100 bg-body-secondary">
        <section class="container d-flex py-3 align-items-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 border py-2 px-3 bg-white rounded">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item"><a href="/account">Account</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Profile</li>
                </ol>
            </nav>
        </section>

        <div class="container d-flex flex-column py-1">
            <h2 class="mb-4">Edit Profile</h2>

            <div class="card p-4 mb-4">
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
                <form action="/account/update" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="d-flex column-gap-4">
                        <div class="w-100">
                            <div class="d-flex column-gap-2">
                                <div class="mb-2 w-100">
                                    @php
                                        if($errors->has('card_number')) {
                                            $card_number = old('card_number');
                                        } else {
                                            $card_number = (old('card_number')) ? old('card_number') : $user->card_number;
                                        }
                                    @endphp
                                    <label for="card_number" class="form-label">Card No.</label>
                                    <input disabled type="text" class="form-control form-control-sm" placeholder="--" name="card_number" id="card_number" value="{{ $card_number }}">
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
                                                $suffix = (old('suffix')) ? old('suffix') : $user->suffix;
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
                                        $first_name = (old('first_name')) ? old('first_name') : $user->first_name;
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
                                            $middle_name = (old('middle_name')) ? old('middle_name') : $user->middle_name;
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
                                            $last_name = (old('last_name')) ? old('last_name') : $user->last_name;
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
                                            $gender = (old('gender')) ? old('gender') : $user->gender;
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
                                            $birthday = (old('birthday')) ? old('birthday') : $user->birthday;
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
                                        if($errors->has('province')) {
                                            $province = old('province');
                                        } else {
                                            $province = (old('province')) ? old('province') : $user->province;
                                        }
                                    @endphp
                                    <label for="province" class="form-label">Province</label>
                                    <input type="text" class="form-control form-control-sm" placeholder="--" name="province" id="province" value="{{ $province }}">
                                    @error('province')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-2 w-100">
                                    @php
                                        if($errors->has('municipality')) {
                                            $municipality = old('municipality');
                                        } else {
                                            $municipality = (old('municipality')) ? old('municipality') : $user->municipality;
                                        }
                                    @endphp
                                    <label for="municipality" class="form-label">Municipality</label>
                                    <input type="text" class="form-control form-control-sm" placeholder="--" name="municipality" id="municipality" value="{{ $municipality }}">
                                    @error('municipality')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-2 w-100">
                                @php
                                    if($errors->has('barangay')) {
                                        $barangay = old('barangay');
                                    } else {
                                        $barangay = (old('barangay')) ? old('barangay') : $user->barangay;
                                    }
                                @endphp
                                <label for="barangay" class="form-label">Address Line</label>
                                <input type="text" class="form-control form-control-sm" placeholder="--" name="barangay" id="barangay" value="{{ $barangay }}">
                                @error('barangay')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="w-100 d-flex flex-column">
                            <div class="flex-grow-1 rounded d-flex align-items-center justify-content-center">
                                <div id="profile-container" class="border text-center shadow">
                                    @php $profile = ($user->profile) ? "/storage/images/users/$user->profile" : '/images/profile.jpg'; @endphp
                                    <img id="profile" class="h-100 d-block" src="{{ asset($profile) }}" alt="">
                                </div>
                                <input class="d-none" type="file" name="file" id="file">
                            </div>
                            <div class="d-flex column-gap-2">
                                <div class="mb-2 w-100">
                                    @php
                                        if($errors->has('mobile_number')) {
                                            $mobile_number = old('mobile_number');
                                        } else {
                                            $mobile_number = (old('mobile_number')) ? old('mobile_number') : $user->mobile_number;
                                        }
                                    @endphp
                                    <label for="mobile_number" class="form-label">Mobile No.</label>
                                    <input type="text" class="form-control form-control-sm" placeholder="--" name="mobile_number" id="mobile_number" value="{{ $mobile_number }}">
                                    @error('mobile_number')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-2 w-100">
                                    @php
                                        if($errors->has('email')) {
                                            $email = old('email');
                                        } else {
                                            $email = (old('email')) ? old('email') : $user->email;
                                        }
                                    @endphp
                                    <label for="email" class="form-label">Email</label>
                                    <input disabled type="text" class="form-control form-control-sm" placeholder="--" name="email" id="email" value="{{ $email }}">
                                    @error('email')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-flex column-gap-2">
                                <div class="mb-2 w-100">
                                    @php
                                        if($errors->has('library')) {
                                            $library = old('library');
                                        } else {
                                            $library = (old('library')) ? old('library') : $user->library;
                                        }
                                    @endphp
                                    <label for="library" class="form-label">
                                        Library
                                    </label>
                                    <select {{ ($user->role != 'admin') ? 'disabled' : '' }} class="form-control form-control-sm" name="library" id="library">
                                        <option value="">--</option>
                                        @foreach($libraries as $_library)
                                            <option {{ ($library==$_library->code) ? 'selected' : '' }} value="{{ $_library->code }}">{{ $_library->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('library')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-2 w-100">
                                    @php
                                        if($errors->has('status')) {
                                            $status = old('status');
                                        } else {
                                            $status = (old('status')) ? old('status') : $user->status;
                                        }
                                    @endphp
                                    <label for="status" class="form-label">Status</label>
                                    <select disabled class="form-control form-control-sm text-uppercase" name="status" id="status">
                                        <option value="">--</option>
                                        @foreach ($statuses as $_status)
                                            <option {{ $_status==$status ? "selected" : "" }} value="{{ $_status }}">{{ $_status }}</option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex column-gap-4 mt-4">
                        <div class="w-50"></div>
                        <div class="w-50 d-flex column-gap-2 flex-row-reverse ">
                            <a href="{{ url()->previous() }}" class="w-25 btn btn-outline-dark px-3">Cancel</a>
                            <button type="submit" class="w-25 btn btn-primary px-3">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <x-footer />
    <x-slot:script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const fileInput = document.getElementById('file');
                const container = document.getElementById('profile-container');
                const cover_img = document.getElementById('profile');

                container.addEventListener('click', ()=> { file.click() });
                fileInput.addEventListener('change', (e)=> {
                    let self = e.target;

                    if(self.files.length) {
                        let image = URL.createObjectURL(self.files[0]);

                        cover_img.src = image;
                    } else {
                        cover_img.src = '/images/profile.jpg';
                    }
                });
            });
        </script>
    </x-slot>
</x-layout>
