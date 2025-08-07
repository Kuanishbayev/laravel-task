<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationRequest;
use App\Jobs\SendEmailJob;
use App\Mail\ApplicationCreated;
use App\Models\Application;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class ApplicationController extends Controller
{
    public function index()
    {
        return view('applications.index', ['applications' => auth()->user()->applications]);
    }


    public function store(StoreApplicationRequest $request)
    {


        if ($this->checkDate()) {
            if ($request->hasFile('file')) {
                $path = $request->file('file')->store('files', 'public');
            }

            $application = Application::create([
                'user_id' => auth()->user()->id,
                'subject' => $request->subject,
                'message' => $request->message,
                'file_url' => $path ?? null
            ]);

            dispatch(new SendEmailJob($application));

            return back();
        }

        return back()->with('error', 'You can create only one application a day.');
    }


    public function checkDate()
    {
        if (is_null(auth()->user()->applications()->latest()->first())) {
            return true;
        }

        $last_application = auth()->user()->applications()->latest()->first();
        $last_app_date = Carbon::parse($last_application->created_at)->format('Y-m-d');
        $today = Carbon::now()->format('Y-m-d');

        return $last_app_date < $today;
    }
}
