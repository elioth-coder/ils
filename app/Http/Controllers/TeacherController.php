<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use App\Models\Teacher;
use App\Models\College;
use App\Models\Campus;

class TeacherController extends Controller
{
    public $suffixes = ['JR','SR','II','III','IV','V','VI'];
    public $genders  = ['male','female'];
    public $statuses = [ 'active', 'inactive',];
    public $academic_ranks = [
        'lecturer',
        'instructor i',
        'instructor ii',
        'instructor iii',
        'assistant professor i',
        'assistant professor ii',
        'assistant professor iii',
        'assistant professor iv',
        'associate professor i',
        'associate professor ii',
        'associate professor iii',
        'associate professor iv',
        'associate professor v',
        'professor i',
        'professor ii',
        'professor iii',
        'professor iv',
        'professor v',
        'professor vi',
        'university professor',
    ];

    public function index()
    {
        $teachers = Teacher::latest()->get();
        $colleges = College::latest()->get();
        $campuses = Campus::latest()->get();

        return view('teachers.index', [
            'teachers'       => $teachers,
            'suffixes'       => $this->suffixes,
            'genders'        => $this->genders,
            'colleges'       => $colleges,
            'campuses'       => $campuses,
            'academic_ranks' => $this->academic_ranks,
            'statuses'       => $this->statuses,
        ]);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'employee_number' => ['required', 'string', 'unique:teachers,employee_number', 'max:255'],
            'first_name'      => ['required', 'string', 'max:255'],
            'middle_name'     => ['nullable', 'string', 'max:255'],
            'last_name'       => ['required', 'string', 'max:255'],
            'suffix'          => ['nullable', 'string', 'max:255'],
            'gender'          => ['required', 'in:male,female'],
            'birthday'        => ['required', 'date'],
            'province'        => ['required', 'string', 'max:255'],
            'municipality'    => ['required', 'string', 'max:255'],
            'barangay'        => ['required', 'string', 'max:255'],
            'mobile_number'   => ['required', 'string', 'max:255'],
            'email'           => ['required', 'email', 'unique:teachers,email', 'max:255'],
            'college'         => ['required', 'exists:colleges,code'],
            'campus'          => ['required', 'exists:campuses,code'],
            'academic_rank'   => ['required', 'string', 'max:255'],
            'status'          => ['required', 'in:active,inactive'],
            'file'            => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $teacher = Teacher::create($attributes);
        if(!empty($attributes['file'])) {
            $manager = ImageManager::gd();
            $image = $manager->read($request->file('file'));
            $image->scale(height: 225);

            $image->crop(225, 225, position: 'center');
        }

        if(!empty($image)) {
            $path = "public/images/teachers";
            Storage::makeDirectory($path);
            $path .= "/$teacher->employee_number.png";
            Storage::put($path, (string) $image->encode());

            $teacher->profile = "$teacher->employee_number.png";
            $teacher->save();
        }

        return redirect('users/teachers')->with([
            'message' => "Successfully created the teacher $teacher->employee_number."
        ]);
    }

    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);
        $path = "public/images/teachers/$teacher->profile";

        if (Storage::exists($path)) {
            Storage::delete($path);
        }

        $teacher->delete();

        return redirect("users/teachers")
            ->with([
                'message' => 'Successfully deleted the teacher ' . $teacher->employee_number . '.',
            ]);
    }

    public function edit($id)
    {
        $selected = Teacher::findOrFail($id);
        $teachers = Teacher::latest()->get();
        $colleges = College::latest()->get();
        $campuses = Campus::latest()->get();

        return view('teachers.edit', [
            'teachers'       => $teachers,
            'selected'       => $selected,
            'suffixes'       => $this->suffixes,
            'genders'        => $this->genders,
            'colleges'       => $colleges,
            'campuses'       => $campuses,
            'academic_ranks' => $this->academic_ranks,
            'statuses'       => $this->statuses,
        ]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'employee_number' => ['required', 'string', 'unique:teachers,employee_number', 'max:255'],
            'first_name'      => ['required', 'string', 'max:255'],
            'middle_name'     => ['nullable', 'string', 'max:255'],
            'last_name'       => ['required', 'string', 'max:255'],
            'suffix'          => ['nullable', 'string', 'max:255'],
            'gender'          => ['required', 'in:male,female'],
            'birthday'        => ['required', 'date'],
            'province'        => ['required', 'string', 'max:255'],
            'municipality'    => ['required', 'string', 'max:255'],
            'barangay'        => ['required', 'string', 'max:255'],
            'mobile_number'   => ['required', 'string', 'max:255'],
            'email'           => ['required', 'email', 'unique:teachers,email', 'max:255'],
            'college'         => ['required', 'exists:colleges,code'],
            'campus'          => ['required', 'exists:campuses,code'],
            'academic_rank'   => ['required', 'string', 'max:255'],
            'status'          => ['required', 'in:active,inactive'],
            'file'            => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];

        $teacher = Teacher::findOrFail($id);
        if($request->post('employee_number') == $teacher->employee_number) {
            unset($rules['employee_number']);
        }
        if($request->post('email') == $teacher->email) {
            unset($rules['email']);
        }

        $attributes = $request->validate($rules);

        $previousEmployeeNumber = $teacher->employee_number;
        $previousProfile = $teacher->profile;
        $teacher->update($attributes);
        if(!empty($attributes['file'])) {
            $manager = ImageManager::gd();
            $image = $manager->read($request->file('file'));
            $image->scale(height: 225);

            $image->crop(225, 225, position: 'center');
        }

        if(!empty($image)) {
            $path = "public/images/teachers";
            Storage::makeDirectory($path);
            $path .= "/$teacher->employee_number.png";
            Storage::put($path, (string) $image->encode());

            $teacher->profile = $teacher->employee_number . ".png";
            $teacher->save();
        } else {
            if($previousEmployeeNumber != $teacher->employee_number) {
                $path = "public/images/teachers";
                Storage::makeDirectory($path);
                $newPath = $path . "/$teacher->employee_number.png";
                $oldPath = $path . "/$previousProfile";

                if (Storage::exists($oldPath)) {
                    Storage::move($oldPath, $newPath);
                }

                $teacher->profile = $teacher->employee_number . ".png";
                $teacher->save();
            }
        }

        return redirect('users/teachers')->with([
            'message' => "Successfully updated the teacher $teacher->employee_number."
        ]);
    }
}
