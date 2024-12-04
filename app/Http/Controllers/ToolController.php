<?php

namespace App\Http\Controllers;

use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;

class ToolController extends Controller
{
    public function csv_import()
    {
        return view('tools.csv_import');
    }

    public function id_card_print(Request $request)
    {
        $card_numbers = $request->input('card_numbers', []);
        $patrons = UserDetail::whereIn('card_number', $card_numbers)->get();

        return view('tools.id_card_print', [
            'patrons' => $patrons,
        ]);
    }

    public function id_card_maker()
    {
        $patrons = UserDetail::all();

        return view('tools.id_card_maker', [
            'patrons' => $patrons,
        ]);
    }

    public function barcode_maker()
    {
        $sql =
        "SELECT *
        FROM items
        WHERE status='no barcode' AND barcode IS NOT NULL";

        $pdo = DB::connection()->getPdo();
        $query = $pdo->prepare($sql);
        $query->execute();
        $items = $query->fetchAll(PDO::FETCH_CLASS, 'stdClass');

        return view('tools.barcode_maker', [
            'items' => $items
        ]);
    }

    public function barcode_print()
    {
        $sql =
        "SELECT *
        FROM items
        WHERE status='no barcode' AND barcode IS NOT NULL";

        $pdo = DB::connection()->getPdo();
        $query = $pdo->prepare($sql);
        $query->execute();
        $items = $query->fetchAll(PDO::FETCH_CLASS, 'stdClass');

        return view('tools.barcode_print', [
            'items' => $items
        ]);
    }

}
