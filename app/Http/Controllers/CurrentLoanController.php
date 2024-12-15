<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;

class CurrentLoanController extends Controller
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
            'user_id' => $item->loaner_id,
        ]);
        $patron = $query->fetchObject('stdClass');

        return $patron;
    }

    public function index()
    {
        $pdo = DB::connection()->getPdo();
        $sql =
        "SELECT
            items.*,
            loaned_items.status AS loan_status,
            loaned_items.date_loaned,
            loaned_items.date_returned,
            loaned_items.due_date,
            loaned_items.loaner_id
         FROM items
         INNER JOIN loaned_items
         ON items.barcode = loaned_items.barcode
         WHERE loaned_items.status = 'checked out'
         AND DATE(loaned_items.due_date) <= DATE(NOW())
        ";
        $order_by = "ORDER BY loaned_items.created_at DESC ";

        $query = $pdo->prepare($sql . $order_by);
        $query->execute();
        $overdue_items = $query->fetchAll(PDO::FETCH_CLASS, 'stdClass');

        $overdue_items = collect($overdue_items)->map(function($item) {
            $patron = $this->getPatron($item);
            $item->patron = $patron;

            return $item;
        });

        $_sql =
        "SELECT
            items.*,
            loaned_items.status AS loan_status,
            loaned_items.date_loaned,
            loaned_items.date_returned,
            loaned_items.due_date,
            loaned_items.loaner_id
         FROM items
         INNER JOIN loaned_items
         ON items.barcode = loaned_items.barcode
         WHERE loaned_items.status
        ";

        $predicate = "IN ('checked out') AND DATE(loaned_items.due_date) > DATE(NOW()) ";
        $sql = $_sql . $predicate . $order_by;
        $query = $pdo->prepare($sql);
        $query->execute();
        $loaned_items = $query->fetchAll(PDO::FETCH_CLASS, 'stdClass');

        $loaned_items = collect($loaned_items)->map(function($item) {
            $patron = $this->getPatron($item);
            $item->patron = $patron;

            return $item;
        });

        $predicate = "IN ('returned') ";
        $sql = $_sql . $predicate . $order_by;
        $query = $pdo->prepare($sql);
        $query->execute();
        $returned_items = $query->fetchAll(PDO::FETCH_CLASS, 'stdClass');

        $returned_items = collect($returned_items)->map(function($item) {
            $patron = $this->getPatron($item);
            $item->patron = $patron;

            return $item;
        });

        return view('current_loans.index', [
            'loaned_items'   => $loaned_items ?? [],
            'overdue_items'  => $overdue_items ?? [],
            'returned_items' => $returned_items ?? [],
        ]);
    }
}
