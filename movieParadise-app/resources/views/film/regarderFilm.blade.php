<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
     <div>Catégories: 
        <?php foreach ($film->filmCategories as $categorie) {
            echo $categorie->nom.", ";
        }
        ?>
     </div>
    <div>Réalisateur: <a href="/bio/{{$real->id}}" >{{ $real->name ?? "N/A" }} </a> </div>
    <div>Date de sortie: {{strftime("%d %B %G", strtotime($film->dateSortie)) }}</div>
    <div>Synopsis: {{ $film->resume }}</div>

<br>
<!-- Comment section -->
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-5 col-md-6 col-12 pb-4">
                <h1>Comments ({{count($com)}})</h1>
                <?php $countUser=0?>
                @foreach ($com as $unCom)
                    <div class="comment mt-4 text-justify float-left">
                        <h4> {{$UsersCom[$countUser]->name}} </h4>
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
                <form id="algin-form"  action="/PostCommentFilm/{{$film->id}}" method="POST">
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
                                <i class="fa fa-star" aria-hidden="true">★</i>
                            </button>
                            <button type="button" class="btnrating btn btn-default btn-lg" data-attr="2" id="rating-star-2" name="rating">
                                <i class="fa fa-star" aria-hidden="true">★</i>
                            </button>
                            <button type="button" class="btnrating btn btn-default btn-lg" data-attr="3" id="rating-star-3" name="rating">
                                <i class="fa fa-star" aria-hidden="true">★</i>
                            </button>
                            <button type="button" class="btnrating btn btn-default btn-lg" data-attr="4" id="rating-star-4" name="rating">
                                <i class="fa fa-star" aria-hidden="true">★</i>
                            </button>
                            <button type="button" class="btnrating btn btn-default btn-lg" data-attr="5" id="rating-star-5" name="rating">
                                <i class="fa fa-star" aria-hidden="true">★</i>
                            </button>
                        </div>
                          

                        <label for="message">Message</label>
                        <textarea name="msg" id=""msg cols="30" rows="5" class="form-control" style="background-color: black;"></textarea>
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

<style>
        #post{
        margin: 10px;
        padding: 6px;
        padding-top: 2px;
        padding-bottom: 2px;
        text-align: center;
        background-color: #ecb21f;
        border-color: #a88734 #9c7e31 #846a29;
        color: black;
        border-width: 1px;
        border-style: solid;
        border-radius: 13px;
        width: 50%;
    }
    .comments{
        margin-top: 5%;
        margin-left: 20px;
    }
    .comment{
    border: 1px solid rgb(16, 18, 46);
    background-color: rgba(16, 18, 46, 0.973);
    float: left;
    border-radius: 5px;
    padding-left: 40px;
    padding-right: 30px;
    padding-top: 10px;
    
    }
    .comment h4,.comment span,.darker h4,.darker span{
        display: inline;
    }

    .comment p,.comment span,.darker p,.darker span{
        color: rgb(184, 183, 183);
    }

    .form-group input,.form-group textarea{
        background-color: black;
        border: 1px solid rgba(16, 18, 46, 1);
        border-radius: 12px;
    }
    form{

        padding: 20px;
    }
    .comments{
        margin-top: 5%;
        margin-left: 20px;
    }

    .darker{
        border: 1px solid #ecb21f;
        background-color: black;
        float: right;
        border-radius: 5px;
        padding-left: 40px;
        padding-right: 30px;
        padding-top: 10px;
    }



</style>

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
    
</script>