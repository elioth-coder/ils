<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\College;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::latest()->get();
        $colleges = College::all();

        return view('programs.index', [
            'programs' => $programs,
            'colleges' => $colleges,
        ]);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'code' => ['required','unique:programs,code'],
            'name' => ['required','unique:programs,name'],
            'description' => ['required'],
            'college' => ['required','exists:colleges,code'],
            'program_length' => ['required','numeric','min:1','max:10'],
        ]);

        $program = Program::create($attributes);

        return redirect('settings/programs')->with([
            'message' => "Successfully created the program $program->name."
        ]);
    }

    public function destroy($id)
    {
        $program = Program::findOrFail($id);
        $program->delete();

        return redirect("settings/programs")
            ->with([
                'message' => 'Successfully deleted the program ' . $program->name . '.',
            ]);
    }

    public function edit($id)
    {
        $selected = Program::findOrFail($id);
        $programs = Program::latest()->get();
        $colleges = College::all();

        return view('programs.edit', [
            'programs' => $programs,
            'colleges' => $colleges,
            'selected' => $selected,
        ]);
    }

    public function update(Request $request, $id)
    {
        $program = Program::findOrFail($id);
        $rules = [
            'code' => ['required','unique:programs,code'],
            'name' => ['required','unique:programs,name'],
            'description' => ['required'],
            'college' => ['required','exists:colleges,code'],
            'program_length' => ['required','numeric','min:1','max:10'],
        ];

        if($request->post('name') == $program->name) {
            unset($rules['name']);
        }
        if($request->post('code') == $program->code) {
            unset($rules['code']);
        }

        $attributes = $request->validate($rules);

        $program->update($attributes);

        return redirect('settings/programs')->with([
            'message' => "Successfully updated the program $program->name."
        ]);
    }
}
