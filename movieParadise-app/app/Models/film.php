<?php

namespace App\Models;

use App\Models\Personnes;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class film extends Model
{
    protected $guarded =[];

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
}

