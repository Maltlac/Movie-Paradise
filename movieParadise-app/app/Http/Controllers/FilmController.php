<?php

namespace App\Http\Controllers;

use App\Models\film;
use App\Models\realisateurs;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    public function voirfilm($film)
    {
        $film =film::find($film);
        $real=realisateurs::find($film->realisateurs_id);
        return view('/film/regarderFilm', [
            'film' => $film,
            'real'=>$real
        ] );
    }

   
    
}
