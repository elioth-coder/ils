<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;

class NotificationController extends Controller
{
    private function getRequestCount()
    {
        $sql =
        "SELECT COUNT(*) AS `count`
        FROM requested_items WHERE `status` IN ('pending','for pickup')";

        $pdo = DB::connection()->getPdo();
        $query = $pdo->prepare($sql);
        $query->execute();
        $item = $query->fetchObject('stdClass');

        return $item->count;
    }

    private function getLoanCount()
    {
        $sql =
        "SELECT COUNT(*) AS `count`
        FROM items WHERE `status` IN ('checked out')";

        $pdo = DB::connection()->getPdo();
        $query = $pdo->prepare($sql);
        $query->execute();
        $item = $query->fetchObject('stdClass');

        return $item->count;
    }

    public function library_services()
    {
        $request_count = $this->getRequestCount();
        $loan_count    = $this->getLoanCount();

        return response()->json([
            'status' => 'success',
            'request_count' => $request_count,
            'loan_count' => $loan_count,
        ]);
    }
}
