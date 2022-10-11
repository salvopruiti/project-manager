<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        /** @var User $user */
        $user = request()->user();

        $data['tasks'] = $user->tasks()->active()->with(['sessions', 'ticket', 'activeSession'])->withSessionsTime()->get()->sortByDesc(function($data) {
            return $data->sessions->whereNull('stopped_at')->max('started_at');
        })->map(function($task) use($user) {
            $task->user = $user;
            return $task;
        });


        return view('home', $data);
    }
}
