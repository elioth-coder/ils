<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Token;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\College;
use App\Models\Campus;
use App\Models\Library;
use App\Models\RequestedItem;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Mail\ActivateAccountMail;
use App\Models\UserDetail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;

use Exception;
use PDO;

class AccountController extends Controller
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
        $patron = UserDetail::where('card_number', Auth::user()->card_number)->first();
        $user   = User::where('email', $patron->email)->first();

        $patron->user_id = $user->id;
        $birth_date   = Carbon::parse($patron->birthday);
        $current_date = Carbon::now();
        $age = $birth_date->diffInYears($current_date);
        $patron->age = (int) $age;

        $pdo = DB::connection()->getPdo();
        $sql =
        "SELECT items.*, requested_items.status AS request_status, requested_items.date_requested, requested_items.due_date
         FROM items
         INNER JOIN requested_items
         ON items.barcode = requested_items.barcode
         WHERE requested_items.requester_id=:requester_id
         AND requested_items.status=:status
        ";
        $query = $pdo->prepare($sql);
        $query->execute([
            'requester_id' => $user->id,
            'status' => 'pending',
        ]);
        $pending_items = $query->fetchAll(PDO::FETCH_CLASS, 'stdClass');

        $query = $pdo->prepare($sql);
        $query->execute([
            'requester_id' => $user->id,
            'status' => 'for pickup',
        ]);
        $for_pickup_items = $query->fetchAll(PDO::FETCH_CLASS, 'stdClass');

        $sql =
        "SELECT items.*, loaned_items.status AS loan_status, loaned_items.date_loaned, loaned_items.due_date, loaned_items.date_returned
         FROM items
         INNER JOIN loaned_items
         ON items.barcode = loaned_items.barcode
         WHERE loaned_items.loaner_id=:loaner_id
         AND loaned_items.status=:status
        ";
        $query = $pdo->prepare($sql);
        $query->execute([
            'loaner_id' => $user->id,
            'status' => 'checked out',
        ]);
        $loaned_items = $query->fetchAll(PDO::FETCH_CLASS, 'stdClass');

        $query = $pdo->prepare($sql);
        $query->execute([
            'loaner_id' => $user->id,
            'status' => 'returned',
        ]);
        $returned_items = $query->fetchAll(PDO::FETCH_CLASS, 'stdClass');

        return view('account.index', [
            'patron'           => $patron,
            'user'             => $user,
            'pending_items'    => $pending_items ?? [],
            'for_pickup_items' => $for_pickup_items ?? [],
            'loaned_items'     => $loaned_items ?? [],
            'returned_items'   => $returned_items ?? [],
        ]);
    }

    public function edit()
    {
        $user      = UserDetail::where('email', Auth::user()->email)->first();
        $libraries = Library::latest()->get();

        return view('account.edit', [
            'user'           => $user,
            'suffixes'       => $this->suffixes,
            'genders'        => $this->genders,
            'libraries'      => $libraries,
            'statuses'       => $this->statuses,
        ]);
    }

    public function update(Request $request)
    {
        $rules = [
            'first_name'      => ['required', 'string', 'max:255'],
            'middle_name'     => ['nullable', 'string', 'max:255'],
            'last_name'       => ['required', 'string', 'max:255'],
            'suffix'          => ['nullable', 'string', 'max:255'],
            'gender'          => ['required', 'in:male,female'],
            'province'        => ['nullable', 'string', 'max:255'],
            'municipality'    => ['nullable', 'string', 'max:255'],
            'barangay'        => ['nullable', 'string', 'max:255'],
            'mobile_number'   => ['nullable', 'string', 'max:255'],
            'file'            => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
        $attributes = $request->validate($rules);

        $user_detail = UserDetail::where('email', Auth::user()->email)->first();
        $user_detail->update($attributes);

        if(!empty($attributes['file'])) {
            $manager = ImageManager::gd();
            $image = $manager->read($request->file('file'));
            $image->scale(height: 225);

            $image->crop(225, 225, position: 'center');
        }

        if(!empty($image)) {
            $path = "public/images/users";
            Storage::makeDirectory($path);
            $path .= "/$user_detail->card_number.png";
            Storage::put($path, (string) $image->encode());

            $user_detail->profile = $user_detail->card_number . ".png";
            $user_detail->save();
        }

        $user = User::where('email', Auth::user()->email)->first();
        $user->update([
            'name' => $user_detail->first_name . " " . $user_detail->last_name,
        ]);

        return redirect('account/edit')->with([
            'message' => [
                'type'    => 'success',
                'content' => "Successfully updated your profile"
            ]
        ]);
    }

    public function change_password()
    {
        return view('account.change_password');
    }

    public function update_password(Request $request)
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

            return redirect('/account/change_password')->with([
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
        return view('account.register');
    }

    public function store(Request $request)
    {
        $userAttributes = $request->validate([
            'first_name'   => ['required'],
            'last_name'    => ['required'],
            'email'        => ['required', 'email', 'unique:users,email'],
            'password'     => ['required', 'confirmed', Password::min(6)],
        ]);

        $user = UserDetail::where('email', $userAttributes['email'])->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => 'The email you entered does not exist in our database',
            ]);
        }

        $name = $userAttributes['first_name'] . ' ' . $userAttributes['last_name'];
        $password = Hash::make($userAttributes['password']);
        $generated_token = Str::uuid();
        Token::create([
            'token' => $generated_token,
            'data'  => json_encode([
                'name'        => $name,
                'email'       => $userAttributes['email'],
                'password'    => $password,
                'role'        => $user->role,
                'card_number' => $user->card_number,
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

        return redirect('/account/email_confirmation')->with([
            'confirm' => true,
        ]);
    }

    public function email_confirmation()
    {
        if(!session('confirm')) {
            return redirect('/');
        }
        return view('account.email_confirmation');
    }

    public function activate($token_value)
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
                'name'        => $data->name,
                'email'       => $data->email,
                'password'    => $data->password,
                'role'        => $data->role,
                'card_number' => $data->card_number,
                'created_at'  => DB::raw('NOW()'),
                'updated_at'  => DB::raw('NOW()'),
                'email_verified_at' => DB::raw('NOW()'),
            ]);

            $token->delete();

            return view('account.activate');

        } catch(Exception $e) {
            return view('account.activate', [
                'error' => $e->getMessage()
            ]);
        }
    }
}
