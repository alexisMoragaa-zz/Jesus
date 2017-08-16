@extends('app')
@section('content')

    <style>
        .contenedor2{
            margin: auto;
            margin-top: 40px;
            max-width: 97%;

        }
        .contenedor1{
            margin: auto;
            margin-top: 40px;
            max-width: 85%;

        }
        #table{

            margin-top: 35px;
        }
        .table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
            background-color: #caecff;
        }
    </style>

    <script>
        $(document).ready(function(){

            $(".detalle").hide();
            $(".ocultar").css('color','white');

            $("#vista").change(function(){

                if($("#vista").val()==2){

                    $(".detalle").fadeIn(1000);
                    $("#con").removeClass('contenedor1');
                    $("#con").addClass('contenedor2');

                }else{
                    $(".detalle").fadeOut(800);
                    $("#con").removeClass('contenedor2');
                    $("#con").addClass('contenedor1');
               }
           });

            $("#tabla_resultados").hide();

            $("#dias").change(function(e) {

                var dia=e.target.value;
                console.log(e);
                $.get('showDay?dia='+dia, function (data) {
                        console.log(data);

                    if($("#dias").val()== 1 ){
                        $("#tabla_resultados >tbody").empty();
                        $("#table").hide();
                        $("#tabla_resultados").fadeIn();

                    }else  if($("#dias").val()== 2){
                        $("#tabla_resultados >tbody").empty();
                        $("#table").fadeOut();
                        $("#tabla_resultados").show();


                    }else if($("#dias").val()== 3){
                        $("#tabla_resultados >tbody").empty();
                        $("#table").fadeOut();
                        $("#tabla_resultados").show();


                    }else{
                        $("#tabla_resultados").hide();
                        $("#table").fadeIn();

                    }
                   var fila = data.length;
                 for(var i =0; i<fila;i++){
                     var nuevafila= "<tr><td>" +
                             data[i].nombre + "</td><td>" +
                             data[i].apellido + "</td><td>" +
                             data[i].id + "</td></tr>"

                         if(data[i].nombre != null) {
                            $("#table").fadeOut();
                             $("#tabla_resultados").show();
                             $("#tabla_resultados").append(nuevafila)
                        }
                 }
                });

              });

        });
    </script>

    <div class=" contenedor1" id="con">

        <div class="col-md-3">
            <label for="" class="control-label">Tipo de Vista</label>
            <select name="tipo_vista" id="vista" class="form-control">
                <option value="1">Simple</option>
                <option value="2">Detallada</option>
            </select>
        </div>

        <div class="col-md-3">
            <label for="" class="control-label">Ver agendamientos de</label>
            <select name="" id="dias" class="form-control">
                <option value="">--seleccione --</option>
                <option value="1">Hoy</option>
                <option value="2">La Semana</option>
                <option value="3">El Mes</option>
            </select>
        </div>

        <div class="col-md-3">
            <label for="" class="control-label">Teleoperador</label>
            <select name="" id="" class="form-control">
            <option value="">Todos</option>
            @foreach($teos as $teo)
                <option value="{{$teo->id}}">{{$teo->name}}</option>
            @endforeach
            </select>
        </div>
<div class="cl-md-12 table table-responsive">

        <table class="table table-striped table-hover" id="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Fono</th>
                <th>Rut</th>
                <th class="detalle">Correo</th>
                <th>Direccion</th>
                <th class="detalle">Comuna</th>
                <th class="detalle" >Rutero</th>
                <th class="detalle">Horario</th>
                <th>Observaciones</th>
                <th class="detalle">TeleOperador</th>
                <th class="detalle">Fundacion</th>
                <th class="detalle">Campaña</th>
                <th class="detalle">Forma De Pago</th>
                <th class="detalle">Captacion</th>
                <th class="detalle">Agendamiento</th>
                <th>Monto</th>
                <th>rutero</th>
            </tr>
            </thead>
            <tbody>
            @foreach($datos as $dato)
                <tr>
                    <td>{{$dato->id}}</td>
                    <td>{{$dato->nombre}} {{$dato->apellido}}</td>
                    <td>{{$dato->fono_1}}</td>
                    <td>{{$dato->rut}} - {{$dato->dv}}</td>
                    <td class="detalle">{{$dato->correo_1}}</td>
                    <td>{{$dato->direccion}}</td>
                    <td class="detalle">{{$dato->comuna}}</td>
                    <td class="detalle">{{$dato->rutero}}</td>
                    <td class="detalle">{{$dato->horario}}</td>
                    <td>{{$dato->observaciones}}</td>
                    <td class="detalle">{{$dato->teleoperador}}</td>
                    <td class="detalle">{{$dato->fundacion}}</td>
                    <td class="detalle">{{$dato->nom_campana}}</td>
                    <td class="detalle">{{$dato->forma_pago}}</td>
                    <td class="detalle">{{$dato->fecha_captacion}}</td>
                    <td class="detalle">{{$dato->fecha_agendamiento}}</td>
                    <td>{{$dato->monto}}</td>
                    <td class="rutero"></td>

                </tr>
            @endforeach
            </tbody>

        </table>
        </div>

        <table id="tabla_resultados" class="table table-striped table-hover">
            <thead>
            <th>nombre</th>
            <th>apellido</th>
            <th>id</th>
            </thead>
            <tbody >
                <tr>

                </tr>
            </tbody>
        </table>

</div>
    </div>


@endsection