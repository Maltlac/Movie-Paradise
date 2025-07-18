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
   <label class="visually-hidden" for="inputName" id="inputHidden" value="{{$bio->id}}"></label>
   @csrf
   @if (!$IsInlist)
   <input id="AjoutListeButtonPersonne" type="image" src="/images/icons8-aimer-96.png" style="width: 50px" alt="">
   <input id="suppListeButtonPersonne" type="image" src="/images/icons8-aimer-100.png" style="width: 50px;display:none" alt="">
   @else
   <input id="AjoutListeButtonPersonne" type="image" src="/images/icons8-aimer-96.png" style="width: 50px;display:none" alt="">
   <input id="suppListeButtonPersonne" type="image" src="/images/icons8-aimer-100.png" style="width: 50px;" alt="">
   @endif

   <h3>Biographie:</h3>
    <div>{{ $bio->bio ?? "N/A" }}</div>
    <br>
    <div>Date de naissance: {{strftime("%d %B %G", strtotime($bio->dateNaissance)) }} ({{$interval->y}}ans)</div>
    <br>
    <h3>Apparitions connues</h3>
    {{$apparitions}}
    <br>
    <?php
       
       if (null!=$tabFilms) {
         echo "<h4>Films</h4>";
            echo'<table class="table table-bordered table-hover" style=" color: whitesmoke;">';
                echo'<tbody>';

                    foreach($tabFilms as $tab){
                        echo '<tr id="'.$tab['id'].'">';
                            echo'<td> <a  href="/film/'.$tab['id'].'">'.$tab['titre'].'</a></td>';
                        echo '</tr>';
                    }
                echo"</tbody>";
            echo "</table>";
        } 
        if (null!=$tabSeries) {
            echo "<h4> Séries</h4>";
            echo'<table class="table table-bordered table-hover" style=" color: whitesmoke;">';
                echo'<tbody>';

                    foreach($tabSeries as $tab){
                        echo '<tr id="'.$tab['id'].'">';
                            echo'<td> <a  href="/serie/'.$tab['id'].'">'.$tab['titre'].'</a></td>';
                        echo '</tr>';
                    }
                echo"</tbody>";
            echo "</table>";
        }    

        if (null!=$tabReal) {
            echo "<h4> Réalisation</h4>";
            echo'<table class="table table-bordered table-hover" style=" color: whitesmoke;">';
                echo'<tbody>';

                    foreach($tabReal as $tab){
                        echo '<tr id="'.$tab['id'].'">';
                            echo'<td> <a  href="/film/'.$tab['id'].'">'.$tab['titre'].'</a></td>';
                        echo '</tr>';
                    }
                echo"</tbody>";
            echo "</table>";
        }    
        
    ?>

</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#AjoutListeButtonPersonne').on('click',function(e){
            e.preventDefault();
            $idPersonne=$("#inputHidden").attr('value');
            $("#suppListeButtonPersonne").show();
            $("#AjoutListeButtonPersonne").hide();
            $url="{{ url('/ajoutMalistePersonne') }}"
                console.log($url)
            $.ajax({
                method: 'post',
                url: $url,
                data: { idPersonne: $idPersonne, _token:@json(csrf_token())},
        });    
        });
        $('#suppListeButtonPersonne').on('click',function(e){
            e.preventDefault();
            $idPersonne=$("#inputHidden").attr('value');
            $("#suppListeButtonPersonne").hide();
            $("#AjoutListeButtonPersonne").show();
            $url="{{ url('/suppMalistePersonne') }}"
                console.log($url)
            $.ajax({
                method: 'post',
                url: $url,
                data: { idPersonne: $idPersonne, _token:@json(csrf_token()) },
        });        
        
    });
    });
</script>
@endsection
