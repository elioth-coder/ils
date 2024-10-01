<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use App\Models\Student;
use App\Models\Program;

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
        $students = Student::latest()->get();
        $programs = Program::latest()->get();

        return view('students.index', [
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
        $attributes = $request->validate([
            'student_number' => ['required', 'string', 'unique:students,student_number', 'max:255'],
            'first_name'     => ['required', 'string', 'max:255'],
            'middle_name'    => ['nullable', 'string', 'max:255'],
            'last_name'      => ['required', 'string', 'max:255'],
            'suffix'         => ['nullable', 'string', 'max:255'],
            'gender'         => ['required', 'in:male,female'],
            'birthday'       => ['required', 'date'],
            'province'       => ['required', 'string', 'max:255'],
            'municipality'   => ['required', 'string', 'max:255'],
            'barangay'       => ['required', 'string', 'max:255'],
            'mobile_number'  => ['required', 'string', 'max:255'],
            'email'          => ['required', 'email', 'unique:students,email', 'max:255'],
            'program'        => ['required','exists:programs,code'],
            'year'           => ['required','integer', 'min:1', 'max:10'],
            'section'        => ['required','in:A,B,C,D,E,F'],
            'status'         => ['required','in:active,inactive'],
            'file'           => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $student = Student::create($attributes);
        if(!empty($attributes['file'])) {
            $manager = ImageManager::gd();
            $image = $manager->read($request->file('file'));
            $image->scale(height: 225);

            $image->crop(225, 225, position: 'center');
        }

        if(!empty($image)) {
            $path = "public/images/students";
            Storage::makeDirectory($path);
            $path .= "/$student->number.png";
            Storage::put($path, (string) $image->encode());

            $student->profile = $student->number . ".png";
            $student->save();
        }

        return redirect('users/students')->with([
            'message' => "Successfully created the student $student->student_number."
        ]);
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $path = "public/images/students/$student->profile";

        if (Storage::exists($path)) {
            Storage::delete($path);
        }

        $student->delete();

        return redirect("users/students")
            ->with([
                'message' => 'Successfully deleted the student ' . $student->student_number . '.',
            ]);
    }

    public function edit($id)
    {
        $selected = Student::findOrFail($id);
        $students = Student::latest()->get();
        $programs = Program::latest()->get();

        return view('students.edit', [
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
            'student_number' => ['required', 'string', 'unique:students,student_number', 'max:255'],
            'first_name'     => ['required', 'string', 'max:255'],
            'middle_name'    => ['nullable', 'string', 'max:255'],
            'last_name'      => ['required', 'string', 'max:255'],
            'suffix'         => ['nullable', 'string', 'max:255'],
            'gender'         => ['required', 'in:male,female'],
            'birthday'       => ['required', 'date'],
            'province'       => ['required', 'string', 'max:255'],
            'municipality'   => ['required', 'string', 'max:255'],
            'barangay'       => ['required', 'string', 'max:255'],
            'mobile_number'  => ['required', 'string', 'max:255'],
            'email'          => ['required', 'email', 'unique:students,email', 'max:255'],
            'program'        => ['required','exists:programs,code'],
            'year'           => ['required','integer', 'min:1', 'max:10'],
            'section'        => ['required','in:A,B,C,D,E,F'],
            'status'         => ['required','in:active,inactive'],
            'file'           => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];

        $student = Student::findOrFail($id);
        if($request->post('student_number') == $student->student_number) {
            unset($rules['student_number']);
        }
        if($request->post('email') == $student->email) {
            unset($rules['email']);
        }

        $attributes = $request->validate($rules);

        $previousStudentNumber = $student->student_number;
        $previousProfile = $student->profile;
        $student->update($attributes);
        if(!empty($attributes['file'])) {
            $manager = ImageManager::gd();
            $image = $manager->read($request->file('file'));
            $image->scale(height: 225);

            $image->crop(225, 225, position: 'center');
        }

        if(!empty($image)) {
            $path = "public/images/students";
            Storage::makeDirectory($path);
            $path .= "/$student->student_number.png";
            Storage::put($path, (string) $image->encode());

            $student->profile = $student->student_number . ".png";
            $student->save();
        } else {
            if($previousStudentNumber != $student->student_number) {
                $path = "public/images/students";
                Storage::makeDirectory($path);
                $newPath = $path . "/$student->student_number.png";
                $oldPath = $path . "/$previousProfile";

                if (Storage::exists($oldPath)) {
                    Storage::move($oldPath, $newPath);
                }

                $student->profile = $student->student_number . ".png";
                $student->save();
            }
        }

        return redirect('users/students')->with([
            'message' => "Successfully updated the student $student->student_number."
        ]);
    }
}

