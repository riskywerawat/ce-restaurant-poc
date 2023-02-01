<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function support(Request $request)
    {
        return view('public.support');
    }
}
