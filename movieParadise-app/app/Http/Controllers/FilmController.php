<?php

namespace App\Http\Controllers;

use App\Models\film;
use App\Models\User;
use App\Models\Personnes;
use App\Models\commantaire;
use Illuminate\Http\Request;

class FilmController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function voirfilm($film)
    {
        $film =film::find($film);
        $real=Personnes::find($film->realisateurs_id);
        $coms=$film->getCommentFilm();
        foreach ($coms as $com) {
            $usersName[]=User::find($com->user_id); 
        }
        if (!isset($usersName)) {
            $usersName=null;
        }
        
        return view('/film/regarderFilm', [
            'film' => $film,
            'real'=>$real,
            'com'=>$coms,
            'UsersCom'=>$usersName,
        ] );
    }

   
    
}
