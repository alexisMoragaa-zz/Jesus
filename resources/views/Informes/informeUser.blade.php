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
              {{$iradues}},

            ],
            backgroundColor:[
              "#43A047",
              "#02CDED",
              "#BA68C8",
              "#900C3F",

            ],
          }],
          labels:[
            "Agendamiento",
            "Grabacion",
            "Delivery",
            "Ir a Dues",
          ]
        },
        options:{
          responsive:true,
        }
      }
      var grafico_cumas =$("#cumas");
      window.pie = new Chart(grafico_cumas,cumas);

      //Grafico recorrido general de la base por dias
        var datos_mensuales = {
          type:"bar",
          data:{
            labels:[<?php foreach ($labelsPrimer as $label) {
              echo("'$label'".',');
            }?>],
            datasets:[{
              label:"CU+",
              data:[<?php foreach ($dCumasPrimer as $dato) {
                echo("'$dato'".',');
              }?>],
              backgroundColor:"#05c814",
              borderColor:"#28b463",
              borderWidth:2,
            },{
              label:"CU-",
              data:[<?php foreach ($dCumenosPrimer as $dcum) {
                echo("'$dcum'".',');
              }?>],
              backgroundColor:"#ec7063",
              borderColor:"#0c5f12",
              borderWidth:2,
            },{
              label:"CNU",
              data:[<?php foreach ($dCnuPrimer as $dato) {
                echo("'$dato'".',');
              }?>],
              backgroundColor:"#f7dc6f",
              borderColor:"#f39c12",
              borderWidth:2,
            }
            ,{
              label:"CallAgain",
              data:[<?php foreach ($dCallAgainPrimer as $dato) {
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

        //Grafico recorrido general de la base por dias
          var second_call = {
            type:"bar",
            data:{
              labels:[<?php foreach ($labelsSecond as $label) {
                echo("'$label'".',');
              }?>],
              datasets:[{
                label:"CU+",
                data:[<?php foreach ($dCumasSegundo as $dato) {
                  echo("'$dato'".',');
                }?>],
                backgroundColor:"#05c814",
                borderColor:"#28b463",
                borderWidth:2,
              },{
                label:"CU-",
                data:[<?php foreach ($dCumenosSegundo as $dcum) {
                  echo("'$dcum'".',');
                }?>],
                backgroundColor:"#ec7063",
                borderColor:"#0c5f12",
                borderWidth:2,
              },{
                label:"CNU",
                data:[<?php foreach ($dCnuSegundo as $dato) {
                  echo("'$dato'".',');
                }?>],
                backgroundColor:"#f7dc6f",
                borderColor:"#f39c12",
                borderWidth:2,
              }
              ,{
                label:"CallAgain",
                data:[<?php foreach ($dCallAgainSegundo as $dato) {
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
          var grafico_second_call = document.getElementById('secondCall').getContext('2d');
          window.pie = new Chart(grafico_second_call,second_call);


    //Grafico recorrido general de la base por dias
      var three_call = {
        type:"bar",
        data:{
          labels:[<?php foreach ($labelsTercero as $label) {
            echo("'$label'".',');
          }?>],
          datasets:[{
            label:"CU+",
            data:[<?php foreach ($dCumasTercero as $dato) {
              echo("'$dato'".',');
            }?>],
            backgroundColor:"#05c814",
            borderColor:"#28b463",
            borderWidth:2,
          },{
            label:"CU-",
            data:[<?php foreach ($dCumenosTercero as $dcum) {
              echo("'$dcum'".',');
            }?>],
            backgroundColor:"#ec7063",
            borderColor:"#0c5f12",
            borderWidth:2,
          },{
            label:"CNU",
            data:[<?php foreach ($dCnuTercero as $dato) {
              echo("'$dato'".',');
            }?>],
            backgroundColor:"#f7dc6f",
            borderColor:"#f39c12",
            borderWidth:2,
          }
          ,{
            label:"CallAgain",
            data:[<?php foreach ($dCallAgainTercero as $dato) {
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
      var grafico_three_call = document.getElementById('threeCall').getContext('2d');
      window.pie = new Chart(grafico_three_call,three_call);
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

  <div class="col-md-12 ">
    <div id="canvas-container" class="col-md-12 bordes">
      <h3 class="graphic-tittle">Registro diario primer recorrido <small>Registros obtenidos mediante el resultado de la primera llamada</small></h3>
      <canvas id="history"  height="80px"></canvas>
    </div>
  </div>

  <div class="col-md-12 ">
    <div id="canvas-container" class="col-md-12 bordes">
      <h3 class="graphic-tittle">Registro diario Segundo recorrido <small>Registros obtenidos mediante el resultado de la Segunda llamada</small></h3>
      <canvas id="secondCall"  height="80px"></canvas>
    </div>
  </div>

  <div class="col-md-12 ">
    <div id="canvas-container" class="col-md-12 bordes">
      <h3 class="graphic-tittle">Registro diario Tercer recorrido <small>Registros obtenidos mediante el resultado de la Terera llamada</small></h3>
      <canvas id="threeCall"  height="80px"></canvas>
    </div>
  </div>
</div>


@endsection
