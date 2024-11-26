<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;

class CollectionController extends Controller
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

    public function index()
    {
        $books_count    = $this->getCollectionsCount(type: 'book');
        $research_count = $this->getCollectionsCount(type: 'research');
        $audios_count   = $this->getCollectionsCount(type: 'audios');
        $videos_count   = $this->getCollectionsCount(type: 'videos');
        $items = $this->getNewCollections();
        $new_collections_count = count($items ?? []);


        return view('collections.index', [
            'books_count'    => $books_count,
            'research_count' => $research_count,
            'audios_count'   => $audios_count,
            'videos_count'   => $videos_count,
            'new_collections_count' => $new_collections_count,
        ]);
    }

    public function new()
    {
        $items = $this->getNewCollections();

        return view('collections.new', [
            'items' => $items,
        ]);
    }

    public function new_with_type($type)
    {
        $filtered_items = $this->getNewCollections($type);
        $items = $this->getNewCollections();

        return view('collections.new_with_type', [
            'filtered_items' => $filtered_items,
            'items' => $items,
            'type'  => $type,
        ]);
    }
}
