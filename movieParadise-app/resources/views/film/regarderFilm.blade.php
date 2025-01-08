@extends('layouts.app')
<?php  setlocale(LC_TIME, "fr_FR", "French");?>
@section('content')
<div class="container" style=" color: whitesmoke;">
    <i class="bi bi-arrow-left"></i><a href="{{ url()->previous() }}">retour</a>
   <h1>{{ $film->titre }}</h1>
   
   <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $film->urlTrailler }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
    <div>durée du film: {{ $film->duree }}</div>

    <div>Acteurs:
            <?php
                $i = 0;
                $len = count($film->filmsPersonnes);
                foreach ($film->filmsPersonnes as $acteur) { 
                    echo '<a href="/bio/'.$acteur->id.'/type/acteur">';       
                    echo $acteur->name.'</a> ' ;
                    if ($i == $len - 1) {
                        echo ' ';
                    }else {
                        echo ', ';
                    }
                    $i++;
            }
            ?>
        
     </div>
     <div>Catégories: 
        <?php foreach ($film->filmCategories as $categorie) {
            echo $categorie->nom.", ";
        }
        ?>
     </div>
    <div>Réalisateur: <a href="/bio/{{$real->id}}/type/realisateur">{{ $real->name ?? "N/A" }} </a> </div>
    <div>Date de sortie: {{strftime("%d %B %G", strtotime($film->dateSortie)) }}</div>
    <div>Synopsis: {{ $film->resume }}</div>

</div>
@endsection
