@extends('layouts.app')
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<?php  setlocale(LC_TIME, "fr_FR", "French");?>
@section('content')
@vite(['resources\css\commentsStyle.css'])
<div class="container" style=" color: whitesmoke;">
   <h1>{{ $serie->titre }}</h1>
   
   <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $serie->urlTrailler }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>

    <div class="mb-3">
        @csrf
        <label class="visually-hidden" for="inputName" id="inputHidden" value="{{$serie->id}}">Hidden input label</label>
        @if (!$IsInlist)
        <button id="AjoutListeButtonSerie" type="submit" style="color:black;">Ajouter à ma liste</button>
        <button id="SuppListeButtonSerie" type="submit" style="color:black; display:none">Supprimer de ma liste</button>
        @else
        <button id="AjoutListeButtonSerie" type="submit" style="color:black; display:none">Ajouter à ma liste</button>
        <button id="SuppListeButtonSerie" type="submit" style="color:black;">Supprimer de ma liste</button>
        @endif
    </div>
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

<br>
<!-- Comment section -->
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-5 col-md-6 col-12 pb-4">
                <h1>Comments ({{count($com)}})</h1>
                <?php $countUser=0?>
                @foreach ($com as $unCom)
                    <div class="comment mt-4 text-justify float-left w-100">
                        <h4> {{$UsersCom[$countUser]->username}} </h4>
                        <span>-{{ strftime("%d %B %G", strtotime($unCom->created_at))}} </span>
                        <br>
                        <p> {{$unCom->Corp}} </p>
                    </div>
                    <br>
                    <br>
                    <br>
                    <br>
                    <?php $countUser++?>
                    
                @endforeach

               
            </div>
            <div class="col-lg-4 col-md-5 col-sm-4 offset-md-1 offset-sm-1 col-12 mt-4">
                <form id="algin-form"  action="/postCommentSerie/{{$serie->id}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <h4>Leave a comment</h4>
                        <div class="form-group" id="rating-ability-wrapper">
                            <label class="control-label" for="rating">
                            <span class="field-label-info"></span>
                            <input type="hidden" id="selected_rating" name="selected_rating" value="" required="required">
                            </label>
                            <h2 class="bold rating-header" style="">Note
                            <span class="selected-rating">0</span><small> / 5</small>
                            </h2>
                            <button type="button" class="btnrating btn btn-default btn-lg" data-attr="1" id="rating-star-1" name="rating">
                                <i class="fa fa-star" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="btnrating btn btn-default btn-lg" data-attr="2" id="rating-star-2" name="rating">
                                <i class="fa fa-star" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="btnrating btn btn-default btn-lg" data-attr="3" id="rating-star-3" name="rating">
                                <i class="fa fa-star" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="btnrating btn btn-default btn-lg" data-attr="4" id="rating-star-4" name="rating">
                                <i class="fa fa-star" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="btnrating btn btn-default btn-lg" data-attr="5" id="rating-star-5" name="rating">
                                <i class="fa fa-star" aria-hidden="true"></i>
                            </button>
                        </div>
                          

                        <label for="message">Message</label>
                        <textarea name="msg" id="msg" cols="30" rows="5" class="form-control" style="background-color: black; color: whitesmoke;"></textarea>
                    </div>
                   
                    
                    <div class="form-group">
                        <button type="submit" id="post" class="btn">Post Comment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

</div>
@endsection



<script type="text/javascript">
    	jQuery(document).ready(function($){
	    
        $(".btnrating").on('click',(function(e) {
        
        var previous_value = $("#selected_rating").val();
        
        var selected_value = $(this).attr("data-attr");
        $("#selected_rating").val(selected_value);
        
        $(".selected-rating").empty();
        $(".selected-rating").html(selected_value);
        
        for (i = 1; i <= selected_value; ++i) {
        $("#rating-star-"+i).toggleClass('btn-warning');
        $("#rating-star-"+i).toggleClass('btn-default');
        }
        
        for (ix = 1; ix <= previous_value; ++ix) {
        $("#rating-star-"+ix).toggleClass('btn-warning');
        $("#rating-star-"+ix).toggleClass('btn-default');
        }
        
        }));
        
            
    });
    $(document).ready(function(){
        $('#AjoutListeButtonSerie').on('click',function(e){
            e.preventDefault();
            $idSerie=$("#inputHidden").attr('value');
            $("#SuppListeButtonSerie").show();
            $("#AjoutListeButtonSerie").hide();
            $url="{{ url('/ajoutMalisteSerie') }}"
                console.log($url)
            $.ajax({
                method: 'post',
                url: $url,
                data: { idSerie: $idSerie, _token:@json(csrf_token()) },
        });    
        });
        $('#SuppListeButtonSerie').on('click',function(e){
            e.preventDefault();
            $idSerie=$("#inputHidden").attr('value');
            $("#SuppListeButtonSerie").hide();
            $("#AjoutListeButtonSerie").show();
            $url="{{ url('/suppMalisteSerie') }}"
                console.log($url)
            $.ajax({
                method: 'post',
                url: $url,
                data: { idSerie: $idSerie, _token:@json(csrf_token()) },
        });        
        });
    });
    
</script>


