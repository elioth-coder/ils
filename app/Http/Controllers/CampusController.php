<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campus;

class CampusController extends Controller
{
    public function index()
    {
        $campuses = Campus::latest()->get();

        return view('campuses.index', [
            'campuses' => $campuses,
        ]);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'code' => ['required','unique:campuses,code'],
            'name' => ['required','unique:campuses,name'],
            'address' => ['required'],
            'description' => ['required'],
        ]);

        $campus = Campus::create($attributes);

        return redirect('settings/campuses')->with([
            'message' => "Successfully created the campus $campus->name."
        ]);
    }

    public function destroy($id)
    {
        $campus = Campus::findOrFail($id);
        $campus->delete();

        return redirect("settings/campuses")
            ->with([
                'message' => 'Successfully deleted the campus ' . $campus->name . '.',
            ]);
    }

    public function edit($id)
    {
        $selected  = Campus::findOrFail($id);
        $campuses = Campus::latest()->get();

        return view('campuses.edit', [
            'campuses' => $campuses,
            'selected' => $selected,
        ]);
    }

    public function update(Request $request, $id)
    {
        $campus = Campus::findOrFail($id);
        $rules = [
            'code' => ['required','unique:campuses,code'],
            'name' => ['required','unique:campuses,name'],
            'address' => ['required'],
            'description' => ['required'],
        ];

        if($request->post('name') == $campus->name) {
            unset($rules['name']);
        }
        if($request->post('code') == $campus->code) {
            unset($rules['code']);
        }

        $attributes = $request->validate($rules);

        $campus->update($attributes);

        return redirect('settings/campuses')->with([
            'message' => "Successfully updated the campus $campus->name."
        ]);
    }
}
