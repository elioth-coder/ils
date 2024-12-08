<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\UserDetail;

class AudioController extends Controller
{
    public $languages = [
        'english',
        'tagalog',
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

    public $statuses = [
        'available',
        'checked out',
        'reserved',
        'lost',
        'missing',
        'damaged',
        'reference only',
        'no barcode',
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
            ->where('type', 'audio')
            ->when($library, function ($query) use ($library) {
                return $query->where('library', $library);
            })
            ->get();

        return view('audios.index', [
            'items'    => $items,
            'languages' => $this->languages,
            'genres'    => $this->genres,
            'statuses'  => $this->statuses,
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
            'publisher'        => ['nullable', 'string', 'max:255'],
            'publication_year' => ['required', 'integer'],
            'duration'         => ['required', 'integer'],
            'section'          => ['required', 'string'],
            'language'         => ['nullable', 'string', 'max:255'],
            'genre'            => ['nullable', 'string', 'max:255'],
            'summary'          => ['nullable', 'string'],
            'tags'             => ['nullable', 'string', 'max:255'],
            'status'           => ['required', 'string', 'max:255'],
            'file'             => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        if(Auth::user()->role != 'admin') {
            $user = UserDetail::where('email', Auth::user()->email)->first();
            $attributes['library'] = $user->library;
        }

        $attributes['type'] = 'audio';
        $item = Item::create($attributes);
        if(!empty($attributes['file'])) {
            $manager = ImageManager::gd();
            $image = $manager->read($request->file('file'));
            $image->scale(height: 350);

            $image->crop(235, 350, position: 'center');
        }

        if(!empty($image)) {
            $path = "public/images/audio";
            Storage::makeDirectory($path);
            $path .= "/$item->id.png";
            Storage::put($path, (string) $image->encode());

            $item->cover_image = $item->id . ".png";
            $item->save();
        }

        return redirect('collections/audio')->with([
            'message' => "Successfully created the audio $item->title."
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
            'publisher'        => ['nullable', 'string', 'max:255'],
            'publication_year' => ['required', 'integer'],
            'duration'         => ['required', 'integer'],
            'section'          => ['required', 'string'],
            'language'         => ['nullable', 'string', 'max:255'],
            'genre'            => ['nullable', 'string', 'max:255'],
            'summary'          => ['nullable', 'string'],
            'tags'             => ['nullable', 'string', 'max:255'],
            'status'           => ['required', 'string', 'max:255'],
            'file'             => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        if(Auth::user()->role != 'admin') {
            $user = UserDetail::where('email', Auth::user()->email)->first();
            $attributes['library'] = $user->library;
        }

        $attributes['type'] = 'audio';
        $item = Item::create($attributes);
        if(!empty($attributes['file'])) {
            $manager = ImageManager::gd();
            $image = $manager->read($request->file('file'));
            $image->scale(height: 350);

            $image->crop(235, 350, position: 'center');
        }

        $source = Item::findOrFail($id);

        if(!empty($image)) {
            $path = "public/images/audio";
            Storage::makeDirectory($path);
            $path .= "/$item->id.png";
            Storage::put($path, (string) $image->encode());

            $item->cover_image = "$item->id.png";
            $item->save();
        } else {
            $source = Item::findOrFail($id);

            if($source->cover_image) {
                $path = "public/images/audio";
                Storage::makeDirectory($path);
                $copy1 = "$path/$source->id.png";
                $copy2 = "$path/$item->id.png";
                Storage::copy($copy1, $copy2);

                $item->cover_image = "$item->id.png";
                $item->save();
            }
        }

        $item->save();


        return redirect('collections/audio')->with([
            'message' => "Successfully copied the audio $item->title."
        ]);
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $path = "public/images/audio/$item->cover_image";

        if (Storage::exists($path)) {
            Storage::delete($path);
        }

        $item->delete();

        return redirect("collections/audio")
            ->with([
                'message' => 'Successfully deleted the audio ' . $item->title . '.',
            ]);
    }

    public function copy($id)
    {
        $library = $this->getAffiliatedLibrary();

        $selected  = Item::findOrFail($id);
        $items = Item::latest()
            ->where('type', 'audio')
            ->when($library, function ($query) use ($library) {
                return $query->where('library', $library);
            })
            ->get();

        return view('audios.copy', [
            'items' => $items,
            'selected'    => $selected,
            'languages'   => $this->languages,
            'genres'      => $this->genres,
            'statuses'    => $this->statuses,
        ]);
    }

    public function edit($id)
    {
        $library = $this->getAffiliatedLibrary();

        $selected  = Item::findOrFail($id);
        $items = Item::latest()
            ->where('type', 'audio')
            ->when($library, function ($query) use ($library) {
                return $query->where('library', $library);
            })
            ->get();

        return view('audios.edit', [
            'items'     => $items,
            'selected'   => $selected,
            'genres'     => $this->genres,
            'languages'  => $this->languages,
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
            'publisher'        => ['nullable', 'string', 'max:255'],
            'publication_year' => ['required', 'integer'],
            'duration'         => ['required', 'integer'],
            'section'          => ['required', 'string'],
            'language'         => ['nullable', 'string', 'max:255'],
            'genre'            => ['nullable', 'string', 'max:255'],
            'summary'          => ['nullable', 'string'],
            'tags'             => ['nullable', 'string', 'max:255'],
            'status'           => ['required', 'string', 'max:255'],
            'file'             => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];

        if($request->post('accession_number') == $item->accession_number) {
            unset($rules['accession_number']);
        }
        if($request->post('barcode') == $item->barcode) {
            unset($rules['barcode']);
        }

        $attributes = $request->validate($rules);

        if(Auth::user()->role != 'admin') {
            $user = UserDetail::where('email', Auth::user()->email)->first();
            $attributes['library'] = $user->library;
        }

        $item->update($attributes);
        if(!empty($attributes['file'])) {
            $manager = ImageManager::gd();
            $image = $manager->read($request->file('file'));
            $image->scale(height: 350);

            $image->crop(235, 350, position: 'center');
        }

        if(!empty($image)) {
            $path = "public/images/audio";
            Storage::makeDirectory($path);
            $path .= "/$item->id.png";
            Storage::put($path, (string) $image->encode());

            $item->cover_image = $item->id . ".png";
            $item->save();
        }

        return redirect('collections/audio')->with([
            'message' => "Successfully updated the audio $item->title."
        ]);
    }
}
