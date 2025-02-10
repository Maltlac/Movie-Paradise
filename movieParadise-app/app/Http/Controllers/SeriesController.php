<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\saison;
use App\Models\series;
use App\Models\episode;
use App\Models\Personnes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function showSerieInfo($id)
    {
        $Serie = Series::find($id);
  
        return response()->json($Serie);
    }

    public function updateSerie(Request $request){
        //dd($request);
        DB::statement('UPDATE series SET titre = "'.$request->titre.'",resume="'.$request->resume.'",dateSortie="'.date("Y-m-d ",strtotime($request->dateSortie)).'" WHERE id ='.$request->serieUpdate_id);
        return redirect()->back()->withErrors(['Changements sauvegarder']);;

    }
    
    public function deleteSerie($id){
        $Serie=Series::find($id);
        $Serie->SeriesActeurs()->delete();
        $saisonsSerie=saison::where('series_id',$id)->get();
        foreach ($saisonsSerie as $saison) {
            episode::where('saisons_id',$saison->id)->delete();
        }
        saison::where('series_id',$id)->delete();
        $Serie->SeriesCategories()->delete();
        $Serie->delete();


        return redirect()->back()->withErrors(['Serie suprimé avec succès']);
    }
}
