@extends('app')
@section('content')
    <script>
        $("document").ready(function(){
            $("#date").hide();
        });
    </script>
    <div class="container">
    @if(Auth::User()->perfil==1)
        {!! Form::open(['url'=>['admin/updatepivot2'],'method'=>'post']) !!}
    @elseif (Auth::user()->perfil==3)
      {!! Form::open(['url'=>['sup/updatepivot2'],'method'=>'post']) !!}
    @endif
        <div class="container">
             <input type="hidden" id="pivote" name="pivote" value="{{$pivot_id}}">
             <input type="hidden" name="user_id" value="{{$user_id}}">
        <div class="form-group">

             <label for="motivo" class="control-label col-md-12">Motivo Termino</label>
                <div class="col-md-8">
             <input type="text" name="motivo" class="form-control ">
        </div>

            <input type="submit" class="btn btn-info col-md-2">
        </div>
        </div>
        {!! Form::close() !!}
    </div>


@endsection
