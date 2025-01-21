<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\saison;
use App\Models\series;
use App\Models\episode;
use App\Models\Personnes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeriesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function voirSerie($idSerie)
    {
        $serie =series::find($idSerie);
        $createur=Personnes::find($serie->createur_id);
        $saisonsSerie=saison::where('series_id',$serie->id)->get();
        $coms=$serie->getCommentSerie();
        foreach ($coms as $com) {
            $usersName[]=User::find($com->user_id); 
        }
        if (!isset($usersName)) {
            $usersName=null;
        }
        $userId=Auth::user()->id;
        $user=User::find($userId);
        $user->UserSerieVue()->attach($idSerie);
        $hasSerie = $user->UserSerie()->where('series_id', $idSerie)->exists();
        return view('/serie/regarderSerie', [
            'serie' => $serie,
            'createur'=>$createur,
            'saisons'=>$saisonsSerie,
            'com'=>$coms,
            'UsersCom'=>$usersName,
            'IsInlist'=>$hasSerie,
        ] );
    }

    public function voirSaison($seriId,$saisonId)
    {   
        $serie =series::find($seriId);
        $saison=saison::find($saisonId);
        $episode=episode::where('saisons_id',$saisonId)->get();
        return view('/serie/regarderSerieSaison', [
            'serie' => $serie,
            'saison'=>$saison,
            'episode'=>$episode,
        ] );
    }

    public function voirEpisode($seriId,$saisonId,$episodeId)
    {   
        $serie =series::find($seriId);
        $saison=saison::find($saisonId);
        $episode=episode::find($episodeId);
        return view('/serie/regarderSerieSaisonEpisode', [
            'serie' => $serie,
            'saison'=>$saison,
            'episode'=>$episode,
        ] );
    }

    public function ajoutMalisteSerie(Request $request)
    {
        $idSerie=$request->idSerie;
        $userId=Auth::user()->id;
        $user=User::find($userId);
        $user->UserSerie()->attach($idSerie);

    }
    public function suppMalisteSerie(Request $request)
    {
        $idSerie=$request->idSerie; 
        $userId=Auth::user()->id;
        $user=User::find($userId);
        $user->UserSerie()->detach($idSerie);

    }
}
