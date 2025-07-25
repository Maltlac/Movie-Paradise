<?php

namespace App\Models;

use App\Models\User;
use App\Models\Personnes;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class film extends Model
{
    use Sortable;
    public $timestamps = true;
    protected $guarded =[];
    public $sortable = ['id', 'titre', 'dateSortie','duree','active'];
    public function filmsPersonnes(){
        return $this->belongsToMany(Personnes::class)->limit(10);
    }

    public  function filmCategories(){
        return $this->belongsToMany(categories::class);
    }
    public static function searchBarFilm($nomFilm){
        $output="";
        $films= Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/search/movie?api_key=cffc672e34d23c4c89487652fccefd28&query='.$nomFilm.'&language=fr-FR')
            ->json();
            if($films)
            {
                foreach($films['results'] as $film){
                    $output.='<tr>'.
                    '<td>'.$film['title'].'</td>'.
                    '<td>'.$film['release_date'].'</td>'.
                    '<td>'.$film['vote_average'].'</td>'.
                    '</tr>';
                }
                
               
                
            return Response($output);
            }

    }

    public function getCommentFilm(){
        return commantaire::where('film_id',$this->id)->get();
    }

    public function getFilm($filmId){
        return film::where('film_id',$filmId)->get();
    }

    public function FilmUser(){
        return $this->belongsToMany(User::class,'film_user');
    }

    public function FilmUserVue(){
        return $this->belongsToMany(User::class,'film_vue');
    }

    public function filmsActeurs(){
        return $this->belongsToMany(Personnes::class);
    }

    public static function nbFilm(){
        return film::count();
    }

    public static function filmR($userId){
        $toutesCateg= categories::categsFilmR($userId);
        foreach ($toutesCateg as $key ) {
            $FilmRecommander[$key->nomCateg]=DB::select("SELECT * FROM films WHERE active=1 AND id IN(
                    SELECT film_id FROM categories_film 
                    WHERE categories_id=$key->categories_id 
            )ORDER BY RAND() LIMIT 10");
        }
        return $FilmRecommander;
    }


}

