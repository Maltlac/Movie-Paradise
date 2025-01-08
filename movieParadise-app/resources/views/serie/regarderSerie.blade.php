@extends('layouts.app')
<?php  setlocale(LC_TIME, "fr_FR", "French");?>
@section('content')
<div class="container" style=" color: whitesmoke;">
   <h1>{{ $serie->titre }}</h1>
   
   <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $serie->urlTrailler }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>

    <div>Acteurs:
            <?php
                $i = 0;
                $len = count($serie->seriesPersonnes);
                foreach ($serie->seriesPersonnes as $acteur) { 
                    echo '<a href="/bio/'.$acteur->id.'">';       
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
     <div>createur : <a href="/bio/{{$createur->id}}">{{ $createur->name ?? "N/A" }} </a></div>
     <div>Catégories: 
        <?php foreach ($serie->seriesCategories as $categorie) {
            echo $categorie->nom.", ";
        }
        ?>
     </div>
    <div>Date de sortie: {{strftime("%d %B %G", strtotime($serie->dateSortie)) }}</div> <br>
    <div>Synopsis: {{ $serie->resume }}</div>

    <?php
        $countSaison=count($saisons);
         echo "<h4> Saisons ($countSaison)</h4>";
            echo'<table class="table table-bordered table-hover" style=" color: whitesmoke;">';
                echo'<tbody>';

                    foreach($saisons as $tab){
                        echo '<tr id="'.$tab['id'].'">';
                            echo'<td> <a  href="/serie/'.$serie->id.'/saison/'.$tab['id'].'">'.$tab['titre'].'</a></td>';
                        echo '</tr>';
                    }
                echo"</tbody>";
            echo "</table>";
    ?>

</div>
@endsection
