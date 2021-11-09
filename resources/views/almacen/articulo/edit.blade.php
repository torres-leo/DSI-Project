@extends('layouts.admin')
@section('contenido')

<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h3>Editar Artículo:
            <span style="border-bottom: 1px solid green; margin-left: 15px;">
                <i>{{ $articulo->nombre}}
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

{!!Form::model($articulo, ['method'=>'PATCH' ,'route'=>['almacen.articulo.update',$articulo->idArticulo,
'files'=>'true']]
)
!!}
{{Form::token()}}

<div class="row">
    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
        <div class="form-group">
            <label for="nombre">Nombre del articulo</label>
            <input type="text" name="nombre" required value="{{ $articulo->articulo }}" class="form-control" </div>
        </div>

        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label for="descripcion">Categoría</label>
                <select name="idCategoria" id="idCategoria" class="form-control">
                    @foreach($categorias as $cat)
                    @if($cat->idCategoria==$articulo->idCategoria)
                    <option value="{{ $cat->idCategoria }}" selected>{{ $cat->nombre }}</option>
                    @else
                    <option value="{{ $cat->idCategoria }}">{{ $cat->nombre }}</option>
                    @endif
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group" style="margin-top: 10px;">
                <label for="codigo">Código</label>
                <input type="text" name="codigo" required value="{{ $articulo->codigo }}" class="form-control"
                    placeholder="Ingresa el código del artículo">
                @if(session('mensaje'))
                <div class="alert alert-danger">
                    <p>{{ session('mensaje')}}</p>
                </div>
                @endif
            </div>
        </div>

        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group" style="margin-top: 10px;">
                <label for="stock">Stock</label>
                <input type="text" name="stock" required value="{{ $articulo->stock }}" class="form-control"
                    placeholder="Coloca la cantidad del artículo que se va ingresar">
            </div>
        </div>

        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group" style="margin-top: 10px;">
                <label for="descripcion">Descripción</label>
                <input type="text" name="descripcion" value="{{ $articulo->descripcion }}" class="form-control"
                    placeholder="Ingresa una descripción del artículo">
            </div>
        </div>

        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group" style="margin-top: 10px;">
                <label for="imagen">Imagen</label>
                <input type="file" name="imagen" class="form-control">
                @if(($articulo->imagen)!="")
                <img src="{{ asset('imagenes/articulos/'.$articulo->imagen) }}" alt="Juguete" width="250px"
                    height="250px">
                @endif
            </div>
        </div>

        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group" style="margin-top: 15px;">
                <button class="btn btn-primary" type="submit">Guardar</button>
                <button class="btn btn-danger" type="reset"><a href="{{url('almacen/articulo')}}"
                        style="text-decoration: none; color: white;">Cancelar</a></button>
            </div>
        </div>

    </div>

    {!!Form::close()!!}

    @endsection