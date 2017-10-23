@extends('app')
@section('content')

    <style>



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



        });
    </script>
{!! Form::open(array('url'=>'admin/showDay1')) !!}
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

            <input type="submit" class="btn btn1 btn-success busqueda" value="Buscar" id="btn_search" >
            <input type="button" class="btn btn1 btn-success mas" value="Buscar" id="btn_search_mas" >
            <input type="button" class="btn btn1 btn-info mas+" value="Mas +" id="mas" >

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
                        <td>{{$dato->observaciones}}</td>
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