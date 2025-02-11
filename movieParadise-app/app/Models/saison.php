<?php

namespace App\Models;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class saison extends Model
{
    protected $guarded =[];
    public $sortable = ['id', 'titre', 'dateSortie','numeroSaison'];
    use Sortable;
    public static function nbSaison(){
        return saison::count();
    }
}
