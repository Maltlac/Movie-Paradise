<?php

namespace App\Http\Controllers;

use App\Models\film;
use App\Models\User;
use App\Models\Personnes;
use App\Models\commantaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FilmController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function voirfilm($idfilm)
    {
        //film_vue
        $film =film::find($idfilm);
        $real=Personnes::find($film->realisateurs_id);
        $coms=$film->getCommentFilm();
        $userId=Auth::user()->id;
        $user=User::find($userId);

        
        foreach ($coms as $com) {
            $usersName[]=User::find($com->user_id); 
        }
        if (!isset($usersName)) {
            $usersName=null;
        }
        $hasFilm = $user->UserFilm()->where('film_id', $idfilm)->exists();

        return view('/film/regarderFilm', [
            'film' => $film,
            'real'=>$real,
            'com'=>$coms,
            'UsersCom'=>$usersName,
            'IsInlist'=>$hasFilm,
        ] );
    }

    public function ajoutMalisteFilm(Request $request)
    {
        $idFilm=$request->idFilm;
        $userId=Auth::user()->id;
        $user=User::find($userId);
        $user->UserFilm()->attach($idFilm);

    }
    public function suppMalisteFilm(Request $request)
    {
        $idFilm=$request->idFilm; 
        $userId=Auth::user()->id;
        $user=User::find($userId);
        $user->UserFilm()->detach($idFilm);

    }


   
    
}
