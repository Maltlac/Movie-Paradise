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
                        <span>-{{ strftime("%d %B %G", strtotime($unCom->datePost))}} </span>
                        <br>
                        <p> {{$unCom->Corp}} </p>
                    </div>
                    <?php $countUser++?>
                    
                @endforeach
                
               
            </div>
            <div class="col-lg-4 col-md-5 col-sm-4 offset-md-1 offset-sm-1 col-12 mt-4">
                <form id="algin-form">
                    <div class="form-group">
                        <h4>Leave a comment</h4>
                        <label for="message">Message</label>
                        <textarea name="msg" id=""msg cols="30" rows="5" class="form-control" style="background-color: black;"></textarea>
                    </div>
                   
                    
                    <div class="form-group">
                        <button type="button" id="post" class="btn">Post Comment</button>
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

    .form-group input,.form-group textarea{
        background-color: black;
        border: 1px solid rgba(16, 46, 46, 1);
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

    .comment{
        border: 1px solid rgba(16, 46, 46, 1);
        background-color: rgba(16, 46, 46, 0.973);
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
</style>