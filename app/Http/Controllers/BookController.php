<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use App\Models\Library;
use App\Models\Staff;

class BookController extends Controller
{
    public $languages = [
        'english',
        'spanish',
        'french',
        'german',
        'chinese',
        'japanese',
        'russian',
        'italian',
        'portuguese',
        'dutch',
        'korean',
        'arabic',
        'hindi',
        'bengali',
        'turkish',
        'polish',
        'swedish',
        'greek',
        'danish',
        'finnish',
    ];

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

    public $formats = ['hardcover','paperback','ebook'];

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

    private function getAffiliatedLibrary() {
        $library = null;
        if(in_array(Auth::user()->role, ['librarian','assistant','clerk'])) {
            $staff = Staff::where('email',Auth::user()->email)->first();
            $library = $staff->library;
        }

        return $library;
    }

    public function index()
    {
        $library = $this->getAffiliatedLibrary();

        $books = Book::latest()
            ->when($library, function ($query) use ($library) {
                return $query->where('library', $library);
            })
            ->get();

        return view('books.index', [
            'books'     => $books,
            'languages' => $this->languages,
            'genres'    => $this->genres,
            'formats'   => $this->formats,
            'statuses'  => $this->statuses,
        ]);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'accession_number' => ['nullable', 'string', 'unique:books,accession_number', 'max:255'],
            'barcode_number'   => ['nullable', 'string', 'unique:books,barcode_number', 'max:255'],
            'lcc_number'       => ['nullable', 'string', 'max:255'],
            'ddc_number'       => ['nullable', 'string', 'max:255'],
            'title'            => ['required', 'string', 'max:255'],
            'author'           => ['required', 'string', 'max:255'],
            'isbn'             => ['required', 'string', 'max:255'],
            'publisher'        => ['required', 'string', 'max:255'],
            'publication_year' => ['required', 'integer'],
            'language'         => ['nullable', 'string', 'max:255'],
            'genre'            => ['nullable', 'string', 'max:255'],
            'number_of_pages'  => ['nullable', 'integer', 'min:1'],
            'format'           => ['nullable', 'in:hardcover,paperback,ebook'],
            'summary'          => ['nullable', 'string'],
            'price'            => ['nullable', 'numeric', 'min:0'],
            'location'         => ['nullable', 'string', 'max:255'],
            'tags'             => ['nullable', 'string', 'max:255'],
            'status'           => ['required','string', 'max:255'],
            'file'             => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        if(Auth::user()->role != 'admin') {
            $staff = Staff::where('email', Auth::user()->email)->first();
            $attributes['library'] = $staff->library;
        }

        $book = Book::create($attributes);
        if(!empty($attributes['file'])) {
            $manager = ImageManager::gd();
            $image = $manager->read($request->file('file'));
            $image->scale(height: 350);

            $image->crop(235, 350, position: 'center');
        }

        if(!empty($image)) {
            $path = "public/images/books";
            Storage::makeDirectory($path);
            $path .= "/$book->isbn.png";
            Storage::put($path, (string) $image->encode());

            $book->cover_image = $book->isbn . ".png";
            $book->save();
        }

        return redirect('collections/books')->with([
            'message' => "Successfully created the book $book->title."
        ]);
    }

    public function detail(Request $request, $isbn)
    {
        $libraries = Library::all();

        $book  = Book::where('isbn', $isbn)->first();
        $books = Book::where('isbn', $isbn)->get();
        $book->copies = count($books);

        $books->map(function ($book) {
            $library = Library::where('code', $book->library)->first();
            $book->library_name = $library->name;

            return $book;
        });

        $libraries->map(function ($library) use ($books) {
            $library->books = $books->filter(function ($book) use ($library) {
                return $book->library == $library->code;
            });
        });

        return view('books.detail', [
            'book'  => $book,
            // 'books' => $books,
            'libraries' => $libraries,
        ]);
    }

