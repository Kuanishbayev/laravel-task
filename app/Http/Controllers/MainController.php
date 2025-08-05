<?php

namespace App\Http\Controllers;

use App\Models\Application;

class MainController extends Controller
{
    public function main()
    {
        return view('welcome');
    }


    public function dashboard()
    {
        return view('dashboard')->with([
            'applications' => Application::latest()->paginate(5)
        ]);
    }
}
