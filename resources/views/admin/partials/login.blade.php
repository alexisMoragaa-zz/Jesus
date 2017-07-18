 <script src="{{asset('js/optimizar.js')}}"></script>
   <style>
       label{
           font-size: 17px;
       }
   </style>

<div class="col-md-6">
    <label class=" control-label">Nombre</label>

        {!! form::text('name', null,['class'=>'form-control', 'placeholder'=>'Nombre Completo']) !!}
</div>

<div class="col-md-6">
    <label for="" class=" control-label">Apellido</label>

        {!! form::text('last_name',null,['class'=>'form-control']) !!}

</div>

<div class="col-md-4">
    <label for="" class="control-label">Rut</label>

        {!! form::text('rut',null,['class'=>'form-control','placeholder'=>'18202912']) !!}

</div>
<div class="col-md-2">
    <label for="" class="control-label "> Dv</label>

        {!! form::text('dv',null,['class'=>'form-control','placeholder'=>'2']) !!}

</div>

    <div class="col-md-2">
        <label class="control-label">Perfil</label>

        <select name="perfil" id="perfil" class="form-control">

            @if(Auth::user()->perfil==1)
                <option value="1">Administrador</option>
                <option value="3">Supervisor</option>
            @endif
                <option value="2">Teleoperador</option>
                <option value="4">Operaciones</option>
                <option value="5">Rutero</option>
        </select>

    </div>

<div class="col-md-4">
    <label class=" control-label">E-Mail </label>

        {!! form::email('email',null,['class'=>'form-control', 'placeholder'=>'ejemplo@gmail.com']) !!}


</div>

<div class="col-md-6">
    <label for="" class="control-label" >Direccion</label>

        {!! form::text('direccion',null,['class'=>'form-control','placeholder'=>'Rochdale 3675']) !!}

</div>

<div class="col-md-3">
    <label for="" class="control-label ">Telefono</label>

        {!! form::text('telefono',null,['class'=>'form-control']) !!}


</div>

<div class="col-md-3">
        <label for="" class="control-label ">AFP</label>

        {!! form::text('afp',null,['class'=>'form-control','placeholder'=>'Modelo']) !!}

    </div>

<div class="col-md-2">
    <label for="" class="control-label  ">Previcion</label>

                <select name="previcion" id="previcion" class="form-control" >
                    <option value="fonasa">Fonasa</option>
                    <option value="isapre">Isapre</option>
                </select>

</div>

<div class="col-md-3 ispre">
    <label for="" class="control-label ">Nombre Isapre</label>

        {!! form::text('nombre_isapre',null,['class'=>'form-control','id'=>'isapre']) !!}

</div>

<div class="col-md-2">
    <label for="" class=" control-label">Turno</label>

        <select name="turno" id="" class="col-md-12 form-control">
            <option value="am">AM</option>
            <option value="pm">PM</option>
            <option value="td">TD</option>
        </select>

</div>


<div class="col-md-2">
    <label  class=" control-label">Estado</label>

        <select name="estado" id="" class="col-md-12 form-control">
            <option value="activo">Activo</option>
            <option value="inactivo">Inactivo</option>
        </select>

</div>

 <div class="col-md-3">
     <label for="" class="control-label">Fecha Nacimiento</label>
     {!! form::date('fecha_nacimiento',null,['class'=>'form-control'])!!}
 </div>

<div class="col-md-3">
    <label for="" class="control-label"> Tipo de Cuenta</label>
    {!! form::text('tipo_cuenta',null,['class'=>'form-control','id'=>'tipo_cuenta','placeholder'=>'Banco Estado Cuenta Rut']) !!}
</div>

<div class="col-md-3">
    <label for="" class="control-label">Numero Cuenta</label>
    {!! form::text('n_cuenta',null,['class'=>'form-control','id'=>'n_cuenta']) !!}
</div>

<!--este formulario se encuentra como parcial para poder reutilizarlo tanto en la ventana de login como en la de
login, registrar, y editar usuarios. ya que estas tres ventanas comparten la misma informacion. por ende tendriamos
que duplicar el formulario en estas tres vistas-->


