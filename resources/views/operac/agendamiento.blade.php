@extends('app')
@section('content')

    <style>

      #code{
        float:right;
        margin-top: -7em;
        margin-bottom: 7em;
      }
      .danger{
        border-color: red;
      }

    </style>
    <script src="http://code.jquery.com/jquery-migrate-1.0.0.js"></script>
    <script>
        $(document).ready(function () {

            $(".detalle").hide();
            $(".busqueda").hide();
            // $(".ocultar").css('color', 'white');
            // $(".mas").hide();

            $("#filtterBy").change(function(){

                if($(this).val() == 1){
                  $(".busqueda").hide();
                  $("#teleoperador").fadeIn();

                }else if($(this).val()==2){
                  $(".busqueda").hide();
                  $("#ruteros").fadeIn();

                }else if($(this).val()==3){
                  $(".busqueda").hide();
                  $("#catchDate").fadeIn();

                }else if($(this).val()==4){
                  $(".busqueda").hide();
                  $("#dateBook").fadeIn();

                }else if($(this).val()==5){
                  $(".busqueda").hide();
                  $("#name").fadeIn();

                }  else if($(this).val()==6){
                    $(".busqueda").hide();
                    $("#dni").fadeIn();

                }else if($(this).val()==7){
                  $(".busqueda").hide();
                  $("#phon").fadeIn();
                }

            });

            $("#vista").change(function () {
              if ($("#vista").val() == 2) {
                $(".detalle").fadeIn(1000);
                $("#con").removeClass('contenedor1');
                $("#con").addClass('contenedor2');
              } else {
                $(".detalle").fadeOut(800);
                $("#con").removeClass('contenedor2');
                $("#con").addClass('contenedor1');
              }
            });

      });
    </script>

    <div class=" contenedor1" id="con">
      <div class="row">
        {!!Form::open(['url'=>['ope/pc'],'method'=>'post'])!!}

        <div class="col-md-4 input-group" id="code">
          @if($code =="fail")
            <input type="password" class="form-control danger" placeholder="Las Contraseñas no Conciden" id="pass" name="pass">

          @elseif($code =="")
              <input type="password" class="form-control" placeholder="Ingrese su password Actual" id="pass" name="pass">
          @endif

          <span class="input-group-btn">
            <input type="submit" class="btn btn-warning " value="Genarar Codigo" id="getpass">
          </span>
        </div>
        {!!Form::close()!!}

    @if(Auth::user()->perfil==1)
        {!! Form::open(['url'=>['admin/showDay1'],'method'=>'POST']) !!}
    @elseif(Auth::user()->perfil==4)
        {!! Form::open(['url'=>['ope/showDay1'],'method'=>'POST']) !!}
    @endif


  </div>
  <div class="row">
      <div class="col-md-2">
          <label for="" class="control-label">Tipo de Vista</label>
          <select name="tipo_vista" id="vista" class="form-control">
              <option value="1">Simple</option>
              <option value="2">Detallada</option>
          </select>
      </div>

        <div class="col-md-2 ">
          <label for="" class="control-label">Filtrar Por</label>
          <select name="filtterBy" id="filtterBy" class="form-control" required>
              <option value="">--seleccione --</option>
              <option value="1">TeleOperador</option>
              <option value="2">Rutero</option>
              <option value="3">Fecha Captacion</option>
              <option value="4">Fecha Agendamiento</option>
              <option value="5">Nombre Socio</option>
              <option value="6">Rut Socio</option>
              <option value="7">Fono Socio</option>
              <option value="8">Captaciones de Ayer</option>
              <option value="9">Captaciones de la Semana</option>
              <option value="10">Captaciones del Mes</option>
          </select>
        </div>

        <div class="col-md-2 busqueda" id="teleoperador">
            <label for="" class="control-label">Teleoperador</label>
            <select name="teo" id="teo" class="form-control">
                <option value="">Seleccione</option>
                @foreach($teos as $teo)
                    <option value="{{$teo->id}}">{{$teo->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2 busqueda" id="ruteros">
            <label for="" class="control-label">Rutero</label>
            <select name="rutero" id="rutero" class="form-control">
                <option value="">Seleccione</option>
                @foreach($ruteros as $rutero)
                    <option value="{{$rutero->name}}">{{$rutero->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2 busqueda" id="catchDate">
            <label for="" class="control-label">Fecha Captacion</label>
          <input type="date" class="form-control"  name="catchDate">
        </div>

        <div class="col-md-2 busqueda" id="dateBook">
            <label for="" class="control-label">Fecha Agendamiento</label>
          <input type="date" class="form-control"  name="dateBook">
        </div>

        <div class="col-md-2 busqueda" id="name">
            <label for="" class="control-label">Nombre Socio</label>
          <input type="text" class="form-control"  name="memberName">
        </div>

        <div class="col-md-2 busqueda" id="dni">
            <label for="" class="control-label">Rut Socio</label>
          <input type="text" class="form-control"  name="memberDni">
        </div>

        <div class="col-md-2 busqueda"  id="phon">
            <label for="" class="control-label">Fono Socio</label>
          <input type="text" class="form-control" name="memberPhone">
        </div>

        <div class="col-md-2">
          <input type="submit" class="btn btn1 btn-success" value="Buscar" id="btn_search" >
        </div>
        <div class="col-md-4">
          <h3 class="text-center text-muted">@if(isset($breadCrum)){{$breadCrum}}@endif</h3>
        </div>
  </div>
{!! Form::close() !!}

        <div class="col-md-12" id="espacio"> </div>



        <div class="cl-md-12 table table-responsive " id="table-table">

            <table class="table table-hover table-condensed" id="table">

                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Fono</th>
                    <th>Rut</th>
                    <th class="detalle">Correo</th>
                    <th>Direccion</th>
                    <th class="detalle">Comuna</th>
                    <th class="detalle">Horario</th>
                    <th>Observaciones</th>
                    <th class="detalle ">TeleOperador</th>
                    <th class="detalle">Fundacion</th>
                    <th class="detalle">Campaña</th>
                    <th class="detalle">F Pago</th>
                    <th class="detalle">Captacion</th>
                    <th class="detalle">Agendamiento</th>
                    <th>Monto</th>
                    <th>rutero</th>
                    <th>Detalle</th>
                    <th id="mdt" ><span id="mdtspan" class=" glyphicon glyphicon-list-alt "></span></th>
                </tr>
                </thead>
                <tbody>

                @foreach($datos as $dato)
                    @if($dato == "")
                        @else
                        @if($dato->estado_captacion =="OK")
                            <tr class="success">
                        @elseif($dato->edit =="editado")
                            <tr class="info">
                        @elseif($dato->estado_captacion =="conReparo")
                            <tr class="warning">
                        @elseif($dato->estado_captacion =="rechazada")
                            <tr class="danger">
                        @elseif($dato->estado_captacion =="")
                            <tr>
                                @endif
                        <td>{{$dato->id}}</td>
                        <td>{{$dato->nombre}} {{$dato->apellido}}</td>
                        <td>{{$dato->fono_1}}</td>
                        <td>{{$dato->rut}}</td>
                        <td class="detalle">{{$dato->correo_1}}</td>
                        <td>{{$dato->direccion}}</td>
                        <td class="detalle">{{$dato->comuna}}</td>
                        <td class="detalle">{{$dato->horario}}</td>
                        <td>{{ str_limit($dato->observaciones,$limit=34,$end="...")}}</td>
                        <td class="detalle">{{$dato->user->name}}</td>
                        <td class="detalle">{{$dato->fundacion}}</td>
                        <td class="detalle">{{$dato->nom_campana}}</td>
                        <td class="detalle">{{$dato->forma_pago}}</td>
                        <td class="detalle">{{$dato->fecha_captacion}}</td>
                        <td class="detalle">{{$dato->fecha_agendamiento}}</td>
                        <td>{{$dato->monto}}</td>
                        <td class="rutero">{{$dato->rutero}}</td>
                        @if(Auth::User()->perfil == 1)
                            <td><a href="{{route('admin.call.show',$dato->id)}}">Ver <span class="glyphicon glyphicon-search"></span></a></td>
                        @elseif(Auth::User()->perfil == 4)
                            <td><a href="{{route('ope.call.show',$dato->id)}}">Ver <span class="glyphicon glyphicon-search"></span></a></td>

                        @endif
                                @if($dato->estado_mandato =="OK")
                                    <td class="center"><span class="glyphicon glyphicon-ok"></span></td>
                                @elseif($dato->estado_mandato =="conReparo")
                                    <td class="center"><span class="glyphicon glyphicon-minus-sign"></span></td>
                                @elseif($dato->estado_mandato =="rechazado")
                                    <td center="center"><span class="glyphicon glyphicon-remove"></span></td>
                                @elseif($dato->estado_mandato =="")
                                    <td center="center"><span class="glyphicon "></span></td>
                                @endif
                    </tr>
                    @endif
                @endforeach

                </tbody>

            </table>


    </div>
    </div>


@endsection
