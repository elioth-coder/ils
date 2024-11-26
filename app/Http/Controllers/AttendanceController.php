<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use App\Models\UserDetail;
use Exception;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        return view('attendance.index');
    }

    public function find_barcode(Request $request)
    {
        try {
            $patron = User::where('card_number', $request->input('barcode'))->first();

            if ($patron) {
                $patron->details = UserDetail::where('card_number', $request->input('barcode'))->first();
                return response()->json([
                    'status'  => 'success',
                    'message' => 'Success',
                    'patron'  => $patron,
                ]);
            }

            throw new Exception("Card No. not found");

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Card No. not found',
        ]);
    }

    public function record(Request $request)
    {
        try {
            $card_number = $request->input('card_number');
            $name = $request->input('name');
            $role = $request->input('role');

            Attendance::create([
                'card_number' => $card_number,
                'name' => $name,
                'role' => $role,
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Successfully recorded the attendance',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
