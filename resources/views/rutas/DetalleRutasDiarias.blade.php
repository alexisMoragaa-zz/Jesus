@extends('app')
@section('content')

<div class="container">
    <table class="table">
        <thead>
        <th>Nombre</th>
        <th>Telefono</th>
        <th>Direccion</th>
        <th>Comuna</th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        </thead>
        <tbody>
        @foreach($ruta as $r)
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection