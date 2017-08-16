@extends('app')

@section('content')

    <style>
        #titulo{
            text-align: center;
        }
    </style>

    <div class="container">
        <h1 id="titulo">Teleoperador</h1>

        <a href="{{route('admin.call.index')}}">Comenzar a Llamar</a>

    </div>


@endsection