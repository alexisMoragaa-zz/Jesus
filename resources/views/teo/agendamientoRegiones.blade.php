@extends('app')
@section('content')
<style>
    .error {
        border-color: red;
    }
    .succes {
        border-color: green;
    }
    #space{
        margin-left: -40%;
    }
    #space2{
        margin-left: 40%;
    }
    .btn2{
      margin-top: 2em;
    }
    #code{
      float:right;
      margin-top: -5em;
      margin-bottom: 5em;
      }
      .center{
        text-align: center;
      }
</style>

<link href="{{ asset('/css/style.css') }}" rel="stylesheet">
<script>
  $(document).ready(function(){
    $(".modal-form").hide();//ocultamos la ventana modal para cancelar el agendamiento
    $("#btn-cancel").click(function(){//al ejecutatar la funcion click en el boton cancel mostramos la ventana modal con el formaulario para cancelar el agendamiento
        $( ".modal-form" ).dialog({
            buttons: [{
               text: "Cancelar","class":'btn btn-danger space',"id":'space',click: function () {

                    $(this).dialog("close");
                }},{
                text:"Aceptar","class":'btn btn-success',"id":'space2',click : function(){
                    $("#form-cap").submit();
                }
            }]
        });
    });

    $("#cobertura").hide();//ocultamos las cuatro tablas que componen la cobertura

    $("#comunas").change(function(){

    });

    $("#btn-cobertura").click(function(){
      if($("#comuna").val()!=""){
        var comuna = $("#comunas").val();
        $.get('/teo/show/cobertura',{ comuna }, function(data){
          console.log(data);
          $("#comunacobertura").text(data.comuna);
          $("#showCobertura").text(data.cobertura);

            $("#semana1").empty();
            var semana1 ="<tr><td>"+
            data.semana_1_lunes+"</td><td>"+
            data.semana_1_martes+"</td><td>"+
            data.semana_1_miercoles+"</td><td>"+
            data.semana_1_jueves+"</td><td>"+
            data.semana_1_viernes+"</td><tr>"
            $("#semana1").append(semana1);

            $("#semana2").empty();
            var semana2 ="<tr><td>"+
            data.semana_2_lunes+"</td><td>"+
            data.semana_2_martes+"</td><td>"+
            data.semana_2_miercoles+"</td><td>"+
            data.semana_2_jueves+"</td><td>"+
            data.semana_2_viernes+"</td><tr>"
            $("#semana2").append(semana2);

            $("#semana3").empty();
            var semana3 ="<tr><td>"+
            data.semana_3_lunes+"</td><td>"+
            data.semana_3_martes+"</td><td>"+
            data.semana_3_miercoles+"</td><td>"+
            data.semana_3_jueves+"</td><td>"+
            data.semana_3_viernes+"</td><tr>"
            $("#semana3").append(semana3);

            $("#semana4").empty();
            var semana4 ="<tr><td>"+
            data.semana_4_lunes+"</td><td>"+
            data.semana_4_martes+"</td><td>"+
            data.semana_4_miercoles+"</td><td>"+
            data.semana_4_jueves+"</td><td>"+
            data.semana_4_viernes+"</td><tr>"
            $("#semana4").append(semana4);


        });
        $("#cobertura").dialog({width:"auto", height:"auto",
          buttons: [{
             text: "Cerrar","class":'btn btn-danger space',"id":'space',click: function () {
               $(this).dialog("close");

               // var semana1 ="<tr><td>"+
               // data.
             }
           }]
         });
      }else{
        alert("Seleccione Comuna");
      }

     });
    $("#comunas").autocomplete({
      source: "/teo/complete/comunas",
    	  minLength: 3,
    	  select: function(event, ui) {
    	  	$('#q').val(ui.item.value);
    }
    });
    $(".v_llamar").hide();
    $("#status").change(function(){
      if($(this).val() == "Agendar Llamado"){
        $(".v_llamar").fadeIn();
      }else{
        $(".v_llamar").fadeOut();
      }

    });

  });
</script>
{{-- <script src="{{asset('plugins/jquery-validator/jquery.validate.js')}}"></script>
<script src="{{asset('js/validarAgendamiento.js')}}"></script> --}}


