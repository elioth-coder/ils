<?php

namespace App\Http\Controllers;

use App\Models\Library;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class StaffController extends Controller
{
    public $suffixes = ['JR','SR','II','III','IV','V','VI'];
    public $genders  = ['male','female'];
    public $statuses = [ 'active', 'inactive',];
    public $roles = [
        'librarian',
        'assistant',
        'clerk'
    ];

    public function index()
    {
        $staffs = UserDetail::whereIn('role', ['librarian','clerk','staff'])->get();
        $libraries = Library::latest()->get();

        return view('staffs.index', [
            'staffs'         => $staffs,
            'suffixes'       => $this->suffixes,
            'genders'        => $this->genders,
            'libraries'      => $libraries,
            'statuses'       => $this->statuses,
            'roles'          => $this->roles,
        ]);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'card_number'     => ['required', 'string', 'unique:user_details,card_number', 'max:255'],
            'first_name'      => ['required', 'string', 'max:255'],
            'middle_name'     => ['nullable', 'string', 'max:255'],
            'last_name'       => ['required', 'string', 'max:255'],
            'suffix'          => ['nullable', 'string', 'max:255'],
            'gender'          => ['required', 'in:male,female'],
            'birthday'        => ['required', 'date'],
            'email'           => ['required', 'email', 'unique:users,email'],
            'mobile_number'   => ['required', 'string', 'max:255'],
            'password'        => ['required', 'confirmed', Password::min(6)],
            'library'         => ['required', 'string', 'exists:libraries,code', 'max:255'],
            'status'          => ['required', 'in:active,inactive'],
            'role'            => ['required', 'in:librarian,assistant,clerk'],
            'file'            => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $staff = UserDetail::create($attributes);
        $userAttributes = [
            'name'        => $staff->first_name . ' ' . $staff->last_name,
            'email'       => $staff->email,
            'role'        => $staff->role,
            'password'    => $attributes['password'],
            'card_number' => $staff->card_number,
        ];
        User::create($userAttributes);

        if(!empty($attributes['file'])) {
            $manager = ImageManager::gd();
            $image = $manager->read($request->file('file'));

            if($image->height() >= $image->width()) {
                $image->scale(width: 225);
            } else {
                $image->scale(height: 225);
            }

            $image->crop(225, 225, position: 'center');
        }

        if(!empty($image)) {
            $path = "public/images/users";
            Storage::makeDirectory($path);
            $path .= "/$staff->card_number.png";
            Storage::put($path, (string) $image->encode());

            $staff->profile = "$staff->card_number.png";
            $staff->save();
        }

        return redirect('users/staffs')->with([
            'message' => "Successfully created the staff $staff->card_number."
        ]);
    }

    public function destroy($id)
    {
        $staff = UserDetail::findOrFail($id);
        $user  = User::where('email', $staff->email)->first();
        $path  = "public/images/users/$staff->profile";

        if (Storage::exists($path)) {
            Storage::delete($path);
        }

        $staff->delete();
        $user->delete();

        return redirect("users/staffs")
            ->with([
                'message' => 'Successfully deleted the staff ' . $staff->card_number . '.',
            ]);
    }

    public function edit($id)
    {
        $selected = UserDetail::findOrFail($id);
        $user = User::where('email', $selected->email)->first();
        $selected->role = $user->role;
        $staffs = UserDetail::whereIn('role', ['librarian','clerk','staff'])->get();
        $libraries = Library::latest()->get();

        return view('staffs.edit', [
            'staffs'         => $staffs,
            'selected'       => $selected,
            'suffixes'       => $this->suffixes,
            'genders'        => $this->genders,
            'libraries'      => $libraries,
            'statuses'       => $this->statuses,
            'roles'          => $this->roles,
        ]);

    }

    public function update(Request $request, $id)
    {
        $rules = [
            'card_number'     => ['required', 'string', 'unique:user_details,card_number', 'max:255'],
            'first_name'      => ['required', 'string', 'max:255'],
            'middle_name'     => ['nullable', 'string', 'max:255'],
            'last_name'       => ['required', 'string', 'max:255'],
            'suffix'          => ['nullable', 'string', 'max:255'],
            'gender'          => ['required', 'in:male,female'],
            'birthday'        => ['required', 'date'],
            'email'           => ['required', 'email', 'unique:users,email'],
            'mobile_number'   => ['required', 'string', 'max:255'],
            'password'        => ['required', 'confirmed', Password::min(6)],
            'library'         => ['required', 'string', 'exists:libraries,code', 'max:255'],
            'status'          => ['required', 'in:active,inactive'],
            'role'            => ['required', 'in:librarian,assistant,clerk'],
            'file'            => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];

        $staff = UserDetail::findOrFail($id);
        $user = User::where('email', $staff->email)->first();
        if($request->post('card_number') == $staff->card_number) {
            unset($rules['card_number']);
        }
        if($request->post('email') == $staff->email) {
            unset($rules['email']);
        }
        $attributes = $request->validate($rules);

        $previousCardNumber = $staff->card_number;
        $previousProfile = $staff->profile;
        $staff->update($attributes);
        $user->update([
            'name'        => $staff->first_name . ' ' . $staff->last_name,
            'email'       => $staff->email,
            'role'        => $staff->role,
            'password'    => $attributes['password'],
            'card_number' => $staff->card_number,
        ]);
        if(!empty($attributes['file'])) {
            $manager = ImageManager::gd();
            $image = $manager->read($request->file('file'));

            if($image->height() >= $image->width()) {
                $image->scale(width: 225);
            } else {
                $image->scale(height: 225);
            }

            $image->crop(225, 225, position: 'center');
        }

        if(!empty($image)) {
            $path = "public/images/users";
            Storage::makeDirectory($path);
            $path .= "/$staff->card_number.png";
            Storage::put($path, (string) $image->encode());

            $staff->profile = $staff->card_number . ".png";
            $staff->save();
        } else {
            if($previousCardNumber != $staff->card_number) {
                $path = "public/images/users";
                Storage::makeDirectory($path);
                $newPath = $path . "/$staff->card_number.png";
                $oldPath = $path . "/$previousProfile";

                if (Storage::exists($oldPath)) {
                    Storage::move($oldPath, $newPath);
                }

                $staff->profile = $staff->card_number . ".png";
                $staff->save();
            }
        }

        return redirect('users/staffs')->with([
            'message' => "Successfully updated the staff $staff->card_number."
        ]);
    }
}

