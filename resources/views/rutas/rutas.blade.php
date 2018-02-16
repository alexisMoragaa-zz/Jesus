@extends('app')

@section('content')
    <style>



    </style>
    <script src="http://code.jquery.com/jquery-migrate-1.0.0.js"></script>
    <script>
        $(document).ready(function () {


            $(".futuras").hide();
            $(".pasadas").hide();
            $("#dia").hide();
            $(".ocultar").hide();

            $("#buscarPor").change(function () {

                if ($(this).val() == 'hoy') {

                    $(".futuras").fadeOut();
                    $(".pasadas").fadeOut();
                    $("#dia").fadeOut();

                } else if ($(this).val() == 'rutas futuras') {

                    $(".pasadas").hide();
                    $("#dia").hide();
                    $(".futuras").fadeIn(800);

                } else if ($(this).val() == 'rutas pasadas') {

                    $(".futuras").hide();
                    $("#dia").hide();
                    $(".pasadas").fadeIn(800);
                }else if($(this).val() == 'dia'){

                    $(".futuras").hide();
                    $(".pasadas").hide();
                    $("#dia").fadeIn(800);
                }

            });

            $("#info").toggle(function(){


                $(this).val("menos info");
                $(".ocultar").fadeIn();
                },function(){

                        $(this).val("mas info");
                        $(".ocultar").fadeOut();
            }

            );

        });
    </script>
    <div class="contenedor1">


    @if(Session::has('message'))
      <div class="col-md-12   alert alert-info" id="breadCrum">
        {{Session::get('message')}}
      </div>

        <div class="col-md-12 linea">

        </div>
@endif
@if(Auth::user()->perfil ==1)
        {!! Form::open(array('url'=>'/admin/filtroRutas')) !!}
@elseif(Auth::user()->perfil ==4)
            {!! Form::open(array('url'=>'/ope/filtroRutas')) !!}
@endif
                <div class="col-md-3">
                    <label for="" class="control-label">Buscar por</label>
                    <select name="buscarPor" id="buscarPor" class="form-control">
                        <option value="hoy">Hoy</option>
                        <option value="rutas futuras">Rutas Futuras</option>
                        <option value="rutas pasadas">Rutas Pasadas</option>
                        <option value="dia">Buscar Por Dia</option>
                     </select>
                </div>
                <div class="col-md-3 futuras">
                    <label for="" class="control-label">Rutas Para</label>
                    <select name="rutas_para" id="rutas_para" class="form-control">
                        <option value="mañana">Mañana</option>
                        <option value="la semana">La semana</option>
                        <option value="el mes">El mes</option>
                        <option value="elInfinitoYMasAlla">El Infinito Y mas Alla</option>
                    </select>
                </div>

                <div class="col-md-3 pasadas">
                    <label for="" class="control-label">Rutas De</label>
                    <select name="rutasDe" id="rutasDe" class="form-control">
                        <option value="ayer">Ayer</option>
                        <option value="la semana">La Semana</option>
                        <option value="el mes">El Mes</option>
                        <option value="elOrigenDeLosTiempos">El Origen de los tiempos</option>
                    </select>
                </div>

                <div class="col-md-3" id="dia">
                    <label for="" class="control-label">Seleccioe Dia</label>
                    <input type="date" class="form-control" name="buscarPorDia">
                </div>

                <div class="col-md-3">
                    <label for="" class="control-label">Voluntario Ruta</label>
                    <select name="voluntario" id="voluntario" class="form-control">
                        <option value="todos">--Todos--</option>
                        @foreach($ruteros as$rutero)
                            <option value="{{$rutero->name}}">{{$rutero->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <input type="submit" class="btn btn1 btn-success" value="Buscar">

                    <input type="button" class="btn btn1 btn-info" value="Mas Info" id="info">
                </div>


        {!! Form::close() !!}

        <table class="table table-responsive table-striped table-hover">
            <thead>
            <th>Nombre</th>
            <th>direccion</th>
            <th>Comuna</th>
            <th>Fono</th>

            <th>Horario</th>
            <th id="dia">Dia</th>
            <th>Voluntario</th>
            <th>Estado</th>
            <th>N°Visita</th>
            <th class="ocultar">Observaciones</th>
            </thead>
            <tbody>
            @foreach($rutas as $ruta)
                 <tr>
                    <td>{{$ruta->nombre}} {{$ruta->apellido}}</td>
                    <td>{{$ruta->direccion}}</td>
                    <td>{{$ruta->comuna}}</td>
                    <td>{{$ruta->fono_1}}</td>

                    <td>{{$ruta->horario}}</td>
                    <td id="dia">{{$ruta->fecha_agendamiento}}</td>
                     <td>{{$ruta->rutero}}</td>

                     @foreach($estado as $estados)
                         @if($ruta->id == $estados->id)
                             <td>{{$estados->estado_primer_agendamiento}}</td>
                         @endif
                     @endforeach
                      <td><a href="{{url('/ope/detalleRuta',$ruta->id)}}">Ver Mas</a></td>
                     <td class="ocultar" >{{$ruta->observaciones}}</td>
                 </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
