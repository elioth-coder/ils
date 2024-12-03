<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;

class ToolController extends Controller
{

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