<div class="container">
  {{-- botones cancelar y disponivilidad de ruta --}}
  <div class="col-sm-12">
    <div class="col-md-1" style="padding-right: 90%">
      <input type="button" value="Cancelar" class="btn btn1 btn-danger" id="btn-cancel">
    </div>
    <div class="col-md-1">
      <input type="button" value="Cobertura" class="btn btn1 btn-primary " id="btn-cobertura">

    </div>
  </div>
  {{-- /botones cancelar y disponivilidad de ruta --}}

  {{-- Cancelar Agendamioento --}}
  <div class="modal-form" title="Cancelar Agendamiento">
    {{-- Con esta ventana modal se puede cancelar un agendamiento y reasignar el valor de estado para el registro
    en caso de llegar a esta pantalla por error, o que el socio se arrepienta durante el transcurso de la llamada --}}
      {!! Form::open(['url'=>['teo/siguiente',$capta->id],'method'=>'POST','id'=>'form-cap']) !!}
          <label for="status" class="control-label">Estado Llamado</label>
          <select name="call_status" id="status" class="form-control">
              <option value="">selecione estado</option>
              @foreach($status as $sta)
                <option value="{{$sta->Estado}}">{{$sta->Estado}}</option>
              @endforeach
          </select>

          <label for="observation" class="control-label">Observacion</label>
          <input type="text" class="form-control" name="observation1">

          <label for="call_again" class="control-label v_llamar">Volver a llamar</label>
          <input type="date" name="call_again" class="v_llamar form-control">
        {!! Form::close() !!}
  </div>


  {{--Formulario de Agendamiento --}}
  <div class="container">
      <div class="panel panel-default">
        <div class="panel-body">
          <form class="form-horizontal formulario" role="form" id="sendd" method="POST" action="{{ url('teo/regiones')}}">

                <div class="">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input type="hidden" class="form-control" name="fundacion" value="{{$capta->fundacion}}" id="fundacion">
                  <input type="hidden" class="form-control" name="n_dues" value="{{$capta->n_dues}}">
                  <input type="hidden" class="form-control" name="id_fundacion" value="{{$capta->id_fundacion}}">
                  <input type="hidden" class="form-control" name="teleoperador" value="{{Auth::user()->id}}">
                  <input type="hidden" name="id_captacion" value="{{$capta->id}}">
                </div>

