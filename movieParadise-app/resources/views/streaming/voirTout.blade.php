@extends('layouts.app')
@section('content')



        <div class="container">


                <form action="/searchStreaming" method="get" class="form-inline">
                    <div class="row g-3">
                        <div class="col-sm-7">
                            <input id="search" name="search" type="search" class="form-control " placeholder="Search" style="color:whitesmoke;" autocomplete="off"/>
                          </div>
                          <div class="col-sm">
                            <button class="btn bg-light  " type="submit"><i class="fa fa-search"></i> </button>
                        </div>   

                    </div>                             
                </form>


                        
                      <h2 style="color:whiteSmoke">Ma liste</h2>
                        <div class="owl-carousel ">    
                            @foreach ($maListe as $filmSerie)
                                <div class="item">
                                    @if (count($filmSerie)==11)
                                        <a id="imgCardStreaming" href="/serie/{{ $filmSerie['id'] }}" class="card col-sm-4 ">
                                    @else
                                        <a id="imgCardStreaming" href="/film/{{ $filmSerie['id'] }}" class="card col-sm-4 ">
                                    @endif
                                        <img class="card-img-center " src="https://image.tmdb.org/t/p/w200{{ $filmSerie['image'] }}" alt="Card image cap">
                                    </a>
                                </div>
                            @endforeach               
                        </div>  
                
                        <h2 style="color:whiteSmoke">Films</h2>
                        <div class="owl-carousel ">
                           
                            @foreach ($film as $lesFilms2)
                                <div class="item">
                                    <a id="imgCardStreaming" href="/film/{{ $lesFilms2->id }}" class="card col-sm-4 ">
                                        <img class="card-img-center " src="https://image.tmdb.org/t/p/w200{{ $lesFilms2->image }}" alt="Card image cap">
                                    </a>
                                </div>
                            @endforeach               
                        </div>   
                
                        <h2 style="color:whiteSmoke">Series</h2>
                        <div class="owl-carousel ">
                          
                            
                            @foreach ($serie as $lesSeries)
                            
                                <div class="item">
                                    <a id="imgCardStreaming" href="/serie/{{ $lesSeries->id }}" class="card col-sm-4 ">
                                        <img class="card-img-center " src="https://image.tmdb.org/t/p/w200{{ $lesSeries->image }}" alt="Card image cap">
                                    </a>
                                </div>
                            @endforeach               
                        </div>   
                        
                
                        <h2 style="color:whiteSmoke">récemment ajouté</h2>
                        <div class="owl-carousel ">
                           
                            @foreach ($lastAdd as $filmSerie)
                                <div class="item">
                                    @if (count($filmSerie)==11)
                                        <a id="imgCardStreaming" href="/film/{{ $filmSerie['id'] }}" class="card col-sm-4 ">
                                    @else
                                        <a id="imgCardStreaming" href="/serie/{{ $filmSerie['id'] }}" class="card col-sm-4 ">
                                    @endif
                                        <img class="card-img-center " src="https://image.tmdb.org/t/p/w200{{ $filmSerie['image'] }}" alt="Card image cap">
                                    </a>
                                </div>
                            @endforeach               
                        </div> 

                        <h2 style="color:whiteSmoke">Les Films les plus vue ce moi-ci</h2>
                        <div class="owl-carousel ">
                          
                            
                            @foreach ($filmMV as $lesfilmMV)
                            
                                <div class="item">
                                    <a id="imgCardStreaming" href="/film/{{ $lesfilmMV->id }}" class="card col-sm-4 ">
                                        <img class="card-img-center " src="https://image.tmdb.org/t/p/w200{{ $lesfilmMV->image }}" alt="Card image cap">
                                    </a>
                                </div>
                            @endforeach               
                        </div>   

                        @foreach ($toutesCateg as $categ)
                            <h2 style="color:whiteSmoke">{{$categ->nomCateg}} </h2>
                            <div class="owl-carousel ">
                            
                                
                                @foreach ($FilmRecommander[$categ->nomCateg] as $films)
                                        <div class="item">
                                            <a id="imgCardStreaming" href="/film/{{ $films->id }}" class="card col-sm-4 ">
                                                <img class="card-img-center " src="https://image.tmdb.org/t/p/w200{{ $films->image }}" alt="Card image cap">
                                            </a>
                                        </div>
                                @endforeach               
                            </div>   
                        @endforeach
        </div>




   

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <!-- Owl Carousel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <!-- custom JS code after importing jquery and owl -->
    <script type="text/javascript" >
        
        $(document).ready(function() {
            $(".owl-carousel").owlCarousel();
        });

        $('.owl-carousel').owlCarousel({
            loop: true,

            responsive: {
                0: {
                    items: 2
                },
                500: {
                    items: 2
                },
                750: {
                    items: 3
                },
                1100: {
                    items: 4
                },
                1250: {
                    items: 5
                },
                1500: {
                    items: 6
                },
                1700: {
                    items: 7
                }
            }
        })
        var global = new Array();
        var route = "{{ url('autocomplete') }}";
        
        $('#search').typeahead({
            source:  function (term, process) {
            return $.get(route, { term: term }, function (data) {
             return process(data);
                });
            }  
        });

    </script>

@endsection 