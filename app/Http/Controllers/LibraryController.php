<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Library;

class LibraryController extends Controller
{
    public function index()
    {
        $libraries = Library::latest()->get();

        return view('libraries.index', [
            'libraries' => $libraries,
        ]);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'code' => ['required','unique:libraries,code'],
            'name' => ['required','unique:libraries,name'],
            'host' => ['required'],
            'address' => ['required'],
            'description' => ['required'],
        ]);

        $library = Library::create($attributes);

        return redirect('/settings/libraries')->with([
            'message' => "Successfully created the library $library->name."
        ]);
    }

    public function destroy($id)
    {
        $library = Library::findOrFail($id);
        $library->delete();

        return redirect("/settings/libraries")
            ->with([
                'message' => 'Successfully deleted the library ' . $library->name . '.',
            ]);
    }

    public function edit($id)
    {
        $selected  = Library::findOrFail($id);
        $libraries = Library::latest()->get();

        return view('libraries.edit', [
            'libraries' => $libraries,
            'selected' => $selected,
        ]);
    }

    public function update(Request $request, $id)
    {
        $library = Library::findOrFail($id);
        $rules = [
            'code' => ['required','unique:libraries,code'],
            'name' => ['required','unique:libraries,name'],
            'host' => ['required'],
            'address' => ['required'],
            'description' => ['required'],
        ];

        if($request->post('name') == $library->name) {
            unset($rules['name']);
        }
        if($request->post('code') == $library->code) {
            unset($rules['code']);
        }

        $attributes = $request->validate($rules);

        $library->update($attributes);

        return redirect('/settings/libraries')->with([
            'message' => "Successfully updated the library $library->name."
        ]);
    }
}
