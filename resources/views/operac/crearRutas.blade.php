@extends('app')
@section('content')
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <style>
        #titulo {
            text-align: center;
            color: gray;
        }
        #ocultar{
            color: white;
        }
        #enviar{

            margin-top: 23px;
        }
        .formulario .checkbox label {
            display: inline-block;
            cursor: pointer;
            color: #111111;
            position: relative;
            padding: 5px 15px 5px 37px;
            font-size: 1em;
            border-radius: 5px;
            -webkit-transition: all 0.3s ease;
            -o-transition: all 0.3s ease;
            transition: all 0.3s ease;
        }

        .formulario .checkbox label:before {
            content: "";
            display: inline-block;
            width: 17px;
            height: 17px;
            position: absolute;
            left: 10px;
            border-radius: 40%;
            background: none;
            border: 3px solid #AAAAAA; }


        .formulario .checkbox label:before {
            border-radius: 3px; }
        .formulario .checkbox input[type="checkbox"] {
            display: none; }
        .formulario .checkbox input[type="checkbox"]:checked + label:before {
            display: none; }
        .formulario .checkbox input[type="checkbox"]:checked + label {
            background:gray;
            color: #fff;
            padding: 5px 15px; }

        .table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
            background-color: #caecff;
        }

    </style>

    <script>
        $(document).ready(function(){
            $("#lunes").hide();
            $("#martes").hide();
            $("#miercoles").hide();
            $("#jueves").hide();
            $("#viernes").hide();
            $("#enviar").hide();


            $('#checkbox1').change(function(){

                if ($('#checkbox1').is(':checked')) {

                    $("#lunes").fadeIn(700);


                }else{
                    $("#lunes").fadeOut(700);

                }
                if ($('input[type=checkbox]:checked').length != 0) {

                    $("#enviar").fadeIn();
                }else{
                    $("#enviar").fadeOut();
                }
            });

            $('#checkbox2').change(function(){

                if ($('#checkbox2').is(':checked')) {

                    $("#martes").fadeIn(700);

                }else{
                    $("#martes").fadeOut(700);
                }

                if ($('input[type=checkbox]:checked').length != 0) {

                        $("#enviar").fadeIn();
                }else{
                    $("#enviar").fadeOut();
                }
            });

            $('#checkbox3').change(function(){

                if ($('#checkbox3').is(':checked')) {

                    $("#miercoles").fadeIn(700);
                }else{
                    $("#miercoles").fadeOut(700);
                }
                if ($('input[type=checkbox]:checked').length != 0) {

                    $("#enviar").fadeIn();
                }else{
                    $("#enviar").fadeOut();
                }
            });

            $('#checkbox4').change(function(){

                if ($('#checkbox4').is(':checked')) {

                    $("#jueves").fadeIn(700);
                }else{
                    $("#jueves").fadeOut(700);
                }
                if ($('input[type=checkbox]:checked').length != 0) {

                    $("#enviar").fadeIn();
                }else{
                    $("#enviar").fadeOut();
                }
            });

            $('#checkbox5').change(function(){

                if ($('#checkbox5').is(':checked')) {

                    $("#viernes").fadeIn(700);
                }else{
                    $("#viernes").fadeOut(700);
                }
                if ($('input[type=checkbox]:checked').length != 0) {

                    $("#enviar").fadeIn();
                }else{
                    $("#enviar").fadeOut();
                }
            });


                    $("#enviar").click(function(){

                        if($("#comunas").val()!=""){

                            $("#comerror").css('color','black');

                            if($("#rutero").val()!=""){

                                $("#ruterror").css('color','black');

                                $('form').submit(function(e){

                                    if ($('input[type=checkbox]:checked').length === 0) {
                                        e.preventDefault();
                                        $("#checkerror").css('color','red');

                                    }else{
                                        $("#checkerror").css('color','black');
                                    }
                                });

                            }else{
                                $("#ruterror").css('color','red');
                                return false;
                            }
                        }else{
                            $("#comerror").css('color','red');
                            return false;
                        }

                    });

        });
    </script>

    <div class="container wrap">
        <h1 id="titulo">Asignacion de ruteros</h1>

        {!! Form::open(['url'=>['admin/comuna'],'method'=>'post','class'=>'formulario']) !!}

        <div class="col-md-6" id="contenedor-izquierdo">
            <div class="col-md-6">
                <label for="" class="control-label" id="comerror">Seleccione Comuna</label>
                <select name="comunas" id="comunas" class="form-control">
                    <option value="">-- seleccione --</option>
                    @foreach($comunas as $com)
                        <option value="{{$com->id}}">{{$com->comuna}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label for="" class="control-label" id="ruterror">Seleccione Rutero</label>
                <select name="name_rutero" id="rutero" class="form-control">
                    <option value="">-- seleccione --</option>
                    @foreach($ruteros as $rutero)
                        <option value="{{$rutero->name}}">{{$rutero->name}}</option>
                     @endforeach
                </select>
            </div>

        <div class="checkbox col-md-12">

            <p id="checkerror">Seleccione los dias para retiro</p>
            <fieldset>
            <input type="checkbox" name="checkbox1" id="checkbox1">
            <label for="checkbox1">Lunes</label>
            <input type="checkbox" name="checkbox2" id="checkbox2">
            <label for="checkbox2">Martes</label>
            <input type="checkbox" name="checkbox3" id="checkbox3">
            <label for="checkbox3">Miercoles</label>
            <input type="checkbox" name="checkbox4" id="checkbox4">
            <label for="checkbox4">Jueves</label>
            <input type="checkbox" name="checkbox5" id="checkbox5">
            <label for="checkbox5">Viernes</label>
            </fieldset>
        </div>

        </div>
        <div class="col-md-3" id="lunes">

            <div class="col-md-6">
                <label for="" class="control-label">Lunes <span id="ocultar">...........</span>de</label>
                <input type="time" name="lunes_de" class="form-control" >
            </div>

            <div class="col-md-6">
                <label for="" class="control-label">A</label>
                <input type="time" name="lunes_a" class="form-control">
            </div>
        </div>

        <div class="col-md-3" id="martes">
            <div class="col-md-6">
                <label for="" class="control-label">Martes <span id="ocultar">.....</span>de</label>
                <input type="time" class="form-control" name="martes_de">
            </div>

            <div class="col-md-6">
                <label for="" class="control-label">A</label>
                <input type="time" class="form-control" name="martes_a">
            </div>
        </div>

        <div class="col-md-3" id="miercoles">
            <div class="col-md-6">
                <label for="" class="control-label">Miercoles <span id="ocultar">.....</span>de</label>
                <input type="time" name="miercoles_de" class="form-control">
            </div>

            <div class="col-md-6">
                <label for="" class="control-label">A</label>
                <input type="time" class="form-control" name="miercoles_a">
            </div>
        </div>

        <div class="col-md-3" id="jueves">
            <div class="col-md-6">
                <label for="" class="control-label">Jueves <span id="ocultar">.....</span>de</label>
                <input type="time" class="form-control" name="jueves_de">
            </div>

            <div class="col-md-6">
                <label for="" class="control-label">A</label>
                <input type="time" class="form-control" name="jueves_a">
            </div>
        </div>

        <div class="col-md-3" id="viernes">
            <div class="col-md-6">
                <label for="" class="control-label">Viernes <span id="ocultar">.....</span>de</label>
                <input type="time" class="form-control" name="viernes_de">
            </div>

            <div class="col-md-6">
                <label for="" class="control-label">A</label>
                <input type="time" class="form-control" name="viernes_a">
            </div>
        </div>

        <input type="submit" class="btn btn-success" id="enviar">
        {!! Form::close() !!}

        <div class="col-md-12">
            <table class="table table-responsive table-hover">
                <thead>
                <tr>
                    <th>Comuna</th>
                     <th>Rutero</th>
                    <th>Lunes</th>
                    <th>Martes</th>
                    <th>Miercoles</th>
                    <th>Jueves</th>
                    <th>Viernes</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($comunas as $comuna )
                        <tr>
                             <td>{{$comuna->comuna}}</td>
                            <td>{{$comuna->rutero}}</td>
                             @if($comuna->h_lunes != 0) <td>{{$comuna->h_lunes}}</td>@else <td><span>X</span></td>@endif
                             @if($comuna->h_martes != 0) <td>{{$comuna->h_martes}}</td>@else <td><span>X</span></td>@endif
                             @if($comuna->h_miercoles != 0) <td>{{$comuna->h_miercoles}}</td>@else <td><span>X</span></td>@endif
                             @if($comuna->h_jueves != 0) <td>{{$comuna->h_jueves}}</td>@else <td><span>X</span></td>@endif
                             @if($comuna->h_viernes != 0) <td>{{$comuna->h_viernes}}</td>@else <td><span>X</span></td>@endif

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection