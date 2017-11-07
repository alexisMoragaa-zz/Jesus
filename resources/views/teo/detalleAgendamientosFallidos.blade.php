@extends('app')
@section('content')
<style>
</style>
<script>
  $(document).ready(function(){
    $("#ancho").removeClass('col-md-8');
    $("#ancho").addClass('col-xs-12');
  });
</script>
  <div class="container">
    @include('partials.partialDetalleReagendamiento')
  </div>

@endsection()
