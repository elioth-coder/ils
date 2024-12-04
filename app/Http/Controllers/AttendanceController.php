<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use App\Models\UserDetail;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $attendances = Attendance::whereDate('in', $today)->orderBy('updated_at','DESC')->limit(10)->get();

        return view('attendance.index', [
            'attendances' => $attendances,
        ]);
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

            $patron     = UserDetail::where('card_number', $card_number)->first();
            $attendance = Attendance::where('card_number', $card_number)->whereNull('out')->first();
            $type = "entry";

            if($attendance) {
                $type = "exit";
                $attendance->update([
                    'out' => Carbon::now(),
                ]);
            } else {
                Attendance::create([
                    'card_number' => $card_number,
                    'name'    => $name,
                    'role'    => $role,
                    'program' => ($role == 'student') ? $patron->program : 'FACULTY',
                    'in' => Carbon::now(),
                ]);
            }

            return response()->json([
                'status'  => 'success',
                'message' => "Successfully recorded $type to the library",
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