{{-- Inicio primera fila --}}
              <div class="row">
                <div class="col-md-3">
                  <label class=" control-label">Tipo Retiro</label>
                  <div class="">
                    <select name="tipo_retiro" class="form-control" id="tipo_retiro" required>
                        <option value="Acepta Delivery">Acepta Delivery</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <label class=" control-label">Comuna</label>
                      <input type="text"  name="comunas" id="comunas"  class="form-control">
                  </div>

                  <div class="col-md-3 grabacion">
                    <label class=" control-label">Fecha Agendamiento</label>
                      <div class="">
                        <input type="date" id="f_agendamiento" class="form-control" name="fecha_agendamiento" required value="{{$capta->fecha_agendamiento}}">
                      </div>
                  </div>

                  <div class="col-md-3">
                    <label for="" class="control-label">Horario</label>
                    <select name="jornada" id="" class="form-control" required>
                      <option value="">--Seleccione--</option>
                      <option value="AM">AM</option>
                      <option value="PM">PM</option>
                    </select>
                  </div>
              </div>
{{-- Fin primera fila --}}
{{-- Inicio segunda fila --}}
              <div class="row">
                  <div class="col-md-3">
                    <label class=" control-label">Rut</label>
                      <input type="text" class="form-control" id="rut" name="rut" required
                        placeholder="Ingrese Rut Sin Puntos ni Guion" value="{{$capta->rut}}">
                  </div>

                  <div class="col-md-3">
                    <label class=" control-label">Fono</label>
                      <input type="text" class="form-control" name="fono_1" required value="{{$capta->fono_1}}">
                  </div>

                  <div class="col-md-3">
                    <label class=" control-label">Nombre</label>
                      <input type="text" class="form-control" name="nombre" required value="{{$capta->nombre}}">
                  </div>

                  <div class="col-md-3">
                    <label class=" control-label">Apellido</label>
                      <input type="text" class="form-control" name="apellido" required value="{{$capta->apellido}}">
                  </div>
              </div>
{{-- Fin segunda fila --}}
{{-- Inicio Tercera Fila --}}
             <div class="row">

                  <div class="col-md-3">
                    <label class="control-label">Direccion</label>
                    <input type="text" name="direccion" class="form-control" required placeholder="Ej: Santa Magdalena" value="{{$capta->direccion}}">
                  </div>

                  <div class="col-md-1">
                    <label for="" class="control-label">N°</label>
                    <input type="text" name="numero" class="form-control" placeholder="658" required>
                  </div>

                  <div class="col-md-2">
                    <label for="" class="control-label">Tipo Direccion</label>
                    <select name="lugarRetiro" id="lugarRetiro" class="form-control" required>
                      <option value="">Seleccione</option>
                      <option value="Casa">Casa</option>
                      <option value="Oficina">Oficina</option>
                      <option value="Departamento">Departamento</option>
                      <option value="Trabajo">Trabajo</option>
                    </select>
                  </div>

                  <div class="col-md-1">
                    <label for="" class="control-label">Off/Depto</label>
                    <input type="text" name="off_depto" class="form-control" placeholder="302">
                  </div>

                  <div class="col-md-3">
                    <label class="control-label">Correo</label>
                      <input type="text" class="form-control" name="correo_1" value="{{$capta->correo_1}}" required>
                  </div>
              </div>
    {{-- Fin tercera fila --}}
    {{-- Inicio Cuarta fila --}}
              <div class="row">
                <div class="col-md-6">
                  <label class=" control-label">Observaciones</label>
                  <textarea name="observaciones" rows="5" cols="30" class="form-control" required>{{$capta->observaciones}}</textarea>
                </div>

                <div class="col-md-6">
                    <div class="row">

                        <div class="col-md-4">
                          <label class="control-label">Campaña</label>
                          <input type="text" class="form-control" name="nom_campana" value="{{$capta->campanas->nombre_campana}}"onfocus="this.blur()" required>
                        </div>

                        <div class="col-md-4">
                          <label class="control-label" for="monto">Monto</label>
                          <input type="text" class="form-control" name="monto"  id="monto" value="{{$capta->monto}}" required>
                        </div>

                        <div class="col-md-4">
                          <label class="control-label">Forma Pago</label>
                          <select name="forma_pago" class="form-control" id="f_pago" required>
                            <option value="">-- Seleccione --</option>
                            <option value="Cuenta Corriente"> Cuenta Corriente</option>
                            <option value="Cuenta Vista"> Cuenta Vista</option>
                            <option value="Cuenta Rut">Cuenta Rut</option>
                          </select>
                        </div>

                    </div>
                    <div class="row">
                      <div class="col-md-12">
                          <button type="submit" class="btn btn2 btn-success form-control send_data" id="enviar">
                            Ingresar Agendamiento
                          </button>
                      </div>
                    </div>
                </div>
              </div>
      {{-- Fin Cuarta fila --}}
          </form>
        </div>{{--fin Panmel Body--}}
    </div>{{--Fin Panel Default--}}

    <div class="" id="cobertura">
      <div class="col-md-6">
        <h4 class="center" >Comuna </h4>
        <h5 class="center" id="comunacobertura"></h5>
      </div>
      <div class="col-md-6">
        <h4 class="center">Cobertura</h4>
        <h5 class="center" id="showCobertura"></h5>
      </div>
<div></div>

      <div class="">
        <table class="table table-hover" >
          <h4 class="text-muted center">Semana 1</h4>
          <thead>
            <th>Lunes</th>
            <th>Martes</th>
            <th>Miercoles</th>
            <th>Jueves</th>
            <th>Viernes</th>
          </thead>
          <tbody id="semana1">

          </tbody>
        </table>
      </div>{{--FIN TABLA--}}

      <div class="">
        <table class="table table-hover" >
        <h4 class="text-muted center">Semana 2</h4>
          <thead>
            <th>Lunes</th>
            <th>Martes</th>
            <th>Miercoles</th>
            <th>Jueves</th>
            <th>Viernes</th>
          </thead>
          <tbody id="semana2">

          </tbody>
        </table>
      </div>{{--FIN TABLA--}}

      <div class=" ">
        <table class="table table-hover" >
          <h4 class="text-muted center">Semana 3</h4>
          <thead>
            <th>Lunes</th>
            <th>Martes</th>
            <th>Miercoles</th>
            <th>Jueves</th>
            <th>Viernes</th>
          </thead>
          <tbody id="semana3">

          </tbody>
        </table>
      </div>{{--FIN TABLA--}}

      <div class=" ">
        <table class="table table-hover" >
          <h4 class="text-muted center">Semana 4</h4>
          <thead>
            <th>Lunes</th>
            <th>Martes</th>
            <th>Miercoles</th>
            <th>Jueves</th>
            <th>Viernes</th>
          </thead>
          <tbody id="semana4">

          </tbody>
        </table>
      </div>{{--FIN TABLA--}}
    </div>
  </div>{{--fin container interno--}}
</div>
@endsection
