@extends('app')

@section('content')
    <script>
        $(document).ready(function () {

            $(".futuras").hide();
            $(".pasadas").hide();

            $("#buscarPor").change(function () {

                if ($(this).val() == 'hoy') {

                    $(".futuras").fadeOut();
                    $(".pasadas").fadeOut();

                } else if ($(this).val() == 'rutas futuras') {

                    $(".futuras").fadeIn(800);
                    $(".pasadas").hide();

                } else if ($(this).val() == 'rutas pasadas') {

                    $(".futuras").hide();
                    $(".pasadas").fadeIn(800);
                }
            });

        });
    </script>

    <div>
        <img class="logoRu" src="/imagenes/iconoRu.png">
    </div>

    <div class="contenedor1">

        {!! Form::open(array('url'=>'/admin/filtroRutas')) !!}

                <div class="col-md-3">
                    <label for="" class="control-label">Buscar por</label>
                    <select name="buscarPor" id="buscarPor" class="form-control">
                        <option value="hoy">Hoy</option>
                        <option value="rutas futuras">Rutas Futuras</option>
                        <option value="rutas pasadas">Rutas Pasadas</option>
                     </select>
                </div>
                <div class="col-md-3 futuras">
                    <label for="" class="control-label">Rutas Para</label>
                    <select name="rutas_para" id="rutas_para" class="form-control">
                        <option value="mañana">Mañana</option>
                        <option value="la semana">La semana</option>
                        <option value="el mes">El mes</option>
                        <option value="el infinito y mas alla">El Infinito Y mas Alla</option>
                    </select>
                </div>

                <div class="col-md-3 pasadas">
                    <label for="" class="control-label">Rutas De</label>
                    <select name="Rutas_De" id="" class="form-control">
                        <option value="ayer">Ayer</option>
                        <option value="la semana">La Semana</option>
                        <option value="el mes">El Mes</option>
                        <option value="el origen de los tiempos">El Origen de los tiempos</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="" class="control-label">Voluntario Ruta</label>
                    <select name="voluntario" id="voluntario" class="form-control">
                        <option value="">--Todos--</option>
                        @foreach($ruteros as$rutero)
                            <option value="{{$rutero->name}}">{{$rutero->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="submit" class="btn btn-success" value="Buscar">
                </div>

        {!! Form::close() !!}

        <table class="table table-responsive table-striped table-hover">
            <thead>
            <th>Nombre</th>
            <th>direccion</th>
            <th>Comuna</th>
            <th>Fono</th>
            <th>Am/Pm</th>
            <th>Hora</th>
            <th id="dia">Dia</th>
            </thead>
            <tbody>
            <tr>
                @foreach($rutas as $ruta)
                    <td>{{$ruta->nombre}} {{$ruta->apellido}}</td>
                    <td>{{$ruta->direccion}}</td>
                    <td>{{$ruta->comuna}}</td>
                    <td>{{$ruta->fono_1}}</td>
                    <td>{{$ruta->jornada}}</td>
                    <td>{{$ruta->horario}}</td>
                    <td id="dia">{{$ruta->fecha_agendamiento}}</td>
                @endforeach
            </tr>
            </tbody>
        </table>
    </div>
@endsection