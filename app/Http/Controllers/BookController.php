<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use App\Models\Book;

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

    public $formats = ['hardcover','paperback'];

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

    public function index()
    {
        $books = Book::latest()->get();

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
            'status'           => ['nullable','in:available,checked out,reserved,on hold,lost,damaged,in repair,in processing,missing,on order,reference only,withdrawn,transferred,archived,overdue'],
            'file'             => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

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
            $path .= "/book_$book->id.png";
            Storage::put($path, (string) $image->encode());

            $book->cover_image = "book_" . $book->id . ".png";
            $book->save();
        }

        return redirect('collections/books')->with([
            'message' => "Successfully created the book $book->title."
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
            'status'           => ['nullable','in:available,checked out,reserved,on hold,lost,damaged,in repair,in processing,missing,on order,reference only,withdrawn,transferred,archived,overdue'],
            'file'             => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

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
            $path .= "/book_$book->id.png";
            Storage::put($path, (string) $image->encode());

            $book->cover_image = "book_$book->id.png";
            $book->save();
        } else {
            $source_book = Book::findOrFail($id);
            if($source_book->cover_image) {
                $path = "public/images/books";
                Storage::makeDirectory($path);
                Storage::copy($path . "/$source_book->cover_image", $path . "/book_$book->id.png");

                $book->cover_image = "book_$book->id.png";
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
        $books = Book::latest()->get();

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
        $books = Book::latest()->get();

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
            'status'           => ['nullable','in:available,checked out,reserved,on hold,lost,damaged,in repair,in processing,missing,on order,reference only,withdrawn,transferred,archived,overdue'],
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

        $book->update($attributes);
        if(!empty($attributes['file'])) {
            $manager = ImageManager::gd();
            $image = $manager->read($request->file('file'));
            $image->scale(height: 350);

            $image->crop(235, 350, position: 'center');
        }

        if(!empty($image)) {
            $path = "public/images/books";
            Storage::makeDirectory($path);
            $path .= "/book_$book->id.png";
            Storage::put($path, (string) $image->encode());

            $book->cover_image = "book_" . $book->id . ".png";
            $book->save();
        }

        return redirect('collections/books')->with([
            'message' => "Successfully updated the book $book->name."
        ]);
    }
}
