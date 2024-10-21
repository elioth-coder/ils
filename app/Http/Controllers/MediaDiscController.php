<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\MediaDisc;
use App\Models\Staff;

class MediaDiscController extends Controller
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

    public $types = [
        "cd",
        "dvd",
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

    public function index()
    {
        $media_discs = MediaDisc::latest()->get();

        return view('media_discs.index', [
            'media_discs' => $media_discs,
            'languages'   => $this->languages,
            'genres'      => $this->genres,
            'types'       => $this->types,
            'statuses'    => $this->statuses,
        ]);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'accession_number' => ['nullable', 'string', 'unique:media_discs,accession_number', 'max:255'],
            'barcode_number'   => ['nullable', 'string', 'unique:media_discs,barcode_number', 'max:255'],
            'lcc_number'       => ['nullable', 'string', 'max:255'],
            'ddc_number'       => ['nullable', 'string', 'max:255'],
            'ir_number'        => ['nullable', 'string', 'max:255'],
            'title'            => ['required', 'string', 'max:255'],
            'author'           => ['required', 'string', 'max:255'],
            'publisher'        => ['nullable', 'string', 'max:255'],
            'year_released'    => ['required', 'integer'],
            'duration'         => ['required', 'integer'],
            'language'         => ['nullable', 'string', 'max:255'],
            'genre'            => ['nullable', 'string', 'max:255'],
            'type'             => ['nullable', 'string', 'max:255'],
            'summary'          => ['nullable', 'string'],
            'location'         => ['nullable', 'string', 'max:255'],
            'tags'             => ['nullable', 'string', 'max:255'],
            'status'           => ['required', 'string', 'max:255'],
            'file'             => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        if(Auth::user()->role != 'admin') {
            $staff = Staff::where('email', Auth::user()->email)->first();
            $attributes['library'] = $staff->library;
        }

        $media_disc = MediaDisc::create($attributes);
        if(!empty($attributes['file'])) {
            $manager = ImageManager::gd();
            $image = $manager->read($request->file('file'));
            $image->scale(height: 350);

            $image->crop(235, 350, position: 'center');
        }

        if(!empty($image)) {
            $path = "public/images/media_discs";
            Storage::makeDirectory($path);
            $path .= "/$media_disc->id.png";
            Storage::put($path, (string) $image->encode());

            $media_disc->cover_image = $media_disc->id . ".png";
            $media_disc->save();
        }

        return redirect('collections/media_discs')->with([
            'message' => "Successfully created the media disc $media_disc->title."
        ]);
    }

    public function duplicate(Request $request, $id)
    {
        $attributes = $request->validate([
            'accession_number' => ['nullable', 'string', 'unique:media_discs,accession_number', 'max:255'],
            'barcode_number'   => ['nullable', 'string', 'unique:media_discs,barcode_number', 'max:255'],
            'lcc_number'       => ['nullable', 'string', 'max:255'],
            'ddc_number'       => ['nullable', 'string', 'max:255'],
            'ir_number'        => ['nullable', 'string', 'max:255'],
            'title'            => ['required', 'string', 'max:255'],
            'author'           => ['required', 'string', 'max:255'],
            'publisher'        => ['nullable', 'string', 'max:255'],
            'year_released'    => ['required', 'integer'],
            'duration'         => ['required', 'integer'],
            'language'         => ['nullable', 'string', 'max:255'],
            'genre'            => ['nullable', 'string', 'max:255'],
            'type'             => ['nullable', 'string', 'max:255'],
            'summary'          => ['nullable', 'string'],
            'location'         => ['nullable', 'string', 'max:255'],
            'tags'             => ['nullable', 'string', 'max:255'],
            'status'           => ['required', 'string', 'max:255'],
            'file'             => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        if(Auth::user()->role != 'admin') {
            $staff = Staff::where('email', Auth::user()->email)->first();
            $attributes['library'] = $staff->library;
        }

        $media_disc = MediaDisc::create($attributes);
        if(!empty($attributes['file'])) {
            $manager = ImageManager::gd();
            $image = $manager->read($request->file('file'));
            $image->scale(height: 350);

            $image->crop(235, 350, position: 'center');
        }

        $source = MediaDisc::findOrFail($id);

        if(!empty($image)) {
            $path = "public/images/media_discs";
            Storage::makeDirectory($path);
            $path .= "/$media_disc->id.png";
            Storage::put($path, (string) $image->encode());

            $media_disc->cover_image = "$media_disc->id.png";
            $media_disc->save();
        } else {
            if($source->cover_image) {
                $media_disc->cover_image = $source->cover_image;
                $media_disc->save();
            }
        }

        $media_disc->ir_number = $source->ir_number;
        $media_disc->save();


        return redirect('collections/media_discs')->with([
            'message' => "Successfully copied the media disc $media_disc->title."
        ]);
    }

    public function destroy($id)
    {
        $media_disc = MediaDisc::findOrFail($id);
        $path = "public/images/media_discs/$media_disc->cover_image";

        if (Storage::exists($path)) {
            Storage::delete($path);
        }

        $media_disc->delete();

        return redirect("collections/media_discs")
            ->with([
                'message' => 'Successfully deleted the media disc ' . $media_disc->title . '.',
            ]);
    }

    public function copy($id)
    {
        $selected  = MediaDisc::findOrFail($id);
        $media_discs = MediaDisc::latest()->get();

        return view('media_discs.copy', [
            'media_discs' => $media_discs,
            'selected'  => $selected,
            'languages' => $this->languages,
            'genres'     => $this->genres,
            'types'     => $this->types,
            'statuses'  => $this->statuses,
        ]);
    }

    public function edit($id)
    {
        $selected  = MediaDisc::findOrFail($id);
        $media_discs = MediaDisc::latest()->get();

        return view('media_discs.edit', [
            'media_discs' => $media_discs,
            'selected'   => $selected,
            'genres'     => $this->genres,
            'languages'  => $this->languages,
            'types'      => $this->types,
            'statuses'   => $this->statuses,
        ]);
    }

    public function update(Request $request, $id)
    {
        $media_disc = MediaDisc::findOrFail($id);
        $rules = [
            'accession_number' => ['nullable', 'string', 'unique:media_discs,accession_number', 'max:255'],
            'barcode_number'   => ['nullable', 'string', 'unique:media_discs,barcode_number', 'max:255'],
            'lcc_number'       => ['nullable', 'string', 'max:255'],
            'ddc_number'       => ['nullable', 'string', 'max:255'],
            'ir_number'        => ['nullable', 'string', 'max:255'],
            'title'            => ['required', 'string', 'max:255'],
            'author'           => ['required', 'string', 'max:255'],
            'publisher'        => ['nullable', 'string', 'max:255'],
            'year_released'    => ['required', 'integer'],
            'duration'         => ['required', 'integer'],
            'language'         => ['nullable', 'string', 'max:255'],
            'genre'            => ['nullable', 'string', 'max:255'],
            'type'             => ['nullable', 'string', 'max:255'],
            'summary'          => ['nullable', 'string'],
            'location'         => ['nullable', 'string', 'max:255'],
            'tags'             => ['nullable', 'string', 'max:255'],
            'status'           => ['required', 'string', 'max:255'],
            'file'             => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];

        if($request->post('accession_number') == $media_disc->accession_number) {
            unset($rules['accession_number']);
        }
        if($request->post('barcode_number') == $media_disc->barcode_number) {
            unset($rules['barcode_number']);
        }

        $attributes = $request->validate($rules);

        if(Auth::user()->role != 'admin') {
            $staff = Staff::where('email', Auth::user()->email)->first();
            $attributes['library'] = $staff->library;
        }

        $media_disc->update($attributes);
        if(!empty($attributes['file'])) {
            $manager = ImageManager::gd();
            $image = $manager->read($request->file('file'));
            $image->scale(height: 350);

            $image->crop(235, 350, position: 'center');
        }

        if(!empty($image)) {
            $path = "public/images/media_discs";
            Storage::makeDirectory($path);
            $path .= "/$media_disc->id.png";
            Storage::put($path, (string) $image->encode());

            $media_disc->cover_image = $media_disc->id . ".png";
            $media_disc->save();
        }

        return redirect('collections/media_discs')->with([
            'message' => "Successfully updated the media disc $media_disc->title."
        ]);
    }
}
