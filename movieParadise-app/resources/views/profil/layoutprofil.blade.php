@extends('layouts.app')
@vite(['resources/css/profilStyle.css'])
@section('content')
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<div class="container">
   <div class="row">
      <div class="col-md-12">
         <div id="content" class="content content-full-width">
            <!-- begin profile -->
            <div class="profile">
               <div class="profile-header">
                  <!-- BEGIN profile-header-cover -->
                  <div class="profile-header-cover"></div>
                  <!-- END profile-header-cover -->
                  <!-- BEGIN profile-header-content -->
                  <div class="profile-header-content">
                     <!-- BEGIN profile-header-img -->
                     <div class="profile-header-img">
                        <img src="https://bootdey.com/img/Content/avatar/avatar3.png" alt="">
                     </div>
                     <!-- END profile-header-img -->
                     <!-- BEGIN profile-header-info -->
                     <div class="profile-header-info">
                        <h4 class="m-t-10 m-b-5">{{ Auth::user()->name }}</h4>
                        <p class="m-b-10">Mood : {{ Auth::user()->info ?? "" }}</p>
                        <a href="{{route('profil.parametre')}}" class="btn btn-sm btn-info mb-2">Edit Profile</a>
                     </div>
                     <!-- END profile-header-info -->
                  </div>
                  <!-- END profile-header-content -->
                  <!-- BEGIN profile-header-tab -->
                  <ul class="profile-header-tab nav nav-tabs bg-dark.bg-gradient" style="background-color: rgb(207, 207, 207)">
                     <li class="nav-item"><a id="nav1" href="{{route('profil.parametre')}}"  class="nav-link_ ">Paramètres</a></li>
                     <li class="nav-item"><a id="nav2" href="{{route('profil.cinema')}}"  class="nav-link_">Mes cinémas favories</a></li>
                     <li class="nav-item"><a id="nav3" href="{{route('profil.film')}}" class="nav-link_">Film/Series</a></li>
                     <li class="nav-item"><a id="nav4" href="{{route('profil.Artiste')}}"  class="nav-link_">Artistes</a></li>
                     <li class="nav-item"><a id="nav5" href="{{route('profil.commentaire')}}"  class="nav-link_">Comentaires({{$nbcoms}}) </a></li>
                  </ul>
                  <!-- END profile-header-tab -->
               </div>
            </div>
            <!-- end profile-content -->
         </div>
      </div>
   </div>
   <div>
      @yield('second_content')
   </div>
</div>

@endsection