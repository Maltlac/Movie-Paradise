<?php

namespace App\Http\Controllers;

use App\Models\film;
use App\Models\series;
use Illuminate\Http\Request;

class StreamingController extends Controller
{
    public function index()
    {
        $film=film::inRandomOrder()->limit(20)->get();
        $serie=series::inRandomOrder()->limit(20)->get();
        return view('/streaming/voirTout',[
            'film'=>$film,
            'serie'=>$serie,
        ]);
    }
}
