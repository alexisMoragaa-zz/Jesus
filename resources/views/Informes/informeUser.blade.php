@extends('app')
@section('content')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      var llamadosBase={
        type:"doughnut",
        data:{
          datasets:[{
            data:[
              {{$registrosContactados}},
              {{$cnu}},
            ],
            backgroundColor:[
              "#027FED",
              "#FB8C00",
            ],
          }],
          labels:[
            "Contactados",
            "No Contactados",
          ]
        },
        options:{
          responsive:true,
        }
      }
      var grafico_llamadosBase =$("#llamadosBase");
      window.pie = new Chart(grafico_llamadosBase,llamadosBase);

      var ContactadosBase={
        type:"doughnut",
        data:{
          datasets:[{
            data:[
              {{$cumas}},
              {{$cumenos}},
              {{$ca}},
            ],
            backgroundColor:[
              "#43A047",
              "#FB1A01",
              "#33b8ff",
            ],
          }],
          labels:[
            "CU+",
            "CU-",
            'Call Again'
          ]
        },
        options:{
          responsive:true,
        }
      }
      var grafico_ContactadosBase =$("#contactadosBase");
      window.pie = new Chart(grafico_ContactadosBase,ContactadosBase);

      var cumas={
        type:"doughnut",
        data:{
          datasets:[{
            data:[
              {{$agendamiento}},
              {{$grabacion}},
              {{$delivery}},
            ],
            backgroundColor:[
              "#43A047",
              "#02CDED",
              "#BA68C8",

            ],
          }],
          labels:[
            "Agendamiento",
            "Grabacion",
            "Delivery",
          ]
        },
        options:{
          responsive:true,
        }
      }
      var grafico_cumas =$("#cumas");
      window.pie = new Chart(grafico_cumas,cumas);

    });
  </script>
<div class="container">

  <div class="row">
    <div class="col-xs-12 col-md-4">
      <h3 class="graph-tittle text-center  text-muted">Llamados Realizados</h3>
      <canvas id="llamadosBase" width="250px" height="220px"></canvas>
    </div>

    <div class="col-xs-12 col-md-4">
      <h3 class="graph-tittle text-center text-muted">Contactados</h3>
      <canvas id="contactadosBase" width="250px" height="220px"></canvas>
    </div>

    <div class="col-xs-12 col-md-4">
      <h3 class="graph-tittle text-center text-muted">Cu+</h3>
      <canvas id="cumas" width="250px" height="220px"></canvas>
    </div>
  </div>

  <h1 class="text-center text-muted">{{$breadcrum}}</h1>
  <div class="col-md-4">
    <div class=" panel panel-default">
      <div class="panel-heading">Campañas</div>
      <div class="list-group">
        @foreach ($user->campanitas as $c)
          <a href="{{url('/informes/user/'.$user->id.'/campaing',$c->id)}}" class="list-group-item">{{$c->nombre_campana}}</a>
        @endforeach
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class=" panel panel-default">
      <div class="panel-heading">Campaña Actual</div>
      <ul class="list-group">
        <li class="list-group-item">Llamados <span class="badge">{{$llamados}}</span></li>
        <li class="list-group-item">Contactados <span class="badge">{{$registrosContactados}}</span></li>
        <li class="list-group-item">No Contactados (CNU) <span class="badge">{{$cnu}}</span></li>
      </ul>
    </div>


    <div class="panel panel-default">
      <div class="panel-heading">Contactados</div>
      <ul class="list-group">
        <li class="list-group-item">Cu+ <span class="badge">{{$cumas}}</span></li>
        <li class="list-group-item">Cu- <span class="badge">{{$cumenos}}</span></li>
        <li class="list-group-item">Call Again <span class="badge">{{$ca}}</span></li>
      </ul>
    </div>
  </div>


  <div class="col-md-4">
    <div class=" panel panel-default">
      <div class="panel-heading">Resultados</div>
      <ul class="list-group">
        <li class="list-group-item">Contactabilidad<span class="badge">{{$contactabilidad}}</span></li>
        <li class="list-group-item">Penetracion<span class="badge">{{$penetracion}}</span></li>
      </ul>
    </div>
  </div>

</div>

@endsection
