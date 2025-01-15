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
    

    }
}
