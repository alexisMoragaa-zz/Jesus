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
</style>

<link href="{{ asset('/css/style.css') }}" rel="stylesheet">
<script>
  $(document).ready(function(){
  $(".modal-form").hide();
  $("#btn-cancel").click(function(){
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
  });
</script>
{{-- <script src="{{asset('plugins/jquery-validator/jquery.validate.js')}}"></script>
<script src="{{asset('js/validarAgendamiento.js')}}"></script> --}}


<div class="container">
  {{-- botones cancelar y disponivilidad de ruta --}}
  <div class="col-sm-12">
    <div class="col-md-1" style="padding-right: 80%">
      <input type="button" value="Cancelar" class="btn btn1 btn-danger" id="btn-cancel">
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

          <label for="v_llamar" class="control-label v_llamar">Volver a llamar</label>
          <input type="date" name="call_again" class="v_llamar form-control">
        {!! Form::close() !!}
  </div>
  {{-- /Cancelar Agendamioento --}}


  {{--Formulario de Agendamiento --}}
  <div class="container">
      <div class="panel panel-default">
        <div class="panel-body">
          <form class="form-horizontal formulario" role="form" id="sendd" method="POST" action="{{ url('teo/regiones')}}">

                <div class="">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input type="hidden" class="form-control" name="fundacion" value="{{$capta->fundacion}}" id="fundacion">
                  <input type="hidden" value="{{$minmax->maxDay}}" id="max_day">
                  <input type="hidden" value="{{$minmax->maxAm}}" id="max_am">
                  <input type="hidden" value="{{$minmax->maxPm}}" id="max_pm">
                  <input type="hidden" class="form-control" name="n_dues" value="{{$capta->n_dues}}">
                  <input type="hidden" class="form-control" name="id_fundacion" value="{{$capta->id_fundacion}}">
                  <input type="hidden" class="form-control" name="teleoperador" value="{{Auth::user()->id}}">
                  <input type="hidden" name="id_captacion" value="{{$capta->id}}">
                  <input type="hidden" name="checkPass">
                </div>

{{-- Inicio primera fila --}}

              <div class="row">
                  <div class="col-md-3">
                    <label class=" control-label">Tipo Retiro</label>
                    <div class="">
                      <select name="tipo_retiro" class="form-control" id="tipo_retiro">
                          <option value="">-- Seleccione --</option>
                          @foreach($estado as $est)
                              <option value="{{$est->Estado}}">{{$est->Estado}}</option>
                          @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <label class=" control-label">Comuna</label>
                      <select name="comuna" id="comuna" class="form-control">
                          <option value="">-- Seleccione --</option>
                          @foreach($comunas as $comuna)
                            <option value="{{$comuna->comuna}}">{{$comuna->comuna}}</option>
                          @endforeach
                      </select>
                  </div>

                  <div class="col-md-3 grabacion">
                    <label class=" control-label">Fecha Agendamiento</label>
                      <div class="">
                        <input type="date" id="f_agendamiento" class="form-control" name="fecha_agendamiento" value="{{$capta->fecha_agendamiento}}">
                      </div>
                  </div>

                  <div class="col-md-3">
                    <div class="col-md-6">
                      <label class="control-label">Horario</label>
                      <input type="time" class="form-control">
                    </div>

                    <div class="col-md-6">
                      <label class="control-label">Retiro</label>
                      <input type="time" class="form-control">
                    </div>

                  </div>
              </div>
  {{-- Fin primera fila --}}
  {{-- Inicio segunda fila --}}
              <div class="row">
                  <div class="col-md-3">
                    <label class=" control-label">Rut</label>
                      <input type="text" class="form-control" id="rut" name="rut"
                        placeholder="Ingrese Rut Sin Puntos ni Guion" value="{{$capta->rut}}">
                  </div>

                  <div class="col-md-3">
                    <label class=" control-label">Fono</label>
                      <input type="text" class="form-control" name="fono_1" value="{{$capta->fono_1}}">
                  </div>

                  <div class="col-md-3">
                    <label class=" control-label">Nombre</label>
                      <input type="text" class="form-control" name="nombre" value="{{$capta->nombre}}">
                  </div>

                  <div class="col-md-3">
                    <label class=" control-label">Apellido</label>
                      <input type="text" class="form-control" name="apellido" value="{{$capta->apellido}}">
                  </div>
              </div>
  {{-- Fin segunda fila --}}
  {{-- Inicio Tercera Fila --}}

             <div class="row">
                 <div class="col-md-2" id="fixedPhone">
                    <label for="c_movistar" class="control-label">Telefono Cuenta</label>
                      <input type="text" class="form-control" name="c_movistar"  value="{{$capta->cuenta_movistar}}">
                  </div>

                  <div class="col-md-3">
                    <label class="control-label">Direccion</label>
                    <input type="text" name="direccion" class="form-control" placeholder="Ej: Santa Magdalena" value="{{$capta->direccion}}">
                  </div>

                  <div class="col-md-1">
                    <label for="" class="control-label">N°</label>
                    <input type="text" name="numero" class="form-control" placeholder="658">
                  </div>

                  <div class="col-md-2">
                    <label for="" class="control-label">Tipo Direccion</label>
                    <select name="lugarRetiro" id="lugarRetiro" class="form-control">
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
                      <input type="text" class="form-control" name="correo_1" value="{{$capta->correo_1}}">
                  </div>
              </div>
    {{-- Fin tercera fila --}}
    {{-- Inicio Cuarta fila --}}
              <div class="row">
                <div class="col-md-6">
                  <label class=" control-label">Observaciones</label>
                  <textarea name="observaciones" rows="5" cols="30" class="form-control">{{$capta->observaciones}}</textarea>
                </div>

                <div class="col-md-6">
                    <div class="row">

                        <div class="col-md-4">
                          <label class="control-label">Campaña</label>
                          <input type="text" class="form-control" name="nom_campana" value="{{$capta->campanas->nombre_campana}}"onfocus="this.blur()" >
                        </div>

                        <div class="col-md-4">
                          <label class="control-label" for="monto">Monto</label>
                          <input type="text" class="form-control" name="monto"  id="monto" value="{{$capta->monto}}">
                        </div>

                        <div class="col-md-4">
                          <label class="control-label">Forma Pago</label>
                          <select name="forma_pago" class="form-control" id="f_pago">
                            <option value="">-- Seleccione --</option>
                            @foreach($f_pago as $pago)
                              <option value="{{$pago->Estado}}">{{$pago->Estado}}</option>
                            @endforeach
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
  </div>{{--fin container interno--}}
</div>
@endsection
