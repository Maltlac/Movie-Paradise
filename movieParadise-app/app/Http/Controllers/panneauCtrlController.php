<?php

namespace App\Http\Controllers;
use App\Models\film;
use App\Models\saison;
use App\Models\series;
use App\Models\episode;
use App\Models\Personnes;
use App\Models\categories;
use App\Models\User;
use Illuminate\Http\Request;
use Psy\Readline\Hoa\Console;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;


class panneauCtrlController extends Controller
{
    public $sortable = ['id', 'titre', 'dateSortie' ];
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

    public function ajoutSerie(){
        return view("adminV/ajoutSerie");
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
                if (Personnes::Where('name','=',$directorName)->count() > 0) {
                    $realisateurId=Personnes::whereName($directorName)->first();
                }else{
                    $realInfo =Http::get("https://api.themoviedb.org/3/person/$idTMDBrealisateur?api_key=cffc672e34d23c4c89487652fccefd28&language=fr-FR")->json();
                    $realisateurId=Personnes::firstOrCreate([
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
                'titre'=>$film['title'],
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
                if (Personnes::Where('name','=',$acteur['name'])->count() > 0) {
                    $acteurId=Personnes::whereName($acteur['name'])->first();
                }else{
                    $acteurInfo =Http::get("https://api.themoviedb.org/3/person/$idTMDBacteur?api_key=cffc672e34d23c4c89487652fccefd28&language=fr-FR")->json();
                    $acteurId=Personnes::firstOrCreate([
                        'name'=>$acteurInfo['name'],
                        'bio'=>$acteurInfo['biography'],
                        'image'=>$acteurInfo['profile_path'],
                        'dateNaissance'=>$acteurInfo['birthday']
                    ]);
                }        
                DB::insert('Insert into film_personnes (film_id,personnes_id) VALUES(?,?)', [$id_film ,$acteurId->id]);
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

    public function storeSerie(Request $request){

        $series = $request->input('tmdb_serie_id');
        
        if (empty($series)) {
            return abort(403);
        }
        
        foreach ($series as $serieId) {
            
            $serie=Http::get("https://api.themoviedb.org/3/tv/$serieId?api_key=cffc672e34d23c4c89487652fccefd28&language=fr-FR")->json(); 
            $traillerYtb=Http::get("https://api.themoviedb.org/3/tv/$serieId/videos?api_key=cffc672e34d23c4c89487652fccefd28&language=fr-FR")->json()['results'];
            $credits =Http::get("https://api.themoviedb.org/3/tv/$serieId/credits?api_key=cffc672e34d23c4c89487652fccefd28&language=fr-FR")->json();
            $createur=Http::get("https://api.themoviedb.org/3/person/".$serie['created_by'][0]['id']."?api_key=cffc672e34d23c4c89487652fccefd28&language=fr-FR")->json();
            if (empty($createur)) {
                $createur="N/A";
            }else{
                if (Personnes::Where('name','=',$createur['name'])->count() > 0) {
                    $createur=Personnes::whereName($createur['name'])->first();
                }else{
                    $createur=Personnes::firstOrCreate([
                        'name'=>$createur['name'],
                        'bio'=>$createur['biography'],
                        'image'=>$createur['profile_path'],
                        'dateNaissance'=>$createur['birthday']
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
            if (empty($trailler)) {
                $trailler="N/A";
            }
            
            
            $data=[
                'titre'=>$serie['name'],
                'createur_id'=>$createur->id,
                'resume'=>$serie['overview'],
                'image'=>$serie['poster_path'],
                'dateSortie'=>$serie['first_air_date'],
                'urlTrailler'=>$trailler,
                'tmdb_id'=>$serieId
            ];

            $id_serie=series::create($data);
            $id_serie=DB::getPdo()->lastInsertId();

            foreach ($serie['seasons'] as $saison) {
                $saisonNb=0;
                if ($saison['air_date']!="") {
                    $dataSaison=[
                        'titre'=>$saison['name'],
                        'resume'=>$saison['overview'],
                        'image'=>$saison['poster_path'],
                        'dateSortie'=>$saison['air_date'],
                        'numeroSaison'=>$saison['season_number'],
                        'tmdb_id'=>$saison['id'],
                        'series_id'=>$id_serie,
                    ];
                    $saisonNb=$saison['season_number'];
                }
                
                
               
                if ($saisonNb>0) {
                    $saisonId=saison::create($dataSaison);
                    $saisonId=DB::getPdo()->lastInsertId();
                    $episodes=Http::get("https://api.themoviedb.org/3/tv/$serieId/season/$saisonNb?api_key=cffc672e34d23c4c89487652fccefd28&language=fr-FR")->json();
                   
                    if (isset($episodes['id'])) {
                        foreach ($episodes['episodes'] as $episode) {
                            $dataEp=[
                                'titre'=>$episode['name'],
                                'resume'=>$episode['overview'],
                                'image'=>$episode['still_path'],
                                'dateSortie'=>$episode['air_date'],
                                'numeroEpisode'=>$episode['episode_number'],
                                'tmdb_id'=>$episode['id'],
                                'saisons_id'=>$saisonId,
                            ];
                            episode::create($dataEp);
                        }
                    }                
                }
           }

            foreach ($castFilm as $acteur) {
                $idTMDBacteur=$acteur['id'];
                if (Personnes::Where('name','=',$acteur['name'])->count() > 0) {
                    $acteurId=Personnes::whereName($acteur['name'])->first();
                }else{
                    $acteurInfo =Http::get("https://api.themoviedb.org/3/person/$idTMDBacteur?api_key=cffc672e34d23c4c89487652fccefd28&language=fr-FR")->json();
                    $acteurId=Personnes::firstOrCreate([
                        'name'=>$acteurInfo['name'],
                        'bio'=>$acteurInfo['biography'],
                        'image'=>$acteurInfo['profile_path'],
                        'dateNaissance'=>$acteurInfo['birthday']
                    ]);
                }        
                DB::insert('Insert into personnes_series (series_id,personnes_id) VALUES(?,?)', [$id_serie ,$acteurId->id]);
            }
            
            foreach ($serie['genres'] as $genrSerie) {
                $categId=categories::firstOrCreate([
                    'nom'=>$genrSerie['name']
                ]);

                $categId=categories::whereNom($genrSerie['name'])->first();
                DB::insert('Insert into categories_series(series_id,categories_id) VALUES(?,?)', [$id_serie ,$categId->id]);
            }
        }
        return view("adminV/ajoutSerie");
        
    }


    public function searchBarFilm(Request $search){
        setlocale(LC_TIME, "fr_FR", "French");
        $output="";
        $films= Http::get("https://api.themoviedb.org/3/search/movie?api_key=cffc672e34d23c4c89487652fccefd28&query=$search->search&language=fr-FR")
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

    public function searchBarSerie(Request $search){
        setlocale(LC_TIME, "fr_FR", "French");
        $output="";
        $series= Http::get("https://api.themoviedb.org/3/search/tv?api_key=cffc672e34d23c4c89487652fccefd28&query=$search->search&language=fr-FR")
            ->json()['results'];
            
            
            if($series)
            {
                
                foreach($series as $serie){
                    $output.='<tr id="'.$serie['id'].'">'.
                    '<td> <img src="https://image.tmdb.org/t/p/w200'.$serie['poster_path'].'"style="width: 100px"></td>'.
                    '<td>'.$serie['name'].'</td>'.
                    '<td>'.$serie['overview'].'</td>'.
                    '<td>'. strftime("%d %B %G", strtotime($serie['first_air_date'])).'</td>'.
                    '<td>'.$serie['vote_average']*10 .'%</td>'.
                    '<td>   <input type="checkbox" name="tmdb_serie_id[]" value="'.$serie['id'].'"></td>'.
                    '</tr>';
                }
                
               
                
            return Response($output);
            }

    }
        
    public function gererFilm(Request $request){
        $items = $request->items ?? 10;  
        if (request()->has('search')) {
            $films=film::where('titre', 'LIKE', '%'. $request->search. '%')->sortable()->paginate($items);
        }
        else{
            $films=film::sortable()->paginate($items);
        }
        
        return view('adminV/gererFilm',compact('films','items'));
    }

    public function gererSeries(Request $request){
        $items = $request->items ?? 10;  
        if (request()->has('search')) {
            $series=series::where('titre', 'LIKE', '%'. $request->search. '%')->sortable()->paginate($items);
        }
        else{
            $series=series::sortable()->paginate($items);
        }
        
        return view('adminV/gererSeries',compact('series','items'));
    }

    public function gererSeriesSaison(Request $request, $id){
        $items = $request->items ?? 10;  
        $serie =series::find($id);
        $saisonsSerie=saison::where('series_id',$serie->id)->sortable()->paginate($items);
        $saison=saison::sortable()->paginate($items);
        
        return view('adminV/gererSeriesSaison',compact('serie','items','saisonsSerie'));
    }
    public function gererSeriesSaisonEpisode(Request $request,$idSerie, $idSaison){
        $items = $request->items ?? 10;  
        $serie =series::find($idSerie);
        $saisonsSerie=saison::find($idSaison);
        $episodes=episode::where('saisons_id',$saisonsSerie->id)->sortable()->paginate($items);
        $saison=saison::sortable()->paginate($items);
        
        return view('adminV/gererSeriesSaisonEpisode',compact('serie','items','saisonsSerie','episodes'));
    }

    public function stats(){
        $moisAnnee=['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];
        $countDb =[
            'film'=>film::nbFilm(),
            'series'=>series::nbSeries(),
            'episode'=>episode::nbEpisodes(),
            'categ'=>categories::nbCateg(),
            'artiste'=>Personnes::nbPersonne(),
            'users'=>User::nbUser(),
        ];

        $users = User::select(DB::raw("COUNT(*) as count"), DB::raw("Month(created_at) as month_name"))->whereYear('created_at', date('Y'))->groupBy(DB::raw("Month(created_at)"))->pluck('count', 'month_name');     
        $film = film::select(DB::raw("COUNT(*) as count"), DB::raw("Month(created_at) as month_name"))->whereYear('created_at', date('Y'))->groupBy(DB::raw("Month(created_at)"))->pluck('count', 'month_name');
        $serie = series::select(DB::raw("COUNT(*) as count"), DB::raw("Month(created_at) as month_name"))->whereYear('created_at', date('Y'))->groupBy(DB::raw("Month(created_at)"))->pluck('count', 'month_name');
        $artiste = Personnes::select(DB::raw("COUNT(*) as count"), DB::raw("Month(created_at) as month_name"))->whereYear('created_at', date('Y'))->groupBy(DB::raw("Month(created_at)"))->pluck('count', 'month_name');
        
        $labelsU = $users->keys();
        $dataU = $users->values();

        $labelsF = $film->keys();
        $dataF = $film->values();

        $labelsS = $serie->keys();
        $dataS = $serie->values();

        $labelsA = $artiste->keys();
        $dataA = $artiste->values();
        for ($i=0; $i <count($labelsU) ; $i++) { 
            $labelsU[$i]=$moisAnnee[$labelsU[$i]-1];
        }
        for ($i=0; $i <count($labelsF) ; $i++) { 
            $labelsF[$i]=$moisAnnee[$labelsF[$i]-1];
        }
        for ($i=0; $i <count($labelsS) ; $i++) { 
            $labelsS[$i]=$moisAnnee[$labelsS[$i]-1];
        }
        for ($i=0; $i <count($labelsA) ; $i++) { 
            $labelsA[$i]=$moisAnnee[$labelsA[$i]-1];
        }



        return view('adminV/statsSite', compact('countDb','labelsF','dataF','labelsU','dataU','labelsS','dataS','labelsA','dataA'));
    }
    
    

    
}
