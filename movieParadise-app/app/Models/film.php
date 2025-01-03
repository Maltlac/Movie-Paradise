<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class film extends Model
{
    protected $guarded =[];

    public function filmsActeurs(){
        return $this->belongsToMany(Acteurs::class);
    }

    public  function filmCategories(){
        return $this->belongsToMany(categories::class);
    }
    public static function searchBarFilm($nomFilm){
        $output="";
        $films= Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/search/movie?api_key=cffc672e34d23c4c89487652fccefd28&query='.$nomFilm.'&language=fr-FR')
            ->json();
        dd($films);
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
}

