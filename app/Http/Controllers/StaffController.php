<?php

namespace App\Http\Controllers;

use App\Models\Library;
use App\Models\Staff;
use App\Models\User;
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
        $staffs = Staff::latest()->get();
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
            'employee_number' => ['required', 'string', 'unique:staffs,employee_number', 'max:255'],
            'first_name'      => ['required', 'string', 'max:255'],
            'middle_name'     => ['nullable', 'string', 'max:255'],
            'last_name'       => ['required', 'string', 'max:255'],
            'suffix'          => ['nullable', 'string', 'max:255'],
            'gender'          => ['required', 'in:male,female'],
            'birthday'        => ['required', 'date'],
            'email'           => ['required', 'email', 'unique:users,email'],
            'password'        => ['required', 'confirmed', Password::min(6)],
            'library'         => ['required', 'string', 'exists:libraries,code', 'max:255'],
            'status'          => ['required', 'in:active,inactive'],
            'role'            => ['required', 'in:librarian,assistant,clerk'],
            'file'            => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $staff = Staff::create($attributes);
        $userAttributes = [
            'name'  => $staff->first_name . ' ' . $staff->last_name,
            'email' => $staff->email,
            'role'  => $attributes['role'],
            'password' => $attributes['password'],
        ];
        $user = User::create($userAttributes);

        if(!empty($attributes['file'])) {
            $manager = ImageManager::gd();
            $image = $manager->read($request->file('file'));
            $image->scale(height: 225);

            $image->crop(225, 225, position: 'center');
        }

        if(!empty($image)) {
            $path = "public/images/staffs";
            Storage::makeDirectory($path);
            $path .= "/$staff->employee_number.png";
            Storage::put($path, (string) $image->encode());

            $staff->profile = "$staff->employee_number.png";
            $staff->save();
        }

        return redirect('users/staffs')->with([
            'message' => "Successfully created the staff $staff->employee_number."
        ]);
    }

    public function destroy($id)
    {
        $staff = Staff::findOrFail($id);
        $user = User::where('email', $staff->email)->first();
        $path = "public/images/staffs/$staff->profile";

        if (Storage::exists($path)) {
            Storage::delete($path);
        }

        $staff->delete();
        $user->delete();

        return redirect("users/staffs")
            ->with([
                'message' => 'Successfully deleted the staff ' . $staff->employee_number . '.',
            ]);
    }

    public function edit($id)
    {
        $selected = Staff::findOrFail($id);
        $user = User::where('email', $selected->email)->first();
        $selected->role = $user->role;
        $staffs = Staff::latest()->get();
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
            'employee_number' => ['required', 'string', 'unique:staffs,employee_number', 'max:255'],
            'first_name'      => ['required', 'string', 'max:255'],
            'middle_name'     => ['nullable', 'string', 'max:255'],
            'last_name'       => ['required', 'string', 'max:255'],
            'suffix'          => ['nullable', 'string', 'max:255'],
            'gender'          => ['required', 'in:male,female'],
            'birthday'        => ['required', 'date'],
            'password'        => ['required', 'confirmed', Password::min(6)],
            'library'         => ['required', 'string', 'exists:libraries,code', 'max:255'],
            'status'          => ['required', 'in:active,inactive'],
            'role'            => ['required', 'in:librarian,assistant,clerk'],
            'file'            => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];

        $staff = Staff::findOrFail($id);
        $user = User::where('email', $staff->email)->first();
        if($request->post('employee_number') == $staff->employee_number) {
            unset($rules['employee_number']);
        }

        $attributes = $request->validate($rules);

        $previousEmployeeNumber = $staff->employee_number;
        $previousProfile = $staff->profile;
        $staff->update($attributes);
        $user->update([
            'name'  => $staff->first_name . ' ' . $staff->last_name,
            'role'  => $attributes['role'],
            'password' => $attributes['password'],
        ]);
        if(!empty($attributes['file'])) {
            $manager = ImageManager::gd();
            $image = $manager->read($request->file('file'));
            $image->scale(height: 225);

            $image->crop(225, 225, position: 'center');
        }

        if(!empty($image)) {
            $path = "public/images/staffs";
            Storage::makeDirectory($path);
            $path .= "/$staff->employee_number.png";
            Storage::put($path, (string) $image->encode());

            $staff->profile = $staff->employee_number . ".png";
            $staff->save();
        } else {
            if($previousEmployeeNumber != $staff->employee_number) {
                $path = "public/images/staffs";
                Storage::makeDirectory($path);
                $newPath = $path . "/$staff->employee_number.png";
                $oldPath = $path . "/$previousProfile";

                if (Storage::exists($oldPath)) {
                    Storage::move($oldPath, $newPath);
                }

                $staff->profile = $staff->employee_number . ".png";
                $staff->save();
            }
        }

        return redirect('users/staffs')->with([
            'message' => "Successfully updated the staff $staff->employee_number."
        ]);
    }
}

