@extends('layouts.admin')
@section('contenido')


<div class="row">
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <h3> Lista de Ingresos <a href="ingreso/create" style="margin-left: 15px;"><button class='btn btn-success'>
                    <b>Nuevo Ingreso</b></button></a>
        </h3>
        @include('compras.ingreso.search')
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <th class="text-center">Fecha</th>
                    <th class="text-center">Proveedor</th>
                    <th class="text-center">Tipo Comprobante</th>
                    <th class="text-center">Impuesto</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Estado</th>
                    <th class="text-center">Opciones</th>
                </thead>
                @foreach ($ingresos as $ing)
                <tr>
                    <td class="text-center" style="vertical-align: middle"> {{ $ing->fechaHora }} </td>
                    <td class="text-center" style="vertical-align: middle"> {{ $ing->nombre}} </td>
                    <td class="text-center" style="vertical-align: middle">
                        {{ $ing->tipoComprobante. ': '. $ing->serieComprobante.'-'.$ing->numComprobante}}
                    </td>
                    <td class="text-center" style="vertical-align: middle"> {{ $ing->impuesto}} </td>
                    <td class="text-center" style="vertical-align: middle"> {{ $ing->total}} </td>
                    <td class="text-center" style="vertical-align: middle"> {{ $ing->estado}} </td>
                    <!-- BOTONES -->
                    <td class="text-center" style="vertical-align: middle">
                        <a href="{{ URL::action('IngresoController@show', $ing->idIngreso) }}"><button
                                class="btn btn-primary" style="margin-right: 5px;">Detalles</button></a>
                        <a href="" data-target="#modal-delete-{{ $ing->idIngreso }}" data-toggle="modal"><button
                                class="btn btn-danger">Anular</button></a>
                    </td>
                    <!-- FIN BOTONES -->
                </tr>
                @include('compras.ingreso.modal')
                @endforeach
            </table>
        </div>
        {{$ingresos->render()}}
    </div>
</div>

@endsection