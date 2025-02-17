@extends('layouts.app')

@section('content')
@php
    use Carbon\Carbon; 
@endphp
<div class="container bg-light rounded shadow-sm border border-dark">
    <table class="table table-striped">
        @foreach ($data as $data2)
            @foreach($data2 as $post)
            <tr style="height:250px">
                <td><img src="{{ $post['image'] }} " alt="" style="width:160px; height:231px"> </td>
                <td>
                    {{ $post['titreFilm'] }} <br> 
                    {{ $post['infoDivers']}} <br>
                    {{ $post['infoActeur']}} <br> 
                    {{ $post['infoReal']  }} <br>
                    {{ $post['synopsis']  }}
                </td>

                <td>{{ $post['date'] }}
                    @foreach ($post['seance'] as $item)
                        @php
                            $dt = Carbon::now()

                        @endphp
                        @if ($dt>$item["heure"] && $data->currentPage()==1)
                            <a class="btn btn-secondary mt-1" style="pointer-events: none" >{{$item["heure"]}}</a> 
                        @else
                            <a id="seanceResa" class="btn btn-warning mt-1" data-titre="{{ $post['titreFilm'] }}" data-date="{{ $post['date'] }}" data-heure="{{$item["heure"]}}">{{$item["heure"]}}</a> 
                        @endif
                            
                        
                    @endforeach
                </td>
            </tr>
            @endforeach
        @endforeach
        
    </table>
    {{ $data->links() }}
</div>
<div class="modal fade" id="resaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Réservation billets</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body d-inline">
            <form id="filmUpdateForm" name="filmUpdateForm" class=" d-inline" action="{{route("reserver.billet")}} " method="POST">
                @csrf
                <input type="hidden" name="titre" id="titreFilm" >
                <input type="hidden" name="date" id="dateSeance" >
                <input type="hidden" name="heure" id="dateSeanceH">
                <div class="center">
                    <p>PLEIN 11.20€ :  </p>
                    <div class="input-group">
                        
                          <span class="input-group-btn">
                              <button type="button" class="btn btn-danger btn-number"  data-type="minus" data-field="quant[1]">
                                <span class="glyphicon glyphicon-minus">-</span>
                              </button>
                          </span>
                          <input type="text" name="quant[1]" class="form-control input-number bg-light" value="0" min="0" max="10" style="max-width: 80px">
                          <span class="input-group-btn">
                              <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="quant[1]">
                                  <span class="glyphicon glyphicon-plus">+</span>
                              </button>
                          </span>
                      </div>      
                </div>

                <div class="center">
                    <p>MOINS 18 ANS 7.80 € :  </p>
                    <div class="input-group float-left">
                        
                          <span class="input-group-btn">
                              <button type="button" class="btn btn-danger btn-number"  data-type="minus" data-field="quant[2]">
                                <span class="glyphicon glyphicon-minus">-</span>
                              </button>
                          </span>
                          <input type="text" name="quant[2]" class="form-control input-number bg-light " value="0" min="0" max="10" style="max-width: 80px">
                          <span class="input-group-btn">
                              <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="quant[2]">
                                  <span class="glyphicon glyphicon-plus">+</span>
                              </button>
                          </span>
                      </div>      
                </div>

                <div class="center">
                    <p >ETUDIANT 7.80 € :  </p>
                    <div class="input-group">
                        
                          <span class="input-group-btn">
                              <button type="button" class="btn btn-danger btn-number"  data-type="minus" data-field="quant[3]">
                                <span class="glyphicon glyphicon-minus">-</span>
                              </button>
                          </span>
                          <input type="text" name="quant[3]" class="form-control input-number bg-light" value="0" min="0" max="10" style="max-width: 80px">
                          <span class="input-group-btn">
                              <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="quant[3]">
                                  <span class="glyphicon glyphicon-plus">+</span>
                              </button>
                          </span>
                      </div>      
                </div>
<br>
                <div class="d-inline">

                        <p class="d-inline" >Total :</p>
                        <p class="d-inline" id="totalPlaceP" >0</p>
                        <input type="hidden" id="totalPlace" name="totalPlace" style="max-width: 80px" class="d-inline">
                        <p class="d-inline">€</p>

                </div>


                <!-- footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Réserver
                    </button>
                </div>
             </form>
        </div>
        
      </div>
    </div>
  </div>

  <script>
     $(document).ready(function () {

       $('body').on('click', '#seanceResa', function () {

            $('#resaModal').modal('show');
            $('#titreFilm').val($(this).data('titre'));
            $('#dateSeance').val($(this).data('date'));
            $('#dateSeanceH').val($(this).data('heure'));
       });
       
    });

    $('.btn-number').click(function(e){
    e.preventDefault();
    
    fieldName = $(this).attr('data-field');
    type      = $(this).attr('data-type');
    var input = $("input[name='"+fieldName+"']");


    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
        if(type == 'minus') {
            
            if(currentVal > input.attr('min')) {
                input.val(currentVal - 1).change();
            } 
            if(parseInt(input.val()) == input.attr('min')) {
                $(this).attr('disabled', true);
            }

        } else if(type == 'plus') {

            if(currentVal < input.attr('max')) {
                input.val(currentVal + 1).change();
            }
            if(parseInt(input.val()) == input.attr('max')) {
                $(this).attr('disabled', true);
            }

        }
        var input1 = $("input[name='quant[1]']");
        var input2 = $("input[name='quant[2]']");
        var input3 = $("input[name='quant[3]']");
       
        var currentVal1 = parseInt(input1.val())*11.20 ;
        var currentVal2 = parseInt(input2.val())*5.80;
        var currentVal3 = parseInt(input3.val())*7.80;
        var tot =currentVal1 +currentVal2 + currentVal3
        tot=Math.round(tot * 100) / 100;
        $("input[name='totalPlace']").val(tot)
        $('#totalPlaceP').text(tot)

        


    } else {
        input.val(0);
    }
    });
    $('.input-number').focusin(function(){
    $(this).data('oldValue', $(this).val());
    });
    $('.input-number').change(function() {
        
        minValue =  parseInt($(this).attr('min'));
        maxValue =  parseInt($(this).attr('max'));
        valueCurrent = parseInt($(this).val());
        
        name = $(this).attr('name');
        if(valueCurrent >= minValue) {
            $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
        } else {
            alert('Sorry, the minimum value was reached');
            $(this).val($(this).data('oldValue'));
        }
        if(valueCurrent <= maxValue) {
            $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
        } else {
            alert('Sorry, the maximum value was reached');
            $(this).val($(this).data('oldValue'));
        }
        
        
    });
    $(".input-number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
  </script>

<style>

</style>
@endsection