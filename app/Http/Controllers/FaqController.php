<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::latest()->get();

        return view('faqs.index', [
            'faqs'     => $faqs,
        ]);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'question'         => ['required', 'string', 'unique:faqs,question', 'max:255'],
            'answer'           => ['required', 'string'],
            'keywords'         => ['required', 'string', 'max:255'],
        ]);

        $faq = Faq::create($attributes);

        return redirect('settings/faqs')->with([
            'message' => "Successfully created an faq."
        ]);
    }

    public function destroy($id)
    {
        $item = Faq::findOrFail($id);

        $item->delete();

        return redirect("settings/faqs")
            ->with([
                'message' => 'Successfully deleted the faq.',
            ]);
    }


    public function edit($id)
    {
        $selected  = Faq::findOrFail($id);

        $faqs = Faq::latest()->get();

        return view('faqs.edit', [
            'faqs'     => $faqs,
            'selected' => $selected,
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = Faq::findOrFail($id);
        $rules = [
            'question'         => ['required', 'string', 'unique:faqs,question', 'max:255'],
            'answer'           => ['required', 'string'],
            'keywords'         => ['required', 'string', 'max:255'],
        ];

        if($request->post('question') == $item->question) {
            unset($rules['question']);
        }

        $attributes = $request->validate($rules);
        $item->update($attributes);

        return redirect('settings/faqs')->with([
            'message' => "Successfully updated the faq."
        ]);
    }
}
