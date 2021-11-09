<?php

namespace CompraVenta\Http\Controllers;

use Illuminate\Http\Request;
use CompraVenta\Http\Requests;

use CompraVenta\Ingreso;
use CompraVenta\DetalleIngreso;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use CompraVenta\Http\Requests\IngresoFormRequest;
use DB;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;
use PhpParser\Node\Stmt\TryCatch;

class IngresoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText'));
            $ingresos = DB::table('ingreso as ing')
                ->join('persona as p', 'ing.idProveedor', '=', 'p.idPersona')
                ->join('detalleingreso as det', 'ing.idIngreso', '=', 'det.idIngreso')
                ->select(
                    'ing.idIngreso',
                    'ing.fechaHora',
                    'p.nombre',
                    'ing.tipoComprobante',
                    'ing.serieComprobante',
                    'ing.numComprobante',
                    'ing.impuesto',
                    'ing.estado',
                    DB::raw('sum(det.cantidad * precioCompra) as total')
                )
                ->where('ing.numComprobante', 'LIKE', '%' . $query . '%')
                ->orwhere('p.nombre', 'LIKE', '%' . $query . '%')
                ->orderBy('ing.idIngreso', 'desc')
                ->groupBy(
                    'ing.idIngreso',
                    'ing.fechaHora',
                    'p.nombre',
                    'ing.tipoComprobante',
                    'ing.serieComprobante',
                    'ing.numComprobante',
                    'ing.impuesto',
                    'ing.estado'
                )

                ->paginate(7);

            return view('compras.ingreso.index', ["ingresos" => $ingresos, "searchText" => $query]);
        }
    }

    public function create()
    {
        $personas = DB::table('persona')->where('tipoPersona', '=', 'Proveedor')->get();
        $articulos = DB::table('articulo as art')
            ->select(DB::raw('CONCAT(art.codigo, " ", art.nombre) AS articulo'), 'art.idArticulo')
            ->where('art.estado', '=', 'Activo')->get();
        return view("compras.ingreso.create", ["personas" => $personas, "articulos" => $articulos]);
    }

    public function store(IngresoFormRequest $request)
    {
        try {
            DB::beginTransaction();
            $ingreso = new Ingreso;
            $ingreso->idProveedor = $request->get('idProveedor');
            $ingreso->tipoComprobante = $request->get('tipoComprobante');
            $ingreso->serieComprobante = $request->get('serieComprobante');
            $ingreso->numComprobante = $request->get('numComprobante');
            // OBTENIENDO EL TIEMPO DE LA ZONA LOCAL
            $myTime = Carbon::now('America/Managua');
            $ingreso->fechaHora = $myTime->toDateTimeString();
            $ingreso->impuesto = '10';
            $ingreso->estado = 'A';
            $ingreso->save();

            $idArticulo = $request->get('idArticulo');
            $cantidad = $request->get('cantidad');
            $precioCompra = $request->get('precioCompra');
            $precioVenta = $request->get('precioVenta');

            $cont = 0;
            while ($cont < count($idArticulo)) {
                $detalle = new DetalleIngreso();
                $detalle->idIngreso = $ingreso->idIngreso;
                $detalle->idArticulo = $idArticulo[$cont];
                $detalle->cantidad = $cantidad[$cont];
                $detalle->precioCompra = $precioCompra[$cont];
                $detalle->precioVenta = $precioVenta[$cont];
                $detalle->save();

                $cont = $cont + 1;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return Redirect::to('compras/ingreso');
    }

    public function show($id)
    {
        $ingreso = DB::table('ingreso as ing')
            ->join('persona as p', 'ing.idProveedor', '=', 'p.idPersona')
            ->join('detalleingreso as det', 'ing.idIngreso', '=', 'det.idIngreso')
            ->select(
                'ing.idIngreso',
                'ing.fechaHora',
                'p.nombre',
                'ing.tipoComprobante',
                'ing.serieComprobante',
                'ing.numComprobante',
                'ing.impuesto',
                'ing.estado',
                DB::raw('sum(det.cantidad * precioCompra) as total')
            )
            ->where('ing.idIngreso', '=', $id)
            ->groupBy(
                'ing.idIngreso',
                'ing.fechaHora',
                'p.nombre',
                'ing.tipoComprobante',
                'ing.serieComprobante',
                'ing.numComprobante',
                'ing.impuesto',
                'ing.estado'
            )
            ->first();

        $detalles = DB::table('detalleingreso as det')
            ->join('articulo as art', 'det.idArticulo', '=', 'art.idArticulo')
            ->select('art.nombre as articulo', 'det.cantidad', 'det.precioCompra', 'det.precioVenta')
            ->where('det.idIngreso', '=', $id)->get();

        return view("compras.ingreso.show", ["ingreso" => $ingreso, "detalles" => $detalles]);
    }

    public function destroy($id)
    {
        $ingreso = Ingreso::findOrFail($id);
        $ingreso->estado = 'C';
        $ingreso->update();
        return Redirect::to('compras/ingreso');
    }
}