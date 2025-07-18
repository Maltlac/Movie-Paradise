<?php

namespace App\Http\Controllers;

use App\Models\film;
use Illuminate\Http\Request;
use CyrildeWit\EloquentViewable\Contracts\Viewable;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function test()
    {
        $film=film::all();
        return view('testView',compact('film'));
    }
}
