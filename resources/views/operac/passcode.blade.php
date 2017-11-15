@extends('app')
@section('content')

<script>
  $(document).ready(function(){
  var cont = 31;
  timer = setInterval(function(){
    cont--;
    $("#contador").text(cont);
    if(cont <=0 ){
      clearInterval(timer);
      alert("Su PassCode Expiro");
        $("#pass").text("XXXX");
        //window.location='/ope/ope';
        $("#resetpasscode").submit();
    }
  },1000);
});
</script>

<style>
#titulo{
  font-size:3em;
  text-align: center;
  }
#pass{
  font-size:5.5em;
  text-align: center;
}
#contador{
  font-size:5.5em;
  text-align: center;
}
#expira{
  font-size: 1.5em;
  margin-top: 23px;
  text-align: center;
}

.panel{
  max-width: 120px;
}

.row{
  margin-top: 3em;
}
</style>
<div class="row">
  <div class="container">
    <a href="{{url('ope/ope')}}" class="btn btn-default">Regresar</a>
    <div class="col-md-8 col-md-offset-3">
      <div class="col-md-6">
        <h1 id="titulo">PassCode</h1>
        <h2 id="pass">{{$passcode}}</h2>
      </div>
      <div class="col-md-6">
        <div class="panel panel-default">
          <p id="expira">Expira en</p>
          <h1 id="contador"></h1>
        </div>
      </div>
    </div>
    {!!Form::open(['url'=>['ope/resetPassCode'],'method'=>'post','id'=>'resetpasscode'])!!}

    {!!Form::close()!!}
  </div>
</div>
@endsection