    public function duplicate(Request $request, $id)
    {
        $attributes = $request->validate([
            'accession_number' => ['nullable', 'string', 'unique:books,accession_number', 'max:255'],
            'barcode_number'   => ['nullable', 'string', 'unique:books,barcode_number', 'max:255'],
            'lcc_number'       => ['nullable', 'string', 'max:255'],
            'ddc_number'       => ['nullable', 'string', 'max:255'],
            'title'            => ['required', 'string', 'max:255'],
            'author'           => ['required', 'string', 'max:255'],
            'isbn'             => ['required', 'string', 'max:255'],
            'publisher'        => ['required', 'string', 'max:255'],
            'publication_year' => ['required', 'integer'],
            'language'         => ['nullable', 'string', 'max:255'],
            'genre'            => ['nullable', 'string', 'max:255'],
            'number_of_pages'  => ['nullable', 'integer', 'min:1'],
            'format'           => ['nullable', 'in:hardcover,paperback,ebook'],
            'summary'          => ['nullable', 'string'],
            'price'            => ['nullable', 'numeric', 'min:0'],
            'location'         => ['nullable', 'string', 'max:255'],
            'tags'             => ['nullable', 'string', 'max:255'],
            'status'           => ['required','string', 'max:255'],
            'file'             => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        if(Auth::user()->role != 'admin') {
            $staff = Staff::where('email', Auth::user()->email)->first();
            $attributes['library'] = $staff->library;
        }

        $book = Book::create($attributes);
        if(!empty($attributes['file'])) {
            $manager = ImageManager::gd();
            $image = $manager->read($request->file('file'));
            $image->scale(height: 350);

            $image->crop(235, 350, position: 'center');
        }

        if(!empty($image)) {
            $path = "public/images/books";
            Storage::makeDirectory($path);
            $path .= "/$book->isbn.png";
            Storage::put($path, (string) $image->encode());

            $book->cover_image = "$book->isbn.png";
            $book->save();
        } else {
            $source = Book::findOrFail($id);
            if($source->cover_image) {
                $book->cover_image = $source->cover_image;
                $book->save();
            }
        }

        return redirect('collections/books')->with([
            'message' => "Successfully copied the book $book->title."
        ]);
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $path = "public/images/books/$book->cover_image";

        if (Storage::exists($path)) {
            Storage::delete($path);
        }

        $book->delete();

        return redirect("collections/books")
            ->with([
                'message' => 'Successfully deleted the book ' . $book->title . '.',
            ]);
    }

    public function copy($id)
    {
        $selected  = Book::findOrFail($id);
        $library = $this->getAffiliatedLibrary();

        $books = Book::latest()
            ->when($library, function ($query) use ($library) {
                return $query->where('library', $library);
            })
            ->get();

        return view('books.copy', [
            'books' => $books,
            'selected' => $selected,
            'languages' => $this->languages,
            'genres'    => $this->genres,
            'formats'   => $this->formats,
            'statuses'  => $this->statuses,
        ]);
    }

    public function edit($id)
    {
        $selected  = Book::findOrFail($id);
        $library = $this->getAffiliatedLibrary();

        $books = Book::latest()
            ->when($library, function ($query) use ($library) {
                return $query->where('library', $library);
            })
            ->get();

        return view('books.edit', [
            'books' => $books,
            'selected' => $selected,
            'languages' => $this->languages,
            'genres'    => $this->genres,
            'formats'   => $this->formats,
            'statuses'  => $this->statuses,
        ]);
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $rules = [
            'accession_number' => ['nullable', 'string', 'unique:books,accession_number', 'max:255'],
            'barcode_number'   => ['nullable', 'string', 'unique:books,barcode_number', 'max:255'],
            'lcc_number'       => ['nullable', 'string', 'max:255'],
            'ddc_number'       => ['nullable', 'string', 'max:255'],
            'title'            => ['required', 'string', 'max:255'],
            'author'           => ['required', 'string', 'max:255'],
            'isbn'             => ['required', 'string', 'max:255'],
            'publisher'        => ['required', 'string', 'max:255'],
            'publication_year' => ['required', 'integer'],
            'language'         => ['nullable', 'string', 'max:255'],
            'genre'            => ['nullable', 'string', 'max:255'],
            'number_of_pages'  => ['nullable', 'integer', 'min:1'],
            'format'           => ['nullable', 'in:hardcover,paperback,ebook'],
            'summary'          => ['nullable', 'string'],
            'price'            => ['nullable', 'numeric', 'min:0'],
            'location'         => ['nullable', 'string', 'max:255'],
            'tags'             => ['nullable', 'string', 'max:255'],
            'status'           => ['required', 'string', 'max:255'],
            'file'             => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];

        if($request->post('accession_number') == $book->accession_number) {
            unset($rules['accession_number']);
        }
        if($request->post('barcode_number') == $book->barcode_number) {
            unset($rules['barcode_number']);
        }
        if($request->post('isbn') == $book->isbn) {
            unset($rules['isbn']);
        }

        $attributes = $request->validate($rules);

        $previousIsbn  = $book->isbn;
        $previousCover = $book->cover_image;

        if(Auth::user()->role != 'admin') {
            $staff = Staff::where('email', Auth::user()->email)->first();
            $attributes['library'] = $staff->library;
        }

        $book->update($attributes);

        Book::where('isbn', $book->isbn)->update([
            'title'            => $attributes['title'],
            'author'           => $attributes['author'],
            'publisher'        => $attributes['publisher'],
            'publication_year' => $attributes['publication_year'],
            'genre'            => $attributes['genre'],
            'summary'          => $attributes['summary'],
            'number_of_pages'  => $attributes['number_of_pages'],
            'format'           => $attributes['format'],
            'language'         => $attributes['language'],
            'tags'             => $attributes['tags'],
        ]);

        if(!empty($attributes['file'])) {
            $manager = ImageManager::gd();
            $image = $manager->read($request->file('file'));
            $image->scale(height: 350);

            $image->crop(235, 350, position: 'center');
        }

        if(!empty($image)) {
            $path = "public/images/books";
            Storage::makeDirectory($path);
            $path .= "/$book->isbn.png";
            Storage::put($path, (string) $image->encode());

            $book->cover_image = $book->isbn . ".png";
            $book->save();
        } else {
            if($previousIsbn != $book->isbn) {
                $path = "public/images/books";
                Storage::makeDirectory($path);
                $newPath = $path . "/$book->isbn.png";
                $oldPath = $path . "/$previousCover";

                if (Storage::exists($oldPath)) {
                    Storage::move($oldPath, $newPath);
                }

                $book->cover_image = $book->isbn . ".png";
                $book->save();
            }
        }

        return redirect('collections/books')->with([
            'message' => "Successfully updated the book $book->title."
        ]);
    }
}
