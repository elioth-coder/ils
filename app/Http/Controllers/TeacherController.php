<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\UserDetail;
use App\Models\College;
use App\Models\Campus;
use App\Models\Library;

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

        $teachers = UserDetail::whereIn('role', ['teacher'])
            ->latest()
            ->get();

        $colleges  = College::latest()->get();
        $campuses  = Campus::latest()->get();
        $libraries = Library::latest()->get();

        return view('teachers.index', [
            'teachers'       => $teachers,
            'suffixes'       => $this->suffixes,
            'genders'        => $this->genders,
            'libraries'      => $libraries,
            'colleges'       => $colleges,
            'campuses'       => $campuses,
            'academic_ranks' => $this->academic_ranks,
            'statuses'       => $this->statuses,
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'card_number'     => ['required', 'string', 'unique:user_details,card_number', 'max:255'],
            'first_name'      => ['required', 'string', 'max:255'],
            'middle_name'     => ['nullable', 'string', 'max:255'],
            'last_name'       => ['required', 'string', 'max:255'],
            'suffix'          => ['nullable', 'string', 'max:255'],
            'gender'          => ['required', 'in:male,female'],
            'birthday'        => ['required', 'date'],
            'province'        => ['nullable', 'string', 'max:255'],
            'municipality'    => ['nullable', 'string', 'max:255'],
            'barangay'        => ['nullable', 'string', 'max:255'],
            'mobile_number'   => ['nullable', 'string', 'max:255'],
            'email'           => ['required', 'email', 'unique:user_details,email', 'unique:users,email', 'max:255'],
            'college'         => ['required', 'exists:colleges,code'],
            'campus'          => ['required', 'exists:campuses,code'],
            'academic_rank'   => ['required', 'string', 'max:255'],
            'status'          => ['required', 'in:active,inactive'],
            'file'            => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];

        $attributes = $request->validate($rules);
        $attributes['role'] = 'teacher';

        $staff = UserDetail::where('email', Auth::user()->email)->first();
        $attributes['library'] = $staff->library;

        $teacher = UserDetail::create($attributes);
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
            $path .= "/$teacher->card_number.png";
            Storage::put($path, (string) $image->encode());

            $teacher->profile = "$teacher->card_number.png";
            $teacher->save();
        }

        return redirect('users/teachers')->with([
            'message' => "Successfully created the teacher $teacher->card_number."
        ]);
    }

    public function destroy($id)
    {
        $teacher = UserDetail::findOrFail($id);
        $path = "public/images/users/$teacher->profile";

        if (Storage::exists($path)) {
            Storage::delete($path);
        }

        $teacher->delete();

        return redirect("users/teachers")
            ->with([
                'message' => 'Successfully deleted the teacher ' . $teacher->card_number . '.',
            ]);
    }

    public function edit($id)
    {

        $teachers = UserDetail::whereIn('role', ['teacher'])
            ->latest()
            ->get();

        $selected  = UserDetail::findOrFail($id);
        $colleges  = College::latest()->get();
        $campuses  = Campus::latest()->get();
        $libraries = Library::latest()->get();

        return view('teachers.edit', [
            'teachers'       => $teachers,
            'selected'       => $selected,
            'suffixes'       => $this->suffixes,
            'genders'        => $this->genders,
            'libraries'      => $libraries,
            'colleges'       => $colleges,
            'campuses'       => $campuses,
            'academic_ranks' => $this->academic_ranks,
            'statuses'       => $this->statuses,
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
            'province'        => ['nullable', 'string', 'max:255'],
            'municipality'    => ['nullable', 'string', 'max:255'],
            'barangay'        => ['nullable', 'string', 'max:255'],
            'mobile_number'   => ['nullable', 'string', 'max:255'],
            'email'           => ['required', 'email', 'unique:user_details,email', 'unique:users,email', 'max:255'],
            'college'         => ['required', 'exists:colleges,code'],
            'campus'          => ['required', 'exists:campuses,code'],
            'academic_rank'   => ['required', 'string', 'max:255'],
            'status'          => ['required', 'in:active,inactive'],
            'file'            => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];

        $teacher = UserDetail::findOrFail($id);
        if($request->post('card_number') == $teacher->card_number) {
            unset($rules['card_number']);
        }
        if($request->post('email') == $teacher->email) {
            unset($rules['email']);
        }

        $attributes = $request->validate($rules);

        $staff = UserDetail::where('email', Auth::user()->email)->first();
        $attributes['library'] = $staff->library;

        $previousCardNumber = $teacher->card_number;
        $previousProfile = $teacher->profile;

        $teacher->update($attributes);
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
            $path .= "/$teacher->card_number.png";
            Storage::put($path, (string) $image->encode());

            $teacher->profile = $teacher->card_number . ".png";
            $teacher->save();
        } else {
            if($previousCardNumber != $teacher->card_number) {
                $path = "public/images/users";
                Storage::makeDirectory($path);
                $newPath = $path . "/$teacher->card_number.png";
                $oldPath = $path . "/$previousProfile";

                if (Storage::exists($oldPath)) {
                    Storage::move($oldPath, $newPath);
                }

                $teacher->profile = $teacher->card_number . ".png";
                $teacher->save();
            }
        }

        return redirect('users/teachers')->with([
            'message' => "Successfully updated the teacher $teacher->card_number."
        ]);
    }
}
