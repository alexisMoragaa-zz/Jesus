@extends('app')
@section('content')
  <div class="container">
    @foreach($fallidos as $fallido)
      <p>{{$fallido->nombre}}</p>
    @endforeach
  </div>
@endsection()
