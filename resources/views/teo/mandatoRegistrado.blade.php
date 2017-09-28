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
            /**Ocultar ventanas al Inicio*/
            $(".modal-form").hide();
            $(".modal_form_rutas").hide();
            $(".v_llamar").hide();
            $("#fixedPhone").hide();
            $(".send_data").attr("disabled",true);

            /**Si esl estado es Volver a Llamar despliega un input oculto*/
            $("#status").change(function(){
                if($(this).val()=="Volver a llamar"){
                    $(".v_llamar").fadeIn();
                }else{
                    $(".v_llamar").fadeOut();
                }
            });

            /**si se apreta cancelar despliega una ventana modal para regresar*/
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

            /**Funcion ajax para mostrar el rutero que corresponde segun la comuna seleccionada*/
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

            /**llamado a una funcion rur, la cual valida si el es chileno, y marca el input en rojo
             * de no ser unrut valido para chile*/
            $("#rut").rut({validateOn: 'keyup change'})
                    .on('rutInvalido', function () {
                        $(this).addClass("error")

                    })
                    .on('rutValido', function () {

                        $(this).removeClass("error")
                    });

            /**Validaciones que se desencadenan cuando le damos click al boton enviar*/
            $("#enviar").click(function () {

                if($("#tipo_retiro").val()!=""){

                    if($("#tipo_retiro").val()=="Acepta Agendamiento"||$("#tipo_retiro").val()=="Acepta Delivery"||$("#tipo_retiro").val()=="Acepta Upgrade"||$("#tipo_retiro").val()=="Acepta ir a Dues"||$("#tipo_retiro").val()=="Acepta Chilexpress"){
                        if($("#f_pago").val()=="Tarjeta de Credito"||$("#f_pago").val()=="Movistar"){

                            alert(" Porfavor Seleccione Una Forma de Pago  Valida");
                            return false;
                        }
                    }else if($("#tipo_retiro").val()=="Acepta Grabacion"){
                        if($("#f_pago").val()=="Cuenta Corriente"||$("#f_pago").val()=="Cuenta Vista"||$("#f_pago").val()=="Cuenta Rut") {

                            alert("Porfavor Seleccione Una Forma de Pago  Valida");
                            return false;
                        }

                        }
                };
                    /**inicio validar socio
                     * Esta funcion toma el rut y la fundacion, y lo consulta en la base de datos, si el rut ya existe retorna un alert,
                     * y frena la ejecucion del formulario evitando al insercion de datos indeseados, si el rut no existe
                     * como socio de esta fundacion continua la ejecucion normal*/
                    var datos = {rut: $("#rut").val(), fundacion: $("#fundacion").val()}
                    $.get('validarSocio', datos, procesarDatos);
                        console.log(datos);

                    function procesarDatos(data)
                    {
                        console.log(data);
                        if (data == 2) {
                            alert("este usuarios ya es socio o tiene uina visita pendiente de greenpeace");
                        }else{

                            $("#send").submit();
                        }
                    }/**Fin validar socio*/

            });

            if($("#tipo_retiro").val()=="Acepta Grabacion"){
                $("#fixedPhone").show();
                $(".send_data").attr("disabled",false);
            }

            $("#tipo_retiro").change(function(){

                if($(this).val()=="Acepta Grabacion"||$(this).val()=="Acepta Upgrade"){

                    $(".grabacion").fadeOut();
                    $("#fixedPhone").show();
                    $(".send_data").attr("disabled",false);
                    $("#btn_rutas").hide();
                }else{
                    $(".grabacion").fadeIn();
                    $("#fixedPhone").hide();
                    $("#btn_rutas").show();
                    $(".send_data").attr("disabled",true);
                }
            });


            /**funncion que desbloquea un boton para ver la disponivilidad de ruta*/
            $("#comuna").change(function(){
                 $("#f_agendamiento").change(function(){
                     $("#jornada").change(function(){

                         $("#btn_rutas").attr("disabled",false);
                     });
                 });
            });

            /**esta funcion mediante ajax nos muestra la disponivilidad de rutas para el dia y el rutero seleccionados*/
            $("#btn_rutas").click(function(){

                info={fecha:$("#f_agendamiento").val(),rutero:$("#rutero").val()} //creamos un literal con la informacion que enviaremos al servidor

                $.get('dispRutas',info,procDatos); //enviamos la informacion del literal y asignam,os la funcion encargada de procesar la ifnormacion con el metodo get
                    console.log(info);
                /**limpiamos la tabla que usaremos para mostrar la informacion
                 * asignamos la variable fila segun el largo del array que tiene la informacion
                 * con un ciclo for recorremos la informacion y guardamos los datos en una bariable la cual contiene el formato para mostrar la tabla
                 * usamos la funcio append para mostra el contenido de la variable en la tabla
                 * por ultimo mostramos la tabla en una ventamos modal usando la funcion dialog
                 * si el largo de el array es igual o mayor que la cantidad maxima asignada se bloquea el boton agendar y salta una alerta idnicando que se exedio el maximo
                 * de agendamientos para el dia y ruteros seleccionado*/
                function procDatos(data){
                    console.log(data);
                    $("#rutas_dias_table > tbody").empty();
                    $("#rutas_dias_tablePm > tbody").empty();
                    var fila = data.length;
                    $("#titulo").text("Agendamientos "+fila);
                    var countAm=0;
                    var countPm=0;
                    for(var i = 0;i<fila;i++){

                        var nuevaFilaAm = "<tr><td>"+
                            data[i].rutero+"</td><td>"+
                            data[i].comuna+"</td><td>"+
                            data[i].horario+"</td></tr>"

                        if(data[i].horario=="AM"){

                            $("#rutas_dias_table").append(nuevaFilaAm);
                                countAm++;

                        }else{
                            $("#rutas_dias_tablePm").append(nuevaFilaAm);
                              countPm++;
                        }

                    }/***Fin for*/
                    $("#tituloam").text("Agendamientos AM :"+countAm);
                    $("#titulopm").text("Agendamientos PM :"+countPm);
                    $(".modal_form_rutas").dialog({heigh:"auto",width:"auto"});
                    var day= parseInt($("#max_day").val());
                    var am= parseInt($("#max_am").val());
                    var pm= parseInt($("#max_pm").val());


                    if(fila >= day){

                        $(".send_data").attr("disabled",true);
                        alert("Excede maximo de rutas diarias");
                    }else{

                        if($("#jornada").val()=="AM"){
                            if(countAm >=am) {
                                $(".send_data").attr("disabled", true);
                                alert("Excede maximo de rutas AM");
                            }else{
                                $(".send_data").attr("disabled", false);
                            }
                        }else if($("#jornada").val()=="PM"){
                                if(countPm >=pm){
                                    $(".send_data").attr("disabled",true);
                                    alert("Excede maximo de rutas PM");
                                }else{
                                    $(".send_data").attr("disabled", false);
                                }
                        }
                    }
                }/**Fin ProcDatos*/
            });/**Fin Funcion para validar Rutas*/
        });/**fin document.ready*/
    </script>

    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">

    <div class="container">
