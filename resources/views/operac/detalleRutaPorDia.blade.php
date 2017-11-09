@extends('app')
@section('content')
  <style>
  .titulo{
    text-align: center;
  }
  .resaltar{
    font-size: 1.2em;
    font-family: monospace;
    color: gray;
  }
  </style>
  <script>

  </script>
  <div class="container">
    <h3 class="titulo">Ruta Completa Para <span class="resaltar">{{$rutero}}</span> el dia {{$dia}}</h3>
    <div class="table-responsive">
      <table class=" table table-hover">
        <thead>
          <th>Nombre</th>
          <th>Telefono</th>
          <th>Rut</th>
          <th>Direccion</th>
          <th>Comuna</th>
          <th>Horario</th>
          <th>Estado</th>
          <th>Detalles</th>
        </thead>
        <tbody>
          @foreach ($ruta as $ruta)
            <tr>
              <td>{{$ruta->nombre}} {{$ruta->apellido}}</td>
              <td>{{$ruta->fono_1}}</td>
              <td>{{$ruta->rut}}</td>
              <td>{{$ruta->direccion}}</td>
              <td>{{$ruta->comuna}}</td>
              <td>{{$ruta->horario}}</td>
              <td>{{$ruta->estadoRuta->estado}}</td>
              @if(Auth::User()->perfil==4)
                  <td><a href="{{url('/ope/detalleRuta',$ruta->id)}}">Ver Mas</a></td>
              @elseif(Auth::User()->perfil==5)
                    <td><a href="{{url('/rutas/detalleRuta',$ruta->id)}}">Ver Mas</a></td>
              @endif

            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
