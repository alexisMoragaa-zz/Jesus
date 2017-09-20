@extends('app')

@section('content')
    <style>
        .centrado{
            margin: auto;

        }
        td{

            padding-left: 25px;
            padding-top: 3px;
            font-size: 20px;
        }
        .or{

        }
        #statusRecord{
            margin-top: 20px;
        }


    </style>
    <script>
        $(document).ready(function(){

            $("#pm").hide();

            $("#addstatuscap").click(function() {


                if($("#checkRecord").val()=="1"){
                    alert('ingrese una opcion valida');
                    return false;
                }else {
                   $("#formulario").submit();

                    }


            });

            $("#statusRecord").hide();

            $("#checkRecord").change(function(){

                if($(this).val() !="OK"){
                    $("#statusRecord").fadeIn();
                    if($(this).val() !="1"){
                        $("#statusRecord").fadeIn();
                    }else{
                        $("#statusRecord").fadeOut();
                        $("#motivo").val('');
                    }
                }else{
                    $("#statusRecord").fadeOut();
                    $("#motivo").val('');
                }
            });

            //segunda parte
            $("#statusRecordMdt").hide();

            $("#status_mdt").change(function(){

                if($(this).val() !="OK"){
                    $("#statusRecordMdt").fadeIn();
                    if($(this).val() !="1"){
                        $("#statusRecordMdt").fadeIn();
                    }else{
                        $("#statusRecordMdt").fadeOut();
                        $("#motivoMdt").val('');
                    }
                }else{
                    $("#statusRecordMdt").fadeOut();
                    $("#motivoMdt").val('');
                }
            });

        });
    </script>

 <div class="container">

        <div class="col-md-2">
            <button type="button" class="btn btn-outline btn-default or" onclick="history.go(-1); return false;"><span class="glyphicon glyphicon-arrow-left"></span> Regresar</button>

        </div>

<div  id="dialog" title="Revicion Captaciones" >
    <p id="pm">Modificaciones realizadas con Exito!!</p>
