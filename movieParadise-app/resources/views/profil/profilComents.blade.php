@extends('profil.layoutprofil')
@section('second_content')


<!-- end profile -->
<!-- begin profile-content -->
<div class="profile-content">
   <!-- begin tab-content -->
   <div class="tab-content p-0">
      <!-- begin #profile-post tab -->
      <div class="tab-pane fade active show" id="profile-post">
         <!-- begin timeline -->
         <ul class="timeline">
            @foreach ($coms as $commentaire)
            <li>
               <!-- begin timeline-time -->
               <div class="timeline-time">
                  <span class="time">{{$commentaire->created_at}}</span>
               </div>
               <!-- end timeline-time -->
               <!-- begin timeline-icon -->
               <div class="timeline-icon">
                  <a href="javascript:;">&nbsp;</a>
               </div>
               <!-- end timeline-icon -->
               <!-- begin timeline-body -->
               <div class="timeline-body">
                  <div class="timeline-header">
                     <span class="userimage"><img src="https://bootdey.com/img/Content/avatar/avatar3.png" alt=""></span>
                     <span class="username">{{ Auth::user()->name }}</span>
                     @if ($commentaire->created_at!=$commentaire->updated_at)
                        <span>(Modifié le {{$commentaire->updated_at}} )</span>
                     @endif
                     
                  </div>
                  <div class="lead">
                     <p>{{$commentaire->Corp}} </p>
                  </div>
                  <div class="timeline-footer">
                     @if ($commentaire->film_id!= "")
                        <a href="{{ route('voir.film', $commentaire->film_id) }}" class="m-r-15 text-inverse-lighter"><i class="fa fa-share fa-fw fa-lg m-r-3"></i> Voir le film</a>
                        <a href="javascript:void(0)"class="m-r-15 text-inverse-lighter" id="edit-com" data-url="{{ route('commentaire.show', $commentaire->id) }}"><i class="fa fa-pencil-alt"></i> Modifier</a>                         
                     @else
                     <a href="{{ route('voir.serie', $commentaire->series_id) }}" class="m-r-15 text-inverse-lighter"><i class="fa fa-share fa-fw fa-lg m-r-3"></i> Voir la série</a>
                     <a href="javascript:void(0)"class="m-r-15 text-inverse-lighter" id="edit-com" data-url="{{ route('commentaire.show', $commentaire->id) }}"><i class="fa fa-pencil-alt"></i> Modifier</a>   
                     @endif
                     
                     <a href="javascript:void(0)" id="delete-commentaire" data-url="{{ route('commentaire.show', $commentaire->id) }}" class="m-r-15 text-inverse-lighter" ><i class="fa fa-times"></i> Supprimer</a>
                     
                  </div>
               </div>
               <!-- end timeline-body -->
            </li>
            @endforeach
            



         </ul>
         <!-- end timeline -->
      </div>
      <!-- end #profile-post tab -->
   </div>
   <!-- end tab-content -->
</div>

<div class="modal fade" id="commentaireShowModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">Modifier le commentaire n° <span id="commentaire-id"></span>#</h5>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>
       <div class="modal-body">
           <form id="commentaireUpdateForm" name="commentaireUpdateForm" class="form-horizontal " action="/update/commentaire" method="POST">
               @csrf 
               <input type="hidden" name="comUpdateId" id="comUpdateId">
                
                <!-- resume -->
                <div class="form-group">
                    <label class="col-sm-2 control-label">Commentaire:</label>
                    <div class="col-sm-12">
                        <textarea id="commentaire-corp" name="corp" required="" placeholder="Enter Details" class="form-control text-white h-100" style="font-size: 1rem;"></textarea>
                    </div>
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

<!-- Modal Delete commentaire-->
<div class="modal fade" id="CommentaireDelModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">Confirmer la suppression</h5>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
       </div>

       <div class="modal-footer">
           @csrf 
           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
           <a href="" id="deleteCommentaireConfirme" class="btn btn-danger" >Valider</a>
           
       </div>
     </div>
   </div>
</div>

<script>
   $('#nav5').attr('class','nav-link_ active show')

   $(document).ready(function () {
       
       /* When click show user */
        $('body').on('click', '#edit-com', function () {
          var commentaireURL = $(this).data('url');
          var corp= $(this)
          
          $.get(commentaireURL, function (data) {
              $('#commentaireShowModal').modal('show');
              $('#commentaire-id').text(data.id);
              $('#comUpdateId').val(data.id);
              $('#commentaire-corp').val(data.Corp);
              console.log(data)
          })
       });
       $('body').on('click', '#delete-commentaire', function () {
          var serieURL = $(this).data('url');
          
          $.get(serieURL, function (data) {
            $('#CommentaireDelModal').modal('show');
            $('#deleteCommentaireConfirme').attr('href',"/delete/commentaire/"+data.id);
            
          })
       });
       
    });
</script>
@endsection