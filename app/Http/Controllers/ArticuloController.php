<?php

namespace CompraVenta\Http\Controllers;

use Illuminate\Http\Request;
use CompraVenta\Http\Requests;

use CompraVenta\Articulo;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use CompraVenta\Http\Requests\ArticuloFormRequest;
use DB;

class ArticuloController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText')); //trim es para quitar los espacios de inicio y final
            $articulos = DB::table('articulo as a')
                ->join('categoria as c', 'a.idCategoria', '=', 'c.idCategoria')
                ->select(
                    'a.idArticulo',
                    'a.nombre',
                    'a.codigo',
                    'a.stock',
                    'c.nombre as categoria',
                    'a.descripcion',
                    'a.imagen',
                    'a.estado'
                )
                ->where('a.nombre', 'LIKE', '%' . $query . '%', 'OR', 'a.descripcion', 'LIKE', '%' . $query . '%')
                ->orwhere('a.codigo', 'LIKE', '%' . $query . '%')
                ->orderBy('idArticulo', 'asc')
                ->paginate(7);

            return view('almacen.articulo.index', ["articulos" => $articulos, "searchText" => $query]);
        }
    }

    public function create()
    {
        $categorias = DB::table('categoria')->where('condicion', '=', '1')->get();
        return view("almacen.articulo.create", ["categorias" => $categorias]);
    }

    public function store(ArticuloFormRequest $request)
    {
        $articulo = new Articulo;
        $articulo->idcategoria = $request->get('idCategoria');

        if (Articulo::where('codigo', '=', Input::get('codigo'))->exists()) {
            return back()->with('mensaje', 'El código ingresado ya existe en el sistema');
        } else {
            $articulo->codigo = $request->get('codigo');
        }

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

        return Redirect::to('almacen/articulo');
    }

    public function show($id)
    {
        return view("almacen.articulo.show", ["articulo" => Articulo::findOrFail($id)]);
    }

    public function edit($id)
    {
        $articulo = Articulo::findOrFail($id);
        $categorias = DB::table('categoria')->where('condicion', '=', '1')->get();
        return view("almacen.articulo.edit", ["articulo" => $articulo, "categorias" => $categorias]);
    }

    public function update(ArticuloFormRequest $request, $id)
    {
        $articulo = Articulo::findOrFail($id);
        $articulo->idcategoria = $request->get('idCategoria');
        $articulo->codigo = $request->get('codigo');
        $articulo->nombre = $request->get('nombre');
        $articulo->stock = $request->get('stock');
        $articulo->descripcion = $request->get('descripcion');
        // CARGANDO LA IMAGEN
        if (Input::hasFile('imagen')) {
            $file = Input::file('imagen');
            $file->move(public_path() . '/imagenes/articulos/', $file->getClientOriginalName());
            $articulo->imagen = $file->getClientOriginalName();
        }
        $articulo->update();

        return Redirect::to('almacen/articulo');
    }

    public function destroy($id)
    {
        $articulo = Articulo::findOrFail($id);
        $articulo->estado = 'Inactivo';
        $articulo->stock = 0;
        $articulo->update();
        return Redirect::to('almacen/articulo');
    }
}