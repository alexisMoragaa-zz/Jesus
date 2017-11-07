@extends('app')
@section('content')
<div class="container col-sx-12">


    <h1>Rutas diarias</h1>

    <table class=" table table-condensed">
        <thead>

        <th>Nombre</th>
        <th>Telefono</th>
        <th>Direccion</th>
        <th>Jornada</th>
        <th>Ver</th>
        </thead>
        <tbody>
        @foreach($cap as $c)
              <tr>
                <td>{{$c->nombre}} {{$c->apellido}}</td>
                <td>{{$c->fono_1}}</td>
                <td>{{$c->direccion}}</td>
                <td>{{$c->horario}}</td>
                @if(Auth::user()->perfil==1)
                    <td><a href="{{route('admin.rutas.show',$c->id)}}"><span class="glyphicon glyphicon-search"></span></a></td>
                @elseif(Auth::user()->perfil==5)
                    <td><a href="{{route('rutas.rutas.show',$c->id)}}"><span class="glyphicon glyphicon-search"></span></a></td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div><!--fin container->
@endsection
