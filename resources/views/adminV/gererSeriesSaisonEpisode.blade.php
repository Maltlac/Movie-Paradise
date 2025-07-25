@extends('layouts.app')
@section('content')


<link href="/css/styleAdmin.css" rel="stylesheet">
<body>
<div class="container">
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <div class="panel">
                <div class="panel-heading">
                    <div class="row">
                        @if ($errors->any())

                            <div id="hideDiv" class="alert alert-info">{{$errors->first() }}</div>

                        @endif

                        <div class="col-sm-12 col-xs-12">
                            <h4 class="text-white">Série : {{$serie->titre}} </h4>
                            <h4 class="text-white">Saison : {{$saisonsSerie->numeroSaison}} </h4>
                            <h5 class="text-white d-inline">Ajouter un épisode :  </h5>
                            <a href="javascript:void(0)" id="ajout-episode"  class="btn btn-primary d-inline " ><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                            <form class="form-horizontal needs-validation" method="GET" action="/gererSeries/saison/{{$serie->id}} ">  
                                                            
                                    <div class="form-horizontal pull-right d-inline">
                                        <label>Show : </label>
                                        <select id="pagination" name="pagination">
                                            <option value="5" @if($items == 5) selected @endif >5</option>
                                            <option value="10" @if($items == 10) selected @endif >10</option>
                                            <option value="15" @if($items == 15) selected @endif >15</option>
                                            <option value="20" @if($items == 20) selected @endif >20</option>
                                            <option value="25" @if($items == 25) selected @endif >25</option>
                                        </select>
                                    </div>  
                            </form>

                        </div>
                    </div>
                </div>
                <div class="panel-body table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="w-auto" >action</th>
                                <th>@sortablelink('id','#')</th>
                                <th class="w-auto">@sortablelink('titre')</th>
                                <th>@sortablelink('dateSortie','Date de sortie')</th>
                                <th class="w-auto">@sortablelink('numeroEpisode','Numéro episode')</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($episodes as $data)
                            <tr>
                                <td>
                                        <a href="javascript:void(0)" id="edit-episode" data-url="{{ route('episode.show', $data->id) }}" class="btn btn-primary d-inline "><i class="fa fa-pencil-alt"></i></a>
                                        <a href="javascript:void(0)" id="delete-episode" data-url="{{ route('episode.show', $data->id) }}" class="btn btn-danger d-inline " ><i class="fa fa-times"></i></a>

                                </td>
                                <td>{{ $data->id }}</td>
                                <td>{{ $data->titre }}</td>
                                <td>{{ $data->dateSortie }}</td>
                                <td>{{ $data->numeroEpisode }}</td>
                                <td><a href="/serie/{{$serie->id}}/saison/{{$saisonsSerie->id}}/episode/{{$data->id}} " class="btn btn-sm btn-success"><i class="fa fa-search"></i></a></td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
                <div class="panel-footer">
                    <div class="row">
                            
                            @if ($episodes->hasPages())
                            <ul class="pagination hidden-xs pull-right">
                                {!! $episodes->appends(Request::except('page'))->render() !!}

                            </ul>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal  modif serie-->
<div class="modal fade" id="serieShowModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modifier l'épisode n°<span id="serie-id"></span>#</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="serieUpdateForm" name="serieUpdateForm" class="form-horizontal " action="/panneauCtrl/update/episode" method="POST">
                @csrf 

                <input type="hidden" name="serieUpdate_id" id="serieUpdate_id">

                
                <!-- titre -->
                 <div class="form-group">
                     <label for="titre" class="col-sm-2 control-label">Titre</label>
                     <div class="col-sm-12">
                         <input type="text" class="form-control text-white" id="serie-titre" name="titre" placeholder="Enter titre" value="" maxlength="50" required="">
                     </div>
                 </div>
                 
                 <!-- resume -->
                 <div class="form-group">
                     <label class="col-sm-2 control-label">Résumé</label>
                     <div class="col-sm-12">
                         <textarea id="serie-resume" name="resume" required="" placeholder="Enter Details" class="form-control text-white h-100" style="font-size: 1rem;"></textarea>
                     </div>
                 </div>

                 <!-- date sortie -->
                 <div class="form-group">
                    <label class="col-sm-2 control-label d-inline">Date de sortie :</label>
                    <div class="col-sm-12">

                        <input type="date" name="dateSortie" id="serie-dateSortie" required="">
                    </div>
                </div>
                <!-- date sortie -->
                <div class="form-group">
                    <label class="col-sm-2 control-label d-inline">Numéro épisode :</label>
                    <div class="col-sm-12">
                        <input type="number"  name="numeroEpisode" id="serie-numeroEpisode" class="w-25" required="">
                    </div>
                </div>

                <!--Time picker -->
                <div class="form-group pmd-textfield pmd-textfield-floating-label">
                    <label class="control-label" for="timepicker">Durée de l'épisode (HH:MM:SS)</label>
                    <input type="text" class="form-control text-white" id="episode-duree" name="duree" required="">
                </div>

                <!-- footer -->
                 <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                    </button>
                  </div>
             </form>
        </div>
        
      </div>
    </div>
