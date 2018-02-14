@extends('app')
@section('content')
<style>
  .txt{
    color: black;
  }
  .graphic-tittle{
    text-align: center;
  }
#informacion{
  margin-top:5em;
}
#mt-2{
  margin-top: 2em;
}
</style>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js">

</script>
  <script>
    $(document).ready(function(){
      var datos_llamados ={
        //Grafico de pie para los llamados realizados
        type:"doughnut",
        data:{
          datasets:[{
            data:[
              {{$llamados}},
              {{$pendientes}},
            ],
            backgroundColor: [
              "#04B404",
              "#A4A4A4",
            ],
          }],
          labels: [
            "Total Llamados",
            "Pendientes",
          ]
        },
        options:{
          responsive: true,
        }
      }
      var grafico_llamados =$("#llamados");
      window.pie = new Chart(grafico_llamados,datos_llamados);

      var datos_contactados ={
        //Grafico de pie para graficar el resultado de los llamados realizados
        type:"doughnut",
        data:{
          datasets:[{
            data:[
              {{$cumas}},
              {{$cnu}},
              {{$cumenos}},
              {{$call_again}},
            ],
            backgroundColor: [
              "#04B404",
              "#FFBF00",
              "#FF0000",
              "#04B4AE",
            ],
          }],
          labels: [
            "CU+",
            "CNU",
            "CU-",
            "volver a llamar",
          ]
        },
        options:{
          responsive: true,
        }
      }

      var grafico_contactados = document.getElementById('contactados').getContext('2d');
      window.pie = new Chart(grafico_contactados,datos_contactados);

    //Grafico recorrido general de la base por dias
      var datos_mensuales = {
        type:"bar",
        data:{
          labels:[<?php foreach ($labels as $label) {
            echo("'$label'".',');
          }?>],
          datasets:[{
            label:"CU+",
            data:[<?php foreach ($dCumasGeneral as $dato) {
              echo("'$dato'".',');
            }?>],
            backgroundColor:"#05c814",
            borderColor:"#28b463",
            borderWidth:2,
          },{
            label:"CU-",
            data:[<?php foreach ($dCumenosGeneral as $dcum) {
              echo("'$dcum'".',');
            }?>],
            backgroundColor:"#ec7063",
            borderColor:"#0c5f12",
            borderWidth:2,
          },{
            label:"CNU",
            data:[<?php foreach ($dCnuGeneral as $dato) {
              echo("'$dato'".',');
            }?>],
            backgroundColor:"#f7dc6f",
            borderColor:"#f39c12",
            borderWidth:2,
          }
          ,{
            label:"CallAgain",
            data:[<?php foreach ($dCallAgainGeneral as $dato) {
              echo("'$dato'".',');
            }?>],
            backgroundColor:"#33ffb2",
            borderColor:"#1476fa",
            borderWidth:2,
          }
        ],


        },
        options:{
          responsive: true,
        }
      }
      var grafico_datos_mensuales = document.getElementById('history').getContext('2d');
      window.pie = new Chart(grafico_datos_mensuales,datos_mensuales);



  });
  </script>
  <div class="row">
    <div class="container">

      <h2 class="graphic-tittle">
        Informe Rendimiento  <span class="text-muted">{{$base->nombre_campana}}</span>
        de la Fundacion <span class="text-muted">{{$base->funda->nombre}}</span>
      </h2>
      <div class="text-center">
        @if(Auth::user()->perfil==6)
          <a href="{{url('/informes/reporte',$base->id)}}" class=" btn btn-warning">Ver Reporte</a>
        @elseif(Auth::user()->perfil==1)
          <a href="{{url('/admin/reporte',$base->id)}}" class=" btn btn-warning">Ver Reporte</a>
        @endif
      </div>
    </div>

    <div class="col xs-12 col-md-6">
      <div id="canvas-container" class="col-md-12 bordes">
        <h3 class="graphic-tittle">Contactados</h3>
        <canvas id="contactados" width="250px" height="160px"></canvas>
      </div>

      <div id="canvas-container" class="col-md-12 bordes">
        <h3 class="graphic-tittle">Llamados</h3>
        <canvas id="llamados" width="250px" height="160px"></canvas>
      </div>
    </div>
    <div class="container">

    <div class=" col-xs-12 col-md-6" id="informacion">

        <div class="col-md-10 text-center mb-2">

            <div class="alert alert-success">{{$recorrido}}</div>

            <div class="btn-group">
              <a href="{{url('/informes/campana',$base->id)}}" class="btn btn-primary"> General</a>
              <a href="{{url('/informes/campana/'.$base->id.'/recorrido',1)}}" class="btn btn-success">Recorrido 1</a>
              <a href="{{url('/informes/campana/'.$base->id.'/recorrido',2)}}" class="btn btn-warning">Recorrido 2</a>
              <a href="{{url('/informes/campana/'.$base->id.'/recorrido',3)}}" class="btn btn-danger">Recorrido 3</a>
            </div>
        </div>

        <div class="col-md-10">
          <div class="panel panel-default">
            <div class="panel-heading">Registros Sobre la Base</div>
            <ul class="list-group">
              <li class="list-group-item">Total Base <span class="badge">{{$total}}</span></li>
              <li class="list-group-item">Total Registros Llamados <span class="badge">{{$llamados}}</span></li>
              <li class="list-group-item">Total Registros Pendientes <span class="badge">{{$pendientes}}</span></li>
            </ul>
          </div>
        </div>

        <div class="col-md-10">
          <div class="panel panel-success">
            <div class="panel-heading">Registros LLamados</div>
            <ul class="list-group">

              <li class="list-group-item">Total Registros Llamado <span class="badge success">
                {{$llamados}}
              </span></li>

              <li class="list-group-item">CU+<span class="badge">
                @if(isset($cumas))
                  {{$cumas}}
                @else
                  Sin Registros
                @endif
              </span></li>

              <li class="list-group-item">CU- <span class="badge">
                @if(isset($cumenos))
                  {{$cumenos}}
                @else
                  Sin Registros
                @endif
              </span></li>

              <li class="list-group-item">CNU<span class="badge">
                @if(isset($cnu))
                  {{$cnu}}
                @else
                  Sin Registros
                @endif
              </span></li>

              <li class="list-group-item">Volver a LLamar<span class="badge">
                @if(isset($call_again))
                  {{$call_again}}
                @else
                  Sin Registros
                @endif
              </span></li>

            </ul>
          </div>
        </div>

        <div class="col-md-10" id="mt-2">
          <div class="panel panel-info">
            <div class="panel-heading">Penetracion y Contactabilidad</div>
            <ul class="list-group">

              <li class="list-group-item">Penatracion<span class="badge">
                @if(isset($penetracion))
                  {{$penetracion}}%
                @else
                  Sin Registros
                @endif
              </span></li>

              <li class="list-group-item">Contactabilidad<span class="badge">
                @if(isset($contactabilidad))
                  {{$contactabilidad}}%
                @else
                  Sin Registros
                @endif
              </span></li>

              <li class="list-group-item">Penetracion Total <span class="badge">
                @if(isset($penetracionTotal))
                  {{$penetracionTotal}}%
                @else
                  Sin Registros
                @endif
              </span></li>

            </ul>
          </div>
        </div>

      </div>

    </div>





  <div class="col-md-10 col-md-offset-1">
    <div id="canvas-container" class="col-md-12 bordes">
      <h3 class="graphic-tittle">{!!$breadcrum2!!} </h3>
      <canvas id="history"  height="100px"></canvas>
    </div>
  </div>

</div>


@endsection
