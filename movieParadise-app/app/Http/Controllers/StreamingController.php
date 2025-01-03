<?php

namespace App\Http\Controllers;

use App\Models\film;
use Illuminate\Http\Request;

class StreamingController extends Controller
{
    public function index()
    {
        $film=film::inRandomOrder()->limit(20)->get();;
        return view('/streaming/voirTout',[
            'film'=>$film,
        ]);
    }
}