</div>
<!-- Modal Delete serie-->
<div class="modal fade" id="serieDelModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Confirmer la suppression</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-footer">
            @csrf 
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            <a href="" id="deleteserieConfirme" class="btn btn-danger" >Valider</a>
            
        </div>
      </div>
    </div>
</div>

<!-- Modal  ajout épisode-->
<div class="modal fade" id="episodeAjoutModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ajouter un épisode<span id="serie-id"></span>#</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="saisonAddForm" name="saisonAddForm" class="form-horizontal " action="/panneauCtrl/ajout/episode" method="POST">
                @csrf 

                <input type="hidden" name="saisonUpdate_id" id="saisonUpdate_id" value=" {{$saisonsSerie->id}}">

                
                <!-- titre -->
                 <div class="form-group">
                     <label for="titre" class="col-sm-2 control-label">Titre</label>
                     <div class="col-sm-12">
                         <input type="text" class="form-control text-white" id="serie-titre" name="titre" placeholder="Enter titre" value="" maxlength="50" required="">
                     </div>
                 </div>
                 
                 <!-- resume -->
                 <div class="form-group">
                     <label class="col-sm-2 control-label">Résumé</label>
                     <div class="col-sm-12">
                         <textarea id="serie-resume" name="resume" required="" placeholder="Enter Details" class="form-control text-white h-100" style="font-size: 1rem;"></textarea>
                     </div>
                 </div>

                 <!-- date sortie -->
                 <div class="form-group">
                    <label class="col-sm-2 control-label d-inline">Date de sortie :</label>
                    <div class="col-sm-12">

                        <input type="date" name="dateSortie" id="serie-dateSortie" required="">
                    </div>
                </div>

                <!-- numéro episode -->
                <div class="form-group">
                    <label class="col-sm-2 control-label d-inline">Numéro épisode :</label>
                    <div class="col-sm-12">
                        <input type="number"  name="numeroEpisode" id="serie-numeroEpisode" class="w-25" required="">
                    </div>
                </div>

                 <!--Time picker -->
                 <div class="form-group pmd-textfield pmd-textfield-floating-label">
                    <label class="control-label" for="timepicker">Durée de l'épisode (HH:MM:SS)</label>
                    <input type="text" class="form-control text-white" id="episode-duree" name="duree" required="">
                </div>

                <!-- footer -->
                 <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                    </button>
                  </div>
             </form>
        </div>
        
      </div>
    </div>
</div>
</body>

<script>

$(function() {
setTimeout(function() { $("#hideDiv").fadeOut(1500); }, 5000)

})
    document.getElementById('pagination').onchange = function() { 
        window.location = "{!! $episodes->url(1) !!}&items=" + this.value; 
    }; 


    $(document).ready(function () {
       
       /* When click show user */
        $('body').on('click', '#edit-episode', function () {
          var serieURL = $(this).data('url');
          
          $.get(serieURL, function (data) {
              $('#serieShowModal').modal('show');
              $('#serie-id').text(data.id);
              $('#serieUpdate_id').val(data.id);
              $('#serie-titre').val(data.titre);
              $('#serie-resume').val(data.resume);
              $('#episode-duree').val(data.duree);
              $('#serie-numeroEpisode').val(data.numeroEpisode);
              $('#serie-dateSortie').val(data.dateSortie);
              console.log(data)
          })
       });

       $('body').on('click', '#delete-episode', function () {
          var serieURL = $(this).data('url');
          
          $.get(serieURL, function (data) {
            $('#serieDelModal').modal('show');
            $('#deleteserieConfirme').attr('href',"/panneauCtrl/delete/episode/"+data.id);
            
          })
       });

       $('body').on('click', '#ajout-episode', function () {
          var serieURL = $(this).data('url');  
          $.get(serieURL, function (data) {
            $('#episodeAjoutModal').modal('show');
            
          })
       });
       
    });
</script>
@endsection


