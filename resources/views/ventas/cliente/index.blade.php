@extends('layouts.admin')
@section('contenido')


<div class="row">
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <h3> Lista de Clientes
            <a href="cliente/create" style="margin-left: 15px;"><button class='btn btn-success'> <b>Agregar
                        Cliente</b></button></a>
            <a href=" {{ route('cliente.pdf') }} " style="margin-left: 15px;">
                <button class='btn btn-danger'><b>Generar Reporte <small class="label bg-primary">PDF</small>
                    </b></button></a>
        </h3>
        @include('ventas.cliente.search')
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <th class="text-center">Id</th>
                    <th class="text-center">Nombre</th>
                    <th class="text-center">Tipo Documento</th>
                    <th class="text-center">Número Documento</th>
                    <th class="text-center">Teléfono</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Opciones</th>
                </thead>
                @foreach ($personas as $per)
                <tr>
                    <td class="text-center" style="vertical-align: middle">{{ $per->idPersona }})</td>
                    <td class="text-center" style="vertical-align: middle">{{ $per->nombre }}</td>
                    <td class="text-center" style="vertical-align: middle">{{ $per->tipoDocumento}}</td>
                    <td class="text-center" style="vertical-align: middle">{{ $per->numDocumento}}</td>
                    <td class="text-center" style="vertical-align: middle">{{ $per->telefono}}</td>
                    <td class="text-center" style="vertical-align: middle">{{ $per->email}}</td>
                    <!-- BOTONES -->
                    <td class="text-center" style="vertical-align: middle">
                        <a href="{{ URL::action('ClienteController@edit', $per->idPersona) }}"><button
                                class="btn btn-primary" style="margin-right: 5px;">Editar</button></a>
                        <a href="" data-target="#modal-delete-{{ $per->idPersona }}" data-toggle="modal"><button
                                class="btn btn-danger">Eliminar</button></a>
                    </td>
                    <!-- FIN BOTONES -->
                </tr>
                @include('ventas.cliente.modal')
                @endforeach
            </table>
        </div>
        {{$personas->render()}}
    </div>
</div>

@endsection