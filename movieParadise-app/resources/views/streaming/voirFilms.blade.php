@extends('layouts.app')
<?php  setlocale(LC_TIME, "fr_FR", "French");?>
@section('content')
<div class="container">
   <h1>{{ $film->titre }}</h1>
   
   <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $film->urlTrailler }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
    <div>durée du film: {{ $film->duree }}</div>

    <div>Acteurs:
        <?php foreach ($film->filmsActeurs as $acteur) {
            echo $acteur->nom." ".$acteur->prenom." ";
        }
        ?>
     </div>
     <div>Catégories: 
        <?php foreach ($film->filmCategories as $categorie) {
            echo $categorie->nomCategorie." ";
        }
        ?>
     </div>
    <div>Réalisateur:{{ $real->prenom }} {{ $real->nom }} </div>
    <div>Date de sortie: {{strftime("%d %B %G", strtotime($film->dateSortie)) }}</div>
    <div>Synopsis: {{ $film->resume }}</div>

</div>
@endsection
