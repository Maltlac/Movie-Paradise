@extends('layouts.app')
<?php  setlocale(LC_TIME, "fr_FR", "French");
$dt = new DateTime();
$dt2=date_create($bio->dateNaissance);
$interval = date_diff($dt, $dt2);
?>
@section('content')
<div class="container" style=" color: whitesmoke;">
   <h1>{{ $bio->name }}</h1>
   <img class="card-img-center" src="https://image.tmdb.org/t/p/w300{{ $bio->image }}" alt="Card image cap">
   <h3>Biographie:</h3>
    <div>{{ $bio->bio ?? "N/A" }}</div>
    <br>
    <div>Date de naissance: {{strftime("%d %B %G", strtotime($bio->dateNaissance)) }} ({{$interval->y}}ans)</div>
    <br>
    <h3>Apparitions connues</h3>
    {{$apparitions}}
    <br>
    <?php
       
       if (!empty($tab1)) {
         echo "<h4>$type1</h4>";
            echo'<table class="table table-bordered table-hover" style=" color: whitesmoke;">';
                echo'<tbody>';

                    foreach($tab1 as $tab){
                        echo '<tr id="'.$tab['id'].'">';
                            echo'<td> <a  href="/film/'.$tab['id'].'">'.$tab['titre'].'</a></td>';
                        echo '</tr>';
                    }
                echo"</tbody>";
            echo "</table>";
        } 
        if (!empty($tab2)) {
            echo "<h4>$type2</h4>";
            echo'<table class="table table-bordered table-hover" style=" color: whitesmoke;">';
                echo'<tbody>';

                    foreach($tab2 as $tab){
                        echo '<tr id="'.$tab['id'].'">';
                            echo'<td> <a  href="/film/'.$tab['id'].'">'.$tab['titre'].'</a></td>';
                        echo '</tr>';
                    }
                echo"</tbody>";
            echo "</table>";
        }    
        
    ?>

</div>
@endsection
