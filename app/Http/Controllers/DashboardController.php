<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;
use stdClass;

class DashboardController extends Controller
{
    private function getCollectionsCount($type = '', $status = '')
    {
        $sql =
        "SELECT COUNT(*) as `count` FROM `items` WHERE 1 ";

        if($type) {
            $sql .= "AND type='$type'";
        }

        if($status) {
            $sql .= "AND status='$status'";
        }

        $pdo = DB::connection()->getPdo();
        $query = $pdo->prepare($sql);
        $query->execute();
        $item = $query->fetchObject('stdClass');

        return $item->count;
    }

    private function getPatronCountPerProgram()
    {
        $sql =
        "SELECT COUNT(*) as `count`, `program` FROM `user_details` WHERE `status`='active' AND `program` IS NOT NULL AND `role`='student' GROUP BY `program`";

        $pdo = DB::connection()->getPdo();
        $query = $pdo->prepare($sql);
        $query->execute();
        $items = $query->fetchAll(PDO::FETCH_CLASS, 'stdClass');

        return $items;
    }

    private function getPatronCount($role = '')
    {
        $sql =
        "SELECT COUNT(*) as `count` FROM `user_details` WHERE status='active' AND role IN('student','teacher') ";

        if($role) {
            $sql .= "AND role='$role'";
        }

        $pdo = DB::connection()->getPdo();
        $query = $pdo->prepare($sql);
        $query->execute();
        $item = $query->fetchObject('stdClass');

        return $item->count;
    }

    private function getVisitorCount()
    {
        $sql =
        "SELECT DISTINCT card_number
        FROM attendances
        WHERE MONTH(created_at) = MONTH(CURDATE())
        AND YEAR(created_at) = YEAR(CURDATE())
        ";

        $pdo = DB::connection()->getPdo();
        $query = $pdo->prepare($sql);
        $query->execute();
        $items = $query->fetchAll(PDO::FETCH_CLASS, 'stdClass');

        return count($items);

    }

    private function getNewCheckouts()
    {
        $sql =
        "SELECT *
        FROM loaned_items
        WHERE status = 'checked out'
        AND MONTH(date_loaned) = MONTH(CURDATE())
        AND YEAR(date_loaned) = YEAR(CURDATE())";

        $pdo = DB::connection()->getPdo();
        $query = $pdo->prepare($sql);
        $query->execute();
        $items = $query->fetchAll(PDO::FETCH_CLASS, 'stdClass');

        return $items;
    }

    private function getNewRequests()
    {
        $sql =
        "SELECT *
        FROM requested_items
        WHERE MONTH(date_requested) = MONTH(CURDATE())
        AND YEAR(date_requested) = YEAR(CURDATE())";

        $pdo = DB::connection()->getPdo();
        $query = $pdo->prepare($sql);
        $query->execute();
        $items = $query->fetchAll(PDO::FETCH_CLASS, 'stdClass');

        return $items;
    }

    private function getNewCollections($type = '')
    {
        $sql =
        "SELECT *
        FROM items
        WHERE MONTH(date_acquired) = MONTH(CURDATE())
        AND YEAR(date_acquired) = YEAR(CURDATE()) ";

        if($type) {
            $sql .= "AND type = '$type'";
        }

        $pdo = DB::connection()->getPdo();
        $query = $pdo->prepare($sql);
        $query->execute();
        $items = $query->fetchAll(PDO::FETCH_CLASS, 'stdClass');

        return $items;
    }

    private function getTopCollections()
    {
        $sql =
        "SELECT COUNT(`items`.`id`) AS `count`, `items`.*
        FROM `loaned_items`
        INNER JOIN `items`
        ON `loaned_items`.`barcode`=`items`.`barcode`
        GROUP BY `items`.`title`
        ORDER BY `count` DESC
        LIMIT 5";

        $pdo = DB::connection()->getPdo();
        $pdo->exec("SET SESSION sql_mode = (SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''))");
        $query = $pdo->prepare($sql);
        $query->execute();
        $items = $query->fetchAll(PDO::FETCH_CLASS, 'stdClass');

        return $items;
    }

    public function index()
    {
        $new_checkouts   = $this->getNewCheckouts();
        $new_requests    = $this->getNewRequests();
        $top_collections = $this->getTopCollections();
        $new_collections = $this->getNewCollections();
        $visitor_count   = $this->getVisitorCount();
        $new_books       = $this->getNewCollections('book');
        $new_researches  = $this->getNewCollections('research');
        $new_audios      = $this->getNewCollections('audio');
        $new_videos      = $this->getNewCollections('video');

        $patron_count      = $this->getPatronCount();
        $faculty_count     = $this->getPatronCount('teacher');
        $collections_count = $this->getCollectionsCount();
        $on_loan_count     = $this->getCollectionsCount(status: 'checked out');
        $on_reserve_count  = $this->getCollectionsCount(status: 'reserved');
        $available_count   = $this->getCollectionsCount(status: 'available');

        $patrons_per_program = $this->getPatronCountPerProgram();

        $object = new stdClass();
        $object->count = $faculty_count;
        $object->program = 'FACULTY';
        $patrons_per_program[] = $object;

        return view('dashboard.index', [
            'patrons_per_program' => $patrons_per_program,
            'patron_count'        => $patron_count,
            'collections_count'   => $collections_count,
            'on_loan_count'       => $on_loan_count,
            'on_reserve_count'    => $on_reserve_count,
            'available_count'     => $available_count,

            'top_collections' => $top_collections ?? [],
            'new_collections' => $new_collections ?? [],
            'new_books'       => $new_books ?? [],
            'new_researches'  => $new_researches ?? [],
            'new_audios'      => $new_audios ?? [],
            'new_videos'      => $new_videos ?? [],
            'new_checkouts'   => $new_checkouts ?? [],
            'new_requests'    => $new_requests ?? [],
            'visitor_count'   => $visitor_count ?? [],
        ]);
    }
}
