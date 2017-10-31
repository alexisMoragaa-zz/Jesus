@extends('app')

@section('content')
    <style>

    </style>
    <script>
        $(document).ready(function(){
            $("#statusRecordMdt").hide();

            $("#status_mdt").change(function(){

                if($(this).val() !="OK"){
                    $("#statusRecordMdt").fadeIn();
                    if($(this).val() !="1"){
                        $("#statusRecordMdt").fadeIn();
                    }else{
                        $("#statusRecordMdt").fadeOut();
                        $("#motivoMdt").val('');
                    }
                }else{
                    $("#statusRecordMdt").fadeOut();
                    $("#motivoMdt").val('');
                }
            });
        });
    </script>
  <div class="container">

      @if(Auth::user()->perfil==1)
          {!! Form::open(array('url'=>'admin/addStatusMdt','id'=>'form-mandato'))!!}
      @elseif(Auth::user()->perfil==4)
          {!! Form::open(array('url'=>'ope/addStatusMdt','id'=>'form-mandato'))!!}
      @endif

          @include('partials.partialAgendamiento')

        <div class="col-md-2">
              <label for="status-mdt" class="control-label"> Revision Mandato</label>
                <select name="status_mdt" id="status_mdt" class="form-control">
                    <option value="1">-- Seleccione --</option>
                    <option value="OK">OK</option>
                    <option value="conReparo">Con Reparo</option>
                    <option value="rechazado">Rechazado</option>
                </select>
        </div>
        <div class="col-md-4" id="statusRecordMdt">
            <label for="reasonmdt" class="control-label">Estado</label>
            <input type="text" class="form-control" id="motivoMdt" name="motivoMdt">
        </div>
        <div class="col-md-4">
            <input type="submit" class="btn btn-warning btn1" value="Ingresat Mandato">
        </div>
          <input type="hidden" name="reagendamiento" value="1">

      {!! Form::close() !!}

  </div>


@endsection