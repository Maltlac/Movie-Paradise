<?php

namespace App\Http\Controllers;

use App\Models\saison;
use App\Models\series;
use App\Models\episode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class episodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
    public function showEpisodeInfo($id)
    {
        $Serie = episode::find($id);
  
        return response()->json($Serie);
    }

    public function updateEpisode(Request $request){
        $episode=episode::find($request->serieUpdate_id);
        $episode->titre=$request->titre;
        $episode->resume=$request->resume;
        $episode->dateSortie=date("Y-m-d ",strtotime($request->dateSortie));
        $episode->duree=$request->duree;
        $episode->numeroEpisode=$request->numeroEpisode;
        $episode->save();
        return redirect()->back()->withErrors(['Changements sauvegarder']);;

    }
    
    public function deleteEpisode($id){
        episode::find($id)->delete();
        return redirect()->back()->withErrors(['Episode suprimé avec succès']);
    }

    public function ajoutEpisode(Request $request){
        $data=[
            'titre'=>$request->titre,
            'resume'=>$request->resume,
            'numeroEpisode'=>$request->numeroEpisode,
            'dateSortie'=>date("Y-m-d ",strtotime($request->dateSortie)),
            'duree'=>$request->duree,
            'saisons_id'=>$request->saisonUpdate_id,
        ];

        episode::create($data);
        return redirect()->back()->withErrors(['Episode ajouté avec succès']);;
    }
}
