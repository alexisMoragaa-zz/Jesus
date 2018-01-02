@extends('app')

@section('content')

    <script>
        $.datepicker.regional['es'] = {
            closeText: 'Cerrar',
            prevText: '< Ant',
            nextText: 'Sig >',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
            dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
            weekHeader: 'Sm',
            dateFormat: 'dd/mm/yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
        };
        $.datepicker.setDefaults($.datepicker.regional['es']);
        $(function () {
            $("#fecha").datepicker();
        });
    </script>
    <script>
        $(document).ready(function(){



            $("#datepiker").datepicker();

            $("#date").hide();
            $("#btn-start-search").css('margin-right','41%');

            $("#searchFor").change(function(){

                if($(this).val()==2){
                    $("#btn-start-search").css('margin-right','16%');
                   $("#date").fadeIn();
                }else{
                    $("#date").hide();
                    $("#btn-start-search").css('margin-right','41%');
                }
            });
        });
    </script>

    <style>
        #titulo{
            text-align: center;
        }
        #containerSearch{
            margin-bottom: 25px;
        }
        .center{

        }
    </style>

    <div class="container">
        <h1 id="titulo">{{Auth::user()->name." ".Auth::user()->last_name}}</h1>

        <div class="col-md-12" id="containerSearch">
@if(Auth::user()->perfil ==1)
{!! Form::Open(array('url'=>'/admin/capFilter')) !!}
@elseif(Auth::user()->perfil==2)
{!! Form::Open(array('url'=>'/teo/capFilter')) !!}
@endif
        <div class="col-md-3">
            <label for="" class="control-label">Buscar Captaciones Por</label>
            <select name="searchFor" id="searchFor" class="form-control">
                <option value="0">-Seleccione--</option>
                <option value="1">Hoy</option>
                <option value="2">Por Dia</option>
                <option value="3">Exitosas</option>
                <option value="4">Rechazadas</option>
                <option value="5">Con Reparo</option>
                <option value="6">Todas</option>
            </select>
        </div>

        <div class="col-md-3" id="date">
            <label for="" class="control-label">Fecha</label>

            <input type="text" id="datepiker" name="date"  class="form-control">
        </div>
        <div class="col-md-2 call" id="btn-start-search">
            <input type="submit" class="btn btn1 btn-info" value="Buscar">
        </div>

        <div class="col-md-2 " id="btn-start-call">
            @if(Auth::user()->perfil ==1)
                <a href="{{route('admin.call.index')}}"  class="btn btn-success btn1 btn-ajax">Comenzar a Llamar</a>
             @elseif(Auth::user()->perfil ==2)
                <a href="{{route('teo.call.index')}}"  class="btn btn-success btn1 btn-ajax">Comenzar a Llamar</a>
            @endif
        </div>
</div>

   {!! Form::Close() !!}

        <table class="table table-responsive table-hover"   >
            <thead>
                <th>ID</th>
                <th>Nombre</th>
                <th>Fono</th>
                <th>Rut</th>
                <th>Comuna</th>
                <th>Campaña</th>
                <th>Captacion</th>
                <th>Retiro</th>
                <th>Monto</th>
                <th>Detalles</th>
                <th id="mdt" ><span id="mdtspan" class=" glyphicon glyphicon-list-alt "></span></th>
                <th>Editar</th>
            </thead>
            <tbody>
            @foreach($captaciones as $cap)
                @if($cap->estado_captacion =="OK")
                    <tr class="success">
                @elseif($cap->edit =="editado")
                    <tr class="info">
                @elseif($cap->estado_captacion =="conReparo")
                    <tr class="warning">
                @elseif($cap->estado_captacion =="rechazada")
                    <tr class="danger">

                 @elseif($cap->estado_captacion =="")


                    <tr>
                 @endif
                        <td>{{$cap->id}}</td>
                        @if($cap->estado_captacion =="conReparo")
                            @if(Auth::user()->perfil==1)
                                <td ><a href="{{url('admin/editCap')}}/{{$cap->id}}">{{$cap->nombre." ".$cap->apellido}}</a></td>
                            @elseif(Auth::user()->perfil==2)
                                <td ><a href="{{url('teo/editCap')}}/{{$cap->id}}">{{$cap->nombre." ".$cap->apellido}}</a></td>
                            @endif
                        @else
                            <td >{{$cap->nombre." ".$cap->apellido}}</td>
                        @endif
                        <td>{{$cap->fono_1}}</td>
                        <td>{{$cap->rut}}</td>
                        <td>{{$cap->comuna}}</td>
                        <td>{{$cap->nom_campana}}</td>
                        <td>{{$cap->fecha_captacion}}</td>
                        @if($cap->tipo_retiro =="Acepta Grabacion")
                            <td>Grabacion</td>
                        @else
                            <td>{{$cap->fecha_agendamiento}}</td>
                         @endif

                        <td>{{$cap->monto}}</td>
                        @if(Auth::user()->perfil==1)
                            <td><a href="{{route('admin.call.show',$cap)}}">Ver <span class="glyphicon glyphicon-search"></span></a></td>
                        @elseif(Auth::user()->perfil==2)
                            <td><a href="{{route('teo.call.show',$cap)}}">Ver <span class="glyphicon glyphicon-search"></span></a></td>
                        @endif
                             @if($cap->estado_mandato =="OK")
                                <td class="center"><span class="glyphicon glyphicon-ok"></span></td>
                            @elseif($cap->estado_mandato =="conReparo")
                                <td class="center"><span class="glyphicon glyphicon-minus-sign"></span></td>
                            @elseif($cap->estado_mandato =="rechazado"|| $cap->estado_mandato=="AgendamientoFallido"|| $cap->estado_mandato=="retracta")
                                <td center="center"><span class="glyphicon glyphicon-remove"></span></td>
                            @elseif($cap->estado_mandato =="")
                                <td center="center"><span class="glyphicon "></span></td>
                            @endif
                        @if($cap->estado_mandato !="OK")
                          <td><a href="{{url('/teo/editCap',$cap->id)}}">Editar</a></td>
                        @else
                          <td>Editar</td>
                        @endif
                    </tr>

                @endforeach

            </tbody>
        </table>

    </div>

@endsection
