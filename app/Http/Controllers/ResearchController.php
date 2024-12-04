<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\UserDetail;

class ResearchController extends Controller
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
        "developmental",
        "descriptive",
        "analytical",
        "exploratory",
        "explanatory",
        "experimental",
        "correlational",
        "comparative",
        "action",
        "case study",
        "phenomenological",
        "ethnographic",
        "historical",
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
            $staff = UserDetail::where('email',Auth::user()->email)->first();
            $library = $staff->library;
        }

        return $library;
    }

    public function index()
    {
        $library = $this->getAffiliatedLibrary();

        $items = Item::latest()
            ->where('type', 'research')
            ->when($library, function ($query) use ($library) {
                return $query->where('library', $library);
            })
            ->get();

        return view('researches.index', [
            'researches' => $items,
            'languages'  => $this->languages,
            'genres'     => $this->genres,
            'formats'    => $this->formats,
            'statuses'   => $this->statuses,
        ]);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'accession_number' => ['nullable', 'string', 'unique:items,accession_number', 'max:255'],
            'barcode'          => ['nullable', 'string', 'unique:items,barcode', 'max:12'],
            'call_number'      => ['nullable', 'string', 'max:255'],
            'date_acquired'    => ['nullable', 'date'],
            'title'            => ['required', 'string', 'max:255'],
            'author'           => ['required', 'string', 'max:255'],
            'advisor'          => ['nullable', 'string', 'max:255'],
            'publisher'        => ['nullable', 'string', 'max:255'],
            'publication_year' => ['required', 'integer'],
            'language'         => ['nullable', 'string', 'max:255'],
            'genre'            => ['required', 'string', 'max:255'],
            'doi'              => ['nullable', 'string', 'max:255'],
            'degree'           => ['nullable', 'string', 'max:255'],
            'number_of_pages'  => ['nullable', 'integer', 'min:1'],
            'format'           => ['nullable', 'in:hardcover,paperback,ebook'],
            'summary'          => ['nullable', 'string'],
            'tags'             => ['nullable', 'string', 'max:255'],
            'section'          => ['required', 'string'],
            'status'           => ['required','string', 'max:255'],
            'file'             => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        if(Auth::user()->role != 'admin') {
            $staff = UserDetail::where('email', Auth::user()->email)->first();
            $attributes['library'] = $staff->library;
        }

        $attributes['type'] = 'research';
        $item = Item::create($attributes);
        if(!empty($attributes['file'])) {
            $manager = ImageManager::gd();
            $image = $manager->read($request->file('file'));
            $image->scale(height: 350);

            $image->crop(235, 350, position: 'center');
        }

        if(!empty($image)) {
            $path = "public/images/research";
            Storage::makeDirectory($path);
            $path .= "/$item->id.png";
            Storage::put($path, (string) $image->encode());

            $item->cover_image = $item->id . ".png";
            $item->save();
        }

        return redirect('collections/research')->with([
            'message' => "Successfully created the research $item->title."
        ]);
    }

    public function duplicate(Request $request, $id)
    {
        $attributes = $request->validate([
            'accession_number' => ['nullable', 'string', 'unique:items,accession_number', 'max:255'],
            'barcode'          => ['nullable', 'string', 'unique:items,barcode', 'max:12'],
            'call_number'      => ['nullable', 'string', 'max:255'],
            'date_acquired'    => ['nullable', 'date'],
            'title'            => ['required', 'string', 'max:255'],
            'author'           => ['required', 'string', 'max:255'],
            'advisor'          => ['nullable', 'string', 'max:255'],
            'publisher'        => ['nullable', 'string', 'max:255'],
            'publication_year' => ['required', 'integer'],
            'language'         => ['nullable', 'string', 'max:255'],
            'genre'            => ['required', 'string', 'max:255'],
            'doi'              => ['nullable', 'string', 'max:255'],
            'degree'           => ['nullable', 'string', 'max:255'],
            'number_of_pages'  => ['nullable', 'integer', 'min:1'],
            'format'           => ['nullable', 'in:hardcover,paperback,ebook'],
            'summary'          => ['nullable', 'string'],
            'tags'             => ['nullable', 'string', 'max:255'],
            'section'          => ['required', 'string'],
            'status'           => ['required','string', 'max:255'],
            'file'             => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        if(Auth::user()->role != 'admin') {
            $staff = UserDetail::where('email', Auth::user()->email)->first();
            $attributes['library'] = $staff->library;
        }

        $attributes['type'] = 'research';
        $item = Item::create($attributes);
        if(!empty($attributes['file'])) {
            $manager = ImageManager::gd();
            $image = $manager->read($request->file('file'));
            $image->scale(height: 350);

            $image->crop(235, 350, position: 'center');
        }

        if(!empty($image)) {
            $path = "public/images/research";
            Storage::makeDirectory($path);
            $path .= "/$item->id.png";
            Storage::put($path, (string) $image->encode());

            $item->cover_image = "$item->id.png";
            $item->save();
        } else {
            $source = Item::findOrFail($id);

            if($source->cover_image) {
                $path = "public/images/research";
                Storage::makeDirectory($path);
                $copy1 = "$path/$source->id.png";
                $copy2 = "$path/$item->id.png";
                Storage::copy($copy1, $copy2);

                $item->cover_image = "$item->id.png";
                $item->save();
            }
        }

        return redirect('collections/research')->with([
            'message' => "Successfully copied the research $item->title."
        ]);
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $path = "public/images/research/$item->cover_image";

        if (Storage::exists($path)) {
            Storage::delete($path);
        }

        $item->delete();

        return redirect("collections/research")
            ->with([
                'message' => 'Successfully deleted the research ' . $item->title . '.',
            ]);
    }

    public function copy($id)
    {
        $selected  = Item::findOrFail($id);
        $library = $this->getAffiliatedLibrary();

        $items = Item::latest()
            ->where('type', 'research')
            ->when($library, function ($query) use ($library) {
                return $query->where('library', $library);
            })
            ->get();

        return view('researches.copy', [
            'researches' => $items,
            'selected'   => $selected,
            'languages'  => $this->languages,
            'genres'     => $this->genres,
            'formats'    => $this->formats,
            'statuses'   => $this->statuses,
        ]);
    }

    public function edit($id)
    {
        $selected  = Item::findOrFail($id);
        $library = $this->getAffiliatedLibrary();

        $items = Item::latest()
            ->where('type', 'research')
            ->when($library, function ($query) use ($library) {
                return $query->where('library', $library);
            })
            ->get();

        return view('researches.edit', [
            'researches' => $items,
            'selected'   => $selected,
            'languages'  => $this->languages,
            'genres'     => $this->genres,
            'formats'    => $this->formats,
            'statuses'   => $this->statuses,
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        $rules = [
            'accession_number' => ['nullable', 'string', 'unique:items,accession_number', 'max:255'],
            'barcode'          => ['nullable', 'string', 'unique:items,barcode', 'max:12'],
            'call_number'      => ['nullable', 'string', 'max:255'],
            'date_acquired'    => ['nullable', 'date'],
            'title'            => ['required', 'string', 'max:255'],
            'author'           => ['required', 'string', 'max:255'],
            'advisor'          => ['nullable', 'string', 'max:255'],
            'publisher'        => ['nullable', 'string', 'max:255'],
            'publication_year' => ['required', 'integer'],
            'language'         => ['nullable', 'string', 'max:255'],
            'genre'            => ['required', 'string', 'max:255'],
            'doi'              => ['nullable', 'string', 'max:255'],
            'degree'           => ['nullable', 'string', 'max:255'],
            'number_of_pages'  => ['nullable', 'integer', 'min:1'],
            'format'           => ['nullable', 'in:hardcover,paperback,ebook'],
            'summary'          => ['nullable', 'string'],
            'tags'             => ['nullable', 'string', 'max:255'],
            'section'          => ['required', 'string'],
            'status'           => ['required','string', 'max:255'],
            'file'             => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];

        if($request->post('accession_number') == $item->accession_number) {
            unset($rules['accession_number']);
        }
        if($request->post('barcode') == $item->barcode) {
            unset($rules['barcode']);
        }
        if($request->post('isbn') == $item->isbn) {
            unset($rules['isbn']);
        }

        $attributes = $request->validate($rules);

        if(Auth::user()->role != 'admin') {
            $staff = UserDetail::where('email', Auth::user()->email)->first();
            $attributes['library'] = $staff->library;
        }

        $item->update($attributes);

        if(!empty($attributes['file'])) {
            $manager = ImageManager::gd();
            $image = $manager->read($request->file('file'));
            $image->scale(height: 350);

            $image->crop(235, 350, position: 'center');
        }

        if(!empty($image)) {
            $path = "public/images/research";
            Storage::makeDirectory($path);
            $path .= "/$item->id.png";
            Storage::put($path, (string) $image->encode());

            $item->cover_image = $item->id . ".png";
            $item->save();
        }

        return redirect('collections/research')->with([
            'message' => "Successfully updated the research $item->title."
        ]);
    }
}
