<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ReportedItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDO;

class ReportItemController extends Controller
{
    private function getReporter($item) {
        $sql =
        "SELECT
            user_details.*,
            users.id AS user_id
        FROM user_details
        INNER JOIN users
        ON user_details.email = users.email
        WHERE users.id = :user_id
        ";

        $pdo = DB::connection()->getPdo();
        $query = $pdo->prepare($sql);
        $query->execute([
            'user_id' => $item->reporter_id,
        ]);
        $reporter = $query->fetchObject('stdClass');

        return $reporter;
    }

    public function index()
    {
        $pdo = DB::connection()->getPdo();
        $sql =
        "SELECT * FROM items
         WHERE status NOT IN ('missing','damaged','archived')
        ";

        $query = $pdo->prepare($sql);
        $query->execute();
        $items = $query->fetchAll(PDO::FETCH_CLASS, 'stdClass');

        $sql =
        "SELECT items.*,
            reported_items.details,
            reported_items.created_at AS date_reported,
            reported_items.reporter_id
         FROM items
         INNER JOIN reported_items
         ON items.id = reported_items.item_id
        ";

        $query = $pdo->prepare($sql);
        $query->execute();
        $reported_items = $query->fetchAll(PDO::FETCH_CLASS, 'stdClass');

        $reported_items = collect($reported_items)->map(function($item) {
            $reporter = $this->getReporter($item);
            $item->reporter = $reporter;

            return $item;
        });

        return view('report_item.index', [
            'items' => $items ?? [],
            'reported_items' => $reported_items ?? [],
        ]);
    }

    public function create($id)
    {
        $selected = Item::findOrFail($id);

        return view('report_item.create', [
            'selected' => $selected
        ]);
    }

    public function store(Request $request, $id)
    {
        $attributes = $request->validate([
            'item_id' => ['required','unique:reported_items,item_id'],
            'barcode' => ['required','unique:reported_items,barcode'],
            'status'  => ['required'],
            'details' => ['required'],
        ]);

        $attributes['reporter_id'] = Auth::user()->id;

        $item = ReportedItem::create($attributes);
        $selected = Item::findOrFail($attributes['item_id']);

        $selected->update([
            'status' => $attributes['status'],
        ]);

        return redirect('/services/report_item')->with([
            'message' => "Successfully reported the item."
        ]);
    }
}
