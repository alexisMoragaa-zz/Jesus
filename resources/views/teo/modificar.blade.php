@extends('app')

@section('content')

<link href="{{ asset('/css/style.css') }}" rel="stylesheet">
<h1>Actualizar el registro </h1>
          <div class="container">
			<div class="panel panel-default">
            <div class="panel-heading">ACTUALIZAR MANDATO</div> 
					<form class="form-horizontal" role="form" method="POST" action="@if(Auth::user()->perfil==1){{ url('admin/actualizado&') }}{{$capta->id}}@elseif(Auth::user()->perfil==2){{ url('teo/actualizado&') }}{{$capta->id}}@endif" >
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
   <div>
    <img class="iconoActu" src="/imagenes/iconoActu.png"> </img>
    </div>
					
						<div class="form-group">
							<label class="col-md-4 control-label">Monto Original</label>
							<div class="col-md-6">
								<input type="text" class="form-control"  name="monto_original" value="@if($capta->monto_original==0 or $capta->monto_aporte==null) ingrese monto original @else{{ $capta->monto_original }}@endif">
							</div>
						</div>
						
						
						<div class="form-group">
							<label class="col-md-4 control-label">Monto Aporte</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="monto_aporte"  value="@if($capta->monto_aporte==0 or $capta->monto_aporte==null) ingrese monto aporte @else{{ $capta->monto_aporte }}@endif">
							</div>
						</div>	
						
                        <div class="form-group">
							<label class="col-md-4 control-label">Monto Final</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="monto_final"  value="@if($capta->monto_final==0 or $capta->monto_final==null) ingrese monto aporte @else{{ $capta->monto_final }}@endif">
							</div>
						</div>
						
				     <div class="form-group">
                        <label class="col-md-4 control-label">Estado</label>
						<div class="col-md-6">
                        <select  name="estado" class="form-control">
						
                            <option>--Seleccione--</option>
                            <option "@if($capta->estado=='ACEPTA UPGRADE') " value="ACEPTA UPGRADE"  selected "@endif">ACEPTA UPGRADE</option>
                            <option "@if($capta->estado=='PERSONA CUELGA') " value="PERSONA CUELGA"  selected "@endif">PERSONA CUELGA</option>
                            <option "@if( $capta->estado=='NO CONTESTA')" value="NO CONTESTA " selected   "@endif">NO CONTESTA</option>
							<option "@if( $capta->estado=='VOLVER A LLAMAR')" value="VOLVER A LLAMAR  "  selected "@endif">VOLVER A LLAMAR</option>
							<option "@if( $capta->estado=='OTRA PERSONA')" value="OTRA PERSONA  " selected "@endif">OTRA PERSONA</option>
							<option "@if( $capta->estado=='FUERA DE SERVICIO')" value="FUERA DE SERVICIO"  selected "@endif">FUERA DE SERVICIO</option>
							<option "@if( $capta->estado=='GRABADORA')" value="GRABADORA"  selected "@endif">GRABADORA</option>
                        </select>
						</div>
                    </div>
					
					<div class="form-group">
                      <label class="col-md-4 control-label">Fecha Volver a Llamar</label>
					  <div class="col-md-6">
                      <input  type="date" name="fecha_volver_allamar" class="form-control" value="{{$capta->fecha_volver_allamar}}" />
                      </div>
					</div>
					<div class="form-group">
							<label class="col-md-4 control-label">Mensaje</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="mensaje" value="@if($capta->mensaje==null) ingrese un mensaje @else{{ $capta->mensaje }}@endif">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Observacion</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="observacion" value="@if($capta->observacion==null) ingrese un observacion @else{{ $capta->observacion }}@endif">
							</div>
						</div>	
						
					<div class="form-group">
							<label class="col-md-4 control-label">N° llamados</label>
							<div class="col-md-6">
							<select  name="n_llamados" class="form-control">
                            <option>--Seleccione--</option>
                            <option "@if( $capta->n_llamados==1)" value="1" selected "@endif">1</option>
                            <option "@if( $capta->n_llamados==2)" value="2" selected "@endif">2</option>
                            <option "@if( $capta->n_llamados==3)" value="3" selected "@endif">3</option>
                        </select>
							</div>
						</div>						
						
					<div class="form-group">
                      <label class="col-md-4 control-label">Fecha Primer Llamado</label>
					  <div class="col-md-6">
                      <input   type="date" name="fecha_primer_llamado" class="form-control" value="{{$capta->fecha_primer_llamado}}" />

					  </div>
					</div>
					
					<div class="form-group">
                      <label class="col-md-4 control-label">Fecha Segundo Llamado</label>
					  <div class="col-md-6">
                      <input  type="date" name="fecha_segundo_llamado" class="form-control" value="{{$capta->fecha_segundo_llamado}}" />
                      </div>
					</div>
					
					<div class="form-group">
                      <label class="col-md-4 control-label">Fecha Tercer Llamado</label>
					  <div class="col-md-6">
                      <input  type="date" name="fecha_tercer_llamado" class="form-control"  value="{{$capta->fecha_tercer_llamado}}" />
                      </div>
					</div>					
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									ACTUALIZAR
								</button>
							</div>
						</div>
					</form>
					</div>
					</div>


  
@endsection