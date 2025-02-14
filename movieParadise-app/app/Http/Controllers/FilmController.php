<?php

namespace App\Http\Controllers;

use App\Models\film;
use App\Models\User;
use App\Models\Personnes;
use App\Models\commantaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        $user->UserFilmVue()->attach($idfilm);

        
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
    public function showFilmInfo($id)
    {
        $film = film::find($id);
  
        return response()->json($film);
    }
    public function updateFilm(Request $request){
        $film=film::find($request->filmUpdate_id);
        if ($request->active==true) {
           $film->active=1;
        }else{
            $film->active=0;
        }
        $film->titre=$request->titre;
        $film->resume=$request->resume;
        $film->dateSortie=date("Y-m-d ",strtotime($request->dateSortie));
        $film->duree=$request->duree;
        $film->save();
        return redirect()->back()->withErrors(['Changements sauvegarder']);;

    }
    
    public function deleteFilm($id){
        $film=film::find($id);
        $film->filmsActeurs()->delete();
        $film->filmCategories()->delete();
        $film->delete();

        return redirect()->back()->withErrors(['Film suprimé avec succès']);
    }

   
    
}
