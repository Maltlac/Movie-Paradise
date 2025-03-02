<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class categories extends Model
{
    use HasFactory;
    protected $guarded =[];
    public function categoriesFilm(){
        return $this->belongsToMany(film::class);
    }
    public function categoriesSerie(){
        return $this->belongsToMany(series::class);
    }
    public static function nbCateg(){
        return categories::count();
    }
    public static function categsFilmR($userId){
        return DB::select("SELECT categories_id, COUNT(categories_id) AS nbCateg,categories.nom  AS nomCateg
        FROM categories_film, categories  
        WHERE film_id IN(SELECT distinct film_id FROM film_vue WHERE user_id=$userId) 
        AND categories.id = categories_film.categories_id
        GROUP BY categories_id
        ORDER BY  nbCateg desc
        LIMIT 3");
    }
}
