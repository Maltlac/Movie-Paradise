<?php

namespace App\Models;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class episode extends Model
{
    protected $guarded =[];
    public $sortable = ['id', 'titre', 'dateSortie'];
    use Sortable;
    public static function nbEpisodes(){
        return episode::count();
    }
}
