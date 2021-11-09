<?php

namespace CompraVenta\Http\Controllers;

use Illuminate\Http\Request;
use CompraVenta\Http\Requests;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use CompraVenta\Http\Requests\VentaFormRequest;
use CompraVenta\Venta;
use CompraVenta\DetalleVenta;
use DB;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class VentaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText'));
            $ventas = DB::table('venta as vt')
                ->join('persona as p', 'vt.idCliente', '=', 'p.idPersona')
                ->join('detalleventa as dvt', 'vt.idVenta', '=', 'dvt.idVenta')
                ->select(
                    'vt.idVenta',
                    'vt.fechaHora',
                    'p.nombre',
                    'vt.tipoComprobante',
                    'vt.serieComprobante',
                    'vt.numComprobante',
                    'vt.impuesto',
                    'vt.estado',
                    'vt.totalVenta'
                )
                ->where('vt.numComprobante', 'LIKE', '%' . $query . '%')
                // ->orwhere('p.nombre', 'LIKE', '%' . $query . '%')
                ->orderBy('vt.idVenta', 'desc')
                ->groupBy(
                    'vt.idVenta',
                    'vt.fechaHora',
                    'p.nombre',
                    'vt.tipoComprobante',
                    'vt.serieComprobante',
                    'vt.numComprobante',
                    'vt.impuesto',
                    'vt.estado'
                )

                ->paginate(7);

            return view('ventas.venta.index', ["ventas" => $ventas, "searchText" => $query]);
        }
    }

    public function create()
    {
        $personas = DB::table('persona')->where('tipoPersona', '=', 'Cliente')->get();
        $articulos = DB::table('articulo as art')
            ->join('detalleIngreso as di', 'art.idArticulo', '=', 'di.idArticulo')
            ->select(
                DB::raw('CONCAT(art.codigo, " ", art.nombre) AS articulo'),
                'art.idArticulo',
                'art.stock',
                DB::raw('avg(di.precioVenta) as precioPromedio')
                // DB::raw('avg(di.precioVenta) as precioPromedio'),
            )
            ->where('art.estado', '=', 'Activo')
            ->where('art.stock', '>', '0')
            ->groupBy('articulo', 'art.idArticulo', 'art.stock')
            ->get();
        return view("ventas.venta.create", ["personas" => $personas, "articulos" => $articulos]);
    }

    public function store(VentaFormRequest $request)
    {
        try {
            DB::beginTransaction();
            $venta = new Venta;
            $venta->idCliente = $request->get('idCliente');
            $venta->tipoComprobante = $request->get('tipoComprobante');
            $venta->serieComprobante = $request->get('serieComprobante');
            $venta->numComprobante = $request->get('numComprobante');
            $venta->totalVenta = $request->get('totalVenta');
            // OBTENIENDO EL TIEMPO DE LA ZONA LOCAL
            $myTime = Carbon::now('America/Managua');
            $venta->fechaHora = $myTime->toDateTimeString();
            $venta->impuesto = '15';
            $venta->estado = 'A';
            $venta->save();

            $idArticulo = $request->get('idArticulo');
            $cantidad = $request->get('cantidad');
            $descuento = $request->get('descuento');
            $precioVenta = $request->get('precioVenta');

            $cont = 0;
            while ($cont < count($idArticulo)) {
                $detalle = new DetalleVenta();
                $detalle->idVenta = $venta->idVenta;
                $detalle->idArticulo = $idArticulo[$cont];
                $detalle->cantidad = $cantidad[$cont];
                $detalle->descuento = $descuento[$cont];
                $detalle->precioVenta = $precioVenta[$cont];
                $detalle->save();

                $cont = $cont + 1;
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }

        return Redirect::to('ventas/venta');
    }

    public function show($id)
    {
        $venta = DB::table('venta as vt')
            ->join('persona as p', 'vt.idCliente', '=', 'p.idPersona')
            ->join('detalleventa as detV', 'vt.idVenta', '=', 'detV.idVenta')
            ->select(
                'vt.idVenta',
                'vt.fechaHora',
                'p.nombre',
                'vt.tipoComprobante',
                'vt.serieComprobante',
                'vt.numComprobante',
                'vt.impuesto',
                'vt.estado',
                'vt.totalVenta'
            )
            ->where('vt.idVenta', '=', $id)
            ->groupBy(
                'vt.idVenta',
                'vt.fechaHora',
                'p.nombre',
                'vt.tipoComprobante',
                'vt.serieComprobante',
                'vt.numComprobante',
                'vt.impuesto',
                'vt.estado'
            )
            ->first();

        $detalles = DB::table('detalleventa as det')
            ->join('articulo as art', 'det.idArticulo', '=', 'art.idArticulo')
            ->select('art.nombre as articulo', 'det.cantidad', 'det.descuento', 'det.precioVenta')
            ->where('det.idVenta', '=', $id)
            ->get();

        return view("ventas.venta.show", ["venta" => $venta, "detalles" => $detalles]);
    }

    public function destroy($id)
    {
        $venta = Venta::findOrFail($id);
        $venta->estado = 'Cancelado';
        $venta->update();
        return Redirect::to('ventas/venta');
    }
}