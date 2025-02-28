@extends('profil.layoutprofil')

@section('second_content')

<div class="profile-content">
    <!-- begin tab-content -->
    <div class="tab-content p-0">

       <!-- begin #profile-about tab -->
       <div class="tab-pane fade in active show" id="profile-about">
          <!-- begin table -->
          <div class="table-responsive">
             <table class="table table-profile">
               <form action="{{route('update.profil')}} " method="post">
                  @csrf
                  <tbody style=" color: whitesmoke;">
                     <tr class="highlight">
                        <td class="field">Name : </td>
                        <td><input type="text" name="name" id="name"  class="form-control" required maxlength="50" value="{{ Auth::user()->name }}"></td>
                     </tr>
                     <tr class="highlight">
                        <td class="field">Mood : </td>
                        <td><input type="text" name="mood" id="mood"  class="form-control" required maxlength="50" value="{{ Auth::user()->info }}"></td>
                     </tr>
                     <tr class="highlight">
                        <td class="field">&nbsp;</td>
                        <td class="p-t-10 p-b-10">
                           <button type="submit" class="btn btn-primary width-150">Update</button>
                        </td>
                     </tr>
                  </tbody>
               </form>
             </table>
          </div>
          <!-- end table -->
       </div>
       <!-- end #profile-about tab -->
    </div>
    <!-- end tab-content -->
 </div>
 <!-- end profile-content -->
</div>


<script>
    $('#nav1').attr('class','nav-link_ active show')
 </script>
 @endsection
