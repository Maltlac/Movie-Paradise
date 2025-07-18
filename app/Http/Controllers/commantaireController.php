<?php

namespace App\Http\Controllers;

use App\Models\commantaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class commantaireController extends Controller
{
    public function postCommentMovie(Request $request, $idFilm){
      $rating = $request->get('selected_rating');
      $msg = $request->get('msg');
      $idUser=Auth::user()->id;
      $data=[
        'Corp'=>$msg,
        'note'=>$rating,
        'user_id'=>$idUser,
        'film_id'=>$idFilm,
      ];
      commantaire::create($data);
      return redirect("/film/$idFilm");
    }

    public function postCommentSerie(Request $request, $idSeries){
      $rating = $request->get('selected_rating');
      $msg = $request->get('msg');
      $idUser=Auth::user()->id;
      $data=[
        'Corp'=>$msg,
        'note'=>$rating,
        'user_id'=>$idUser,
        'Series_id'=>$idSeries,
      ];
      commantaire::create($data);
      return redirect("/serie/$idSeries");
    }
    public function showComInfo($id)
    {
        $commentaire = commantaire::find($id);
  
        return response()->json($commentaire);
    }
    public function updateCommentaire(Request $request){
      $commentaire = commantaire::find($request->comUpdateId);
      $commentaire->Corp= $request->corp;
      $commentaire->save();
      return redirect()->back()->withErrors(['Commentaire modifié avec succès']);
    }

    public function deleteCommentaire($id){
      commantaire::find($id)->delete();
      return redirect()->back()->withErrors(['Commentaire supprimé avec succès']);
    }
}
