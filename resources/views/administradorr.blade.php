

@extends('app')

@section('content')
    <style>
        #titulo{
            text-align: center;
            color:gray;
        }
    </style>
<div class="container">
    <h1 id="titulo">esta es la vista de administrador</h1>

    <a href="{{url('admin/rutas')}}" class=" btn btn-info" >Modificar Rutas</a>
    <a href="{{url('admin/adminconfig')}}" class="btn btn-info">Añadir Estados</a>
</div>


@endsection
