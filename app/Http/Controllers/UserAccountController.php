<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Token;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\College;
use App\Models\Campus;
use App\Models\Library;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Mail\ActivateAccountMail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;

use Exception;

class UserAccountController extends Controller
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

    public function profile()
    {
        $user      = Teacher::where('email', Auth::user()->email)->first();
        $colleges  = College::latest()->get();
        $campuses  = Campus::latest()->get();
        $libraries = Library::latest()->get();

        return view('accounts.profile', [
            'user'           => $user,
            'suffixes'       => $this->suffixes,
            'genders'        => $this->genders,
            'libraries'      => $libraries,
            'colleges'       => $colleges,
            'campuses'       => $campuses,
            'academic_ranks' => $this->academic_ranks,
            'statuses'       => $this->statuses,
        ]);
    }

    public function edit_profile(Request $request)
    {
        $rules = [
            'first_name'      => ['required', 'string', 'max:255'],
            'middle_name'     => ['nullable', 'string', 'max:255'],
            'last_name'       => ['required', 'string', 'max:255'],
            'suffix'          => ['nullable', 'string', 'max:255'],
            'gender'          => ['required', 'in:male,female'],
            'province'        => ['required', 'string', 'max:255'],
            'municipality'    => ['required', 'string', 'max:255'],
            'barangay'        => ['required', 'string', 'max:255'],
            'mobile_number'   => ['required', 'string', 'max:255'],
            'college'         => ['required', 'exists:colleges,code'],
            'campus'          => ['required', 'exists:campuses,code'],
            'academic_rank'   => ['required', 'string', 'max:255'],
            'file'            => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
        $attributes = $request->validate($rules);

        $teacher = Teacher::where('email', Auth::user()->email)->first();
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
        }

        return redirect('accounts/profile')->with([
            'message' => [
                'type'    => 'success',
                'content' => "Successfully updated your profile"
            ]
        ]);
    }

    public function password()
    {
        return view('accounts.password');
    }

    public function change_password(Request $request)
    {
        $passwordAttributes = $request->validate([
            'current_password' => ['required'],
            'password'         => ['required', 'confirmed', Password::min(6)],
        ]);
        $current_password = $passwordAttributes['current_password'];

        if(Hash::check($current_password, Auth::user()->password)) {
            $user = User::where('email', Auth::user()->email)->first();

            $user->update([
                'password' => $passwordAttributes['password'],
            ]);

            return redirect('/accounts/password')->with([
                'message' => [
                    'type'    => 'success',
                    'content' => 'Successfully changed the password',
                ],
            ]);

        } else {
            throw ValidationException::withMessages([
                'current_password' => 'The current password field is incorrect',
            ]);
        }
    }

    public function create()
    {
        return view('accounts.register');
    }

    public function store(Request $request)
    {
        $userAttributes = $request->validate([
            'account_type' => ['required'],
            'first_name'   => ['required'],
            'last_name'    => ['required'],
            'email'        => ['required', 'email', 'unique:users,email'],
            'password'     => ['required', 'confirmed', Password::min(6)],
        ]);

        $user = null;
        if ($userAttributes['account_type'] == 'teacher') {
            $user = Teacher::where('email', $userAttributes['email'])->first();
            $role = 'teacher';
        }
        if ($userAttributes['account_type'] == 'student') {
            $user = Student::where('email', $userAttributes['email'])->first();
            $role = 'student';

        }

        if ($user == null) {
            throw ValidationException::withMessages([
                'email' => 'The email you entered does not exist in our database',
            ]);
        }

        $name = $userAttributes['first_name'] . ' ' . $userAttributes['last_name'];
        $password = Hash::make($userAttributes['password']);
        $generated_token = Str::uuid();
        $token = Token::create([
            'token' => $generated_token,
            'data'  => json_encode([
                'name'     => $name,
                'email'    => $userAttributes['email'],
                'password' => $password,
                'role'     => $role,
            ], JSON_UNESCAPED_UNICODE),
            'purpose'    => 'ACCOUNT_ACTIVATION',
            'expiration' => Carbon::now()->addDays(3),
        ]);

        Mail::to($userAttributes['email'])->send(new ActivateAccountMail([
            'name'            => $name,
            'app_domain'      => env('APP_DOMAIN'),
            'app_url'         => env('APP_URL'),
            'activation_link' => env('APP_URL') . '/accounts/activate/' . $generated_token,
        ]));

        return redirect('/accounts/email_confirmation')->with([
            'confirm' => true,
        ]);
    }

    public function email_confirmation()
    {
        if(!session('confirm')) {
            return redirect('/');
        }
        return view('accounts.email-confirmation');
    }

    public function activate(Request $request, $token_value)
    {
        try {
            $token = Token::where('token', $token_value)->first();

            if(!$token) {
                throw ValidationException::withMessages([
                    'token' => 'Error: The token you provided is invalid or missing.',
                ]);
            }
            if(Carbon::today()->gte(Carbon::parse($token->expiration))) {
                throw ValidationException::withMessages([
                    'token' => 'Error: The provided token is incorrect or has expired.',
                ]);
            }

            $data = json_decode($token->data);

            DB::table('users')->insert([
                'name'       => $data->name,
                'email'      => $data->email,
                'password'   => $data->password,
                'role'       => $data->role,
                'created_at' => DB::raw('NOW()'),
                'updated_at' => DB::raw('NOW()'),
                'email_verified_at' => DB::raw('NOW()'),
            ]);

            $token->delete();

            return view('accounts.activate');

        } catch(Exception $e) {
            return view('accounts.activate', [
                'error' => $e->getMessage()
            ]);
        }
    }
}
