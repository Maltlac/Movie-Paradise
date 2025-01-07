@extends('layouts.app')
@section('content')
<?php use App\Models\film;
//dd(film::searchBarFilm("iron"))

?>

<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading d-flex align-items-baseline justify-content-between">
                <h3>Series </h3>
            </div>
            <div class="panel-body">

                <div class="form-group">
                    <input type="text" class="form-controller" id="search" name="search">
                </div>

                <form action="ajoutSerie" method="POST">
                    @csrf
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="width: 1rem">Poster</th>
                                <th style="width: 15rem">Titre Series</th>
                                <th  style="width: 35rem">Description</th>
                                <th style="width: 15rem">Date de sortie</th>
                                <th style="width: 10rem">Note</th>
                                <th style="width: 10rem">Ajouter</th>
                            </tr>
                        </thead>
    
                        <tbody>
                            
                        </tbody>
                        
                    </table>
                    <button class="btn btn-primary">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $('#search').on('keyup',function(){
        $value=$(this).val();
            $.ajax({
            type : 'get',
            url : '{{URL::to('searchSerie')}}',
            data:{'search':$value},
            success:function(data){
                $('tbody').html(data);
            },
            error:function(errorThrown ){
                console.log(errorThrown)
            }
        });
        

        
    })
</script>



@endsection
