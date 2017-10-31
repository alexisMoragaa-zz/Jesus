@extends('app')
@section('content')
    <style>
        #verificarRutas{
            margin-top: 15px;
        }
    </style>
    <script>
        $(document).ready(function(){

            $(".dialog").hide();
            $(".edition").hide();
            $("#btn-info").click(function(e){
                var rutero_id =$("#comuna").val();
                $.get('/admin/ajax-rutero?ruteroid=' + rutero_id, function (data) {
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
                e.preventDefault();
                $(".dialog").dialog({height:"auto",width:"auto"});
            });

        });
    </script>
    <script src="{{asset('/js/validarRuta.js')}}"></script>


    <div class="container">
        <div class="row dialog">
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

        <div class="row">
            @include('partials.partialDetalleReagendamiento')
            <div class="col-md-4">
                @if(Auth::user()->perfil==1)
                    {!! Form::open(['url'=>['admin/reagendado'],'method'=>'POST','id'=>'reagendado']) !!}
                @elseif(Auth::user()->perfil==2)
                    {!! Form::open(['url'=>['teo/reagendado'],'method'=>'POST','id'=>'reagendado']) !!}
                @endif
                        <div class="col-md-6">
                            <label for="fecha" class="control-label">Fecha Reagendamiento</label>
                            <input type="date" class="form-control" name="fecha_reagendamiento" id="f_agendamiento">
                        </div>
                        <div class="col-md-6">
                           <label for="horario" class="control-label">Horario</label>
                           <select name="horario" id="jornada" class="form-control">
                               <option value="">-- Seleccione --</option>
                               <option value="AM">AM</option>
                               <option value="PM">PM</option>
                           </select>
                        </div>
                        <div class="col-md-12 bord" id="verificarRutas">
                           <h4>{{$reage->rutero}} tiene <span id="numero_Rutas"></span> rutas este dia</h4>
                           <table class="table table-hover" id="rutas_dias_table">
                               <thead>
                                    <th>Rutero</th>
                                    <th>Comuna</th>
                                    <th>Horario</th>
                                    <th>Validada</th>
                               </thead>
                               <tbody>

                               </tbody>
                           </table>
                           <table class="table table-hover" id="rutas_dias_tablePm">
                               <thead>
                                    <th>Rutero</th>
                                    <th>Comuna</th>
                                    <th>Horario</th>
                                    <th>Validada</th>
                               </thead>
                               <tbody>
                               </tbody>
                           </table>
                        </div>

                        <input type="hidden" value="{{$reage->rutero}}" id="rutero">
                        <input type="hidden" value="{{$minmax->maxDay}}" id="max_day">
                        <input type="hidden" value="{{$minmax->maxAm}}" id="max_am">
                        <input type="hidden" value="{{$minmax->maxPm}}" id="max_pm">
                        <input type="hidden" value="{{$reage->comuna}}" id="comuna">
                        <input type="hidden" value="{{$reage->id}}" name="id_captacion">

                        <div class="col-md-12">
                            <a href="" id="btn-info" class="btn btn1 btn-info"><span class="glyphicon glyphicon-exclamation-sign"></span></a>
                            <a href="{{url('teo/reageWithEdition',$reage->id)}}"  class="btn btn-warning btn1  " id="reageWithEdit">Reagendar con edicion</a>
                            <input type="submit" value="Reagendar" class="btn btn-success btn1 send_data" >

                        </div>
                    {!! Form::close() !!}

            </div>

        </div>
    </div>
@endsection