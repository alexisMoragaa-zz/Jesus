<style>
    .titulo{
        text-align: center;
    }
    .colum{
        border-right: 1px solid gray;
        min-height: 450px;

    }
    .bord{
        border:5px double #ECECEC;

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
</style>

<div class="col-md-8 colum" id="ancho">
    <div class="col-md-12 bord" >
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
    <div class="col-md-12 bord1">
        <h5 class="titulo">Agendamiento Original</h5>
        <table class="table">
            <th>Fecha</th>
            <th>Estado Retiro</th>
            <th>Detalle Retiro</th>
            <th>Observacion</th>
            <tr>
                <td>{{$reage->estadoRuta->primer_agendamiento}}</td>
                <td>{{$reage->estadoRuta->estado_primer_agendamiento}}</td>
                <td>{{$reage->estadoRuta->detalle_primer_agendamiento}}</td>
                <td>{{$reage->estadoRuta->observacion_primer_agendamiento}}</td>
            </tr>
        </table>
    </div>
    @if($reage->estadoRuta->estado_segundo_agendamiento != "")
        <div class="col-md-12 bord2">
            <h5 class="titulo">Primer Re Agendamiento</h5>
            <table class="table">
                <th>Fecha</th>
                <th>Estado Retiro</th>
                <th>Detalle Retiro</th>
                <th>Observacion</th>
                <tr>
                    <td>{{$reage->estadoRuta->segundo_agendamiento}}</td>
                    <td>{{$reage->estadoRuta->estado_segundo_agendamiento}}</td>
                    <td>{{$reage->estadoRuta->detalle_segundo_agendamiento}}</td>
                    <td>{{$reage->estadoRuta->observacion_segundo_agendamiento}}</td>
                </tr>
            </table>
        </div>
        @if($reage->estadoRuta->estado_tercer_agendamiento != "")
            <div class="col-md-12 bord3">
                <h5 class="titulo">Segundo Re Agendamiento</h5>
                <table class="table">
                    <th>Fecha</th>
                    <th>Estado Retiro</th>
                    <th>Detalle Retiro</th>
                    <th>Observacion</th>
                    <tr>
                        <td>{{$reage->estadoRuta->tercer_agendamiento}}</td>
                        <td>{{$reage->estadoRuta->estado_tercer_agendamiento}}</td>
                        <td>{{$reage->estadoRuta->detalle_tercer_agendamiento}}</td>
                        <td>{{$reage->estadoRuta->observacion_tercer_agendamiento}}</td>
                    </tr>
                </table>
            </div>
        @endif
    @endif
</div>
