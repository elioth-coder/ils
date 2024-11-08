<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Library;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDO;

class SearchController extends Controller
{

    public $genres = [
        'fiction',
        'non-fiction',
        'mystery',
        'thriller',
        'science fiction',
        'fantasy',
        'romance',
        'horror',
        'biography',
        'autobiography',
        'history',
        'philosophy',
        'science',
        'self-help',
        'health & wellness',
        'travel',
        'children’s',
        'young adult',
        'graphic novel',
        'poetry',
        'drama',
        'classic',
        'adventure',
        'crime',
        'cooking',
        'art',
        'business',
        'comics',
        'humor',
        'religious',
        'short stories',
    ];

    public $statuses = [
        'available',
        'checked out',
        'reserved',
        'on hold',
        'lost',
        'damaged',
        'in repair',
        'in processing',
        'missing',
        'on order',
        'reference only',
        'withdrawn',
        'transferred',
        'archived',
        'overdue'
    ];

    public $formats = ['hardcover','paperback','ebook'];

    public $filters = [];

    public $tags = [];

    public $publishers;

    public $libraries;

    private function addFilters($key, $input) {
        if($input) {
            $extracted = explode(',', $input);

            foreach($extracted as $value) {
                $this->filters[] = [$key, $value];
            }
        }
    }

    public function index(Request $request, $type='')
    {
        $library = null;
        if(Auth::user()) {
            if(in_array(Auth::user()->role, ['librarian','assistant','clerk'])) {
                $user = UserDetail::where('email',Auth::user()->email)->first();

                $this->filters[] = ['library', $user->library];
                $library = $user->library;
            }
        }

        $this->publishers =
            Item::select('publisher')
                ->distinct()->get();

        $this->publishers = $this->publishers->map(function ($publisher) {
            return $publisher->publisher;
        });

        $hasYearFilter  = false;
        $hasGenreFilter = false;
        $hasFormatFilter = false;
        $hasPublisherFilter = false;
        $hasLibraryFilter = false;
        $hasTagFilter = false;

        $start_year = 0;
        $end_year   = 0;
        if($request->input('year')) {
            $years = explode('-', $request->input('year'));
            $start_year = (int) $years[0] ?? 0;
            $end_year   = (int) $years[1] ?? 0;

            if($start_year <= $end_year) {
                $hasYearFilter = true;
            }
        }

        $formats = [];
        if($request->input('format')) {
            $formats = explode(',', $request->input('format'));

            if(count($formats) > 0) {
                $hasFormatFilter = true;
            }
        }

        $genres = [];
        if($request->input('genre')) {
            $genres = explode(',', $request->input('genre'));

            if(count($genres) > 0) {
                $hasGenreFilter = true;
            }
        }

        $publishers = [];
        if($request->input('publisher')) {
            $publishers = explode(',', $request->input('publisher'));

            if(count($publishers) > 0) {
                $hasPublisherFilter = true;
            }
        }

        $libraries = [];
        if($request->input('library')) {
            $libraries = explode(',', $request->input('library'));

            if(count($libraries) > 0) {
                $hasLibraryFilter = true;
            }
        }

        $tags = [];
        if($request->input('tag')) {
            $tags = explode(',', $request->input('tag'));

            if(count($tags) > 0) {
                $hasTagFilter = true;
            }
        }

        if($library) {
            $libraries[] = $library;
            $hasLibraryFilter = true;
        }

        $this->libraries = Library::all();

        $q = $request->input('q', '');
        $currentPage = (int) $request->input('page', 1);
        $limit     = (int) $request->input('limit', 5);
        $offset    = ($currentPage - 1) * $limit;
        $sort_by   = $request->input('sort_by', 'title');
        $order     = $request->input('order', 'ASC');

        $pdo = DB::connection()->getPdo();
        $pdo->exec("SET SESSION sql_mode = (SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''))");

        $_sql_where  =
        "WHERE `type` LIKE :type
         AND `title` LIKE :q
        ";

        if($hasYearFilter) {
            $_sql_where .= "AND `publication_year` BETWEEN '$start_year' AND '$end_year' ";
        }
        if($hasGenreFilter) {
            $_sql_where .= "AND `genre` IN ('". implode("','", $genres) ."') ";
        }
        if($hasFormatFilter) {
            $_sql_where .= "AND `format` IN ('". implode("','", $formats) ."') ";
        }
        if($hasLibraryFilter) {
            $_sql_where .= "AND `library` IN ('". implode("','", $libraries) ."') ";
        }
        if($hasPublisherFilter) {
            $_sql_where .= "AND `publisher` IN ('". implode("','", $publishers) ."') ";
        }
        if($hasTagFilter) {
            foreach($tags as $tag) {
                $_sql_where .= "AND FIND_IN_SET('$tag', `tags`) ";
            }
        }

        $_sql_select = "SELECT * FROM `items` ";
        $_sql_count  = "SELECT COUNT(DISTINCT title) FROM `items` ";

        $_sql_group_by = "GROUP BY `title` ";
        $_sql_order_by = "ORDER BY `$sort_by` $order ";
        $_sql_limit = "LIMIT :limit OFFSET :offset ";

        $sql = $_sql_select . $_sql_where . $_sql_group_by . $_sql_order_by . $_sql_limit;
        $query = $pdo->prepare($sql);
        $query->execute([
            'type'   => "%$type%",
            'q'      => "%$q%",
            'limit'  => $limit,
            'offset' => $offset,
        ]);

        $items = $query->fetchAll(PDO::FETCH_OBJ);
        $items = collect($items);

        $sql = $_sql_count . $_sql_where;
        $query = $pdo->prepare($sql);
        $query->execute([
            'type' => "%$type%",
            'q'    => "%$q%",
        ]);

        $totalItems = $query->fetchColumn();
        $totalPages = ceil($totalItems / $limit);

        $items = $items->map(function ($item) use($hasLibraryFilter, $libraries) {
            if($item->tags) {
                $tags = explode(',', $item->tags);

                if(count($tags)) {
                    $this->tags = array_unique(array_merge($this->tags, $tags));
                }
            }

            $copies =
                Item::where('isbn', $item->isbn)
                    ->when($hasLibraryFilter, function ($query) use ($libraries) {
                        return $query->whereIn('library', $libraries);
                    })
                    ->count();

            $available =
                Item::where('isbn', $item->isbn)
                    ->when($hasLibraryFilter, function ($query) use ($libraries) {
                        return $query->whereIn('library', $libraries);
                    })
                    ->where('status','available')
                    ->count();

            $item->copies = $copies;
            $item->available = $available;

            return $item;
        });

        $this->addFilters('isbn', $request->input('isbn'));
        $this->addFilters('library', $request->input('library'));
        $this->addFilters('year', $request->input('year'));
        $this->addFilters('publisher', $request->input('publisher'));
        $this->addFilters('genre', $request->input('genre'));
        $this->addFilters('format', $request->input('format'));
        $this->addFilters('tag', $request->input('tag'));

        return view('search.index', [
            'sort_by'     => $sort_by,
            'order'       => $order,
            'limit'       => $limit,
            'offset'      => $offset,
            'totalItems'  => $totalItems,
            'totalPages'  => $totalPages,
            'currentPage' => $currentPage,
            'library'     => $library,
            'items'       => $items,
            'filters'     => $this->filters,
            'genres'      => $this->genres,
            'formats'     => $this->formats,
            'statuses'    => $this->statuses,
            'libraries'   => $this->libraries,
            'publishers'  => $this->publishers,
            'tags'        => $this->tags,
        ]);
    }
}
