<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;

class PatronController extends Controller
{
    public function index()
    {
        $pdo = DB::connection()->getPdo();
        $_sql =
        "SELECT
            user_details.*,
            users.id AS user_id,
            (SELECT COUNT(*) FROM loaned_items WHERE status IN ('checked out') AND loaner_id = user_id) AS loans,
            (SELECT COUNT(*) FROM loaned_items WHERE status IN ('returned') AND loaner_id = user_id) AS returns,
            (SELECT COUNT(*) FROM requested_items WHERE status IN ('pending','for pickup') AND requester_id = user_id) AS requests
         FROM user_details
         INNER JOIN users
         ON user_details.email = users.email
         WHERE user_details.role IN('teacher','student')
         AND user_details.status
        ";

        $predicate = "IN ('active')";
        $sql = $_sql . $predicate;
        $query = $pdo->prepare($sql);
        $query->execute();
        $active_patrons = $query->fetchAll(PDO::FETCH_CLASS, 'stdClass');

        $predicate = "IN ('inactive')";
        $sql = $_sql . $predicate;
        $query = $pdo->prepare($sql);
        $query->execute();
        $inactive_patrons = $query->fetchAll(PDO::FETCH_CLASS, 'stdClass');

        return view('patrons.index', [
            'active_patrons'   => $active_patrons ?? [],
            'inactive_patrons' => $inactive_patrons ?? [],
        ]);
    }
}
