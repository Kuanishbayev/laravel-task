<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AnswerController extends Controller
{
    public function create(Application $application)
    {
        Gate::authorize('answer-to-application');
        return view('answers.create', ['application' => $application]);
    }


    public function store(Application $application, Request $request)
    {
        Gate::authorize('answer-to-application');

        $request->validate([
            'body' => 'required'
        ]);

        $application->answer()->create([
            'body' => $request->body
        ]);

        return redirect()->route('dashboard');
    }
}
