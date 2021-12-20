@extends('layouts.admin')
@section('contenido')


<div class="row">
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <h3> Listado de Articulos <a href="articulo/create" style="margin-left: 15px;">
                <button class='btn btn-success'><b>Agregar Articulo</b></button></a>
            <a href=" {{ route('articulos.pdf') }} " style="margin-left: 15px;">
                <button class='btn btn-danger'><b>Generar Reporte <small class="label bg-primary">PDF</small>
                    </b></button></a>
        </h3>
        @include('almacen.articulo.search')
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <th class="text-center">Id</th>
                    <th class="text-center">Nombre</th>
                    <th class="text-center">Código</th>
                    <th class="text-center">Categoría</th>
                    <th class="text-center">Descripción</th>
                    <th class="text-center">Stock</th>
                    <th class="text-center">Imagen</th>
                    <th class="text-center">Estado</th>
                    <th class="text-center">Opciones</th>
                </thead>
                @foreach ($articulos as $art)
                <tr>
                    <td class="text-center" style="vertical-align: middle">{{ $art->idArticulo }})</td>
                    <td class="text-center" style="vertical-align: middle">{{ $art->nombre }}</td>
                    <td class="text-center" style="vertical-align: middle">{{ $art->codigo}}</td>
                    <td class="text-center" style="vertical-align: middle">{{ $art->categoria}}</td>
                    <td class="text-center" style="vertical-align: middle">{{ $art->descripcion}}</td>
                    <td class="text-center" style="vertical-align: middle" id="stock">{{ $art->stock}}</td>
                    <td class="text-center">
                        <img src="{{ asset('imagenes/articulos/'.$art->imagen) }}" alt="{{ $art->nombre }}"
                            height="100px" width="100px" class="img-thumbnail"
                            style="background-color: brown; filter: brightness(95%);">
                    </td>
                    <td class="text-center" style="vertical-align: middle" id="estado">{{ $art->estado}}</td>

                    <!-- BOTONES -->
                    <td class="text-center" style="vertical-align: middle">
                        <a href="{{ URL::action('ArticuloController@edit', $art->idArticulo) }}"><button
                                class="btn btn-primary" style="margin-right: 5px;">Editar</button></a>
                        <a href="" data-target="#modal-delete-{{ $art->idArticulo }}" data-toggle="modal"><button
                                class="btn btn-danger">Eliminar</button></a>
                    </td>
                    <!-- FIN BOTONES -->
                </tr>
                @include('almacen.articulo.modal')
                @endforeach
            </table>
        </div>
        {{$articulos->render()}}
    </div>
</div>

@endsection

<script>
document.addEventListener("DOMContentLoaded", function() {
    actualizar();
});

function actualizar() {
    var stock = querySelector('#stock');
    var estado = querySelector('#estado');

    if (stock === 0) {
        estado = 'Inactivo';
    }


}
</script>