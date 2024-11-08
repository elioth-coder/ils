<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Library;
use App\Models\LoanedItem;
use App\Models\RequestedItem;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function request(Request $request)
    {
        try {
            $attributes = $request->validate([
                'barcode' => ['required', 'string', 'exists:items,barcode'],
            ]);

            $item = RequestedItem::where('barcode', $attributes['barcode'])
                ->where('requester_id', Auth::user()->id)
                ->whereIn('status', ['pending','for pickup'])
                ->first();

            if($item) {
                throw new Exception('You already have a pending request for this item');
            }

            RequestedItem::create([
                'type'           => 'book',
                'barcode'        => $attributes['barcode'],
                'date_requested' => DB::raw('DATE(NOW())'),
                'requester_id'   => Auth::user()->id,
                'status'         => 'pending',
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Successfully requested item',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function cancel_request(Request $request)
    {
        try {
            $attributes = $request->validate([
                'barcode' => ['required', 'string', 'exists:items,barcode'],
            ]);

            $requested_item = RequestedItem::where('barcode', $attributes['barcode'])->first();
            $requested_item->delete();

            $book = Item::where('barcode', $attributes['barcode'])->first();
            $book->update([
                'status' => 'available',
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Successfully cancelled request',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function detail($title)
    {
        $libraries = Library::all();

        $item  = Item::where('title', $title)->first();
        $items = Item::where('title', $title)->get();
        $item->copies = count($items);

        $items->map(function ($item) {
            $library = Library::where('code', $item->library)->first();
            $item->library_name = $library->name;

            if($item->status=='checked out') {
                $loaned_item =
                    LoanedItem::whereNull('date_returned')
                        ->where('status', 'checked out')
                        ->where('barcode', $item->barcode)
                        ->first();

                $item->loaned_by = User::where('id', $loaned_item->loaner_id)->first();
            }
            if($item->status=='reserved') {
                $requested_item =
                    RequestedItem::where('status', 'for pickup')
                        ->where('barcode', $item->barcode)
                        ->first();

                $item->reserved_for = User::where('id', $requested_item->requester_id)->first();
            }

            $item->requests =
                RequestedItem::where('status', 'pending')
                    ->where('barcode', $item->barcode)
                    ->get();

            return $item;
        });

        $libraries->map(function ($library) use ($items) {
            $library->items = $items->filter(function ($item) use ($library) {
                return $item->library == $library->code;
            });
        });

        return view('items.detail', [
            'item'  => $item,
            'libraries' => $libraries,
        ]);
    }

    public function barcode($title, $barcode)
    {
        $item = Item::where('barcode', $barcode)->first();
        $library = Library::where('code', $item->library)->first();
        $item->library = $library;

        $item_patrons =
            LoanedItem::join('users', 'loaned_items.loaner_id', '=', 'users.id')
                ->join('user_details', 'users.card_number', '=', 'user_details.card_number')
                ->select(
                    'users.*',
                    'user_details.*',
                    'loaned_items.*',
                    'users.id as user_id',
                    'user_details.id as user_detail_id'
                )
                ->where('loaned_items.barcode', $barcode)
                ->whereIn('loaned_items.status', ['returned','checked out'])
                ->orderBy('loaned_items.date_loaned', 'desc')
                ->get();

        $item_requests =
            RequestedItem::join('users', 'requested_items.requester_id', '=', 'users.id')
                ->join('user_details', 'users.card_number', '=', 'user_details.card_number')
                ->select(
                    'users.*',
                    'user_details.*',
                    'requested_items.*',
                    'users.id as user_id',
                    'user_details.id as user_detail_id'
                )
                ->where('requested_items.barcode', $barcode)
                ->whereIn('requested_items.status', ['pending','for pickup'])
                ->orderBy('requested_items.date_requested', 'desc')
                ->get();


        if($item->status=='checked out') {
            $loaned_item =
                LoanedItem::whereNull('date_returned')
                    ->where('status', 'checked out')
                    ->where('barcode', $item->barcode)
                    ->first();

            $item->loaned_by = User::where('id', $loaned_item->loaner_id)->first();
        }
        if($item->status=='reserved') {
            $requested_item =
                RequestedItem::where('status', 'for pickup')
                    ->where('barcode', $item->barcode)
                    ->first();

            $item->reserved_for = User::where('id', $requested_item->requester_id)->first();
        }

        $item->requests =
            RequestedItem::where('status', 'pending')
                ->where('barcode', $item->barcode)
                ->get();

        return view('items.barcode', [
            'item' => $item,
            'item_patrons' => $item_patrons,
            'item_requests' => $item_requests,
        ]);
    }
}