</div>
    @foreach($detalle as $d)

            <table class="centrado table-hover col-md-6">

                <tr>
                     <td>ID </td>
                     <td id="id_cap">:  {{$d->id}}</td>

                </tr>

                <tr>
                    <td>Nombre </td>
                    <td>:  {{$d->nombre}}</td>
                </tr>

                <tr>
                    <td>Apellido</td>
                    <td>: {{$d->apellido}}</td>
                </tr>

                <tr>
                    <td>Rut</td>
                    <td>: {{$d->rut}}</td>
                </tr>

                <tr>
                    <td>Fono</td>
                    <td>: {{$d->fono_1}}</td>
                </tr>

                <tr>
                    <td>Direccion</td>
                    <td>: {{$d->direccion}}</td>
                </tr>

                <tr>
                    <td>Correo</td>
                    <td>: {{$d->correo_1}}</td>
                </tr>


                <tr>
                    <td>Observaciones</td>
                    <td>: {{$d->observaciones}}</td>
                </tr>
                <tr>

                <tr>
                    <td>Tipo Retiro</td>
                    @if($d->tipo_retiro ==1) <td>: Agendamiento</td>@elseif($d->tipo_retiro==2)<td>: Grabacion</td>
                       @elseif($d->tipo_retiro==3)<td>: Delivery</td>@elseif($d->tipo_retiro==4)<td>: Chilexpress</td>
                        @elseif($d->tipo_retiro==5)<td>: Ir a Dues</td>@elseif($d->tipo_retiro==6)<td>: Ir a Fundacion</td>@endif
                </tr>

                <tr>
                    <td>Fecha Captacion</td>
                    <td>: {{$d->fecha_captacion}}</td>
                </tr>
     @if($d->tipo_retiro ==2)

    @else
                    <tr>
                        <td>Rutero</td>
                        <td>: {{$d->rutero}}</td>
                    </tr>

                    <tr>
                        <td>Fecha Retiro</td>
                        <td>: {{$d->fecha_agendamiento}}</td>
                    </tr>

                    <tr>
                        <td>Horario</td>
                        <td>: {{$d->horario}}</td>
                    </tr>
    @endif

                <tr>
                    <td>Comuna</td>
                    <td>: {{$d->comuna}}</td>
                </tr>

                     <tr>
                    <td>Ciudad</td>
                    <td>: {{$d->ciudad}}</td>
                </tr>

                <tr>
                    <td>Region</td>
                    <td>: {{$d->region}}</td>
                </tr>

                <tr>
                    <td>Fundacion</td>
                    <td>: {{$d->fundacion}}</td>
                </tr>

                <tr>
                    <td>Forma de Pago</td>
                    <td>: {{$d->forma_pago}}</td>
                </tr>

                <tr>
                    <td>Monto</td>
                    <td>: {{$d->monto}}</td>
                </tr>

                <tr>
                    <td>Campaña</td>
                    <td>: {{$d->nom_campana}}</td>
                </tr>

                <tr>
                    <td >Estado</td>
                    <td id="status">: {{$d->estado_captacion}}</td>
                </tr>

                <tr>
                    <td >Motivo</td>
                    <td id="reason">: {{$d->motivo}}</td>
                </tr>

                <tr>
                    <td>Estado Mandato</td>
                    <td>: {{$d->estado_mandato}}</td>
                </tr>
                </tbody>
            </table>

            @if(Auth::user()->perfil ==1 || Auth::user()->perfil==4)
                @if($d->estado_captacion != 'OK')

                     @if(Auth::user()->perfil==1)
                         {!! Form::open(array('url'=>'admin/addStatusCap','id'=>'formulario')) !!}
                    @elseif(Auth::user()->perfil==4)
                        {!! Form::open(array('url'=>'ope/addStatusCap','id'=>'formulario')) !!}
                    @endif
                            <div class="col-md-2">
                                <label for="status_cap" class="control-label">Revisar Captacion</label>

                                <select name="status_cap" id="checkRecord" class="form-control">
                                    <option value="1">-- Seleccione --</option>
                                    <option value="OK">OK</option>
                                    <option value="conReparo">Con Reparo</option>
                                    <option value="rechazada">Rechazada</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="submit" class="btn btn-success " id="addstatuscap" >
                            </div>

                            <div class="col-md-4" id="statusRecord">
                                <label for="" class="control-label">Añadir Estado</label>
                                <input type="text" class="form-control" name="motivo_cap" id="motivo">
                            </div>

                            <input type="hidden" id="cap_id" name="cap_id" value="{{$d->id}}">

                      {!! Form::close() !!}
                     <div class="col-md-4">
                        <label for=""></label>
                     </div>
                @else


                <div class="mdt">

                    @if(Auth::user()->perfil==1)
                        {!! Form::open(array('url'=>'admin/addStatusMdt','id'=>'form-mandato'))!!}
                    @elseif(Auth::user()->perfil==4)
                        {!! Form::open(array('url'=>'ope/addStatusMdt','id'=>'form-mandato'))!!}
                    @endif
                        <div class="col-md-2">
                             <label for="status-mdt" class="control-label"> Revision Mandato</label>
                             <select name="status_mdt" id="status_mdt" class="form-control">
                                 <option value="1">-- Seleccione --</option>
                                <option value="OK">OK</option>
                                <option value="conReparo">Con Reparo</option>
                                <option value="rechazado">Rechazado</option>
                             </select>
                        </div>
                        <div class="col-md-2">
                            <input type="submit" class="btn btn-success " id="enviarmdt">
                        </div>

                        <div class="col-md-4" id="statusRecordMdt">
                             <label for="reasonmdt" class="control-label">Estado</label>
                            <input type="text" class="form-control" id="motivoMdt" name="motivoMdt">
                         </div>
                        <input type="hidden" name="cap_id" value="{{$d->id}}">
                    {!! Form::close() !!}
                 </div>

         @endif<!--cierre if estado_captacion-->
         @endif<!--cierre if perfiles-->
        @endforeach

 </div>


@endsection








