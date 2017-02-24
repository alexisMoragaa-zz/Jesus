		
<div class="form-group">
    <label class="col-md-4 control-label">Nombre</label>
    <div class="col-md-6">

        {!! form::text('name', null,['class'=>'form-control', 'placeholder'=>'Nombre Completo']) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-md-4 control-label">E-Mail </label>
    <div class="col-md-6">
        {!! form::text('email',null,['class'=>'form-control', 'placeholder'=>'ejemplo@gmail.com']) !!}
    </div>
</div>

<div class="form-group">
    <label class="col-md-4 control-label">Perfil</label>
    <div class="col-md-6">
        {!! form::text('perfil', null,['class'=>'form-control', 'placeholder'=> '1 = admin.  2 = teo.  3 = sup.  4 = ope. 5 = ruta ']) !!}
    </div>
</div>

<div class="form-group">
    <label  class="col-md-4 control-label">Estado</label>
    <div class="col-md-6">
        {!! form::text('estado',null,['class'=>'form-control', 'placeholder'=> 'Activo / Inactivo']) !!}
    </div>
</div>



