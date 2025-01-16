<?php

namespace App\Http\Controllers;

use App\Models\film;
use App\Models\User;
use App\Models\series;
use App\Models\Personnes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonnesController extends Controller
{
     function showBio($idPers){

        $personne=Personnes::find($idPers);
        $tabFilms=$personne->acteursFilms;
        $tabSeries=$personne->acteursSeries;
        $tabReal=film::where('realisateurs_id','=',$personne->id)->get();
        $apparitions=count($tabFilms)+count($tabReal)+count($tabSeries);

        if (count($tabFilms)==0) {$tabFilms=null;}
        if (count($tabSeries)==0) {$tabSeries=null;}
        if (count($tabReal)==0) {$tabReal=null;}

        //dd($tabFilms,$tabReal,$tabSeries,$personne,$apparitions);
        return view('/bioPersonne', [
            'bio' => $personne,
            'tabFilms'=>$tabFilms,
            'tabSeries'=>$tabSeries,
            'tabReal'=>$tabReal,
            'apparitions'=>$apparitions,
        ] );
    }
    public function ajoutMalistePersonne($Personne)
    {
        $userId=Auth::user()->id;
        $user=User::find($userId);
        $user->UserPersonne()->attach($Personne);

    }
    public function suppMalistePersonne($Personne)
    {
        $userId=Auth::user()->id;
        $user=User::find($userId);
        $user->UserPersonne()->detach($Personne);

    }
}
