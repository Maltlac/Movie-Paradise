<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\commantaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class profilController extends Controller
{
    public function profilComments(){
        $userId=Auth::user()->id;
        $coms=commantaire::where("user_id",$userId)->orderby("created_at","desc")->get();
        $nbcoms=commantaire::where("user_id",$userId)->count();


        return view('profil/profilComents',[
            'coms'=>$coms,
            'nbcoms'=>$nbcoms,
        ]);
    }

    public function profilParametre(){
        $userId=Auth::user()->id;
        $nbcoms=commantaire::where("user_id",$userId)->count();
        return view('profil/paramProfil', [
            'nbcoms'=>$nbcoms,
        ]);
    }

    public function updateProfil(Request $request){
        $user=User::find(Auth::user()->id);
        $user->name=$request->name;
        $user->info=$request->mood;
        $user->save();

        return redirect()->back()->withErrors(['profil modifié avec succès']);
    }
}
