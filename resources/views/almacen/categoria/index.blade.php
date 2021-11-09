@extends('layouts.admin')
@section('contenido')


<div class="row">
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <h3> Listado de categorias <a href="categoria/create" style="margin-left: 15px;"><button
                    class='btn btn-success'> <b>Agregar
                        Categoria</b></button></a>
        </h3>
        @include('almacen.categoria.search')
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <th class="text-center">Id</th>
                    <th class="text-center">Nombre</th>
                    <th class="text-center">Descripción</th>
                    <th class="text-center">Opciones</th>
                </thead>
                @foreach ($categorias as $cat)
                <tr>
                    <td class="text-center">{{ $cat->idCategoria }})</td>
                    <td class="text-center">{{ $cat->nombre }}</td>
                    <td class="text-center">{{ $cat->descripcion}}</td>

                    <!-- BOTONES -->
                    <td class="text-center">
                        <a href="{{ URL::action('CategoriaController@edit', $cat->idCategoria) }}"><button
                                class="btn btn-primary">Editar</button></a>
                        <a href="" data-target="#modal-delete-{{ $cat->idCategoria }}" data-toggle="modal"><button
                                class="btn btn-danger">Eliminar</button></a>
                    </td>
                    <!-- FIN BOTONES -->
                </tr>
                @include('almacen.categoria.modal')
                @endforeach
            </table>
        </div>
        {{$categorias->render()}}
    </div>
</div>

@endsection