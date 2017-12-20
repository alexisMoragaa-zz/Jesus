@extends('app')
@section('content')
  <style>
    .md-label{
      margin-top:23px;
        }
    #ruta{
      margin-bottom: 2em;
    }
    #mtn-1{
      margin-top: -1em;
    }
    .float-right{
      float: right;
    }
  </style>
  <script src="{{asset('plugins/jquery-validator/jquery.validate.js')}}"></script>
  <script>
    $(document).ready(function(){

      $("#nombre").hide();
      $("#apellido").hide();
      $("#rut").hide();
      $("#fecha").hide();
      $("#captacion").hide();
      $("#ruta").hide();

      $("#buscarSocioPor").change(function(){
        if($(this).val()=="captacion"){
          $("#ruta").hide();
          $("#captacion").fadeIn();
        }else if ($(this).val()=="ruta") {
          $("#captacion").hide();
          $("#ruta").fadeIn();
        }
      });

      $("#buscarPor").change(function(){
        if($(this).val()=="nombre"){
          $("#nombre").fadeIn(500);
          $("#apellido").hide();                $("#lastName").val("");
          $("#rut").hide();                     $("#ci").val("");
          $("#fecha").hide();                   $("#date").val("");
        }else if ($(this).val()=="apellido") {
          $("#nombre").hide();                  $("#name").val("");
          $("#apellido").fadeIn(500);
          $("#rut").hide();                     $("#ci").val("");
          $("#fecha").hide();                   $("#date").val("");
        }else if ($(this).val()=="rut") {
          $("#nombre").hide();                  $("#name").val("");
          $("#rut").fadeIn(500);
          $("#apellido").hide();                $("#lastName").val("");
          $("#fecha").hide();                   $("#date").val("");
        }else if ($(this).val()=="fecha") {
          $("#nombre").hide();                  $("#name").val("");
          $("#fecha").fadeIn(500);
          $("#apellido").hide();                $("#lastName").val("");
          $("#rut").hide();                     $("#ci").val("");
        }
      });

      $("#validateRuta").validate({
        rules:{
          rutero:{
            required:true,
          },
          fecha:{
            required:true,
          },
        },messages:{
          rutero:{
            required:"Campo Obligatorio",
          },
          fecha:{
            required:"Campo Obligatorio",
          },
        }
      });
      $("#validate").validate({
        rules:{
          teleoperador:{
            required:true,
          },
          nombre:{
            required:function(element){
              return $("#buscarPor").val()=="nombre";
            }
          },
          apellido:{
            required:function(element){
              return $("#buscarPor").val()=="apellido";
            }
          },
          rut:{
            required:function(element){
              return $("#buscarPor").val()=="rut";
            }
          },
          fecha:{
            required:function(element){
              return $("#buscarPor").val()=="fecha";
            }
          },
        },
        messages:{
          teleoperador:{
              required:"Seleccione un Teleoperador",
          },
          nombre:{
            required:"Campo Obligatorio",
          },

          apellido:{
            required:"Campo Requerido",
          },
          rut:{
            required:"Campo Requerido",
          },
          fecha:{
            required:"Campo Requerido",
          },
        }
      });

    });

  </script>
  <div class="container">
    <div class="row">
      <div class="col-md-12">

          <h1 id="mtn-1">Recepcion  de Mandatos</h1>
          <h3 class="text-muted">Buscar Agendamiento por
            @if(isset($filtroPor))
              <span>{{$filtroPor}}</span>
            @endif
          </h3>

          <div class="row">
            <div class="col-md-4">
              <label for="" class="control-label">Buscar Socio Por</label>
              <select name="" id="buscarSocioPor" class="form-control">
                <option value="">Seleccione</option>
                <option value="captacion">Captacion</option>
                <option value="ruta">Ruta</option>
              </select>
            </div>
          </div>

          <div class="row" id="captacion">
            <form action="/ope/registrar/mandato/captacion" method="post" id="validate">
                <input type="hidden" name="_token" value="{{csrf_token()}}">

                <div class="col-md-4">
                  <label for="" class="control-label">Teleoperador</label>
                  <select class="form-control" name="teleoperador" id="teleoperador">
                    <option value="">Seleccione</option>
                    @foreach ($teleoperador as $teo)
                      <option value="{{$teo->id}}">{{$teo->name}} {{$teo->last_name}}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-xs-12 col-md-3">
                    <label for="">Buscar Socio Por</label>
                    <select name="buscarPor" id="buscarPor" class="form-control">
                      <option value="">Buscar Por</option>
                      <option value="nombre">Nombre</option>
                      <option value="apellido">Apellido</option>
                      <option value="rut">Rut</option>
                      <option value="fecha">fecha</option>
                    </select>
                </div>

                <div class="col-xs-12 col-md-3" id="nombre">
                  <label for="" class="control-label">Nombre Socio</label>
                  <input type="text" class="form-control" name="nombre" id="name">
                </div>

                <div class="col-xs-12 col-md-3" id="apellido">
                  <label for="" class="control-label">Apellido Socio</label>
                  <input type="text" class="form-control" name="apellido" id="lastName">
                </div>

                <div class="col-xs-12 col-md-3" id="rut">
                  <label for="" class="control-label">Rut Socio</label>
                  <input type="text" class="form-control" name="rut" id="ci">
                </div>

                <div class="col-xs-12 col-md-3" id="fecha">
                  <label for="" class="control-label">fecha Agendamiento</label>
                  <input type="date" class="form-control" name="fecha" id="date">
                </div>

                <div class="col-xs-12 col-md-2 md-label">
                  <input type="submit" value="Buscar" class="btn btn-success">
                </div>
            </form>
          </div>{{--fin row Captacion--}}

          <div class="row" id="ruta">
            <div class="col-md-8">
              <form action="/ope/registrar/mandato/ruta" method="post" id="validateRuta">
                  <input type="hidden" name="_token" value="{{csrf_token()}}">
                  <div class="col-xs-12 col-md-4">
                    <label for="" class="control-label">Rutero</label>
                    <select name="rutero" id="" class="form-control">
                      <option value="">Seleccione Rutero</option>
                      @foreach ($ruteros as $rutero)
                        <option value="{{$rutero->id}}">{{$rutero->name}} {{$rutero->last_name}}</option>
                      @endforeach
                    </select>
                  </div>

                <div class="col-md-4">
                  <label for="" class="control-label">Fecha Ruta</label>
                  <input type="date" class="form-control" name="fecha">
                </div>

                <div class="col-md-4">
                    <input type="submit" class="btn btn-success md-label" value="Buscar">
                </div>
              </form>
            </div>


            <div class="col-md-4"> {{--inicio filtro de rutas por erstado de rutas mas rutero--}}
              <form action="/ope/registrar/mandato/ruta/conReparo" method="post">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                  <h3 class="text-muted"></h3>
                  <div class="col-md-6">
                    <label for="" class="control-label">Seleccione Rutero</label>
                    <select name="rutero" id="" class="form-control">
                      <option value="">Seleccione</option>
                      @foreach ($ruteros as $rutero)
                        <option value="{{$rutero->id}}">{{$rutero->name}} {{$rutero->last_name}}</option>
                      @endforeach
                    </select>
                  </div>

                <div class="col-md-6 float-right">
                  <input type="submit" class="btn btn-warning btn1" value="Buscar Por estado de Ruta">
                </div>
              </form>
            </div>
        </div>{{--fin row Ruta--}}

      </div>{{--fin col-md-12--principal--}}
    </div>{{--fin Row Principal--}}

    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <th>Nombre</th>
              <th>Telefono</th>
              <th>Rut</th>
              <th>Direccion</th>
              <th>Comuna</th>
              <th>Detalle</th>
            </thead>
            <tbody>
              @if(isset($registros))
                @foreach ($registros as $registro)
                  <tr>
                    <td>{{$registro->nombre}}</td>
                    <td>{{$registro->fono_1}}</td>
                    <td>{{$registro->rut}}</td>
                    <td>{{$registro->direccion}}</td>
                    <td>{{$registro->comuna}}</td>
                    <td><a href="{{url('ope/detalleRuta',$registro->id)}}">Detalle</a></td>
                  </tr>
                @endforeach
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>{{--Fin Cointainer--}}

@endsection
