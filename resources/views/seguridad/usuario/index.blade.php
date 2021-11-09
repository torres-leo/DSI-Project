@extends('layouts.admin')
@section('contenido')


<div class="row">
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <h3> Listado de Usuarios <a href="usuario/create" style="margin-left: 15px;"><button class='btn btn-success'>
                    <b>Agregar
                        Usuario</b></button></a>
        </h3>
        @include('seguridad.usuario.search')
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <th class="text-center">Id</th>
                    <th class="text-center">Nombre</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Opciones</th>
                </thead>
                @foreach ($usuarios as $user)
                <tr>
                    <td class="text-center">{{ $user->id }})</td>
                    <td class="text-center">{{ $user->name }}</td>
                    <td class="text-center">{{ $user->email}}</td>

                    <!-- BOTONES -->
                    <td class="text-center">
                        <a href="{{ URL::action('UsuarioController@edit', $user->id) }}"><button
                                class="btn btn-primary">Editar</button></a>
                        <a href="" data-target="#modal-delete-{{ $user->id }}" data-toggle="modal"><button
                                class="btn btn-danger">Eliminar</button></a>
                    </td>
                    <!-- FIN BOTONES -->
                </tr>
                @include('seguridad.usuario.modal')
                @endforeach
            </table>
        </div>
        {{$usuarios->render()}}
    </div>
</div>

@endsection