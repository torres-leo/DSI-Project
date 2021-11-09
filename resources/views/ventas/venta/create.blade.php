@extends('layouts.admin')
@section('contenido')


<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h3>Nueva Venta</h3>
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

{!!Form::open(array('url'=>'ventas/venta','method'=>'POST','autocomplete'=>'off'))!!}
{{Form::token()}}

<!-- ESTA ES LA PARTE NECESARIA PARA LA TABLA INGRESO -->
<div class="row">
    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
        <div class="form-group">
            <label for="nombre">Cliente</label>
            <select name="idCliente" id="idCliente" class="form-control selectpicker" data-live-search="true">
                <option selected disabled>--Selecciona--</option>
                @foreach ($personas as $persona)
                <option value="{{ $persona->idPersona }}"> {{ $persona->nombre }} </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
        <div class="form-group">
            <label for="tipoComprobante">Tipo Comprobante</label>
            <select name="tipoComprobante" id="tipoComprobante" class="form-control">
                <option selected disabled>--Selecciona--</option>
                <option value="Factura">Factura</option>
                <option value="Ticket">Ticket</option>
            </select>
        </div>
    </div>

    <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
        <div class="form-group">
            <label for="serieComprobante">Serie Comprobante</label>
            <input type="text" name="serieComprobante" value="{{ old('serieComprobante') }}" class="form-control"
                placeholder="Serie de comprobante">
        </div>
    </div>

    <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
        <div class="form-group">
            <label for="numComprobante">Número de comprobante</label>
            <input type="text" name="numComprobante" required value="{{ old('numComprobante') }}" class="form-control"
                placeholder="Número de comprobante">
        </div>
    </div>

</div>

<!-- ACÁ EMPIEZA LA PARTE NECESARIA PARA LA TABLA DETALLE INGRESO -->
<div class="row">
    <div class="panel panel-primary">
        <div class="panel-body">

            <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                <div class="form-group">
                    <label>Artículo</label>
                    <select name="pIdArticulo" id="pIdArticulo" class="form-control selectpicker"
                        data-live-search="true">
                        <option selected disabled style="color: black;">-- Selecciona el artículo --</option>
                        @foreach($articulos as $art)
                        <option value="{{ $art->idArticulo }}_{{ $art->stock }}_{{ $art->precioPromedio }}">
                            {{ $art->articulo }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                <div class="form-group">
                    <label for="cantidad">Cantidad</label>
                    <input type="number" name="pCantidad" id="pCantidad" class="form-control" placeholder="cantidad">
                </div>
            </div>

            <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="number" disabled name="pStock" id="pStock" class="form-control" placeholder="Stock">
                </div>
            </div>

            <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                <div class="form-group">
                    <label for="precioVenta">Precio de venta</label>
                    <input type="number" disabled name="pPrecioVenta" id="pPrecioVenta" class="form-control"
                        placeholder="Precio de venta">
                </div>
            </div>

            <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                <div class="form-group">
                    <label for="descuento">Descuento</label>
                    <input type="number" name="pDescuento" id="pDescuento" class="form-control" placeholder="Descuento">
                </div>
            </div>

            <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                <div class="form-group" style="margin-top: 23.8px;">
                    <button type="button" id="btnAdd" class="btn btn-primary">Agregar</button>
                </div>
            </div>

            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                    <thead style="background-color: #DA602F;">
                        <th class="text-center">Opciones</th>
                        <th class="text-center">Artículo</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-center">Precio de Venta</th>
                        <th class="text-center">Descuento</th>
                        <th class="text-center">Subtotal</th>
                    </thead>
                    <tfoot>
                        <th class="text-center" style="vertical-align: middle">Total</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>
                            <h4 class="text-center" id="total">C$ 0.00</h4> <input type="hidden" name="totalVenta"
                                id="totalVenta">
                        </th>
                    </tfoot>
                    <tbody></tbody>
                </table>
            </div>

        </div>
    </div>

    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12" id="guardar">
        <div class="form-group" style="margin-top: 15px;">
            <input name="_token" value="{{ csrf_token() }}" type="hidden">
            <button class="btn btn-primary" type="submit">Guardar</button>
            <button class="btn btn-danger" type="reset"><a href="{{url('ventas/venta')}}"
                    style="text-decoration: none; color: white;">Cancelar</a></button>
        </div>
    </div>

</div>

{!!Form::close()!!}

@push ('scripts')

<script>
$(document).ready(function() {
    $('#btnAdd').click(function() {
        agregar();
    });
})

var cont = 0;
total = 0;
subtotal = [];
$("#guardar").hide();
$("#pIdArticulo").change(mostrarValores);

function mostrarValores() {
    datosArticulo = document.getElementById('pIdArticulo').value.split('_');
    $("#pPrecioVenta").val(datosArticulo[2]);
    $("#pStock").val(datosArticulo[1]);

}

function agregar() {

    datosArticulo = document.getElementById('pIdArticulo').value.split('_');

    idArticulo = datosArticulo[0];
    articulo = $("#pIdArticulo option:selected").text();
    cantidad = parseInt($("#pCantidad").val());
    // cantidad = parseInt(cant);
    descuento = $("#pDescuento").val();
    // precioCompra = parseFloat(pCompra);
    precioVenta = $("#pPrecioVenta").val();
    // precioVenta = parseFloat(pVenta);
    stock = parseInt($("#pStock").val());

    if (idArticulo != "" && cantidad != "" && cantidad > 0 && descuento != "" && precioVenta != "") {

        if (stock >= cantidad) {
            subtotal[cont] = (cantidad * (precioVenta - descuento));
            total = total + subtotal[cont];

            var fila = `
                <tr class="selected" id="fila${cont}">
                <td class="text-center" style="vertical-align: middle"><button type="button" class="btn btn-warning" onclick="eliminar(${cont});">X</td>
                <td class="text-center" style="vertical-align: middle"><input class="text-center" style="vertical-align: middle" type="hidden" name="idArticulo[]" value="${idArticulo}">${articulo}</td>
                <td class="text-center" style="vertical-align: middle"><input type="hidden" name="cantidad[]" value="${cantidad}">${cantidad}</td>
                <td class="text-center" style="vertical-align: middle"><input type="hidden" name="precioVenta[]" value="${precioVenta}">${precioVenta}</td>
                <td class="text-center" style="vertical-align: middle"><input type="hidden" name="descuento[]" value="${descuento}">${descuento}</td>
                <td class="text-center" style="vertical-align: middle">${subtotal[cont]}</td>
            `;

            cont++;

            limpiar();
            $('#total').html("C$ " + total);
            $("#totalVenta").val(total);
            evaluar();
            $('#detalles').append(fila);
        } else {
            alert("La cantidad a vender supera el stock");
        }

    } else {
        alert("Error al ingresar el detalle de la venta. Revisa correctamente los campos a rellenar");
    }
}

function limpiar() {
    $("#pCantidad").val("");
    $("#pDescuento").val("");
    $("#pPrecioVenta").val("");
}


function evaluar() {
    if (total > 0) {
        $("#guardar").show();
    } else {
        $("#guardar").hide();
    }
}

function eliminar(index) {
    total = total - subtotal[index];
    $("#total").html("C$ " + total);
    $("#total_venta").val(total);
    $("#fila" + index).remove();
    evaluar();
}
</script>

@endpush

@endsection