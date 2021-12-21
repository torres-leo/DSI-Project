<?php

namespace CompraVenta\Http\Controllers;

use Illuminate\Http\Request; // Para capturar el valor que se ingresa en los input
use CompraVenta\Http\Requests; // Validaciones de parametros
use CompraVenta\Categoria; // Llamando el modelo Categoria
use Illuminate\Support\Facades\Redirect; //Para redirigir las páginas
use CompraVenta\Http\Requests\CategoriaFormRequest; // Para validar las entradas de texto de cada atributo
use DB; //Para realizar la conexion
use Barryvdh\DomPDF\Facade as PDF; // Para generar reportes


class CategoriaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth'); //Ver si hay un usuario activo ahora mismo
    }

    // CAPTURANDO LOS VALORES QUE QUIERO QUE SE MUESTREN EN EL INDEX
    public function index(Request $request)
    {
        // EN ESTE METODO SE REALIZAN LA VISTA DEL INDEX Y EL BUSCAR
        if ($request) {
            $query = trim($request->get('searchText')); //trim es para quitar los espacios de inicio y final
            $categorias = DB::table('categoria')
                ->where('nombre', 'LIKE', '%' . $query . '%', 'OR', 'descripcion', 'LIKE', '%' . $query . '%')
                // ->orwhere('descripcion', 'LIKE', '%' . $query . '%') //Haciendolo de esta forma no funciona
                ->where('condicion', '=', '1')
                ->orderBy('idCategoria', 'desc')
                ->paginate(7);

            // UNA VEZ CAPTURADO LOS VALORES QUE QUIERO MOSTRAR, ME LOS DEBE RETORNAR A LA SIGUIENTE VISTA
            return view('almacen.categoria.index', ["categorias" => $categorias, "searchText" => $query]); //LA VARIABLE QUERY ES EN CASO QUE QUIERA BUSCAR UNA CATEGORIA
        }
    }

    // CREATE ME GENERA UNA NUEVA VISTA, PARA CREAR UNA NUEVA CATEGORIA
    public function create()
    {
        return view("almacen.categoria.create");
    }

    // PARA ALMACENAR LOS VALORES DE LA VISTA CREATE
    public function store(CategoriaFormRequest $request)
    {
        $categoria = new Categoria;
        // CAPTURANDO LOS PARAMETROS INSERTADOS EN LOS INPUT
        $categoria->nombre = $request->get('nombre');
        $categoria->descripcion = $request->get('descripcion');
        $categoria->condicion = '1';
        $categoria->save();

        // UNA VEZ CAPTURADOS ME REDIRIGE A LA VISTA PRINCIPAL DE CATEGORIA
        return Redirect::to('almacen/categoria');
    }

    // BUSCAR POR ID, PARA MOSTRAR EN EL INDEX
    public function show($id)
    {
        return view("almacen.categoria.show", ["categoria" => Categoria::findOrFail($id)]);
    }

    // BUSCANDO POR ID, PARA REALIZAR UNA MODIFICACION
    public function edit($id)
    {
        return view("almacen.categoria.edit", ["categoria" => Categoria::findOrFail($id)]);
    }

    // PARA ACTUALIZAR UN REGISTRO
    public function update(CategoriaFormRequest $request, $id)
    {
        $categoria = Categoria::findOrFail($id); // CAPTURAR EL ID DEL REGISTRO SELECCIONADO
        // CAPTURANDO LOS DATOS NUEVOS
        $categoria->nombre = $request->get('nombre');
        $categoria->descripcion = $request->get('descripcion');
        $categoria->update();

        // REDIRIGIR A LA VISTA PRINCIPAL DE CATEGORIA
        return Redirect::to('almacen/categoria');
    }

    // METODO DE ELIMINAR O DESHABILITAR
    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id); // BUSCANDO POR ID SELECCIONADO
        $categoria->condicion = '0'; // ACTUALIZAR SU CAMPO
        $categoria->update(); // GUARDANDO CON LOS NUEVOS VALORES

        // REDIRIGIENDO A LA VISTA PRINCIPAL DE CATEGORIA
        return Redirect::to('almacen/categoria');
    }

    // CREANDO EL PDF
    public function catPDF()
    {
        $categorias = DB::table('categoria')->get(); //ACCEDIENDO A LA TABLA Y OBTENIEDO TODOS LOS VALORES

        // CARGANDO LOS DATOS A UNA VARIABLE, PARA QUE ME LO MUESTRE EN UNA VISTA
        $pdf = PDF::loadView('almacen.categoria.catPDF', compact('categorias'));
        // STREAM ES UN METODO PARA QUE LO ABRA EN EL NAVEGADOR
        return $pdf->stream('ListaCategorias.pdf');
        // return $pdf->download('ListaCategorias.pdf');
    }
}