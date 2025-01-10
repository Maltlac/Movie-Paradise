@extends('layouts.app')
@section('content')


    <div class="container">

        <div id="custom-search-input">
                <div class="input-group">
                    <input id="search" name="search" type="text" class="form-control" placeholder="Search" style="color:whitesmoke" />
                    
                </div>

            </div>

            
        


        <h2 style="color:whiteSmoke">Films</h2>
        <div class="owl-carousel owl-theme">
           
            @foreach ($film as $lesFilms2)
                <div class="item">
                    <a id="imgCardStreaming" href="/film/{{ $lesFilms2->id }}" class="card col-sm-4 ">
                        <img class="card-img-center " src="https://image.tmdb.org/t/p/w200{{ $lesFilms2->image }}" alt="Card image cap">
                    </a>
                </div>
            @endforeach               
        </div>   

        <h2 style="color:whiteSmoke">Series</h2>
        <div class="owl-carousel owl-theme">
          
            
            @foreach ($serie as $lesSeries)
            
                <div class="item">
                    <a id="imgCardStreaming" href="/serie/{{ $lesSeries->id }}" class="card col-sm-4 ">
                        <img class="card-img-center " src="https://image.tmdb.org/t/p/w200{{ $lesSeries->image }}" alt="Card image cap">
                    </a>
                </div>
            @endforeach               
        </div>   

          
        
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
            pagination: false,
            margin: 10,
            nav: false,
            axis:"x",
            lazyLoad : true,
            theme:"dark",
            responsive: {
                0: {
                    items: 1
                },
                250: {
                    items: 2
                },
                500: {
                    items: 3
                },
                750: {
                    items: 4
                },
                1000: {
                    items: 5
                }
            }
        })
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