<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        try {
            $attributes = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if (!Auth::attempt($attributes)) {
                throw ValidationException::withMessages([
                    'credential' => 'Incorrect username or password',
                ]);
            }

            $request->session()->regenerate();

            return response()->json([
                'status'  => 'success',
                'message' => 'Successfully logged in',
            ]);
        } catch(Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function destroy()
    {
        Auth::logout();

        return response()->json([
            'status' => 'success',
        ]);
    }
}
