<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;

class ItemRequestController extends Controller
{
    private function getPatron($item) {
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
            'user_id' => $item->requester_id,
        ]);
        $patron = $query->fetchObject('stdClass');

        return $patron;
    }

    public function index()
    {
        $pdo = DB::connection()->getPdo();
        $_sql =
        "SELECT
            items.*,
            requested_items.status AS request_status,
            requested_items.date_requested,
            requested_items.due_date,
            requested_items.requester_id
         FROM items
         INNER JOIN requested_items
         ON items.barcode = requested_items.barcode
         WHERE requested_items.status
        ";
        $order_by = "ORDER BY requested_items.created_at DESC ";

        $predicate = "IN ('pending') ";
        $sql = $_sql . $predicate . $order_by;
        $query = $pdo->prepare($sql);
        $query->execute();
        $pending_items = $query->fetchAll(PDO::FETCH_CLASS, 'stdClass');

        $pending_items = collect($pending_items)->map(function($item) {
            $patron = $this->getPatron($item);
            $item->patron = $patron;

            return $item;
        });

        $predicate = "IN ('for pickup') ";
        $sql = $_sql . $predicate . $order_by;
        $query = $pdo->prepare($sql);
        $query->execute();
        $for_pickup_items = $query->fetchAll(PDO::FETCH_CLASS, 'stdClass');

        $for_pickup_items = collect($for_pickup_items)->map(function($item) {
            $patron = $this->getPatron($item);
            $item->patron = $patron;

            return $item;
        });

        $predicate = "IN ('cancelled') ";
        $sql = $_sql . $predicate . $order_by;
        $query = $pdo->prepare($sql);
        $query->execute();
        $cancelled_items = $query->fetchAll(PDO::FETCH_CLASS, 'stdClass');

        $cancelled_items = collect($cancelled_items)->map(function($item) {
            $patron = $this->getPatron($item);
            $item->patron = $patron;

            return $item;
        });

        return view('item_requests.index', [
            'pending_items' => $pending_items ?? [],
            'for_pickup_items' => $for_pickup_items ?? [],
            'cancelled_items' => $cancelled_items ?? [],
        ]);
    }
}
