<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\LoanedItem;
use App\Models\RequestedItem;
use App\Models\Teacher;
use App\Models\User;
use App\Models\UserDetail;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

            $item = Book::where('barcode', $request->input('barcode'))->first();

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
                            ->where('status','reserved')->first();
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
        "SELECT books.*, requested_items.status AS request_status, requested_items.date_requested, requested_items.due_date
         FROM books
         INNER JOIN requested_items
         ON books.barcode = requested_items.barcode
         WHERE requested_items.requester_id=:requester_id
         AND requested_items.status=:status
        ";
        $query = $pdo->prepare($sql);
        $query->execute([
            'requester_id' => $user->id,
            'status' => 'pending',
        ]);
        $pending_books = $query->fetchAll(PDO::FETCH_CLASS, 'stdClass');

        $query = $pdo->prepare($sql);
        $query->execute([
            'requester_id' => $user->id,
            'status' => 'for pickup',
        ]);
        $for_pickup_books = $query->fetchAll(PDO::FETCH_CLASS, 'stdClass');

        $sql =
        "SELECT books.*, loaned_items.status AS loan_status, loaned_items.date_loaned, loaned_items.due_date, loaned_items.date_returned
         FROM books
         INNER JOIN loaned_items
         ON books.barcode = loaned_items.barcode
         WHERE loaned_items.loaner_id=:loaner_id
         AND loaned_items.status=:status
        ";
        $query = $pdo->prepare($sql);
        $query->execute([
            'loaner_id' => $user->id,
            'status' => 'checked out',
        ]);
        $loaned_books = $query->fetchAll(PDO::FETCH_CLASS, 'stdClass');

        $query = $pdo->prepare($sql);
        $query->execute([
            'loaner_id' => $user->id,
            'status' => 'returned',
        ]);
        $returned_books = $query->fetchAll(PDO::FETCH_CLASS, 'stdClass');

        return view('checkouts.patron', [
            'patron'           => $patron,
            'user'             => $user,
            'pending_books'    => $pending_books ?? [],
            'for_pickup_books' => $for_pickup_books ?? [],
            'loaned_books'     => $loaned_books ?? [],
            'returned_books'   => $returned_books ?? [],
        ]);
    }

    public function reserve_item(Request $request)
    {
        try {
            $attributes = $request->validate([
                'barcode'      => ['required', 'string', 'exists:books,barcode'],
                'requester_id' => ['required', 'string', 'exists:users,id'],
            ]);

            $item = RequestedItem::where('barcode', $attributes['barcode'])
                ->where('requester_id', $attributes['requester_id'])
                ->first();

            $item->update([
                'status'   => 'for pickup',
                'due_date' => Carbon::now()->addDays(3),
            ]);

            $book = Book::where('barcode', $attributes['barcode'])->first();
            $book->update([
                'status'   => 'reserved',
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Successfully reserved/prepared item for pickup',
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
                'barcode'      => ['required', 'string', 'exists:books,barcode'],
                'requester_id' => ['required', 'string', 'exists:users,id'],
            ]);

            $item = RequestedItem::where('barcode', $attributes['barcode'])
                ->where('requester_id', $attributes['requester_id'])
                ->first();

            $item->update([
                'status'   => 'cancelled',
                'due_date' => Carbon::now()->addDays(3),
            ]);

            $book = Book::where('barcode', $attributes['barcode'])->first();
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
                'barcode'   => ['required', 'string', 'exists:books,barcode'],
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

            $book = Book::where('barcode', $attributes['barcode'])->first();
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

    public function renew_item(Request $request)
    {
        try {
            $attributes = $request->validate([
                'barcode'   => ['required', 'string', 'exists:books,barcode'],
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
                'barcode'      => ['required', 'string', 'exists:books,barcode'],
                'requester_id' => ['required', 'string', 'exists:users,id'],
            ]);

            $requested_item = RequestedItem::where('barcode', $attributes['barcode'])
                ->where('requester_id', $attributes['requester_id'])
                ->where('status', 'reserved')
                ->first();

            if($requested_item) {
                $requested_item->update([
                    'status' => 'checked out',
                ]);
            }

            $book = Book::where('barcode', $attributes['barcode'])->first();
            $book->update([
                'status'   => 'checked out',
            ]);

            LoanedItem::create([
                'type' => $requested_item->type,
                'barcode' => $requested_item->barcode,
                'date_loaned' => DB::raw('DATE(NOW())'),
                'due_date' => DB::raw('DATE_ADD(DATE(NOW()), INTERVAL 1 WEEK)'),
                'loaner_id' => $requested_item->requester_id,
                'status' => 'checked out',
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
