@extends('app')
@section('content')
  <div class="container">
    <h4>Agendamientos Fallidos</h4>
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
            <th>ID</th>
            <th>Nombre</th>
            <th>Rut</th>
            <th>Telefono</th>
            <th>Direccion</th>
            <th>Comuna</th>
            <th>Estado</th>
            <th>Motivo</th>

        </thead>
        <tbody>
          @foreach($fallidos as $fallido)
            <tr>
              <td>{{$fallido->id}}</td>
              <td>{{$fallido->nombre}} {{$fallido->apellido}}</td>
              <td>{{$fallido->rut}}</td>
              <td>{{$fallido->fono_1}}</td>
              <td>{{$fallido->direccion}}</td>
              <td>{{$fallido->comuna}}</td>
              <td>{{$fallido->estado_mandato}}</td>
              <td><a href="{{url('/teo/detalleFallidos',$fallido->id)}}">Ver Mas</a></td>
            </tr>
          @endforeach

        </tbody>
      </table>
    </div>
  </div>
@endsection()
