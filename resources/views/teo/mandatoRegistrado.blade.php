@extends('app')

@section('content')
    <style>

        .error {

            border-color: red;
        }

        .succes {
            border-color: green;
        }
        #space{
            margin-left: -40%;

        }
        #space2{
            margin-left: 40%;
        }
    </style>
    <script>
        $(document).ready(function () {
            $(".modal-form").hide();
            $(".v_llamar").hide();

            $("#status").change(function(){
                if($(this).val()=="Volver a llamar"){
                    $(".v_llamar").fadeIn();
                }else{
                    $(".v_llamar").fadeOut();
                }
            });

            $("#btn-cancel").click(function(){
                $( ".modal-form" ).dialog({
                    buttons: [{
                       text: "Cancelar","class":'btn btn-danger space',"id":'space',click: function () {

                            $(this).dialog("close");
                        }},{
                        text:"Aceptar","class":'btn btn-success',"id":'space2',click : function(){
                            $("#form-cap").submit();
                        }
                    }]
                });

            });
            $("#comuna").on('change', function (e) {

                console.log(e);
                var rutero_id = e.target.value;


                $.get('ajax-rutero?ruteroid=' + rutero_id, function (data) {
                    console.log(data);
                    $.each(data, function (index, obj) {

                        $("#rutero").val(obj.rutero);

                        $("#comunatable").text(obj.comuna);
                        $("#voluntario").text(obj.rutero);
                        $("#lunes").text(obj.h_lunes);
                        $("#martes").text(obj.h_martes);
                        $("#miercoles").text(obj.h_miercoles);
                        $("#jueves").text(obj.h_jueves);
                        $("#viernes").text(obj.h_viernes);
                    });
                });
            });

            $("#rut").rut({validateOn: 'keyup change'})
                    .on('rutInvalido', function () {
                        $(this).addClass("error")

                    })
                    .on('rutValido', function () {

                        $(this).removeClass("error")
                    });

            $("#enviar").click(function () {

                var datos = {rut: $("#rut").val(), fundacion: $("#fundacion").val()}

                $.get('validarSocio', datos, procesarDatos);
                console.log(datos);

                function procesarDatos(data) {

                    console.log(data);
                    if (data == 2) {
                        alert("este usuarios ya es socio o tiene uina visita pendiente de greenpeace");


                    } else {

                        $("#send").submit();
                    }
                }

            });

            $("#tipo_retiro").change(function(){

                if($(this).val()==2){

                    $(".grabacion").fadeOut();
                }else{
                    $(".grabacion").fadeIn();
                }
            });
        });

    </script>
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">

    <div class="container">
