@extends('layouts.admin')
@section('contenido')


<div class="row">
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <h3> Listado de Ventas <a href="venta/create" style="margin-left: 15px;"><button class='btn btn-success'>
                    <b>Nueva Venta</b></button></a>
        </h3>
        @include('ventas.venta.search')
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <th class="text-center">Fecha</th>
                    <th class="text-center">Cliente</th>
                    <th class="text-center">Tipo Comprobante</th>
                    <th class="text-center">Impuesto</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Estado</th>
                    <th class="text-center">Opciones</th>
                </thead>
                @foreach ($ventas as $ven)
                <tr>
                    <td class="text-center" style="vertical-align: middle"> {{ $ven->fechaHora }} </td>
                    <td class="text-center" style="vertical-align: middle"> {{ $ven->nombre}} </td>
                    <td class="text-center" style="vertical-align: middle">
                        {{ $ven->tipoComprobante. ': '. $ven->serieComprobante.'-'.$ven->numComprobante}}
                    </td>
                    <td class="text-center" style="vertical-align: middle"> {{ $ven->impuesto}} </td>
                    <td class="text-center" style="vertical-align: middle"> {{ $ven->totalVenta}} </td>
                    <td class="text-center" style="vertical-align: middle"> {{ $ven->estado}} </td>
                    <!-- BOTONES -->
                    <td class="text-center" style="vertical-align: middle">
                        <a href="{{ URL::action('VentaController@show', $ven->idVenta) }}"><button
                                class="btn btn-primary" style="margin-right: 5px;">Detalles</button></a>
                        <a href="" data-target="#modal-delete-{{ $ven->idVenta }}" data-toggle="modal"><button
                                class="btn btn-danger">Finalizar</button></a>
                    </td>
                    <!-- FIN BOTONES -->
                </tr>
                @include('ventas.venta.modal')
                @endforeach
            </table>
        </div>
        {{$ventas->render()}}
    </div>
</div>

@endsection