@if($function=="nada")
        <div class="col-md-12">
            <div class="col-md-1" style="padding-right: 80%" >
                <input type="button" value="Cancelar" class="btn btn-danger" id="btn-cancel">
            </div>
            <div class="col-md-2">
                <input type="button" class="btn btn-info" value="Ver Disponivilidad Rutas" disabled id="btn_rutas">
            </div>
        </div>
@else

            <h3 style="text-align:center; color:red">{{$capta->motivo_cap}}</h3>

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
    <div class="modal_form_rutas" title="Verificar Rutas">
        <h3 id="titulo" style="padding-bottom: 10px"></h3>

        <h5 id="tituloam"></h5>
        <table class="table " id="rutas_dias_table">
            <thead>
                <th>Rutero</th>
                <th>Comuna</th>
                <th>Horario</th>
            </thead>
            <tbody>

            </tbody>

        </table>
        <table class="table " id="rutas_dias_tablePm">
            <h5 id="titulopm"></h5>
            <thead>
            <th>Rutero</th>
            <th>Comuna</th>
            <th>Horario</th>
            </thead>
            <tbody>

            </tbody>

        </table>
    </div>

        <div class="panel panel-default ">


            <form class="form-horizontal" role="form" id="send" method="POST"
                  action="
                  @if($function=="nada")
                        @if(Auth::user()->perfil==1){{ url('admin/agregado')}}@elseif(Auth::user()->perfil==2){{ url('teo/agregado')}}@endif ">
                @elseif($function=="editar")
                    @if(Auth::user()->perfil==1){{ url('admin/editCapPost') }}@elseif(Auth::user()->perfil==2){{ url('teo/editCapPost')}}@endif ">
                @endif
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div>

                    <input type="hidden" class="form-control" name="fundacion" value="{{$capta->nom_fundacion}}" id="fundacion">

                    <input type="hidden" value="{{$minmax->maxDay}}" id="max_day">
                    <input type="hidden" value="{{$minmax->maxAm}}" id="max_am">
                    <input type="hidden" value="{{$minmax->maxPm}}" id="max_pm">
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
                        <select name="tipo_retiro" class="form-control" id="tipo_retiro">
                            @if($function=="editar")
                                <option value="{{$capta->tipo_retiro}}">{{$capta->tipo_retiro}}</option>
                            @endif
                            <option value="">-- Seleccione --</option>
                            @foreach($estado as $est)
                                <option value="{{$est->Estado}}">{{$est->Estado}}</option>
                            @endforeach    
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
                        <input type="date" id="f_agendamiento" class="form-control" name="fecha_agendamiento" value="{{$capta->fecha_agendamiento}}">
                    </div>
                </div>

                    <div class="col-md-3">
                        <label class="control-label">Horario Retiro</label>

                        <select name="jornada" class="form-control" id="jornada">
                            @if($function=="editar")
                                <option value="{{$capta->jornada}}">{{$capta->jornada}}</option>
                            @endif
                            <option>--Seleccione--</option>
                            <option>AM</option>
                            <option>PM</option>
                        </select>
                    </div>


                <div class="col-md-3">
                    <label class=" control-label">Rut</label>
                    <input type="text" class="form-control" id="rut" name="rut" placeholder="18.202.912-2" value="{{$capta->rut}}">
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

                 <div class="col-md-3" id="fixedPhone" >
                        <label for="c_movistar" class="control-label">Telefono Cuenta</label>
                        <input type="text" class="form-control" name="c_movistar" value="{{$capta->cuenta_movistar}}">
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
                    <label class="control-label">Voluntario Ruta</label>c
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

                    <select name="forma_pago" class="form-control" id="f_pago">
                        @if($function=="editar")
                            <option value="{{$capta->forma_pago}}">{{$capta->forma_pago}}</option>
                        @endif
                            <option value="">-- Seleccione --</option>
                        @foreach($f_pago as $pago)
                                <option value="{{$pago->Estado}}">{{$pago->Estado}}</option>
                         @endforeach
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
                    <button type="button" class="btn btn-primary form-control send_data" id="enviar">
                        Ingresar Agendamiento
                    </button>
         @elseif($function=="editar")
                        <button type="button" class="btn btn-warning form-control" id="enviar">
                            Editar Agendamiento
                        </button>
         @endif
                </div>
                <div class="form-group "></div>

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