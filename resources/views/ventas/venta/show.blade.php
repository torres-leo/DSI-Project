@extends('layouts.admin')
@section('contenido')


<div class="row">
    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
        <div class="form-group">
            <label for="nombre">Cliente</label>
            <p>{{$venta->nombre}}</p>
        </div>
    </div>

    <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
        <div class="form-group">
            <label>Tipo Comprobante</label>
            <p>{{$venta->tipoComprobante}}</p>
        </div>
    </div>

    <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
        <div class="form-group">
            <label for="serieComprobante">Serie Comprobante</label>
            <p>{{$venta->serieComprobante}}</p>
        </div>
    </div>

    <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
        <div class="form-group">
            <label for="numComprobante">Número de comprobante</label>
            <p>{{$venta->numComprobante}}</p>
        </div>
    </div>

</div>

<div class="row">
    <div class="panel panel-primary">
        <div class="panel-body">

            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                    <thead style="background-color: #DA602F">
                        <th class="text-center">Artículo</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-center">Precio de Venta</th>
                        <th class="text-center">Descuento</th>
                        <th class="text-center">Subtotal</th>
                    </thead>
                    <tfoot>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>
                            <h4 class="text-center" id="total">C$ <b>{{ $venta->totalVenta}}</b></h4>
                        </th>
                    </tfoot>
                    <tbody>
                        @foreach ($detalles as $det)
                        <tr>
                            <td class="text-center">{{$det->articulo}}</td>
                            <td class="text-center">{{$det->cantidad}}</td>
                            <td class="text-center">{{$det->precioVenta}}</td>
                            <td class="text-center">{{$det->descuento}}</td>
                            <td class="text-center">{{ $det->cantidad * ($det->precioVenta - $det->descuento) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>


</div>

@endsection