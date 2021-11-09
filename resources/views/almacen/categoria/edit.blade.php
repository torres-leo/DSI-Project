@extends('layouts.admin')
@section('contenido')

<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h3>Editar Categoria:
            <span style="border-bottom: 1px solid green; margin-left: 15px;">
                <i>{{ $categoria->nombre}}
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

        {!!Form::model($categoria, ['method'=>'PATCH' ,'route'=>['almacen.categoria.update',$categoria->idCategoria]]
        )
        !!}
        {{Form::token()}}
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ $categoria->nombre }}"
                placeholder="Ingresa el nombre de la categoria">
        </div>

        <div class="form-group">
            <label for="descripcion">Descripcion</label>
            <input type="text" name="descripcion" class="form-control" value="{{ $categoria->descripcion }}"
                placeholder="Ingresa una descripcion">
        </div>
        <div class="form-group" style="margin-top: 15px;">
            <button class="btn btn-primary" type="submit">Guardar</button>
            <button class="btn btn-danger" type="reset"><a href="{{url('almacen/categoria')}}"
                    style="text-decoration: none; color: white;">Cancelar</a></button>
        </div>

        {!!Form::close()!!}

        @endsection