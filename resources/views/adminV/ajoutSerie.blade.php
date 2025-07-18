@extends('layouts.app')
@section('content')
<link href="/css/styleAdmin.css" rel="stylesheet">

<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading ">
                    <span class="text-white">Chercher des séries</span>
                    <input type="text" class="form-controller" id="search" name="search" style="background-color:white">
            </div>
            <div class="panel-body">

                

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
                    <div class="panel-footer">
                        <button class="btn btn-primary">Ajouter</button>
                    </div>
                    
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
