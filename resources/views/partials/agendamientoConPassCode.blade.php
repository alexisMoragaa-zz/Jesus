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

<script src="{{asset('plugins/jquery-validator/jquery.validate.js')}}"></script>
<script src="{{asset('js/validarAgendamiento.js')}}"></script>

<div class="container">

        <div class="col-sm-12">
            <div class="col-md-3" style="float:left">
                <input type="button" value="Cancelar" class="btn btn1 btn-danger" id="btn-cancel">
            </div>
            <div class="col-md-6">
              <h3>Estas Agendando con Validacion Reducida</h3>
            </div>
            <div class="col-md-3" style="float:right">
                <input type="button" class="btn btn1 btn-info" value="Ver Disponivilidad Rutas" disabled id="btn_rutas">
            </div>
        </div>

  {{-- /botones cancelar y disponivilidad de ruta --}}

  {{-- Cancelar Agendamioento --}}
      <div class="modal-form" title="Cancelar Agendamiento">
        {{-- Conesta ventana modal se puede cancelar un agendamiento y reasignar el valor de estado para el registro
        en caso de llegar a esta pantalla por error, o que el socio se arrepienta durante el transcurso de la llamada --}}
        @if(Auth::user()->perfil==1)
            {!! Form::open(['url'=>['admin/siguiente',$capta->id],'method'=>'POST','id'=>'form-cap']) !!}
        @elseif(Auth::user()->perfil==2)
            {!! Form::open(['url'=>['teo/siguiente',$capta->id],'method'=>'POST','id'=>'form-cap']) !!}
        @endif
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

  {{-- Modal validar Rutas --}}
      <div class="modal_form_rutas" title="Verificar Rutas">
        {{-- Este bloque corresponde a una ventana modal que carga informacion mediante ajax, para mostrar
        la disponivilidad de rutas el dia seleccionado para el rutero asignado a la comuna en cuestion.
        presenta la informacion en pantalla en dos tablas haciendo distincion entre las rutas AM y PM --}}
        <h3 id="titulo" style="padding-bottom: 10px"></h3>
        <table class="table " id="rutas_dias_table">
          <h5 id="tituloam"></h5>
            <thead>
                <th>Rutero</th>
                <th>Comuna</th>
                <th>Horario</th>
                <th>Verificacion</th>
            </thead>
            <tbody></tbody>
        </table>

        <table class="table " id="rutas_dias_tablePm">
          <h5 id="titulopm"></h5>
          <thead>
            <th>Rutero</th>
            <th>Comuna</th>
            <th>Horario</th>
            <th>Verificacion</th>
          </thead>
          <tbody> </tbody>
        </table>
      </div>
  {{-- /Modal validar Rutas --}}

{{-- Formulario de Agendamiento con Validacion Reducida--}}

{{-- /Formulario de Agendamiento con Validacion Reducida--}}
  {{--Formulario de Agendamiento --}}
<div class="container">
      <div class="panel panel-default">
        <div class="panel-body">
          <form class="form-horizontal formularioConPassCode" role="form" id="senddPassCode" method="POST" action="

                @if(Auth::user()->perfil==1){{ url('admin/agregado')}}@elseif(Auth::user()->perfil==2){{ url('teo/agregado')}}@endif ">

              <div class="">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" class="form-control" name="fundacion" value="{{$capta->nom_fundacion}}" id="fundacion">
                <input type="hidden" value="{{$minmax->maxDay}}" id="max_day">
                <input type="hidden" value="{{$minmax->maxAm}}" id="max_am">
                <input type="hidden" value="{{$minmax->maxPm}}" id="max_pm">
                <input type="hidden" class="form-control" name="n_dues" value="{{$capta->n_dues}}">
                <input type="hidden" class="form-control" name="id_fundacion" value="{{$capta->id_fundacion}}">
                <input type="hidden" class="form-control" name="teleoperador" value="{{auth::user()->id}}">
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
                    <label class="control-label">Horario Retiro</label>
                      <select name="jornada" class="form-control" id="jornada">
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
                 <div class="col-md-3" id="fixedPhone">
                    <label for="c_movistar" class="control-label">Telefono Cuenta</label>
                      <input type="text" class="form-control" name="c_movistar"  value="{{$capta->cuenta_movistar}}">
                  </div>

                  <div class="col-md-6">
                    <label class="control-label">Direccion</label>
                      <input type="text" name="direccion" class="form-control" placeholder="Ej: Santa Magdalena #10" value="{{$capta->direccion}}">
                  </div>

                  <div class="col-md-3">
                    <label class="control-label">Correo</label>
                      <input type="text" class="form-control" name="correo_1" value="{{$capta->correo_1}}">
                  </div>

                  <div class="col-md-3 grabacion">
                    <label class="control-label">Voluntario Ruta</label>
                      <input type="text" class="form-control" name="rutero" id="rutero" value="{{$capta->rutero}}" onfocus="this.blur()">
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
                          <input type="text" class="form-control" name="nom_campana" value="@if($function=="nada"){{$capta->campana}}@elseif($function=="editar"){{$capta->nom_campana}}@endif"onfocus="this.blur()" >
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

  {{-- /formulario de Agendamiento --}}

  {{-- tabla Comuna Rutas --}}
      <table class="table table-responsive grabacion">
        {{-- Esta tabla muestra los dias que el rutero va en la comuna seleccionada ademas de los
        horarios en los cuales pasa por esas comunas --}}
          <thead>
            <tr>
              <th>Comuna</th>
              <th>Voluntario</th>
              <th>Lunes</th>
              <th>Martes</th>
              <th>Miercoles</th>
              <th>Jueves</th>
              <th>Viernes</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td id="comunatable">x</td>
              <td id="voluntario">x</td>
              <td id="lunes">x</td>
              <td id="martes">x</td>
              <td id="miercoles">x</td>
              <td id="jueves">x</td>
              <td id="viernes">x</td>
            </tr>
          </tbody>
      </table>
  {{-- /tabla Comuna Rutas --}}
</div>{{-- /Fin Container Externo --}}




@endsection
