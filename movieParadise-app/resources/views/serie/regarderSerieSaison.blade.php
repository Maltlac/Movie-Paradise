@extends('layouts.app')
<?php  setlocale(LC_TIME, "fr_FR", "French");?>
@section('content')
<div class="container" style=" color: whitesmoke;">
   <h1>{{ $serie->titre}}  </h1>
   <h2>{{$saison->titre}}  </h2>
   <img class="card-img-center" src="https://image.tmdb.org/t/p/w300{{ $saison->image }}" alt="Card image cap">
  
    
     
    <div>Date de sortie: {{strftime("%d %B %G", strtotime($saison->dateSortie)) }}</div> <br>
    <div>Synopsis: {{ $saison->resume }}</div>

    <?php
        $numEp=1;
        $countEpisode=count($episode);
         echo "<h4> Épisodes ($countEpisode)</h4>";
            echo'<table class="table table-bordered table-hover" style=" color: whitesmoke;">';
                echo'<tbody>';

                    foreach($episode as $tab){
                        echo '<tr id="'.$tab['id'].'">';
                            echo'<td> '.$numEp.'.  <a  href="/serie/'.$serie->id.'/saison/'.$saison->id.'/episode/'.$tab['id'].'">'.$tab['titre'].'</a></td>';
                        echo '</tr>';
                        $numEp++;
                    }
                echo"</tbody>";
            echo "</table>";
    ?>


</div>
@endsection
