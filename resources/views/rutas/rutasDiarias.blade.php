@extends('app')
@section('content')
<div class="container">


    <h1>Rutas diarias</h1>

    <table class="table">
        <thead>

        <th>Nombre</th>
        <th>Telefono</th>
        <th>Direccion</th>
        <th>Comuna</th>
        <th>Ver</th>
        </thead>
        <tbody>
        @foreach($cap as $c)
            <tr>

                <td>{{$c->nombre}} {{$c->apellido}}</td>
                <td>{{$c->fono_1}}</td>
                <td>{{$c->direccion}}</td>
                <td>{{$c->comuna}}</td>
                <td><a href=""><span class="glyphicon glyphicon-search"></span></a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div><!--fin container->
@endsection