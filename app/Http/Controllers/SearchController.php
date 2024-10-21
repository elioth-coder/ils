<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Library;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

    public function books(Request $request)
    {
        $library = null;
        if(in_array(Auth::user()->role, ['librarian','assistant','clerk'])) {
            $staff = Staff::where('email',Auth::user()->email)->first();

            $this->filters[] = ['library', $staff->library];
            $library = $staff->library;
        }

        $q = $request->input('q');
        $limit = $request->input('limit', 2);

        $this->publishers = Book::select('publisher')->distinct()->get();
        $this->publishers = $this->publishers->map(function ($publisher) {
            return $publisher->publisher;
        });

        $hasYearFilter  = false;
        $hasGenreFilter = false;
        $hasFormatFilter = false;
        $hasStatusFilter = false;
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

        $statuses = [];
        if($request->input('status')) {
            $statuses = explode(',', $request->input('status'));

            if(count($statuses) > 0) {
                $hasStatusFilter = true;
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

        $isbn = $request->input('isbn', null);

        if($isbn != null) {
            $books = Book::select(
                'barcode_number',
                'isbn',
                'id',
                'title',
                'author',
                'publisher',
                'publication_year',
                'format',
                'tags',
                'cover_image',
                'status',
                'library',
            )
            ->where('isbn', $isbn)
            ->when($hasLibraryFilter, function ($query) use ($libraries) {
                return $query->whereIn('library', $libraries);
            })->get();
        } else {
            $books = Book::select(
                DB::raw('DISTINCT isbn'),
                'title',
                'author',
                'publisher',
                'publication_year',
                'format',
                'tags',
                'cover_image',
                'status',
            )
            ->where('title', 'LIKE', "%$q%")
            ->when($hasYearFilter, function ($query) use ($start_year, $end_year) {
                return $query->whereBetween('publication_year', [$start_year, $end_year]);
            })
            ->when($hasGenreFilter, function ($query) use ($genres) {
                return $query->whereIn('genre', $genres);
            })
            ->when($hasFormatFilter, function ($query) use ($formats) {
                return $query->whereIn('format', $formats);
            })
            ->when($hasStatusFilter, function ($query) use ($statuses) {
                return $query->whereIn('status', $statuses);
            })
            ->when($hasLibraryFilter, function ($query) use ($libraries) {
                return $query->whereIn('library', $libraries);
            })
            ->when($hasTagFilter, function ($query) use ($tags) {
                foreach($tags as $tag) {
                    $query->whereRaw("FIND_IN_SET(?, tags)", [$tag]);
                }

                return $query;
            })
            ->when($hasPublisherFilter, function ($query) use ($publishers) {
                return $query->whereIn('publisher', $publishers);
            })
            ->get();
        }

        $books = $books->map(function ($book) use($hasLibraryFilter, $libraries) {
            if($book->tags) {
                $tags = explode(',', $book->tags);

                if(count($tags)) {
                    $this->tags = array_merge($this->tags, $tags);
                }
            }

            $copies =
                Book::where('isbn', $book->isbn)
                    ->when($hasLibraryFilter, function ($query) use ($libraries) {
                        return $query->whereIn('library', $libraries);
                    })
                    ->count();

            $available =
                Book::where('isbn', $book->isbn)
                    ->when($hasLibraryFilter, function ($query) use ($libraries) {
                        return $query->whereIn('library', $libraries);
                    })
                    ->where('status','available')
                    ->count();

            $book->copies = $copies;
            $book->available = $available;

            return $book;
        });

        $this->addFilters('isbn', $request->input('isbn'));
        $this->addFilters('library', $request->input('library'));
        $this->addFilters('year', $request->input('year'));
        $this->addFilters('publisher', $request->input('publisher'));
        $this->addFilters('genre', $request->input('genre'));
        $this->addFilters('format', $request->input('format'));
        $this->addFilters('status', $request->input('status'));
        $this->addFilters('tag', $request->input('tag'));

        return view('search.books', [
            'library'    => $library,
            'books'      => $books,
            'filters'    => $this->filters,
            'genres'     => $this->genres,
            'formats'    => $this->formats,
            'statuses'   => $this->statuses,
            'libraries'  => $this->libraries,
            'publishers' => $this->publishers,
            'tags'       => $this->tags,
        ]);
    }

    public function book_copies(Request $request, $isbn)
    {
        $library = null;
        if(in_array(Auth::user()->role, ['librarian','assistant','clerk'])) {
            $staff = Staff::where('email',Auth::user()->email)->first();

            $this->filters[] = ['library', $staff->library];
            $library = $staff->library;
        }

        $this->publishers = Book::select('publisher')->distinct()->get();
        $this->publishers = $this->publishers->map(function ($publisher) {
            return $publisher->publisher;
        });

        $hasLibraryFilter = false;

        $libraries = [];
        if($request->input('library')) {
            $libraries = explode(',', $request->input('library'));

            if(count($libraries) > 0) {
                $hasLibraryFilter = true;
            }
        }

        if($library) {
            $libraries[] = $library;
            $hasLibraryFilter = true;
        }


        $this->libraries = Library::all();
        $books = Book::where('isbn', $isbn)
            ->when($hasLibraryFilter, function ($query) use ($libraries) {
                return $query->whereIn('library', $libraries);
            })->get();

        $books->each(function ($book) {
            if($book->tags) {
                $tags = explode(',', $book->tags);

                if(count($tags)) {
                    $this->tags = array_merge($this->tags, $tags);
                }
            }
        });

        return view('search.books', [
            'library'    => $library,
            'books'      => $books,
            'filters'    => $this->filters,
            'genres'     => $this->genres,
            'formats'    => $this->formats,
            'statuses'   => $this->statuses,
            'libraries'  => $this->libraries,
            'publishers' => $this->publishers,
            'tags'       => $this->tags,
        ]);
    }
}
