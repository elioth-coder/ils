<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\College;

class CollegeController extends Controller
{
    public function index()
    {
        $colleges = College::latest()->get();

        return view('colleges.index', [
            'colleges' => $colleges,
        ]);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'code' => ['required','unique:colleges,code'],
            'name' => ['required','unique:colleges,name'],
            'description' => ['required'],
        ]);

        $college = College::create($attributes);

        return redirect('/settings/colleges')->with([
            'message' => "Successfully created the college $college->name."
        ]);
    }

    public function destroy($id)
    {
        $college = College::findOrFail($id);
        $college->delete();

        return redirect("/settings/colleges")
            ->with([
                'message' => 'Successfully deleted the college ' . $college->name . '.',
            ]);
    }

    public function edit($id)
    {
        $selected  = College::findOrFail($id);
        $colleges = College::latest()->get();

        return view('colleges.edit', [
            'colleges' => $colleges,
            'selected' => $selected,
        ]);
    }

    public function update(Request $request, $id)
    {
        $college = College::findOrFail($id);
        $rules = [
            'code' => ['required','unique:colleges,code'],
            'name' => ['required','unique:colleges,name'],
            'description' => ['required'],
        ];

        if($request->post('name') == $college->name) {
            unset($rules['name']);
        }

        if($request->post('code') == $college->code) {
            unset($rules['code']);
        }

        $attributes = $request->validate($rules);

        $college->update($attributes);

        return redirect('/settings/colleges')->with([
            'message' => "Successfully updated the college $college->name."
        ]);
    }
}
