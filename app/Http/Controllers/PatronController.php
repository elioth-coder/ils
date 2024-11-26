<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;

class PatronController extends Controller
{
    public function index()
    {
        return view('patrons.index');
    }

    public function services()
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
         LEFT JOIN users
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

        return view('patrons.services', [
            'active_patrons'   => $active_patrons ?? [],
            'inactive_patrons' => $inactive_patrons ?? [],
        ]);
    }

    public function visited()
    {
        $pdo = DB::connection()->getPdo();
        $pdo->exec("SET SESSION sql_mode = (SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''))");

        $sql =
        "SELECT user_details.*, COUNT(user_details.id) AS visit_count
         FROM user_details
         INNER JOIN attendances
         ON user_details.card_number = attendances.card_number
         WHERE MONTH(attendances.created_at) = MONTH(CURDATE())
         AND YEAR(attendances.created_at) = YEAR(CURDATE())
         GROUP BY user_details.card_number
        ";

        $query = $pdo->prepare($sql);
        $query->execute();
        $patrons = $query->fetchAll(PDO::FETCH_CLASS, 'stdClass');

        return view('patrons.visited', [
            'patrons'   => $patrons ?? [],
        ]);
    }
}
