<?php

namespace CompraVenta\Http\Controllers;

// LLAMANDO LAS "CLASES" QUE SE VAN A UTILIZAR PARA LOS METODOS

use Illuminate\Http\Request; // Para capturar el valor que ingresa en los input
use CompraVenta\Http\Requests; // Para hacer las validaciones de los valores que se ingresaron en los parametros
use CompraVenta\Articulo; // Llamando el modelo "Articulo"
use CompraVenta\Categoria; // Llamando el modelo "Categoria"
use Illuminate\Support\Facades\Redirect; // Para redirigir las páginas
use Illuminate\Support\Facades\Input; // Verificar el archivo que se carga en el Input
use CompraVenta\Http\Requests\ArticuloFormRequest; // Para traer las validaciones plantedas en Articulo
use DB; // Para conectar con la base de datos

use Barryvdh\DomPDF\Facade as PDF; // Para generar reporte


class ArticuloController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth'); //Si existe un usuario que este dentro del sistema ahora mismo
    }

    // INDEX ES LA VISTA PRINCIPAL DE CADA MODULO
    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText')); //trim es para quitar los espacios de inicio y final
            $articulos = DB::table('articulo as a')
                ->join('categoria as c', 'a.idCategoria', '=', 'c.idCategoria')
                ->select( //Aca mando a capturar los valores de las tablas 
                    'a.idArticulo',
                    'a.nombre',
                    'a.codigo',
                    'a.stock',
                    'c.nombre as categoria',
                    'a.descripcion',
                    'a.imagen',
                    'a.estado'
                )
                ->where('a.nombre', 'LIKE', '%' . $query . '%', 'OR', 'a.descripcion', 'LIKE', '%' . $query . '%') //Para el método buscar 
                ->orwhere('a.codigo', 'LIKE', '%' . $query . '%') // Para el metodo buscar
                ->orderBy('idArticulo', 'desc') // Ordenar de mayor a menor
                ->paginate(7);

            // Una vez terminado me lo debe retornar en la siguiente vista
            return view('almacen.articulo.index', ["articulos" => $articulos, "searchText" => $query]);
        }
    }

    public function create()
    {
        $categorias = DB::table('categoria')->where('condicion', '=', '1')->get(); //Mando a llamar las categorias activas
        return view("almacen.articulo.create", ["categorias" => $categorias]); //Retorno en qué vista quiero que las mande a llamar
    }

    // El método storage mando a guardar los valores de cada input correspondiente
    public function store(ArticuloFormRequest $request)
    {
        $articulo = new Articulo;
        $articulo->idcategoria = $request->get('idCategoria');

        if (Articulo::where('codigo', '=', Input::get('codigo'))->exists()) { // VERIFICANDO SI EXISTE ESE CODIGO
            return back()->with('mensaje', 'El código ingresado ya existe en el sistema');
        } else {
            $articulo->codigo = $request->get('codigo'); //EN CASO QUE NO EXISTA, ENTONCES SE CAPTURA EN LA VARIABLE
        }

        // CAPTURANDO LOS OTROS ATRIBUTOS
        $articulo->nombre = $request->get('nombre');
        $articulo->stock = $request->get('stock');
        $articulo->descripcion = $request->get('descripcion');
        $articulo->estado = 'Activo';
        // CARGANDO LA IMAGEN
        if (Input::hasFile('imagen')) {
            $file = Input::file('imagen');
            $file->move(public_path() . '/imagenes/articulos/', $file->getClientOriginalName());
            $articulo->imagen = $file->getClientOriginalName();
        }

        $articulo->save();
        // UNA VEZ QUE SE GUARDA, ME DEBE RETORNAR LA SIGUIENTE VISTA, QUE ES LA VISTA PRINCIPAL DE ARTICULOS
        return Redirect::to('almacen/articulo');
    }

    // BUSCAR POR ID, PARA MOSTRAR EN EL INDEX 
    public function show($id)
    {
        return view("almacen.articulo.show", ["articulo" => Articulo::findOrFail($id)]); //Buscando por id 
    }

    // BUSCAR POR ID, PARA MODIFICAR
    public function edit($id)
    {
        $articulo = Articulo::findOrFail($id);
        $categorias = DB::table('categoria')->where('condicion', '=', '1')->get();
        return view("almacen.articulo.edit", ["articulo" => $articulo, "categorias" => $categorias]);
    }

    // EL METODO ACTUALIZAR ES CASI IGUAL AL DE CREAR
    public function update(ArticuloFormRequest $request, $id)
    {
        $articulo = Articulo::findOrFail($id);
        // CAPTURANDO LOS VALORES DE LOS INPUT
        $articulo->idcategoria = $request->get('idCategoria');
        $articulo->codigo = $request->get('codigo');
        $articulo->nombre = $request->get('nombre');
        $articulo->stock = $request->get('stock');
        $articulo->descripcion = $request->get('descripcion');

        $stockTemp = $articulo->stock;

        if ($stockTemp == 0) {
            $articulo->estado = 'Inactivo';
        } else {
            $articulo->estado = 'Activo';
        }

        // CARGANDO LA IMAGEN
        if (Input::hasFile('imagen')) {
            $file = Input::file('imagen');
            $file->move(public_path() . '/imagenes/articulos/', $file->getClientOriginalName());
            $articulo->imagen = $file->getClientOriginalName();
        }
        $articulo->update();

        return Redirect::to('almacen/articulo');
    }

    // METODO ELIMINAR
    public function destroy($id)
    {
        $articulo = Articulo::findOrFail($id); //BUSCANDO POR ID SELECCIONADO
        $articulo->estado = 'Inactivo'; //HACIENDO LA MODIFICACION
        $articulo->stock = 0;
        $articulo->update();
        // REFIRIGIENDO A LA VISTA PRINCIPAL DE ARTICULO
        return Redirect::to('almacen/articulo');
    }

    // GENERANDO LOS REPORTES
    public function artPDF()
    {
        // CAPTURANDO LOS DATOS QUE QUIERO MOSTRAR DE LAS TABLAS
        $articulos = DB::table('articulo as art')
            ->join('categoria as cat', 'art.idCategoria', '=', 'cat.idCategoria')
            ->select(
                'art.idArticulo',
                'art.nombre',
                'art.codigo',
                'art.stock',
                'cat.nombre as categoria',
                'art.descripcion',
                'art.imagen',
                'art.estado'
            )
            ->get();

        // CARGANDO LOS DATOS A UNA VARIABLE, PARA QUE ME LO MUESTRE EN UNA VISTA
        $pdf = PDF::loadView('almacen.articulo.artPDF', compact('articulos'));
        // STREAM ES UN METODO PARA QUE LO ABRA EN EL NAVEGADOR
        return $pdf->stream('ListaArticulos.pdf');
        // return $pdf->download('ListadoArticulos.pdf');
    }
}