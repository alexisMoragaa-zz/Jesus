@extends('app')
@section('content')
<style>
.badge{
  float: right;
}
.graph-tittle{
  text-align: center;
}
</style>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js">
</script>
<script>
$(document).ready(function(){
  var historialExitosas={
    type:"doughnut",
    data:{
      datasets:[{
        data:[
          {{$rutasExitosas}},
          {{$rutasConReparo}},
        ],
        backgroundColor:[
          "#43A047",
          "#FB8C00",
        ],
      }],
      labels:[
        "Exitosos",
        "Con Reparo",
      ]
    },
    options:{
      responsive:true,
    }
  }
  var grafico_exitosas =$("#historialExitosas");
  window.pie = new Chart(grafico_exitosas,historialExitosas);

  var historial_no_retiradas={
    type:"doughnut",
    data:{
      datasets:[{
        data:[
          {{$rutasRetracta}},
          {{$rutasRechazadas}},
          {{$noContesta}},
          {{$noEstaDomicilio}},
          {{$noEncuentroDireccion}},

        ],
        backgroundColor:[
          "#FF0000",
          "#9E9E9E",
          "#993300",

          "#003399",
          "#4D5656",
        ],
      }],
      labels:[
        "Retracta",
        "rechazadas",
        "No Contestan",
        "No Esta en Domicilio",
        "Direccion Erronea",
      ]
    },
    options:{
      responsive:true,
    }
  }
  var grafico_historial_no_realizadas = $("#historialNoRetiradas");
  window.pie = new Chart(grafico_historial_no_realizadas,historial_no_retiradas);

  var historial_rutas ={
    type:"doughnut",
    data:{
      datasets:[{
        data:[
          {{$rutasExitosas+$rutasConReparo}},
          {{$rutasNoRetiradas}},
          ],
          backgroundColor: [
            "#1E88E5",
            "#FFB74D",
          ],
        }],
        labels: [
          "Retirados",
          "No Retirados",
        ]
      },
      options:{
        responsive: true,
      }
    }
    var grafico_historial_rutas=$("#HistorialRutas");
    window.pie = new Chart(grafico_historial_rutas,historial_rutas);

});
</script>

<div class="container">
  <h1 class="graph-tittle">Registro Historico de rutas de {{$rutero->name}} {{$rutero->last_name}}</h1>
  <div class="row">
    {{--row for the graphics--}}
    <div class="col-xs-12 col-md-4" >
      <h3 class="graph-tittle">Rutas</h3>
      <canvas id="HistorialRutas"  width="250px" height="220px"></canvas>
    </div>

    <div class="col-xs-12 col-md-4">
      <h3 class="graph-tittle">Mandatos Retirados</h3>
      <canvas id="historialExitosas" width="250px" height="220px"></canvas>
    </div>

    <div class="col-xs-12 col-md-4">
      <h3 class="graph-tittle">Mandatos No Retiradas</h3>
      <canvas id="historialNoRetiradas" width="250px" height="220px" ></canvas>
    </div>


  </div>
  <div class="row">
    {{--row for the panels whit information--}}
    <div class="col-md-4">
      <div class="panel panel-primary">
        <div class="panel-heading">Registro de rutas hasta el cierre del dia <span>aca la fecha</span></div>
        <ul class="list-group">
          <li class="list-group-item">Total Rutas <span class="badge">{{$rutero->misRutas->count()}}</span></li>
          <li class="list-group-item">Rutas Realizadas<span class="badge">{{$rutasRealizadas}}</span></li>
          <li class="list-group-item">Rutas no Realizadas<span class="badge"></span></li>
        </ul>
      </div>
    </div>

    <div class="col-md-4">
      <div class="panel panel-success">
        <div class="panel-heading">Rutas Realizadas hasta el <span>2017-12-14</span>
          <span class="badge">{{$rutasRealizadas}}
          </span></div>
        <ul class="list-group">

          <li class="list-group-item">Rutas Exitosas<span class="badge">{{$rutasExitosas}}</span></li>
          <li class="list-group-item">Rutas con Reparo<span class="badge">{{$rutasConReparo}}</span></li>
            <li class="list-group-item">Rutas No Retiradas<span class="badge">{{$rutasNoRetiradas}}</span></li>
          <li class="list-group-item">Rutas Rechazadas<span class="badge">{{$rutasRechazadas}}</span></li>
          <li class="list-group-item">Rutas Retracta<span class="badge">{{$rutasRetracta}}</span></li>
        </ul>
      </div>
    </div>

    <div class="col-md-4">
      <div class="panel panel-info">
        <div class="panel-heading">Registro de rutas Futuras </div>
        <ul class="list-group">
          <li class="list-group-item">Rutas Pendientes<span class="badge">{{$rutasPendientes}}</span></li>
          <li class="list-group-item">Ritas Realizadas<span class="badge"></span></li>
          <li class="list-group-item">Rutas no Realizadas<span class="badge"></span></li>
        </ul>
      </div>
    </div>


  </div>


</div>
@endsection
