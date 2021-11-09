@extends('layouts.admin')
@section('contenido')


<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h3>Nuevo Cliente</h3>
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

{!!Form::open(array('url'=>'ventas/cliente','method'=>'POST','autocomplete'=>'off'))!!}
{{Form::token()}}

<div class="row">
    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
        <div class="form-group">
            <label for="nombre">Nombre del Cliente</label>
            <input type="text" name="nombre" required value="{{ old('nombre') }}" class="form-control"
                placeholder="Ingresar nombre">
        </div>
    </div>

    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
        <div class="form-group">
            <label for="direccion">Dirección</label>
            <input name="direccion" id="direccion" value="{{ old('direccion') }}" class="form-control"
                placeholder="Ingresar dirección">
            </input>
        </div>
    </div>

    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
        <div class="form-group" style="margin-top: 10px;">
            <label for="tipoDocumento">Tipo de Documento</label>
            <select name="tipoDocumento" id="tipoDocumento" class="form-control">
                <option selected disabled>-- Selecciona --</option>
                <option value="CEDULA">Cédula</option>
                <option value="RUC">RUC</option>
                <option value="PAS">Pasaporte</option>
            </select>
        </div>
    </div>

    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
        <div class="form-group" style="margin-top: 10px;">
            <label for="numDocumento">Número de documento</label>
            <input type="text" name="numDocumento" value="{{ old('numDocumento') }}" class="form-control"
                placeholder="Número de documento">
        </div>
    </div>

    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
        <div class="form-group" style="margin-top: 10px;">
            <label for="telefono">Teléfono</label>
            <input type="text" name="telefono" value="{{ old('telefono') }}" class="form-control"
                placeholder="Ingresa el número de teléfono">
        </div>
    </div>

    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
        <div class="form-group" style="margin-top: 10px;">
            <label for="email">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control"
                placeholder="Ingresa email">
        </div>
    </div>

    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
        <div class="form-group" style="margin-top: 15px;">
            <button class="btn btn-primary" type="submit">Guardar</button>
            <button class="btn btn-danger" type="reset"><a href="{{url('ventas/cliente')}}"
                    style="text-decoration: none; color: white;">Cancelar</a></button>
        </div>
    </div>

</div>
{!!Form::close()!!}
@endsection