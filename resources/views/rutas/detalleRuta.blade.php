@extends('app')
@section('content')
    <style>
        .bord {
            border: 5px double #ECECEC;
        }
        .bord3{
            border:1px solid #D96459;
            margin-top: 10px;
        }
        .bord2{
            border:1px solid #F7C873;
            margin-top: 10px;
        }
        .bord1{
            border:1px solid #DBF094;
            margin-top: 10px;
        }
        .titulo{
            text-align: center;
        }
        .row{
            margin: 0.1px;
        }

    </style>
    <script>
        $(document).ready(function(){

            $(".bord2").hide();
            $(".bord3").hide();
            $(".modal-imagen1").hide();
            $(".modal-imagen2").hide();
            $(".modal-imagen3").hide();

            $("#age2").click(function(){
                $(".bord2").fadeIn();
            });
            $("#age3").click(function(){
                $(".bord3").fadeIn();
            });

          $(".verimagen1").click(function(){
            $(".modal-imagen1").dialog({width:"80%"});
          });

        });
    </script>

    <div class="container"> {{--Inicio Container--}}
        <div class="row">{{--Inicio Row Informacion de la Captacion--}}
            <div class="col-xs-12 bord table-responsive int" >
                <h4 class="titulo">Informacion Captacion</h4>
                <table class="table">
                    <tr>
                        <th>Nombre</th>
                        <td>{{$reage->nombre}} {{$reage->apellido}}</td>
                        <th>Direccion</th>
                        <td>{{$reage->direccion}}</td>
                    </tr>
                    <tr>
                        <th>Telfono</th>
                        <td>{{$reage->fono_1}}</td>
                        <th>Monto</th>
                        <td>{{$reage->monto}}</td>
                    </tr>
                    <tr>
                        <th>Rut</th>
                        <td>{{$reage->rut}}</td>
                        <th>Rutero</th>
                        <td>{{$reage->rutero}}</td>
                    </tr>
                    <tr>
                        <th>Fecha Captacion</th>
                        <td>{{$reage->fecha_captacion}}</td>
                        <th>Teleoperador</th>
                        <td>{{$reage->user->name}}</td>
                    </tr>
                </table>
            </div>
        </div>{{--Fin Row Informacion de la Captacion--}}

        <div class="row">
            <div class="col-xs-12">
                @if($reage->estadoRuta->estado_segundo_agendamiento != "")
                    <button class="btn btn-warning" id="age2">2° Agendamiento</button>
                    @if($reage->estadoRuta->estado_tercer_agendamiento !="")
                        <button class="btn btn-danger" id="age3">3° Agendamiento</button>
                    @endif
                @endif
            </div>
        </div>

        <div class="row">{{--Inicio de la row estado primera visita--}}
            <div class="col-xs-12 bord1">
                <h5 class="titulo">Agendamiento Original</h5>
                <table class="table">
                    <th>Fecha</th>
                    <th>Estado Retiro</th>
                    <th>Detalle Retiro</th>
                    <th>Observacion</th>
                    <th>Imagen</th>
                    <tr>
                        <td>{{$reage->estadoRuta->primer_agendamiento}}</td>
                        <td>{{$reage->estadoRuta->estado_primer_agendamiento}}</td>
                        <td>{{$reage->estadoRuta->detalle_primer_agendamiento}}</td>
                        <td>{{$reage->estadoRuta->observacion_primer_agendamiento}}</td>
                        <td><a href="#" class="verimagen1">Ver Imagen</a></td>
                    </tr>
                </table>
            </div>
        </div>{{--fin de la row estado primera visita--}}

        <div class="col-md-12 bord2"> {{--Inicio del div estado Segunda visita--}}
            <h5 class="titulo">Primer Re Agendamiento</h5>
            <table class="table">
                <th>Estado Retiro</th>
                <th>Detalle Retiro</th>
                <th>Observacion</th>
                <tr>
                    <td>{{$reage->estadoRuta->estado_segundo_agendamiento}}</td>
                    <td>{{$reage->estadoRuta->detalle_segundo_agendamiento}}</td>
                    <td>{{$reage->estadoRuta->observacion_segundo_agendamiento}}</td>
                </tr>
            </table>
        </div>{{--Fin del div estado Segunda visita--}}
        <div class="col-md-12 bord3">{{--Inicio del div estado tercera  visita--}}
            <h5 class="titulo">Segundo Re Agendamiento</h5>
            <table class="table">
                <th>Estado Retiro</th>
                <th>Detalle Retiro</th>
                <th>Observacion</th>
                <tr>
                    <td>{{$reage->estadoRuta->estado_tercer_agendamiento}}</td>
                    <td>{{$reage->estadoRuta->detalle_tercer_agendamiento}}</td>
                    <td>{{$reage->estadoRuta->observacion_tercer_agendamiento}}</td>
                </tr>
            </table>
        </div>{{--Fin del div estado tercera  visita--}}
    </div>{{--Fin Container--}}
    <div class="modal-imagen1">
      @if (isset($img1))
        <div class="">
            <img src="{{asset($img1->imagen)}}" alt="" style="width:100%">
        </div>
      @endif
    </div>
    <div class="modal-imagen2">
      @if (isset($img2))
        <img src="{{asset($img2->imagen)}}" alt="" style="width:400px">
      @endif
    </div>
    <div class="modal-imagen3">
      @if (isset($img3))
        <div class="">
          <img src="{{asset($img3->imagen)}}" alt="" style="width:400px">
        </div>
      @endif
    </div>

@endsection
