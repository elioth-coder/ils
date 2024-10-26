<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Research;
use App\Models\Staff;

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

    public $types = [
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

    public function index()
    {
        $researches = Research::latest()->get();

        return view('researches.index', [
            'researches'     => $researches,
            'languages' => $this->languages,
            'types'    => $this->types,
            'formats'   => $this->formats,
            'statuses'  => $this->statuses,
        ]);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'accession_number' => ['nullable', 'string', 'unique:researches,accession_number', 'max:255'],
            'barcode'   => ['nullable', 'string', 'unique:researches,barcode', 'max:255'],
            'lcc_number'       => ['nullable', 'string', 'max:255'],
            'ddc_number'       => ['nullable', 'string', 'max:255'],
            'ir_number'        => ['nullable', 'string', 'max:255'],
            'title'            => ['required', 'string', 'max:255'],
            'author'           => ['required', 'string', 'max:255'],
            'year_submitted'   => ['required', 'integer'],
            'language'         => ['nullable', 'string', 'max:255'],
            'type'            => ['nullable', 'string', 'max:255'],
            'number_of_pages'  => ['nullable', 'integer', 'min:1'],
            'format'           => ['nullable', 'in:hardcover,paperback,ebook'],
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

        $research = Research::create($attributes);
        if(!empty($attributes['file'])) {
            $manager = ImageManager::gd();
            $image = $manager->read($request->file('file'));
            $image->scale(height: 350);

            $image->crop(235, 350, position: 'center');
        }

        if(!empty($image)) {
            $path = "public/images/researches";
            Storage::makeDirectory($path);
            $path .= "/$research->id.png";
            Storage::put($path, (string) $image->encode());

            $research->cover_image = $research->id . ".png";
            $research->save();
        }

        return redirect('collections/researches')->with([
            'message' => "Successfully created the thesis/research $research->title."
        ]);
    }

    public function duplicate(Request $request, $id)
    {
        $attributes = $request->validate([
            'accession_number' => ['nullable', 'string', 'unique:researches,accession_number', 'max:255'],
            'barcode'   => ['nullable', 'string', 'unique:researches,barcode', 'max:255'],
            'lcc_number'       => ['nullable', 'string', 'max:255'],
            'ddc_number'       => ['nullable', 'string', 'max:255'],
            'ir_number'        => ['nullable', 'string', 'max:255'],
            'title'            => ['required', 'string', 'max:255'],
            'author'           => ['required', 'string', 'max:255'],
            'year_submitted'   => ['required', 'integer'],
            'language'         => ['nullable', 'string', 'max:255'],
            'type'            => ['nullable', 'string', 'max:255'],
            'number_of_pages'  => ['nullable', 'integer', 'min:1'],
            'format'           => ['nullable', 'in:hardcover,paperback,ebook'],
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

        $research = Research::create($attributes);
        if(!empty($attributes['file'])) {
            $manager = ImageManager::gd();
            $image = $manager->read($request->file('file'));
            $image->scale(height: 350);

            $image->crop(235, 350, position: 'center');
        }

        $source = Research::findOrFail($id);

        if(!empty($image)) {
            $path = "public/images/researches";
            Storage::makeDirectory($path);
            $path .= "/$research->id.png";
            Storage::put($path, (string) $image->encode());

            $research->cover_image = "$research->id.png";
            $research->save();
        } else {
            if($source->cover_image) {
                $research->cover_image = $source->cover_image;
                $research->save();
            }
        }

        $research->ir_number = $source->ir_number;
        $research->save();


        return redirect('collections/researches')->with([
            'message' => "Successfully copied the thesis/research $research->title."
        ]);
    }

    public function destroy($id)
    {
        $research = Research::findOrFail($id);
        $path = "public/images/researches/$research->cover_image";

        if (Storage::exists($path)) {
            Storage::delete($path);
        }

        $research->delete();

        return redirect("collections/researches")
            ->with([
                'message' => 'Successfully deleted the thesis/research ' . $research->title . '.',
            ]);
    }

    public function copy($id)
    {
        $selected  = Research::findOrFail($id);
        $researches = Research::latest()->get();

        return view('researches.copy', [
            'researches' => $researches,
            'selected' => $selected,
            'languages' => $this->languages,
            'types'     => $this->types,
            'formats'   => $this->formats,
            'statuses'  => $this->statuses,
        ]);
    }

    public function edit($id)
    {
        $selected  = Research::findOrFail($id);
        $researches = Research::latest()->get();

        return view('researches.edit', [
            'researches' => $researches,
            'selected'   => $selected,
            'languages'  => $this->languages,
            'types'      => $this->types,
            'formats'    => $this->formats,
            'statuses'   => $this->statuses,
        ]);
    }

    public function update(Request $request, $id)
    {
        $research = Research::findOrFail($id);
        $rules = [
            'accession_number' => ['nullable', 'string', 'unique:researches,accession_number', 'max:255'],
            'barcode'   => ['nullable', 'string', 'unique:researches,barcode', 'max:255'],
            'lcc_number'       => ['nullable', 'string', 'max:255'],
            'ddc_number'       => ['nullable', 'string', 'max:255'],
            'ir_number'        => ['nullable', 'string', 'max:255'],
            'title'            => ['required', 'string', 'max:255'],
            'author'           => ['required', 'string', 'max:255'],
            'year_submitted'   => ['required', 'integer'],
            'language'         => ['nullable', 'string', 'max:255'],
            'type'             => ['nullable', 'string', 'max:255'],
            'number_of_pages'  => ['nullable', 'integer', 'min:1'],
            'format'           => ['nullable', 'in:hardcover,paperback,ebook'],
            'summary'          => ['nullable', 'string'],
            'location'         => ['nullable', 'string', 'max:255'],
            'tags'             => ['nullable', 'string', 'max:255'],
            'status'           => ['required', 'string', 'max:255'],
            'file'             => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];

        if($request->post('accession_number') == $research->accession_number) {
            unset($rules['accession_number']);
        }
        if($request->post('barcode') == $research->barcode) {
            unset($rules['barcode']);
        }

        $attributes = $request->validate($rules);

        if(Auth::user()->role != 'admin') {
            $staff = Staff::where('email', Auth::user()->email)->first();
            $attributes['library'] = $staff->library;
        }

        $research->update($attributes);
        if(!empty($attributes['file'])) {
            $manager = ImageManager::gd();
            $image = $manager->read($request->file('file'));
            $image->scale(height: 350);

            $image->crop(235, 350, position: 'center');
        }

        if(!empty($image)) {
            $path = "public/images/researches";
            Storage::makeDirectory($path);
            $path .= "/$research->id.png";
            Storage::put($path, (string) $image->encode());

            $research->cover_image = $research->id . ".png";
            $research->save();
        }

        return redirect('collections/researches')->with([
            'message' => "Successfully updated the thesis/research $research->name."
        ]);
    }
}
