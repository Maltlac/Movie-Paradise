<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Movie Paradise</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <script src="https://kit.fontawesome.com/1277de46c1.js" crossorigin="anonymous"></script>
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" />
    @stack('css')
    

    <!-- Scripts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
 
    
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body >
    <div id="app" >
        <nav class="navbar navbar-expand-md navbar-dark bg-dark" id="headerApp">
            <div class="container" style="display: contents">
                
                <a class="navbar-brand d-flex"  href="{{route("streaming.index")}}">
                    <img src="/images/LogoSite.jpg" style="height:70px; mix-blend-mode: multiply;" class="pr-1">
                </a>

                


                <div class="collapse navbar-collapse d-flex" id="navbarNavDarkDropdown">
                    <ul class="navbar-nav">
                      <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          Catégories
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                            @foreach($listeCateg as $categ)
                                <li><a class="dropdown-item" href="/p/film/categ/{{$categ->id}}/year/tous">{{$categ->nom}} </a></li>
                            @endforeach 
                          <li></li>
                        </ul>
                      </li>
                    </ul>
                </div>

                <ul class="navbar-nav ms-auto me-5">
                    
                    
                          @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <div class="dropdown">
                                <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"> {{ Auth::user()->name }}</button>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark ">
                                    <li><a class="dropdown-item" href="{{route("ebillet.home")}} "><i class="fa fa-ticket" aria-hidden="true"></i>Réserver un E-billet </a></li>
                                    <li><a class="dropdown-item" href="{{route('profil.commentaire')}}"> <i class="fa fa-user" aria-hidden="true"></i> Profil</a></li>
                                    <li><a class="dropdown-item" href="/contact"> <i class="fa fa-envelope-o"></i> Nous contacter</a></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> <i class="fa fa-sign-out" aria-hidden="true"></i>  {{ __('Logout') }} </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                    
                                    <li>
                                        <div class="dropdown-divider"></div>
                                        @if(Auth::user()->role=="admin")
                                            <a href="/panneauCtrl" class="navbar-brand dropdown-item" ><i class="fa fa-lock" aria-hidden="true"></i>  panneau de controle</a>
                                        @endif 
                                    </li>
                                </ul>
                            </div>
                            
                        @endguest
                        <div class="btn-group">
                </ul>           

            </div>
        </nav>
        
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>

<style>
    .dropdown-menu-right { 
    right: 0; 
    left: auto; 
}
</style>