<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\College;
use App\Models\Library;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Program;
use App\Models\UserDetail;

class StudentController extends Controller
{
    public $suffixes = [
        'JR','SR','II','III','IV','V','VI'
    ];

    public $genders = ['male','female'];

    public $year_levels = [
        ['key' => '1st', 'value' => 1],
        ['key' => '2nd', 'value' => 2],
        ['key' => '3rd', 'value' => 3],
        ['key' => '4th', 'value' => 4],
        ['key' => '5th', 'value' => 5],
        ['key' => '6th', 'value' => 6],
        ['key' => '7th', 'value' => 7],
        ['key' => '8th', 'value' => 8],
        ['key' => '9th', 'value' => 9],
        ['key' => '10th', 'value' => 10],
    ];

    public $sections = ['A','B','C','D','E','F',];
    public $statuses = [ 'active', 'inactive',];

    public function index()
    {
        if(Auth::user()->role != 'admin') {
            $staff = UserDetail::where('email', Auth::user()->email)->first();
            $students =
                UserDetail::whereIn('role', ['student'])
                    ->where('library', $staff->library)
                    ->latest()
                    ->get();
        } else {
            $students = UserDetail::whereIn('role', ['student'])
                ->latest()
                ->get();
        }

        $colleges  = College::latest()->get();
        $campuses  = Campus::latest()->get();
        $libraries = Library::latest()->get();
        $programs  = Program::latest()->get();

        return view('students.index', [
            'libraries'   => $libraries,
            'colleges'    => $colleges,
            'campuses'    => $campuses,
            'students'    => $students,
            'programs'    => $programs,
            'suffixes'    => $this->suffixes,
            'genders'     => $this->genders,
            'year_levels' => $this->year_levels,
            'sections'    => $this->sections,
            'statuses'    => $this->statuses,
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'card_number'    => ['required', 'string', 'unique:user_details,card_number', 'max:255'],
            'first_name'     => ['required', 'string', 'max:255'],
            'middle_name'    => ['nullable', 'string', 'max:255'],
            'last_name'      => ['required', 'string', 'max:255'],
            'suffix'         => ['nullable', 'string', 'max:255'],
            'gender'         => ['required', 'in:male,female'],
            'birthday'       => ['required', 'date'],
            'province'       => ['nullable', 'string', 'max:255'],
            'municipality'   => ['nullable', 'string', 'max:255'],
            'barangay'       => ['nullable', 'string', 'max:255'],
            'mobile_number'  => ['nullable', 'string', 'max:255'],
            'email'          => ['required', 'email', 'unique:user_details,email', 'max:255'],
            'program'        => ['required', 'exists:programs,code'],
            'college'        => ['required', 'exists:colleges,code'],
            'campus'         => ['required', 'exists:campuses,code'],
            'year'           => ['required', 'integer', 'min:1', 'max:10'],
            'section'        => ['required', 'in:A,B,C,D,E,F'],
            'status'         => ['required', 'in:active,inactive'],
            'file'           => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];

        if(Auth::user()->role == 'admin') {
            $rules['library'] = ['required', 'string', 'exists:libraries,code'];
        }

        $attributes = $request->validate($rules);
        $attributes['role'] = 'student';

        if(Auth::user()->role != 'admin') {
            $staff = UserDetail::where('email', Auth::user()->email)->first();
            $attributes['library'] = $staff->library;
        }

        $student = UserDetail::create($attributes);
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
            $path .= "/$student->card_number.png";
            Storage::put($path, (string) $image->encode());

            $student->profile = $student->card_number . ".png";
            $student->save();
        }

        return redirect('users/students')->with([
            'message' => "Successfully created the student $student->card_number."
        ]);
    }

    public function destroy($id)
    {
        $student = UserDetail::findOrFail($id);
        $path = "public/images/users/$student->profile";

        if (Storage::exists($path)) {
            Storage::delete($path);
        }

        $student->delete();

        return redirect("users/students")
            ->with([
                'message' => 'Successfully deleted the student ' . $student->card_number . '.',
            ]);
    }

    public function edit($id)
    {
        if(Auth::user()->role != 'admin') {
            $staff = UserDetail::where('email', Auth::user()->email)->first();
            $students =
                UserDetail::whereIn('role', ['student'])
                    ->where('library', $staff->library)
                    ->latest()
                    ->get();
        } else {
            $students = UserDetail::whereIn('role', ['student'])
                ->latest()
                ->get();
        }

        $colleges  = College::latest()->get();
        $campuses  = Campus::latest()->get();
        $libraries = Library::latest()->get();
        $programs  = Program::latest()->get();


        $selected = UserDetail::findOrFail($id);

        return view('students.edit', [
            'colleges'    => $colleges,
            'campuses'    => $campuses,
            'libraries'   => $libraries,
            'students'    => $students,
            'students'    => $students,
            'programs'    => $programs,
            'selected'    => $selected,
            'suffixes'    => $this->suffixes,
            'genders'     => $this->genders,
            'year_levels' => $this->year_levels,
            'sections'    => $this->sections,
            'statuses'    => $this->statuses,
        ]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'card_number'    => ['required', 'string', 'unique:user_details,card_number', 'max:255'],
            'first_name'     => ['required', 'string', 'max:255'],
            'middle_name'    => ['nullable', 'string', 'max:255'],
            'last_name'      => ['required', 'string', 'max:255'],
            'suffix'         => ['nullable', 'string', 'max:255'],
            'gender'         => ['required', 'in:male,female'],
            'birthday'       => ['required', 'date'],
            'province'       => ['nullable', 'string', 'max:255'],
            'municipality'   => ['nullable', 'string', 'max:255'],
            'barangay'       => ['nullable', 'string', 'max:255'],
            'mobile_number'  => ['nullable', 'string', 'max:255'],
            'email'          => ['required', 'email', 'unique:students,email', 'max:255'],
            'program'        => ['required', 'exists:programs,code'],
            'college'        => ['required', 'exists:colleges,code'],
            'campus'         => ['required', 'exists:campuses,code'],
            'year'           => ['required', 'integer', 'min:1', 'max:10'],
            'section'        => ['required', 'in:A,B,C,D,E,F'],
            'status'         => ['required', 'in:active,inactive'],
            'file'           => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];

        $student = UserDetail::findOrFail($id);
        if($request->post('card_number') == $student->card_number) {
            unset($rules['card_number']);
        }
        if($request->post('email') == $student->email) {
            unset($rules['email']);
        }
        if(Auth::user()->role == 'admin') {
            $rules['library'] = ['required', 'string', 'exists:libraries,code'];
        }

        $attributes = $request->validate($rules);

        if(Auth::user()->role != 'admin') {
            $staff = UserDetail::where('email', Auth::user()->email)->first();
            $attributes['library'] = $staff->library;
        }

        $previousCardNumber = $student->card_number;
        $previousProfile = $student->profile;

        $student->update($attributes);
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
            $path .= "/$student->card_number.png";
            Storage::put($path, (string) $image->encode());

            $student->profile = $student->card_number . ".png";
            $student->save();
        } else {
            if($previousCardNumber != $student->card_number) {
                $path = "public/images/users";
                Storage::makeDirectory($path);
                $newPath = $path . "/$student->card_number.png";
                $oldPath = $path . "/$previousProfile";

                if (Storage::exists($oldPath)) {
                    Storage::move($oldPath, $newPath);
                }

                $student->profile = $student->card_number . ".png";
                $student->save();
            }
        }

        return redirect('users/students')->with([
            'message' => "Successfully updated the student $student->card_number."
        ]);
    }
}

