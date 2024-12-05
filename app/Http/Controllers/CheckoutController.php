<?php

namespace App\Http\Controllers;

use App\Mail\NotifyForPickupMail;
use App\Mail\NotifyOverdueMail;
use App\Models\Item;
use App\Models\Library;
use App\Models\LoanedItem;
use App\Models\RequestedItem;
use App\Models\User;
use App\Models\UserDetail;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PDO;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('checkouts.index');
    }

    public function find_barcode(Request $request)
    {
        try {
            $patron = UserDetail::where('card_number', $request->input('barcode'))->first();

            if ($patron) {
                $user = User::where('card_number', $request->input('barcode'))->first();
                $patron->user_id = $user->id;

                return response()->json([
                    'status'  => 'success',
                    'message' => 'Success',
                    'patron'  => $patron,
                ]);
            }

            $item = Item::where('barcode', $request->input('barcode'))->first();

            if ($item) {
                if($item->status=='checked out') {
                    $loaned_item =
                        LoanedItem::where('barcode', $item->barcode)
                            ->where('status','checked out')->first();
                    $item->loaner_id = $loaned_item->loaner_id;
                }

                if($item->status=='reserved') {
                    $requested_item =
                        RequestedItem::where('barcode', $item->barcode)
                            ->where('status','for pickup')->first();
                    $item->requester_id = $requested_item->requester_id;
                }

                return response()->json([
                    'status'  => 'success',
                    'message' => 'Success',
                    'item'    => $item,
                ]);
            }

            throw new Exception("Barcode not found");

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Patron or item not found',
        ]);
    }

    public function patron($card_number)
    {
        $patron = UserDetail::where('card_number', $card_number)->first();
        $user = User::where('email', $patron->email)->first();

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

        return view('checkouts.patron', [
            'patron'           => $patron,
            'user'             => $user,
            'pending_items'    => $pending_items ?? [],
            'for_pickup_items' => $for_pickup_items ?? [],
            'loaned_items'     => $loaned_items ?? [],
            'returned_items'   => $returned_items ?? [],
        ]);
    }

    public function reserve_item(Request $request)
    {
        try {
            $attributes = $request->validate([
                'barcode'      => ['required', 'string', 'exists:items,barcode'],
                'requester_id' => ['required', 'string', 'exists:users,id'],
            ]);

            $requested_item = RequestedItem::where('barcode', $attributes['barcode'])
                ->where('requester_id', $attributes['requester_id'])
                ->first();

            $requested_item->update([
                'status'   => 'for pickup',
                'due_date' => Carbon::now()->addDays(3),
            ]);

            $item = Item::where('barcode', $attributes['barcode'])->first();
            $item->update([
                'status'   => 'reserved',
            ]);

            $user    = User::where('id', $attributes['requester_id'])->first();
            $item    = Item::where('barcode', $attributes['barcode'])->first();
            $library = Library::where('code', $item->library)->first();
            $requested_item =
                RequestedItem::where('barcode', $attributes['barcode'])
                    ->where('status', 'for pickup')->first();

            Mail::to($user->email)->send(new NotifyForPickupMail([
                'name'     => $user->name,
                'title'    => $item->title,
                'deadline' => $requested_item->due_date,
                'sender'   => Auth::user()->name,
                'role'     => Auth::user()->role,
                'library'  => $library->name,
                'email'    => Auth::user()->email,
            ]));

            return response()->json([
                'status'  => 'success',
                'message' => 'Successfully reserved item for pickup',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function cancel_item(Request $request)
    {
        try {
            $attributes = $request->validate([
                'barcode'      => ['required', 'string', 'exists:items,barcode'],
                'requester_id' => ['required', 'string', 'exists:users,id'],
            ]);

            $item = RequestedItem::where('barcode', $attributes['barcode'])
                ->where('status', 'pending')
                ->where('requester_id', $attributes['requester_id'])
                ->first();

            $item->update([
                'status'   => 'cancelled',
                'due_date' => Carbon::now()->addDays(3),
            ]);

            $book = Item::where('barcode', $attributes['barcode'])->first();
            $book->update([
                'status'   => 'available',
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Successfully cancelled request for item',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function return_item(Request $request)
    {
        try {
            $attributes = $request->validate([
                'barcode'   => ['required', 'string', 'exists:items,barcode'],
                'loaner_id' => ['required', 'string', 'exists:users,id'],
            ]);

            $item = LoanedItem::where('barcode', $attributes['barcode'])
                ->where('loaner_id', $attributes['loaner_id'])
                ->where('status', 'checked out')
                ->first();

            $item->update([
                'status'        => 'returned',
                'date_returned' => Carbon::now(),
            ]);

            $book = Item::where('barcode', $attributes['barcode'])->first();
            $book->update([
                'status'   => 'available',
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Successfully returned the item',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function notify_overdue(Request $request)
    {
        try {
            $attributes = $request->validate([
                'barcode'   => ['required', 'string', 'exists:items,barcode'],
                'loaner_id' => ['required', 'string', 'exists:users,id'],
            ]);

            $user    = User::where('id', $attributes['loaner_id'])->first();
            $item    = Item::where('barcode', $attributes['barcode'])->first();
            $library = Library::where('code', $item->library)->first();
            $loaned_item =
                LoanedItem::where('barcode', $attributes['barcode'])
                    ->whereNull('date_returned')->first();

            Mail::to($user->email)->send(new NotifyOverdueMail([
                'name'     => $user->name,
                'title'    => $item->title,
                'due_date' => $loaned_item->due_date,
                'sender'   => Auth::user()->name,
                'role'     => Auth::user()->role,
                'library'  => $library->name,
                'email'    => Auth::user()->email,
            ]));

            return response()->json([
                'status'  => 'success',
                'message' => "Successfully notified <b class='text-capitalize'>". $user->name . "</b> to return the item",
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function notify_pickup(Request $request)
    {
        try {
            $attributes = $request->validate([
                'barcode'      => ['required', 'string', 'exists:items,barcode'],
                'requester_id' => ['required', 'string', 'exists:users,id'],
            ]);

            $user    = User::where('id', $attributes['requester_id'])->first();
            $item    = Item::where('barcode', $attributes['barcode'])->first();
            $library = Library::where('code', $item->library)->first();
            $requested_item =
                RequestedItem::where('barcode', $attributes['barcode'])
                    ->where('status', 'for pickup')->first();

            Mail::to($user->email)->send(new NotifyForPickupMail([
                'name'     => $user->name,
                'title'    => $item->title,
                'deadline' => $requested_item->due_date,
                'sender'   => Auth::user()->name,
                'role'     => Auth::user()->role,
                'library'  => $library->name,
                'email'    => Auth::user()->email,
            ]));

            return response()->json([
                'status'  => 'success',
                'message' => "Successfully notified <b class='text-capitalize'>". $user->name . "</b> to pickup the item",
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function renew_item(Request $request)
    {
        try {
            $attributes = $request->validate([
                'barcode'   => ['required', 'string', 'exists:items,barcode'],
                'loaner_id' => ['required', 'string', 'exists:users,id'],
            ]);

            $item = LoanedItem::where('barcode', $attributes['barcode'])
                ->where('loaner_id', $attributes['loaner_id'])
                ->first();

            $item->update([
                'due_date' => Carbon::now()->addDays(7),
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Successfully renewed the item',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function checkout_item(Request $request)
    {
        try {
            $attributes = $request->validate([
                'barcode'      => ['required', 'string', 'exists:items,barcode'],
                'requester_id' => ['required', 'string', 'exists:users,id'],
            ]);

            $requested_item = RequestedItem::where('barcode', $attributes['barcode'])
                ->where('requester_id', $attributes['requester_id'])
                ->where('status', 'for pickup')
                ->first();

            if($requested_item) {
                $requested_item->update([
                    'status' => 'checked out',
                ]);
            }

            $item = Item::where('barcode', $attributes['barcode'])->first();
            $item->update([
                'status'   => 'checked out',
            ]);

            LoanedItem::create([
                'type'        => $item->type,
                'barcode'     => $item->barcode,
                'date_loaned' => DB::raw('DATE(NOW())'),
                'due_date'    => DB::raw('DATE_ADD(DATE(NOW()), INTERVAL 1 WEEK)'),
                'loaner_id'   => $attributes['requester_id'],
                'status'      => 'checked out',
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Successfully checked out the item',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
