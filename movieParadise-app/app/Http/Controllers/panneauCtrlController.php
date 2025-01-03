<?php

namespace App\Http\Controllers;
use App\Models\film;
use App\Models\realisateurs;
use Illuminate\Http\Request;
use Psy\Readline\Hoa\Console;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;


class panneauCtrlController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(){
        return view("adminV/panneauCtrl");
    }
    public function ajoutFilm(){
        return view("adminV/ajoutFilm");
    }

    public function storeFilm(Request $request){
        

        $films = $request->input('tmdb_film_id');

        if (empty($films)) {
            return abort(403);
        }
        foreach ($films as $filmId) {
            $film=Http::get("https://api.themoviedb.org/3/movie/$filmId?api_key=cffc672e34d23c4c89487652fccefd28&language=fr-FR")->json(); 
            $traillerYtb=Http::get("https://api.themoviedb.org/3/movie/$filmId/videos?api_key=cffc672e34d23c4c89487652fccefd28&language=fr-FR")->json()['results'];
            $credits =Http::get("https://api.themoviedb.org/3/movie/$filmId/credits?api_key=cffc672e34d23c4c89487652fccefd28&language=fr-FR")->json();

            foreach($credits['crew'] as $findDirector){
                if ($findDirector['job']=="Director") {
                    $directorName=$findDirector['original_name'];
                    break;
                }
            }
            if (empty($directorName)) {
                $directorName="N/A";
            }
            $realisateurId=realisateurs::firstOrCreate([
                'name'=>$directorName
            ]);
            $realisateurId=realisateurs::whereName($directorName)->first();
            
            //dd($realisateurId);
            foreach ($traillerYtb as $trYtb) {
                if ($trYtb['site']=="YouTube") {
                    $trailler=$trYtb['key'];
                }
            }
            
            $time=$film['runtime'];
            $hours = floor($time / 60);
            $minutes = ($time % 60);
            $data=[
                'titre'=>$film['original_title'],
                'realisateurs_id'=>$realisateurId->id,
                'duree'=>"$hours:$minutes:00",
                'resume'=>$film['overview'],
                'image'=>$film['poster_path'],
                'dateSortie'=>$film['release_date'],
                'urlTrailler'=>$trailler,
                'tmdb_id'=>$filmId
            ];

            $id_film=film::create($data);
            $id_film=DB::getPdo()->lastInsertId();
            foreach ($film['genres'] as $genreFilm) {
                DB::insert('Insert into categories_film (film_id,categories_id) VALUES(?,?)', [$id_film ,$genreFilm['id']] );
            }
        }
        return view("adminV/ajoutFilm");
        
    }


    public function searchBarFilm(Request $search){
        setlocale(LC_TIME, "fr_FR", "French");
        $output="";
        $films= Http::get('https://api.themoviedb.org/3/search/movie?api_key=cffc672e34d23c4c89487652fccefd28&query='.$search->search.'&language=fr-FR')
            ->json()['results'];
            
            
            if($films)
            {
                
                foreach($films as $film){
                    $output.='<tr id="'.$film['id'].'">'.
                    '<td> <img src="https://image.tmdb.org/t/p/w200'.$film['poster_path'].'"style="width: 100px"></td>'.
                    '<td>'.$film['title'].'</td>'.
                    '<td>'.$film['overview'].'</td>'.
                    '<td>'. strftime("%d %B %G", strtotime($film['release_date'])).'</td>'.
                    '<td>'.$film['vote_average']*10 .'%</td>'.
                    '<td>   <input type="checkbox" name="tmdb_film_id[]" value="'.$film['id'].'"></td>'.
                    '</tr>';
                }
                
               
                
            return Response($output);
            }

    }
        
    
}
