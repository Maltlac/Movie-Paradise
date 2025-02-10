<?php

namespace App\Http\Controllers;

use App\Models\saison;
use App\Models\series;
use App\Models\episode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class saisonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
    public function showSaisonInfo($id)
    {
        $saison = saison::find($id);
  
        return response()->json($saison);
    }

    public function updateSaison(Request $request){
        //dd($request);
        DB::statement('UPDATE saisons SET titre = "'.$request->titre.'",resume="'.$request->resume.'",dateSortie="'.date("Y-m-d ",strtotime($request->dateSortie)).'", numeroSaison='.$request->numeroSaison.' WHERE id ='.$request->serieUpdate_id);
        return redirect()->back()->withErrors(['Changements sauvegarder']);;

    }
    
    public function deleteSaison($id){
        episode::where('saisons_id',$id)->delete();
        saison::find($id)->delete();
        return redirect()->back()->withErrors(['Saison suprimé avec succès']);
    }

    public function ajoutSaison(Request $request){
        $data=[
            'titre'=>$request->titre,
            'resume'=>$request->resume,
            'numeroSaison'=>$request->numeroSaison,
            'dateSortie'=>date("Y-m-d ",strtotime($request->dateSortie)),
            'series_id'=>$request->serieUpdate_id,
        ];

        saison::create($data);
        return redirect()->back()->withErrors(['Saison ajouté avec succès']);;
    }
}
