@extends('app')
@section('content')
    <script src="{{asset('/js/validarRuta.js')}}"></script>

    <h3 style="text-align:center; color:red">{{$reage->estadoRuta->observacion_primer_agendamiento}}</h3>

    {!! Form::open(['url'=>['teo/editCapPost'],'method'=>'POST', 'class'=>'form-horizontal']) !!}

        @include('partials.partialAgendamiento')
        <input type="submit" class="btn btn-warning  btna" value="Editar Reagendamiento ">
        <input type="hidden" name="reagendamiento" value="1">

    {!! Form::close() !!}

        <div class="container">

         <div class="panel panel-default">
             <table class="table table-responsive grabacion">
                 <thead>
                 <th>Comuna</th>
                 <th>Voluntario</th>
                 <th>Lunes</th>
                 <th>Martes</th>
                 <th>Miercoles</th>
                 <th>Jueves</th>
                 <th>Viernes</th>
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


     <div class="panel panel-default">
         <h4>{{$reage->rutero}} tiene <span id="numero_Rutas"></span> rutas este dia</h4>
       <div class="row">
           <div class="col-md-6 ">
              <div class="panel panel-default">
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
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel panel-default">
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
        </div>
       </div>
   </div>
 </div>

@endsection