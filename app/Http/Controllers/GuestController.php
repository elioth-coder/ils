<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index()
    {
        return view('guest.index');
    }

    public function about()
    {
        return view('guest.about');
    }

    public function rules()
    {
        return view('guest.rules');
    }

    public function resources()
    {
        return view('guest.resources');
    }

    public function faq(Request $request)
    {
        $q = $request->input('q') ?? '';

        $faqs =
            Faq::where('question', 'LIKE', "%$q%")
                ->orWhere('answer', 'LIKE', "%$q%")
                ->orWhere('keywords', 'LIKE', "%$q%")
                ->latest()
                ->paginate(5);

        return view('guest.faq', [
            'faqs' => $faqs,
        ]);
    }

}
