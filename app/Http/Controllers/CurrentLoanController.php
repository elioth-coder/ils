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
        $_sql =
        "SELECT
            books.*,
            loaned_items.status AS loan_status,
            loaned_items.date_loaned,
            loaned_items.date_returned,
            loaned_items.due_date,
            loaned_items.loaner_id
         FROM books
         INNER JOIN loaned_items
         ON books.barcode = loaned_items.barcode
         WHERE loaned_items.status
        ";

        $predicate = "IN ('checked out')";
        $sql = $_sql . $predicate;
        $query = $pdo->prepare($sql);
        $query->execute();
        $loaned_items = $query->fetchAll(PDO::FETCH_CLASS, 'stdClass');

        $loaned_items = collect($loaned_items)->map(function($item) {
            $patron = $this->getPatron($item);
            $item->patron = $patron;

            return $item;
        });

        $predicate = "IN ('returned')";
        $sql = $_sql . $predicate;
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
            'returned_items' => $returned_items ?? [],
        ]);
    }
}
