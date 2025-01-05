<?php

namespace App\Http\Controllers;

use App\Models\film;
use App\Models\Acteurs;
use App\Models\realisateurs;
use Illuminate\Http\Request;

class ActeurController extends Controller
{
    function showBio($idPers,$type){
        if($type=="realisateur"){
            $personne=realisateurs::find($idPers);
            $Acteur=Acteurs::whereName($personne->name)->first();
            $RealFilm=realisateurs::whereName($personne->name)->first();
        }
        elseif($type=="acteur"){
            $personne=Acteurs::find($idPers);
            $Acteur=Acteurs::whereName($personne->name)->first();
            $RealFilm=realisateurs::whereName($personne->name)->first();
        }
        

        if (!empty($RealFilm)) {
            $RealFilm= film::where('realisateurs_id','=',$RealFilm->id)->get();
        }

        if (!empty($Acteur)) {
            $Acteur=$Acteur->acteursFilms;
        }

        if (empty($RealFilm)) {
            $tab1=$Acteur;
            $type1="Interprétation";
            $tab2=$RealFilm;
            $type2="Réalisation";
            $apparitions=count($Acteur);
        }
        elseif(empty($Acteur)){
            $tab1=$RealFilm;
            $type1="Réalisation";
            $tab2=$Acteur;
            $type2="Interprétation";
            $apparitions=count($RealFilm);
        }

        if (!empty($Acteur) && !empty($RealFilm)) {
            if (count($Acteur)>count($RealFilm)) {
                $tab1=$Acteur;
                $type1="Interprétation";
                $tab2=$RealFilm;
                $type2="Réalisation";
            }else{
                $tab2=$Acteur;
                $type2="Interprétation";
                $tab1=$RealFilm;
                $type1="Réalisation";
            }
            $apparitions=count($Acteur)+count($RealFilm);
        }
        
          // dd($type1,$type2,$tab1,$tab2);
        return view('/bioActeursRealisateur', [
            'bio' => $personne,
            'type1'=>$type1,
            'type2'=>$type2,
            'tab1'=>$tab1,
            'tab2'=>$tab2,
            'apparitions'=>$apparitions,
        ] );
    }
}
