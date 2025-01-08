@extends('layouts.app')
@section('content')


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    </head>
    <div class="container">

        <div class="form-group">
            
            <input class="typeahead form-control" id="search" type="text" placeholder="Rechercher" >

            <select name="Streaming" onChange="combo(this)"  >
                <option id="F">Film</option>
                <option id="S">Série</option>
              </select> 
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

    <!--Jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
    <!-- Owl Carousel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <!-- custom JS code after importing jquery and owl -->
    <script type="text/javascript">
        
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


        var path = "{{ route('autocompleteF') }}";
        function combo(elem) {
            console.log(elem.value)
            if (elem.value=="Film") {
                path='{{ route("autocompleteF") }}';
            }else{
                path='{{ route("autocompleteS") }}';
            }
            

        }
        

        
        $('#search').typeahead({
            source: function (query, process) {
                console.log('heeeelp')
                return $.get(path, {
                    query: query
                }, function (data) {
                    return process(data);
                });
            }
        });
    </script>

@endsection