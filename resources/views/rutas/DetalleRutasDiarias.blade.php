@extends('app')
@section('content')
    <style>
        .q{
            text-align: left;

        }
        .w{
            text-align: left;
        }


    </style>

    <script>

        $(document).ready(function(){
            $(".motivo").hide();
            $(".imagen").hide();
            $("#modal-form").hide();
            $(".modal-alert").hide();
            $(".modal-observacion").hide();
            $("#status").change(function () {
                if($(this).val()=="noRetirado"){
                    $(".motivo").fadeIn();
                    $(".imagen").fadeIn();

                }else{
                    $(".motivo").fadeOut().val("");
                    $(".imagen").fadeOut();
                    $("#file").val("");
                }
            });
            $("#btn_add_status").click(function(){

                $( "#modal-form" ).dialog({
                    buttons: [{
                        text: "Cancelar","class":'btn btn-danger space',"id":'space',click: function () {

                            $(this).dialog("close");
                        }},{
                        text:"Aceptar","class":'btn btn-success',"id":'space2',click : function(){
                            $(".form_status_rout").submit();
                        }
                    }]
                });
            });

        $("#status_add").click(function(){
            $(".modal-alert").dialog({
                buttons: [{
                    text: "Cerrar","class":'btn btn-danger',"id":'cancel',click: function () {

                        $(this).dialog("close");
                    }},{
                    text:"Aceptar","class":'btn btn-success','id':'ok',click:function(){
                        $( "#modal-form" ).dialog({
                            buttons: [{
                                text: "Cancelar","class":'btn btn-danger space',"id":'space',click: function () {

                                    $(this).dialog("close");
                                }},{
                                text:"Aceptar","class":'btn btn-success',"id":'space2',click : function(){
                                    $(".form_status_rout").submit();
                                }
                            }]
                        });
                        $(this).dialog("close");
                    }}


            ]});
        });

            $("#completeobs").click(function(){
                $(".modal-observacion").dialog({
                    buttons: [{
                        text:"Aceptar","class":'btn btn-success','id':'ok',click:function() {
                                $(this).dialog("close");
                            }}]
                });
            });

        });

    </script>

<div class="container ">

  @if (count($errors) > 0)<!--creamos un if para verificar si no hay errores-->
    <div class="alert alert-danger">
      <strong>Por Favor </strong>Corrige los siguientes errores.<br><br>
      <ul>
        @foreach ($errors->all() as $error)<!--si hay errores lso recorremos con un foreach-->
          <li>{{ $error }}</li> <!--imprimimos los errores en pantalla-->
        @endforeach
      </ul>
    </div>
  @endif



    <div class="modal-alert" title="Estado Ruta">
        <p>El estado de esta Ruta ya fue Registrada</p>
        <p>Esta Seguro que desea <span>Modificarlo</span></p>
    </div>

    <div class="modal-observacion">

        <textarea class="form-control" rows="19" id="comment" readonly>{{$ruta->observaciones}}</textarea>
    </div>

<div id="modal-form" title="Agregar estado Retiro">
    @if($ruta->fecha_agendamiento == $esta->primer_agendamiento)

          <form action="/rutas/rutas" method="Post" enctype="multipart/form-data" class="form_status_rout">
    @elseif($ruta->fecha_agendamiento == $esta->segundo_agendamiento)


            {{-- {!! Form::open(['url'=>['rutas/secondRoute/'],'method'=>'POST','class'=>'form_status_rout']) !!} --}}
            <form action="/rutas/secondRoute" method="Post" enctype="multipart/form-data" class="form_status_rout">
    @elseif($ruta->fecha_agendamiento == $esta->tercer_agendamiento)

            {{-- {!! Form::open(['url'=>['rutas/thirdRoute/'],'method'=>'POST','class'=>'form_status_rout']) !!} --}}
            <form action="/rutas/thirdRoute" method="Post" enctype="multipart/form-data" class="form_status_rout">
     @endif
     <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <label for="Status" class="control-label">Estado</label>
        <select name="Status" id="status" class="form-control">
            <option value="OK">OK</option>
            <option value="conReparo">Con Reparo</option>
            <option value="noRetirado">Mandato No Retirado</option>
        </select>

        <label for="Motivo" class="control-label motivo">Motivo</label>
        <select name="Motivo"  class="form-control motivo">
            <option value="">-- Seleccione --</option>
            <option value="NoEstaEnDomicilio">No se encuentra en domicilio</option>
            <option value="NoContesta">No contesta</option>
            <option value="retracta">Persona se arrepiente</option>
            <option value="noEncuentroDireccion">No encuentro Domicilio</option>
        </select>


        <label for="detalle" class="control-label">Observacion</label>
        <input type="text" class="form-control" name="observacion">

        <div class="form-group imagen">
          <label class="control-label">Cargar Imagen</label>
          <div class="">
            <input type="file" class="form-control" name="file" id="file">
          </div>
        </div>
        <input type="hidden" name="id" value="{{$ruta->id}}">
    {{-- {!! Form::close() !!} --}}
    </form>
</div>

    <table class="table" style ="max-width: 400px; margin: auto; text-align: center; margin-top: 25px;" >

        <tbody>

        <tr>
            <td class="q">Nombre</td>
            <td class="w">{{$ruta->nombre}} {{$ruta->apellido}}</td>
        </tr>

        <tr>
            <td class="q">Telefono</td>
            <td class="w">{{$ruta->fono_1}}</td>
        </tr>

        <tr>
            <td class="q">Jornada</td>
            <td class="w">{{$ruta->horario}}</td>
        </tr>

        <tr>
            <td class="q">Direccion</td>
            <td class="w">{{$ruta->direccion}}</td>
        </tr>

        <tr>
            <td class="q">Comuna</td>
            <td class="w">{{$ruta->comuna}}</td>
        </tr>

        <tr>
            <td class="q">Observacion</td>
            <td class="w">{!! str_limit($ruta->observaciones, $limit=100,$end=" <a id='completeobs'>ver mas</a>")!!}</td>
        </tr>

        <tr>
            <td class="q">Teleopetador</td>
            <td class="w">{{$ruta->user->name}}</td>
        </tr>

        <tr>
            <td class="q">Campaña</td>
            <td class="w">{{$ruta->nom_campana}}</td>
        </tr>

        <tr>
            <td class="q">Monto</td>
            <td class="w">{{$ruta->monto}}</td>
        </tr>


        </tbody>
    </table>
    <div class=" col-md-12">
    @if($est != $hoy)
        <input type="button" class="btn btn-success center-block" value="Agregar Estado" id="btn_add_status" >
    @else
            <input type="button" class="btn btn-warning center-block" value="Estado Agregado" id="status_add" >
     @endif
     </div>
</div>
@endsection
