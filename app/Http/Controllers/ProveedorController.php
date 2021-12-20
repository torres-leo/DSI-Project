<?php

namespace CompraVenta\Http\Controllers;

use Illuminate\Http\Request;
use CompraVenta\Http\Requests;

use CompraVenta\Persona;
use Illuminate\Support\Facades\Redirect;
use CompraVenta\Http\Requests\PersonaFormRequest;
use DB;
use Barryvdh\DomPDF\Facade as PDF;


class ProveedorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText')); //trim es para quitar los espacios de inicio y final
            $personas = DB::table('persona')
                ->where('nombre', 'LIKE', '%' . $query . '%')
                ->where('tipoPersona', '=', 'Proveedor')
                ->orwhere('numDocumento', 'LIKE', '%' . $query . '%')
                ->where('tipoPersona', '=', 'Proveedor')
                ->orderBy('idPersona', 'desc')
                ->paginate(7);

            return view('compras.proveedor.index', ["personas" => $personas, "searchText" => $query]);
        }
    }

    public function create()
    {
        return view("compras.proveedor.create");
    }

    public function store(PersonaFormRequest $request)
    {
        $persona = new Persona;
        $persona->tipoPersona = 'Proveedor';
        $persona->nombre = $request->get('nombre');
        $persona->tipoDocumento = $request->get('tipoDocumento');
        $persona->numDocumento = $request->get('numDocumento');
        $persona->direccion = $request->get('direccion');
        $persona->telefono = $request->get('telefono');
        $persona->email = $request->get('email');
        $persona->save();

        return Redirect::to('compras/proveedor');
    }

    public function show($id)
    {
        return view("compras.proveedor.show", ["persona" => Persona::findOrFail($id)]);
    }

    public function edit($id)
    {
        return view("compras.proveedor.edit", ["persona" => Persona::findOrFail($id)]);
    }

    public function update(PersonaFormRequest $request, $id)
    {
        $persona = Persona::findOrFail($id);
        $persona->nombre = $request->get('nombre');
        $persona->tipoDocumento = $request->get('tipoDocumento');
        $persona->numDocumento = $request->get('numDocumento');
        $persona->direccion = $request->get('direccion');
        $persona->telefono = $request->get('telefono');
        $persona->email = $request->get('email');
        $persona->update();

        return Redirect::to('compras/proveedor');
    }

    public function destroy($id)
    {
        $persona = Persona::findOrFail($id);
        $persona->tipoPersona = 'Inactivo';
        $persona->update();
        return Redirect::to('compras/proveedor');
    }

    public function provPDF()
    {
        // $proveedores = Persona::get();
        // $proveedores = Persona::all()->where('tipoPersona', '=', 'Proveedor');

        $proveedores = DB::table('persona')
            ->where('tipoPersona', '=', 'Proveedor')
            ->get();

        $pdf = PDF::loadView('compras.proveedor.provPDF', compact('proveedores'));
        return $pdf->stream('ListaProveedores.pdf');
        // return $pdf->download('ListaCategorias.pdf');
    }
}