<?php

namespace App\Http\Controllers;
use App\Models\film;
use App\Models\Acteurs;
use App\Models\categories;
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
            $idTMDBrealisateur=0;
            foreach($credits['crew'] as $findDirector){
                if ($findDirector['job']=="Director") {
                    $directorName=$findDirector['original_name'];
                    $idTMDBrealisateur=$findDirector['id'];
                    break;
                }
            }
            if (empty($directorName)) {
                $directorName="N/A";
            }else{
                if (realisateurs::Where('name','=',$directorName)->count() > 0) {
                    $realisateurId=realisateurs::whereName($directorName)->first();
                }else{
                    $realInfo =Http::get("https://api.themoviedb.org/3/person/$idTMDBrealisateur?api_key=cffc672e34d23c4c89487652fccefd28&language=fr-FR")->json();
                    $realisateurId=realisateurs::firstOrCreate([
                        'name'=>$realInfo['name'],
                        'bio'=>$realInfo['biography'],
                        'image'=>$realInfo['profile_path'],
                        'dateNaissance'=>$realInfo['birthday']
                    ]);
                }  
            }
           

            $castFilm=null;
            for ($i=0; $i < 30; $i++) { 
                if (!empty($credits['cast'][$i])) {
                    $castFilm[]=$credits['cast'][$i];
                }
                
            }
            
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

            foreach ($castFilm as $acteur) {
                $idTMDBacteur=$acteur['id'];
                if (Acteurs::Where('name','=',$acteur['name'])->count() > 0) {
                    $acteurId=Acteurs::whereName($acteur['name'])->first();
                }else{
                    $acteurInfo =Http::get("https://api.themoviedb.org/3/person/$idTMDBacteur?api_key=cffc672e34d23c4c89487652fccefd28&language=fr-FR")->json();
                    $acteurId=Acteurs::firstOrCreate([
                        'name'=>$acteurInfo['name'],
                        'bio'=>$acteurInfo['biography'],
                        'image'=>$acteurInfo['profile_path'],
                        'dateNaissance'=>$acteurInfo['birthday']
                    ]);
                }        
                DB::insert('Insert into acteurs_film (film_id,acteurs_id) VALUES(?,?)', [$id_film ,$acteurId->id]);
            }
            
            foreach ($film['genres'] as $genreFilm) {
                $categId=categories::firstOrCreate([
                    'nom'=>$genreFilm['name']
                ]);

                $categId=categories::whereNom($genreFilm['name'])->first();
                DB::insert('Insert into categories_film (film_id,categories_id) VALUES(?,?)', [$id_film ,$categId->id]);
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
