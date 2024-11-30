<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LibrarySectionController extends Controller
{

    private function getSectionsCount($section)
    {
        $sql =
        "SELECT COUNT(*) as `count` FROM `items` WHERE section=:section";

        $pdo = DB::connection()->getPdo();
        $query = $pdo->prepare($sql);
        $query->execute([
            'section' => $section,
        ]);
        $item = $query->fetchObject('stdClass');

        return $item->count;
    }

    public function index()
    {
        $count = [
            'circulation'  => $this->getSectionsCount('circulation'),
            'filipiniana'  => $this->getSectionsCount('filipiniana'),
            'periodical'   => $this->getSectionsCount('periodical'),
            'reference'    => $this->getSectionsCount('reference'),
            'e-library'    => $this->getSectionsCount('e-library'),
            'audio-visual' => $this->getSectionsCount('audio-visual'),
            'thesis'       => $this->getSectionsCount('thesis'),
        ];

        return view('sections.index',[
            'count' => $count,
        ]);
    }

    public function section($section)
    {
        $items = Item::where('section', $section)->get();

        return view('sections.section',[
            'items'    => $items,
            'selected' => $section,
        ]);
    }
}
