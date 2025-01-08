<?php

namespace App\Http\Controllers;

use App\Models\saison;
use App\Models\series;
use App\Models\episode;
use App\Models\Personnes;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function voirSerie($serie)
    {
        $serie =series::find($serie);
        $createur=Personnes::find($serie->createur_id);
        $saisonsSerie=saison::where('series_id',$serie->id)->get();
        return view('/serie/regarderSerie', [
            'serie' => $serie,
            'createur'=>$createur,
            'saisons'=>$saisonsSerie,
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
}
