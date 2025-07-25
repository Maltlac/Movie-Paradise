<?php

namespace App\Http\Controllers;

use App\Models\film;
use App\Models\User;
use App\Models\series;
use App\Models\Personnes;
use App\Models\categories;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;


class StreamingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $mostViewFilm= DB::select("SELECT film_id, COUNT(*) AS nombre_de_vues FROM film_vue WHERE EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM CURRENT_DATE) GROUP BY film_id ORDER BY nombre_de_vues DESC LIMIT 5;");
        foreach ($mostViewFilm as $movie ) {
            $filmMV[]=film::find($movie->film_id);
        }
        

        
        $userId=Auth::user()->id;
        $user=User::find($userId);

      
        $FilmRecommander= film::filmR($userId);
        $toutesCateg= categories::categsFilmR($userId);
        $film=film::inRandomOrder()->where("active",1)->limit(20)->get();
        $serie=series::inRandomOrder()->limit(20)->get();

        $lastAdd=film::latest()->where("active",1)->take(10)->get()->toArray();
        $lastAdd2=series::latest()->take(10)->get()->toArray();
        $listeFilm=$user->UserFilm()->where("active",1)->get()->toArray();
        $listeSerie=$user->UserSerie()->get()->toArray();
        $maListe=array_merge($listeFilm,$listeSerie);
        $merge = array_merge($lastAdd2,$lastAdd);

        shuffle($merge);
        shuffle($maListe);
        return view('/streaming/voirTout',[
            'film'=>$film,
            'serie'=>$serie,
            'lastAdd'=>$merge??"",
            'maListe'=>$maListe??"",
            'filmMV'=>$filmMV ?? "" ,
            'FilmRecommander'=>$FilmRecommander?? "",
            'toutesCateg'=>$toutesCateg?? "",

        ]);
    }
  
    public function search(Request $request)
    {
          $search = $request->get('titre');
      
          $result = film::where('titre', 'LIKE', '%'. $search. '%')->get('titre');

          $result2 = series::where('titre', 'LIKE', '%'. $search. '%')->get('titre');

          $result3 = Personnes::where('name', 'LIKE', '%'. $search. '%')->get('name');
          $data = array();

          foreach ($result as $hsl)
              {
                  $data[] = $hsl->titre;
              }
            foreach ($result2 as $hsl)
              {
                  $data[] = $hsl->titre;
              }
              foreach ($result3 as $hsl)
              {
                  $data[] = $hsl->name;
              }
          return response()->json($data);
            
    } 

     public function searchStreaming(Request $request)
    {
        $request=$request['search'];
        $result = array();
        
        $result[] = film::where('titre', 'LIKE', '%'. $request. '%')->get();

        $result[] = series::where('titre', 'LIKE', '%'. $request. '%')->get();

        $result[] = Personnes::where('name', 'LIKE', '%'. $request. '%')->get();
       // dd($result);
        return view('streaming/search',[
            'data'=>$result,
        ]);

    }

    public function searchCateg($p,$idCateg,$year)
    {
        $categAll=categories::all();
        $categ=categories::find($idCateg);

        $yearFilm=DB::table('films')->selectRaw('YEAR(dateSortie) AS year')->orderBy('year')->distinct()->pluck('year')->toArray();
        $yearSerie=DB::table('series')->selectRaw('YEAR(dateSortie) AS year')->orderBy('year')->distinct()->pluck('year')->toArray();
        $years = array_merge($yearSerie, $yearFilm);
        $sortedYear = array_unique($years);
        sort($sortedYear);
        if ($p=="film") {
            if($year=="tous"){
                $requete=$categ->categoriesFilm()->paginate(10);
            }else{
                $requete=$categ->categoriesFilm()->whereYear("dateSortie",'=',$year)->paginate(10);
            }
        }else if($p=="series"){
            if($year=="tous"){
                $requete=$categ->categoriesSerie()->paginate(10);
            }else{
                $requete=$categ->categoriesSerie()->whereYear("dateSortie",'=',$year)->paginate(10);
            }      
        }

        return view("streaming/searchCategYear",[
            "search"=>$requete,
            'listeCateg'=>$categAll,
            'p'=>$p,
            'categSearch'=>$idCateg,
            'years'=>$sortedYear,
            'yearSelected'=>$year
        ]);
    }

    public function searchCategVars(Request $request){
       $p=$request['p'];
       $categ=$request['categ'];
       $year=$request['year'];
        return redirect("/p/$p/categ/$categ/year/$year");
    }

}
