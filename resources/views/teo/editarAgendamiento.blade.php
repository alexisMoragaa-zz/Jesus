@extends('app')
@section('content')
  <style>
  .btna{
      margin-left: 150px;
     }
   .row{
       margin-right: 10px;
       margin-left: 10px;
       margin-top: 5px;
   }
   .text-muted{
     text-align: center;
   }
  </style>

  <script>
  $(document).ready(function(){
      /**Ocultamos las ventanas Modales*/
      $("#fixedPhone").hide();


      if($("#tipo_retiro").val()=="Acepta Grabacion"){
          /**Verificamos el tipo de agendamiento y ocultamos campos dependiendo del tipo seleccionado*/
          $("#fixedPhone").show();
          $(".send_data").attr("disabled",false);
      }

      $("#tipo_retiro").change(function(){

          if($(this).val()=="Acepta Grabacion"||$(this).val()=="Acepta Upgrade"){
              $(".grabacion").fadeOut();
              $("#btn_rutas").hide();
          }else{
              $(".grabacion").fadeIn();
              $("#fixedPhone").hide();
              $("#btn_rutas").show();
          }
          $("#f_pago").change(function(){

              if($(this).val()=="Movistar"){
                  $("#fixedPhone").show();
              }else{
                  $("#fixedPhone").hide();
              }
          });
      });/**Fin */

  });
  </script>
  <script src="{{asset('plugins/jquery-validator/jquery.validate.js')}}"></script>
  <script src="{{asset('js/validarAgendamiento.js')}}"></script>


  <div class="container">
    <h2 class="text-muted">{{$reage->motivo_cap}}</h2>
    <div class="col-sm-12">

        <div class="col-md-2 right">
            <input type="button" class="btn btn1 btn-info" value="Ver Disponivilidad Rutas" disabled id="btn_rutas">
        </div>
    </div>

      <div class="panel panel-default">

        <form action="{{url('teo/editCapPost')}}" method="post">
          <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="row">
          <div class="col-md-3">
            <label for="tipo_retiro" class="control-label">Tipo Retiro</label>
            <select name="tipo_retiro" id="tipo_retiro" class="form-control">
              <option value="{{$reage->tipo_retiro}}">{{$reage->tipo_retiro}}</option>
              @foreach($estado as $est)
                <option value="{{$est->Estado}}">{{$est->Estado}}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3">
            <label for="comuna" class="control-label">Comuna</label>
            <select name="comuna" id="comuna" class="form-control">
              <option value="{{$reage->comuna}}">{{$reage->comuna}}</option>
              <!--[queda pendiente foreach para recorrer las comunas de retiro]-->
              @foreach($comunas as $comuna)
                <option value="{{$comuna->comuna}}">{{$comuna->comuna}}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3 grabacion">
            <label for="fechaAgendamiento" class="control-label">Fecha Agendamiento</label>
            <input type="date" class="form-control" name="fecha_agendamiento"
            id="f_agendamiento" value="{{$reage->fecha_agendamiento}}">
          </div>
          <div class="col-md-3">
            <label for="Horario" class="control-label">Horario</label>
            <select name="horario" id="jornada" class="form-control">
              <option value="{{$reage->horario}}">{{$reage->horario}}</option>
              <option value="AM">AM</option>
              <option value="PM">PM</option>
            </select>
          </div>
        </div>

        <!--[Fin Primera Fila]-->
        <div class="row">
          <div class="col-md-3">
            <label for="rut" class="control-label">Rut</label>
            <input type="text" class="form-control" name="rut"
            placeholder="ingrese rut, sin puntos ni guion" value="{{$reage->rut}}">
          </div>
          <div class="col-md-3">
            <label for="fono" class="control-label">Fono</label>
            <input type="text" class="form-control" name="fono_1" value="{{$reage->fono_1}}">
          </div>
          <div class="col-md-3">
            <label for="nombre" class="control-label">Nombre</label>
            <input type="text" class="form-control" name="nombre" value="{{$reage->nombre}}">
          </div>
          <div class="col-md-3">
            <label for="apellido" class="control-label">Apellido</label>
            <input type="text" class="form-control" name="apellido" value="{{$reage->apellido}}">
          </div>
        </div>
        <!--[Fin Segunda Fila]-->
        <div class="row">
          <div class="col-md-6">
            <label for="" class="control-label">Direccion</label>
            <input type="text" class="form-control" value="{{$reage->direccion}}" name="direccion">
          </div>
          <div class="col-md-3">
            <label for="" class="control-label">Correo</label>
            <input type="text" class="form-control" value="{{$reage->correo_1}}" name="correo_1">
          </div>
          <div class="col-md-3 grabacion">
            <label for="" class="control-label">Voluntario Ruta</label>
            <input type="text" id="rutero" class="form-control" value="{{$reage->rutero}}" name="rutero">
          </div>
          <div class="col-md-3 grabacion" id="fixedPhone">
            <label for="" class="control-label">Telefono Cuenta</label>
            <input type="text" class="form-control">
          </div>
        </div>

        <div class="row">
          <div class="col-md-5">
            <label for="" class="control-label">Observaciones</label>
            <textarea name="observaciones" id="" cols="30" rows="6" value="" class="form-control">{{$reage->observaciones}}</textarea>
          </div>
          <div class="col-md-2">
            <label for="" class="control-label">Campaña</label>
            <input type="text" class="form-control" value="{{$reage->nom_campana}}" readonly>
          </div>
          <div class="col-md-2">
            <label for="" class="control-label">Monto</label>
            <input type="text" class="form-control" value="{{$reage->monto}}" name="monto">
          </div>
          <div class="col-md-3">
            <label for="" class="control-label">Forma Pago</label>
            <select name="forma_pago" id="f_pago" class="form-control">
              <option value="{{$reage->forma_pago}}">{{$reage->forma_pago}}</option>
              @foreach($f_pago as $pago)
                <option value="{{$pago->Estado}}">{{$pago->Estado}}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3 right">
            <input type="submit" class="btn btn-primary btn1 right" value="Actualizar Agendamiento">
          </div>

        </div>
        <input type="hidden" value="{{$reage->id}}" name="id_captacion">

        <!--[Fin Tercera Fila]-->
      </form> {{-- fin formulario--}}

    </div>{{--fin panel--}}

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
</div>
@endsection
