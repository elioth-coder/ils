<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\UserDetail;

class VideoController extends Controller
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

        $videos = Item::latest()
            ->where('type', 'video')
            ->when($library, function ($query) use ($library) {
                return $query->where('library', $library);
            })
            ->get();

        return view('videos.index', [
            'videos'    => $videos,
            'languages' => $this->languages,
            'genres'    => $this->genres,
            'statuses'  => $this->statuses,
        ]);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'accession_number' => ['nullable', 'string', 'unique:items,accession_number', 'max:255'],
            'barcode'          => ['nullable', 'string', 'unique:items,barcode', 'max:255'],
            'call_number'      => ['nullable', 'string', 'max:255'],
            'date_acquired'    => ['nullable', 'date'],
            'title'            => ['required', 'string', 'max:255'],
            'author'           => ['required', 'string', 'max:255'],
            'publisher'        => ['nullable', 'string', 'max:255'],
            'publication_year' => ['required', 'integer'],
            'duration'         => ['required', 'integer'],
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

        $attributes['type'] = 'video';
        $video = Item::create($attributes);
        if(!empty($attributes['file'])) {
            $manager = ImageManager::gd();
            $image = $manager->read($request->file('file'));
            $image->scale(height: 350);

            $image->crop(235, 350, position: 'center');
        }

        if(!empty($image)) {
            $path = "public/images/video";
            Storage::makeDirectory($path);
            $path .= "/$video->id.png";
            Storage::put($path, (string) $image->encode());

            $video->cover_image = $video->id . ".png";
            $video->save();
        }

        return redirect('collections/video')->with([
            'message' => "Successfully created the video $video->title."
        ]);
    }

    public function duplicate(Request $request, $id)
    {
        $attributes = $request->validate([
            'accession_number' => ['nullable', 'string', 'unique:items,accession_number', 'max:255'],
            'barcode'          => ['nullable', 'string', 'unique:items,barcode', 'max:255'],
            'call_number'      => ['nullable', 'string', 'max:255'],
            'date_acquired'    => ['nullable', 'date'],
            'title'            => ['required', 'string', 'max:255'],
            'author'           => ['required', 'string', 'max:255'],
            'publisher'        => ['nullable', 'string', 'max:255'],
            'publication_year' => ['required', 'integer'],
            'duration'         => ['required', 'integer'],
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

        $attributes['type'] = 'video';
        $video = Item::create($attributes);
        if(!empty($attributes['file'])) {
            $manager = ImageManager::gd();
            $image = $manager->read($request->file('file'));
            $image->scale(height: 350);

            $image->crop(235, 350, position: 'center');
        }

        $source = Item::findOrFail($id);

        if(!empty($image)) {
            $path = "public/images/video";
            Storage::makeDirectory($path);
            $path .= "/$video->id.png";
            Storage::put($path, (string) $image->encode());

            $video->cover_image = "$video->id.png";
            $video->save();
        } else {
            if($source->cover_image) {
                $video->cover_image = $source->cover_image;
                $video->save();
            }
        }

        $video->save();


        return redirect('collections/video')->with([
            'message' => "Successfully copied the video $video->title."
        ]);
    }

    public function destroy($id)
    {
        $video = Item::findOrFail($id);
        $path = "public/images/video/$video->cover_image";

        if (Storage::exists($path)) {
            Storage::delete($path);
        }

        $video->delete();

        return redirect("collections/video")
            ->with([
                'message' => 'Successfully deleted the video ' . $video->title . '.',
            ]);
    }

    public function copy($id)
    {
        $library = $this->getAffiliatedLibrary();

        $selected  = Item::findOrFail($id);
        $videos = Item::latest()
            ->where('type', 'video')
            ->when($library, function ($query) use ($library) {
                return $query->where('library', $library);
            })
            ->get();

        return view('videos.copy', [
            'videos' => $videos,
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
        $videos = Item::latest()
            ->where('type', 'video')
            ->when($library, function ($query) use ($library) {
                return $query->where('library', $library);
            })
            ->get();

        return view('videos.edit', [
            'videos'     => $videos,
            'selected'   => $selected,
            'genres'     => $this->genres,
            'languages'  => $this->languages,
            'statuses'   => $this->statuses,
        ]);
    }

    public function update(Request $request, $id)
    {
        $video = Item::findOrFail($id);
        $rules = [
            'accession_number' => ['nullable', 'string', 'unique:items,accession_number', 'max:255'],
            'barcode'          => ['nullable', 'string', 'unique:items,barcode', 'max:255'],
            'call_number'      => ['nullable', 'string', 'max:255'],
            'date_acquired'    => ['nullable', 'date'],
            'title'            => ['required', 'string', 'max:255'],
            'author'           => ['required', 'string', 'max:255'],
            'publisher'        => ['nullable', 'string', 'max:255'],
            'publication_year' => ['required', 'integer'],
            'duration'         => ['required', 'integer'],
            'language'         => ['nullable', 'string', 'max:255'],
            'genre'            => ['nullable', 'string', 'max:255'],
            'summary'          => ['nullable', 'string'],
            'tags'             => ['nullable', 'string', 'max:255'],
            'status'           => ['required', 'string', 'max:255'],
            'file'             => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];

        if($request->post('accession_number') == $video->accession_number) {
            unset($rules['accession_number']);
        }
        if($request->post('barcode') == $video->barcode) {
            unset($rules['barcode']);
        }

        $attributes = $request->validate($rules);

        if(Auth::user()->role != 'admin') {
            $user = UserDetail::where('email', Auth::user()->email)->first();
            $attributes['library'] = $user->library;
        }

        $video->update($attributes);
        if(!empty($attributes['file'])) {
            $manager = ImageManager::gd();
            $image = $manager->read($request->file('file'));
            $image->scale(height: 350);

            $image->crop(235, 350, position: 'center');
        }

        if(!empty($image)) {
            $path = "public/images/video";
            Storage::makeDirectory($path);
            $path .= "/$video->id.png";
            Storage::put($path, (string) $image->encode());

            $video->cover_image = $video->id . ".png";
            $video->save();
        }

        return redirect('collections/video')->with([
            'message' => "Successfully updated the video $video->title."
        ]);
    }
}
