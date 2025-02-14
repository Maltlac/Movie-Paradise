@extends('layouts.app')
@section('content')


@vite(['resources/css/styleAdmin.css'])
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
                            <form class="form-horizontal needs-validation" method="GET" action="/gererFilm">  
                                <div class="">
                                    <div class="pull-left">
                                        <input type="search" name="search" value="{{ request()->input('search') }}" class="w-25" placeholder="Search" required>

                                        <button class="btn btn-primary" type="submit">Search</button> 
                                    </div>
                                    
                                    
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
                                <th>@sortablelink('duree','Durée')</th>
                                <th>@sortablelink('dateSortie','Date de sortie')</th>
                                <th>@sortablelink('active','Film actif')</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($films as $data)
                            <tr>
                                <td>
                                        <a href="javascript:void(0)" id="edit-film" data-url="{{ route('film.show', $data->id) }}" class="btn btn-primary d-inline "><i class="fa fa-pencil-alt"></i></a>
                                        <a href="javascript:void(0)" id="delete-film" data-url="{{ route('film.show', $data->id) }}" class="btn btn-danger d-inline " ><i class="fa fa-times"></i></a>

                                </td>
                                <td>{{ $data->id }}</td>
                                <td>{{ $data->titre }}</td>
                                <td>{{ $data->duree }}</td>
                                <td>{{ $data->dateSortie }}</td>
                                <td><?php if($data->active) echo"oui";  else echo "non"?></td>
                                <td><a href="film/{{$data->id}} " class="btn btn-sm btn-success"><i class="fa fa-search"></i></a></td>
                               
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
                <div class="panel-footer">
                    <div class="row">
                            
                            @if ($films->hasPages())
                            <ul class="pagination hidden-xs pull-right">
                                {!! $films->appends(Request::except('page'))->render() !!}

                            </ul>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal  modif film-->
<div class="modal fade" id="filmShowModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modifier le film n° <span id="film-id"></span>#</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="filmUpdateForm" name="filmUpdateForm" class="form-horizontal " action="panneauCtrl/update/film" method="POST">
                @csrf 
                <input type="hidden" name="filmUpdate_id" id="filmUpdate_id">

                
                <!-- titre -->
                 <div class="form-group">
                     <label for="titre" class="col-sm-2 control-label">Titre</label>
                     <div class="col-sm-12">
                         <input type="text" class="form-control text-white" id="film-titre" name="titre" placeholder="Enter titre" value="" maxlength="50" required="">
                     </div>
                 </div>
                 <br>
                 <!-- resume -->
                 <div class="form-group">
                     <label class="col-sm-2 control-label">Résumé</label>
                     <div class="col-sm-12">
                         <textarea id="film-resume" name="resume" required="" placeholder="Enter Details" class="form-control text-white h-100" style="font-size: 1rem;"></textarea>
                     </div>
                 </div>
                 <br>
                 <!-- date sorti -->
                 <div class="form-group">
                    <label class="col-sm-2 control-label d-inline">Date de sortie :</label>
                    <div class="col-sm-12">

                        <input type="date" name="dateSortie" id="film-dateSortie" required="">
                    </div>
                </div>
                <br>
                <!--Time picker -->
                <div class="form-group pmd-textfield pmd-textfield-floating-label">
                    <label class="control-label" for="timepicker">Durée du film</label>
                    <input type="text" class="form-control text-white" id="film-duree" name="duree" required="">
                </div>
                <br>
                 <!--Film actif streaming -->
                <div class="form-group pmd-textfield pmd-textfield-floating-label">
                    <label class="control-label" for="timepicker">Film visible dans la partie streaming</label>
                    <input type="checkbox" name="active" id="active-movie">
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
<!-- Modal Delete film-->
<div class="modal fade" id="filmDelModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Confirmer la suppression</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-footer">
            @csrf 
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            <a href="" id="deleteFilmConfirme" class="btn btn-danger" >Valider</a>
            
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
        window.location = "{!! $films->url(1) !!}&items=" + this.value; 
    }; 


    $(document).ready(function () {
       
       /* When click show user */
        $('body').on('click', '#edit-film', function () {
          var filmURL = $(this).data('url');
          
          $.get(filmURL, function (data) {
              $('#filmShowModal').modal('show');
              $('#film-id').text(data.id);
              $('#filmUpdate_id').val(data.id);
              $('#film-titre').val(data.titre);
              $('#film-resume').val(data.resume);
              $('#film-duree').val(data.duree);
              if (data.active==1) {
                $('#active-movie').prop('checked', true);
              } else {
                $('#active-movie').prop('checked', false);
              }             
              $('#film-dateSortie').val(data.dateSortie);

              console.log(data)
          })
       });

       $('body').on('click', '#delete-film', function () {
          var filmURL = $(this).data('url');
          
          $.get(filmURL, function (data) {
            $('#filmDelModal').modal('show');
            $('#deleteFilmConfirme').attr('href',"/panneauCtrl/delete/film/"+data.id);
            
          })
       });
       
    });
</script>
@endsection