@if($function=="nada")
        <div class="col-md-12">
            <div class="col-md-1" style="margin-left: 90%">
                <input type="button" value="Cancelar" class="btn btn-danger" id="btn-cancel">
            </div>
        </div>
 @endif
        <div class="modal-form" title="Cancelar Agendamiento">
            @if(Auth::user()->perfil==1)
                {!! Form::open(['url'=>['admin/siguiente',$capta->id],'method'=>'POST','id'=>'form-cap']) !!}
            @elseif(Auth::user()->perfil==2)
                {!! Form::open(['url'=>['teo/siguiente',$capta->id],'method'=>'POST','id'=>'form-cap']) !!}
            @endif
                <label for="status" class="control-label">Estado Llamado</label>
                <select name="call_status" id="status" class="form-control">
                    
                    <option value="">selecione estado</option>
                    @foreach($status as $sta)
                        <option value="{{$sta->Estado}}">{{$sta->Estado}}</option>
                    @endforeach    
                </select>

                <label for="observation" class="control-label">Observacion</label>
                <input type="text" class="form-control" name="observation1">

                <label for="v_llamar" class="control-label v_llamar">Volver a llamar</label>
                <input type="date" name="call_again" class="v_llamar form-control">

           {!! Form::close() !!}
        </div>

        <div class="panel panel-default ">


            <form class="form-horizontal" role="form" id="send" method="POST"
                  action="
                  @if($function=="nada")
                        @if(Auth::user()->perfil==1){{ url('admin/agregado') }}@elseif(Auth::user()->perfil==2){{ url('teo/agregado')}}@endif ">
                @elseif($function=="editar")
                    @if(Auth::user()->perfil==1){{ url('admin/editCapPost') }}@elseif(Auth::user()->perfil==2){{ url('teo/editCapPost')}}@endif ">
                @endif
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div>

                    <input type="hidden" class="form-control" name="fundacion" value="{{$capta->nom_fundacion}}"
                           id="fundacion">
                </div>

                <div class="col-md-4 ">
                    <input type="hidden" class="form-control" name="n_dues" value="{{$capta->n_dues}}">
                </div>

                <div class="col-md-4 ">
                    <input type="hidden" class="form-control" name="id_fundacion" value="{{$capta->id_fundacion}}">
                </div>

                <div class="col-md-4 ">

                </div>

                <div class="col-md-3">
                    <label class=" control-label">Tipo Retiro</label>
                    <div class="">
                        <select name="tipo_retiro" class="form-control" id="tipo_retiro" value="">
                            @if($function=="editar")
                                @if($capta->tipo_retiro==1) <option value="{{$capta->tipo_retiro}}">Agendamiento</option>@elseif($capta->tipo_retiro==2)
                                    <option value="{{$capta->tipo_retiro}}">Grabacion</option>@elseif($capta->tipo_retiro==3)<option value="{{$capta->tipo_retiro}}">Delivery</option>
                                    @elseif($capta->tipo_retiro==4)<option value="{{$capta->tipo_retiro}}">chilexpress</option> @elseif($capta->tipo_retiro==5)
                                    <option value="{{$capta->tipo_retiro}}">Ir Dues</option>@elseif($capta->tipo_retiro==6)
                                    <option value="{{$capta->tipo_retiro}}">Ir a Fundacion</option>@endif
                                @endif
                            <option value="">--seleccione--</option>
                            <option value="1">Agendamiento</option>
                            <option value="2">Grabacion</option>
                            <option value="3">Delivery</option>
                            <option value="4">Chilexpress</option>
                            <option value="5">Ir Dues</option>
                            <option value="6">Ir a Fundacion</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <label class=" control-label">Comuna</label>
                    <select name="comuna" id="comuna" class="form-control">
                        @if($function=="editar")
                            <option value="{{$capta->comuna}}">{{$capta->comuna}}</option>
                        @endif
                        <option value="">-- Seleccione --</option>
                        @foreach($comunas as $comuna)
                            <option value="{{$comuna->comuna}}">{{$comuna->comuna}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 grabacion">
                    <label class=" control-label">Fecha Agendamiento</label>
                    <div class="">
                        <input type="date" class="form-control" name="fecha_agendamiento" value="{{$capta->fecha_agendamiento}}">
                    </div>
                </div>

                <div class="col-md-3 grabacion">
                    <label class=" control-label">Horario .</label>
                    <input type="time" class="form-control" name="horario" value="{{$capta->horario}}">
                </div>


                <div class="col-md-3">
                    <label class=" control-label">Rut</label>
                    <input type="text" class="form-control" id="rut" name="rut" placeholder="18.202.912-2" value="{{$capta->rut}}">
                </div>

                <div class="col-md-3">
                    <label class="control-label">Jornada</label>

                    <select name="jornada" class="form-control">
                        @if($function=="editar")
                            <option value="{{$capta->jornada}}">{{$capta->jornada}}</option>
                        @endif
                        <option>--Seleccione--</option>
                        <option>AM</option>
                        <option>PM</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class=" control-label">Fono</label>
                    <input type="text" class="form-control" name="fono_1" value="{{$capta->fono_1}}">

                </div>

                <div class="col-md-3">
                    <label class=" control-label">Nombre</label>
                    <input type="text" class="form-control" name="nombre" value="{{$capta->nombre}}">

                </div>

                <div class="col-md-3">
                    <label class=" control-label">Apellido</label>
                    <input type="text" class="form-control" name="apellido" value="{{$capta->apellido}}">

                </div>

                <div class="col-md-6">
                    <label class="control-label">Direccion</label>
                    <input type="text" name="direccion" class="form-control" placeholder="Ej: Santa Magdalena #10" value="{{$capta->direccion}}">

                </div>

                <div class="col-md-3">
                    <label class="control-label">Correo</label>
                    <input type="text" class="form-control" name="correo_1" value="{{$capta->correo_1}}">

                </div>


                <div class="col-md-3 grabacion">
                    <label class="control-label">Voluntario Ruta</label>
                    <input type="text" class="form-control" name="rutero" id="rutero" value="{{$capta->rutero}}" onfocus="this.blur()">
                </div>


                <div class="col-md-2">
                    <label class="control-label">Campaña</label>
                    <input type="text" class="form-control" name="nom_campana" value="@if($function=="nada"){{$capta->campana}}@elseif($function=="editar"){{$capta->nom_campana}}@endif"onfocus="this.blur()" >
                </div>

                <div class="col-md-2">
                    <label class="control-label">Monto</label>
                    <input type="text" class="form-control" name="monto" value="{{$capta->monto}}">
                </div>

                <div class="col-md-2">

                    <label class="control-label">Forma Pago</label>

                    <select name="forma_pago" class="form-control">
                        @if($function=="editar")
                            <option value="{{$capta->forma_pago}}">{{$capta->forma_pago}}</option>
                        @endif
                        <option>--Seleccione--</option>
                        <option class="grabacion">Cuenta Vista</option>
                        <option class="grabacion">Cuenta Corriente</option>
                        <option class="grabacion">Cuenta Rut</option>
                        <option>Tarjeta De Credito</option>
                        <option class="grabacion">Cuenta Rut</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class=" control-label">Observaciones</label>

                    <input type="text" class="form-control" name="observaciones" value="{{$capta->observaciones}}">

                </div>
                <div class=" ">
                    <input type="hidden" class="form-control" name="teleoperador" value="{{auth::user()->id}}">
                    <input type="hidden" name="id_captacion" value="{{$capta->id}}">
                </div>

                <div class="col-md-6">
        @if($function==="nada")
                    <button type="button" class="btn btn-primary form-control" id="enviar">
                        Ingresar Agendamiento
                    </button>
         @elseif($function=="editar")
                        <button type="button" class="btn btn-warning form-control" id="enviar">
                            Editar Agendamiento
                        </button>
         @endif
                </div>
                <div class="form-group ">
                </div>
            </form>


        </div>

        <table class="table table-responsive grabacion">
            <thead>
            <tr>
                <th>Comuna</th>
                <th>Voluntario</th>
                <th>Lunes</th>
                <th>Martes</th>
                <th>Miercoles</th>
                <th>Jueves</th>
                <th>Viernes</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td id="comunatable">x</td>
                <td id="voluntario">x</td>
                <td id="lunes">x</td>
                <td id="martes">x</td>
                <td id="miercoles">x</td>
                <td id="jueves">x</td>
                <td id="viernes">x</td>

            </tr>
            </tbody>
        </table>
    </div>



@endsection