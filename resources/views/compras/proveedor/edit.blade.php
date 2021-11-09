@extends('layouts.admin')
@section('contenido')

<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h3>Editar Proveedor:
            <span style="border-bottom: 1px solid green; margin-left: 15px;">
                <i>{{ $persona->nombre}}
                </i>
            </span>
        </h3>
        @if (count($errors)>0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
</div>

{!!Form::model($persona, ['method'=>'PATCH' ,'route'=>['compras.proveedor.update',$persona->idPersona,
'files'=>'true']]
)
!!}
{{Form::token()}}


<div class="row">
    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
        <div class="form-group">
            <label for="nombre">Nombre del Proveedor</label>
            <input type="text" name="nombre" required value="{{ $persona->nombre }}" class="form-control"
                placeholder="Ingresar nombre">
        </div>
    </div>

    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
        <div class="form-group">
            <label for="direccion">Dirección</label>
            <input name="direccion" id="direccion" value="{{ $persona->direccion }}" class="form-control"
                placeholder="Ingresar dirección">
            </input>
        </div>
    </div>

    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
        <div class="form-grop" style="margin-top: 10px;">
            <label for="codigo">Tipo de Documento</label>
            <select name="tipoDocumento" id="tipoDocumento" class="form-control">
                <option selected disabled>--Selecciona--</option>

                @if($persona->tipoDocumento=='CEDULA')
                <option value="CEDULA" selected>Cédula</option>
                <option value="RUC">RUC</option>
                <option value="PAS">Pasaporte</option>

                @elseif($persona->tipoDocumento=='RUC')
                <option value="CEDULA">Cédula</option>
                <option value="RUC" selected>RUC</option>
                <option value="PAS">Pasaporte</option>

                @else
                <option value="CEDULA">Cédula</option>
                <option value="RUC">RUC</option>
                <option value="PAS" selected>Pasaporte</option>
                @endif
            </select>
        </div>
    </div>

    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
        <div class="form-group" style="margin-top: 10px;">
            <label for="numDocumento">Número de documento</label>
            <input type="text" name="numDocumento" value="{{ $persona->numDocumento }}" class="form-control"
                placeholder="Número de documento">
        </div>
    </div>

    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
        <div class="form-group" style="margin-top: 10px;">
            <label for="telefono">Teléfono</label>
            <input type="text" name="telefono" value="{{ $persona->telefono }}" class="form-control"
                placeholder="Ingresa el número de teléfono">
        </div>
    </div>

    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
        <div class="form-group" style="margin-top: 10px;">
            <label for="email">Email</label>
            <input type="email" name="email" value="{{ $persona->email }}" class="form-control"
                placeholder="Ingresa email">
        </div>
    </div>

    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
        <div class="form-group" style="margin-top: 15px;">
            <button class="btn btn-primary" type="submit">Guardar</button>
            <button class="btn btn-danger" type="reset"><a href="{{url('compras/proveedor')}}"
                    style="text-decoration: none; color: white;">Cancelar</a></button>
        </div>
    </div>

</div>

{!!Form::close()!!}

@endsection