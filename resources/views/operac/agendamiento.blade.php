@extends('app')
@section('content')

    <style>
        #espacio {

            margin-bottom: 38px;
        }

        .contenedor2 {
            margin: auto;
            margin-top: 40px;
            max-width: 97%;

        }

        .contenedor1 {
            margin: auto;
            margin-top: 40px;
            max-width: 90%;

        }

        .table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
            background-color: #caecff;
        }

        #table-table {

            height: 500px;
            overflow: auto;
        }

        .btn{
            margin-top: 23px;
        }


    </style>
    <script src="http://code.jquery.com/jquery-migrate-1.0.0.js"></script>
    <script>
        $(document).ready(function () {

            $(".detalle").hide();
            $(".ocultar").css('color', 'white');
            $(".mas").hide();

            $("#opcion").change(function(){

                if($(this).val()==1){

                    $("#buscar").text("Nombre");
                    $("#datos").attr("type","text");
                    $("#datos").val("");

                }else if($(this).val()==2){

                    $("#buscar").text("Apellido");
                    $("#datos").attr("type","text");
                    $("#datos").val("");

                }else if($(this).val()==3){

                    $("#buscar").text("Rut");
                    $("#datos").attr("type","number");
                    $("#datos").val("");

                }else if($(this).val()==4){

                    $("#buscar").text("Fono");
                    $("#datos").attr("type","number");
                    $("#datos").val("");
                }

                else
                {
                    $("#buscar").text("Buscar");
                    $("#datos").attr("type","text");
                    $("#datos").val("");
                }
            });

            $("#mas").toggle(function(){

                $(".busqueda").hide();
                $(".mas").fadeIn();
                $(this).val("Menos -");
            },function(){

                $(".busqueda").fadeIn();
                $(".mas").hide();
                $(this).val("Mas +");
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

            $("#tabla_resultados").hide();



            $("#btn_search").click(function () {

                var datos_busqueda = $("#filtros").serialize();

                $.get("showDay1",datos_busqueda, procesar_datos);
                console.log(datos_busqueda);

                function procesar_datos(data){

                    console.log(data);

                    if ($("#dias").val() == 1) {
                        $("#tabla_resultados >tbody").empty();
                        $("#table").hide();
                        $("#tabla_resultados").fadeIn();

                    } else if ($("#dias").val() == 2) {
                        $("#tabla_resultados >tbody").empty();
                        $("#table").fadeOut();
                        $("#tabla_resultados").show();


                    } else if ($("#dias").val() == 3) {
                        $("#tabla_resultados >tbody").empty();
                        $("#table").fadeOut();
                        $("#tabla_resultados").show();

                    } else {
                        $("#tabla_resultados").hide();
                        $("#table").fadeIn();

                    }
                    var fila = data.length;
                    for (var i = 0; i < fila; i++) {
                        var nuevafila = "<tr><td>" +
                                data[i].id + "</td><td>" +
                                data[i].nombre + " " + data[i].apellido + "</td><td>" +
                                data[i].fono_1 + "</td><td>" +
                                data[i].rut+ "</td><td>" +
                                data[i].correo_1 + "</td><td>" +
                                data[i].direccion + "</td><td class='detalle'>" +
                                data[i].comuna + "</td><td class='detalle'>" +
                                data[i].horario + "</td><td>" +
                                data[i].observaciones + "</td><td class='detalle'>" +
                                data[i].teleoperador + "</td><td class='detalle'>" +
                                data[i].fundacion + "</td><td class='detalle'>" +
                                data[i].nom_campana + "</td><td class='detalle'>" +
                                data[i].forma_pago + "</td><td class='detalle'>" +
                                data[i].fecha_captacion + "</td><td class='detalle'>" +
                                data[i].fecha_agendamiento + "</td><td>" +
                                data[i].monto + "</td><td>" +
                                data[i].rutero + "</td></tr>"


                        if (data[i].nombre != null) {
                            $("#table").fadeOut();
                            $("#tabla_resultados").show();
                            $("#tabla_resultados").append(nuevafila)
                            if ($("#vista").val() == 1) {
                                $(".detalle").hide();
                            }
                            if ($("#vista").val() == 2) {
                                $(".detalle").fadeIn();
                            }

                        }
                    }

                }

            });



            $("#btn_search_mas").click(function(){

                var send_datos = $("#filtros").serialize();


                   $.get("filtrarpor",send_datos,procesar_dat);

                    console.log(send_datos);

                function procesar_dat(data){

                    console.log(data);


                    if ($("#opcion").val() == 1) {
                        $("#tabla_resultados >tbody").empty();
                        $("#table").hide();
                        $("#tabla_resultados").fadeIn();

                    } else if ($("#opcion").val() == 2) {
                        $("#tabla_resultados >tbody").empty();
                        $("#table").fadeOut();
                        $("#tabla_resultados").show();


                    } else if ($("#opcion").val() == 3) {
                        $("#tabla_resultados >tbody").empty();
                        $("#table").fadeOut();
                        $("#tabla_resultados").show();

                    } else if($("#opcion").val() == 4){
                        $("#tabla_resultados >tbody").empty();
                        $("#table").fadeOut();
                        $("#tabla_resultados").show();

                    } else {
                        $("#tabla_resultados").hide();
                        $("#table").fadeIn();

                    }
                    var fila = data.length;
                    for (var i = 0; i < fila; i++) {
                        var nuevafila = "<tr><td>" +
                                data[i].id + "</td><td>" +
                                data[i].nombre + " " + data[i].apellido + "</td><td>" +
                                data[i].fono_1 + "</td><td>" +
                                data[i].rut+ "</td><td>" +
                                data[i].correo_1 + "</td><td>" +
                                data[i].direccion + "</td><td class='detalle'>" +
                                data[i].comuna + "</td><td class='detalle'>" +
                                data[i].horario + "</td><td>" +
                                data[i].observaciones + "</td><td class='detalle'>" +
                                data[i].teleoperador + "</td><td class='detalle'>" +
                                data[i].fundacion + "</td><td class='detalle'>" +
                                data[i].nom_campana + "</td><td class='detalle'>" +
                                data[i].forma_pago + "</td><td class='detalle'>" +
                                data[i].fecha_captacion + "</td><td class='detalle'>" +
                                data[i].fecha_agendamiento + "</td><td>" +
                                data[i].monto + "</td><td>" +
                                data[i].rutero + "</td></tr>"


                        if (data[i].nombre != null) {
                            $("#table").fadeOut();
                            $("#tabla_resultados").show();
                            $("#tabla_resultados").append(nuevafila)
                            if ($("#vista").val() == 1) {
                                $(".detalle").hide();
                            }
                            if ($("#vista").val() == 2) {
                                $(".detalle").fadeIn();
                            }

                        }
                    }

                }



            });

        });
    </script>
    <form action="" id="filtros">
    <div class=" contenedor1" id="con">

        <div class="col-md-2">
            <label for="" class="control-label">Tipo de Vista</label>
            <select name="tipo_vista" id="vista" class="form-control">
                <option value="1">Simple</option>
                <option value="2">Detallada</option>
            </select>
        </div>

        <div class="col-md-2 busqueda">
            <label for="" class="control-label">Filtrar Por</label>
            <select name="dias" id="dias" class="form-control">
                <option value="">--seleccione --</option>
                <option value="1">Hoy</option>
                <option value="2">La Semana</option>
                <option value="3">El Mes</option>
            </select>
        </div>

        <div class="col-md-2 busqueda">
            <label for="" class="control-label">Teleoperador</label>
            <select name="teo" id="teo" class="form-control">
                <option value="">Todos</option>
                @foreach($teos as $teo)
                    <option value="{{$teo->name}}">{{$teo->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2 busqueda">
            <label for="" class="control-label">Rutero</label>
            <select name="rutero" id="rutero" class="form-control">
                <option value="">Todos</option>
                @foreach($ruteros as $rutero)
                    <option value="{{$rutero->name}}">{{$rutero->name}}</option>
                @endforeach
            </select>
        </div>

       

        <div class="col-md-2 mas">
            <label for="" class="control-label">Buscar Por</label>
            <select name="op" id="opcion" class="form-control">
                <option value="">-- Seleccione --</option>
                <option value="1">Nombre</option>
                <option value="2">Apellido</option>
                <option value="3">Rut</option>
                <option value="4">Fono</option>

            </select>
        </div>
        <div class="col-md-2 mas">

            <label for="" class="control-label" id="buscar">Buscar</label>
            <input type="text" class="form-control " id="datos" name="dato">

        </div>

        <div class="col-md-2">

            <input type="button" class="btn btn-success busqueda" value="Buscar" id="btn_search" >
            <input type="button" class="btn btn-success mas" value="Buscar" id="btn_search_mas" >
            <input type="button" class="btn btn-info mas+" value="Mas +" id="mas" >

        </div>

        <div class="col-md-12" id="espacio"> </div>



        <div class="cl-md-12 table table-responsive" id="table-table">

            <table class="table table-striped table-hover table-condensed" id="table">

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
                </tr>
                </thead>
                <tbody>

                @foreach($datos as $dato)
                    <tr>
                        <td>{{$dato->id}}</td>
                        <td>{{$dato->nombre}} {{$dato->apellido}}</td>
                        <td>{{$dato->fono_1}}</td>
                        <td>{{$dato->rut}}</td>
                        <td class="detalle">{{$dato->correo_1}}</td>
                        <td>{{$dato->direccion}}</td>
                        <td class="detalle">{{$dato->comuna}}</td>
                        <td class="detalle">{{$dato->horario}}</td>
                        <td>{{$dato->observaciones}}</td>
                        <td class="detalle">{{$dato->teleoperador}}</td>
                        <td class="detalle">{{$dato->fundacion}}</td>
                        <td class="detalle">{{$dato->nom_campana}}</td>
                        <td class="detalle">{{$dato->forma_pago}}</td>
                        <td class="detalle">{{$dato->fecha_captacion}}</td>
                        <td class="detalle">{{$dato->fecha_agendamiento}}</td>
                        <td>{{$dato->monto}}</td>
                        <td class="rutero">{{$dato->rutero}}</td>

                    </tr>
                @endforeach

                </tbody>

            </table>


            <table id="tabla_resultados" class="table  table-hover table-condensed">
                <thead>
                <th>ID</th>
                <th>Nombre</th>
                <th>Fono</th>
                <th>Rut</th>
                <th class="detalle">Correo</th>
                <th>Direccion</th>
                <th class="detalle">Comuna</th>
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

                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    </div>

    </form>
@endsection