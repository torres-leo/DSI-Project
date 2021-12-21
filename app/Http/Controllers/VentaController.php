<?php

namespace CompraVenta\Http\Controllers;

use Illuminate\Http\Request; // Para capturar valores 
use CompraVenta\Http\Requests; // PARA LAS VALIDACIONES
use Illuminate\Support\Facades\Redirect; // PARA REDIRIGIR A PAGINAS
use Illuminate\Support\Facades\Input; // PARA VERIFICAR ENTRADAS EN LOS INPUT
use CompraVenta\Http\Requests\VentaFormRequest; // PARA TRAER LAS VALIDACIONES PLANTEADAS EN LOS CAMPOS DE LA TABLA VENTA
use CompraVenta\Venta; // LLAMANDO A MODELO VENTA
use CompraVenta\DetalleVenta; // LLAMANDO AL MODELO DETALLE VENTA
use DB; // CONEXION A LA BD

use Carbon\Carbon; //OBTENER ZONA HORARIA

// ESTOS NO SE ESTAN UTILIZANDO
use Response;
use Illuminate\Support\Collection;

class VentaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); //VERIFICANDO SI EXISTE UNA SESION DE UN USUARIO ACTIVO EN EL MOMENTO
    }

    public function index(Request $request)
    {
        // MOSTRANDO LOS DATOS NECESARIOS EN EL INDEX
        if ($request) {
            $query = trim($request->get('searchText')); //PARA BUSCAR UNA VENTA, SEGUN EL NUMERO DE COMPROBANTE
            $ventas = DB::table('venta as vt')
                ->join('persona as p', 'vt.idCliente', '=', 'p.idPersona') //UNIENDNO A LA TABLA PERSONA PARA OBTENER EL REGISTRO DE ELLA
                ->join('detalleventa as dvt', 'vt.idVenta', '=', 'dvt.idVenta') //UNIENDO A LA TABLA DETALLE PARA OBTENER LOS VALORES REQUERIDOS
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
                ->orderBy('vt.idVenta', 'desc') // ORDENANDO DE MAYOR A MENOR 
                // AGRUPARLOS O ORDENARLOS DE LA SIGUIENTE MANERA
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

                ->paginate(7); //SOLO 7 REGISTROS DEBERAN MOSTRAR EN EL INDEX

            // DICIENDO QUE TODO LOS VALORES CAPTURADOS, DEBEN RETORNAR A LA SIGUIENTE VISTA
            return view('ventas.venta.index', ["ventas" => $ventas, "searchText" => $query]);
        }
    }

    // CREANDO NUEVA VENTA
    public function create()
    {
        $personas = DB::table('persona')->where('tipoPersona', '=', 'Cliente')->get(); //OBTENIENDO A LAS PERSONAS QUE SON DE TIPO CLIENTE
        $articulos = DB::table('articulo as art') // MANDANDO A CAPTURAR LOS PARAMETROS DE ARTICULOS QUE QUIERO MOSTRAR
            ->join('detalleIngreso as di', 'art.idArticulo', '=', 'di.idArticulo')
            ->select(
                DB::raw('CONCAT(art.codigo, " ", art.nombre) AS articulo'), //CONCATENANDO CODIGO Y NOMBRE DEL ARTICULO PARA QUE LO MUESTRE JUNTO
                'art.idArticulo',
                'art.stock',
                DB::raw('avg(di.precioVenta) as precioPromedio') //MANDANDO A OBTENER EL PRECIO DEL ARTICULO
                // DB::raw('avg(di.precioVenta) as precioPromedio'),
            )
            ->where('art.estado', '=', 'Activo') // MOSTRANDO LOS QUE SON ARTICULOS ACTIVOS
            ->where('art.stock', '>', '0') //MOSTRANDO QUE EN SU STOCK SEA MAYORES QUE 0
            ->groupBy('articulo', 'art.idArticulo', 'art.stock')
            ->get();

        // UNA VEZ CAPTURADOS TODOS LOS VALORES, QUIERO QUE LO MUESTRE EN LA SIGUIENTE VISTA
        return view("ventas.venta.create", ["personas" => $personas, "articulos" => $articulos]);
    }

    // GENERANDO VENTA
    public function store(VentaFormRequest $request)
    {
        try {
            DB::beginTransaction(); // SE REALIZARAN ACCIONES EN LA BD, TRIGGER 
            // INSTANCIANDO AL MODELO VENTA
            $venta = new Venta;
            // CAPTURANDO LOS VALORES QUE SE INGRESEN EN LOS INPUT
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
            // GUARDANDO DATOS
            $venta->save();

            // CAPTURANDO LOS DATOS PARA EL DETALLE VENTA
            $idArticulo = $request->get('idArticulo');
            $cantidad = $request->get('cantidad');
            $descuento = $request->get('descuento');
            $precioVenta = $request->get('precioVenta');

            // GENERANDO UN CARRITO DE VENTA, PARA QUE SE PUEDA REALIZAR LA VENTA DE MÁS DE UN ARTICULO
            $cont = 0; //INICIANDO UN CONTADOR EN 0
            while ($cont < count($idArticulo)) { // MIENTRAS CONTADOR SEA MENOR A LA SUMA DE ARTICULOS A AGREGAR, NO SE REALIZARÁ NADA
                // INSTANCIANDO EL MODELO DETALLEVENTA
                $detalle = new DetalleVenta();
                // CAPTURANDO LOS VALORES Y GUARDANDO DE FORMA TEMPORAL EN EL CONTADOR, SERVIRA COMO CARRITO DE VENTA
                $detalle->idVenta = $venta->idVenta;
                $detalle->idArticulo = $idArticulo[$cont];
                $detalle->cantidad = $cantidad[$cont];
                $detalle->descuento = $descuento[$cont];
                $detalle->precioVenta = $precioVenta[$cont];
                // GUARDANDO LOS DATOS DE DETALLE
                $detalle->save();

                // INCREMENTANDO EL VALOR EN CASO QUE SE VAYA SELECCIONANDO OTROS ARTICULOS
                $cont = $cont + 1;
            }

            DB::commit(); //TERMINANDO EL PROCESO QUE SE INICIO
        } catch (Exception $e) {
            DB::rollback(); //CAPTURANDO ERRORES EN EL PROCESO
        }

        // REDIRIGIENDO A LA VISTA PRINCIPAL DE VENTA
        return Redirect::to('ventas/venta');
    }

    // BUSCAR POR ID, PARA MOSTRAR EN EL INDEX 
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
            ->where('vt.idVenta', '=', $id) // En caso que se busque un registro, que verifique su id y mande a mostrarlo segun los parametros siguientes
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

        // MANDANDO A CAPTURAR LOS DATOS DE DETALLE VENTA SEGUN LOS REGISTROS
        $detalles = DB::table('detalleventa as det')
            ->join('articulo as art', 'det.idArticulo', '=', 'art.idArticulo')
            ->select('art.nombre as articulo', 'det.cantidad', 'det.descuento', 'det.precioVenta')
            ->where('det.idVenta', '=', $id)
            ->get();

        // UNA VEZ CAPTURADO LOS DATOS, QUE ME RETORNE EN LA SIGUIENTE VISTA
        return view("ventas.venta.show", ["venta" => $venta, "detalles" => $detalles]);
    }





    // ESTE METODO YA NO SE MUESTRA MANDA A MOSTRAR 
    public function destroy($id)
    {
        $venta = Venta::findOrFail($id);
        $venta->estado = 'Cancelado';
        $venta->update();
        return Redirect::to('ventas/venta');
    }
}