<?php

namespace CompraVenta\Http\Controllers;

use Illuminate\Http\Request; // PARA OBTENER LOS VALORES DE LOS INPUT EN UNA VARIABLE TEMPORAL
use CompraVenta\Http\Requests; // PARA REALIZAR LAS VALIDACIONES
use CompraVenta\Persona; //LLAMANDO AL MODELO 'PERSONA'
use Illuminate\Support\Facades\Redirect; // PARA HACER REDIRECCIONES DE PAGINAS
use CompraVenta\Http\Requests\PersonaFormRequest; // PARA OBTENER LAS VALIDACIONES DE LOS CAMPOS CORRESPONDIENTE AL MODELO
use DB; //PARA CONECTAR A LA BD
use Barryvdh\DomPDF\Facade as PDF; // PARA GENERAR REPORTES


class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // CARGANDO LOS DATOS NECESARIOS PARA LA VISTA PRINCIPAL
        if ($request) {
            $query = trim($request->get('searchText')); //trim es para quitar los espacios de inicio y final
            $personas = DB::table('persona') //CONECTANDO A LA TABLA DE PERSONA
                ->where('nombre', 'LIKE', '%' . $query . '%')
                ->where('tipoPersona', '=', 'Cliente')
                ->orwhere('numDocumento', 'LIKE', '%' . $query . '%')
                ->where('tipoPersona', '=', 'Cliente')
                ->orderBy('idPersona', 'desc')
                ->paginate(7);

            // RETORNANDO LOS DATOS A UNA VISTA
            return view('ventas.cliente.index', ["personas" => $personas, "searchText" => $query]);
        }
    }

    // GENERAR UN NUEVO REGISTRO
    public function create()
    {
        return view("ventas.cliente.create"); // REDIRIGIR A LA VISTA CREATE
    }

    // ALMACENANDO LOS DATOS DEL NUEVO REGISTRO
    public function store(PersonaFormRequest $request)
    {
        // INSTANCIANDO EL MODELO
        $persona = new Persona;
        // CAPTURANDO LOS DATOS 
        $persona->tipoPersona = 'Cliente';
        $persona->nombre = $request->get('nombre');
        $persona->tipoDocumento = $request->get('tipoDocumento');
        $persona->numDocumento = $request->get('numDocumento');
        $persona->direccion = $request->get('direccion');
        $persona->telefono = $request->get('telefono');
        $persona->email = $request->get('email');
        // UNA VEZ CAPTURADOS LOS DATOS SE GUARDAN CON EL METODO SAVE
        $persona->save();

        // REDIRIGIENDO A LA VISTA PRINCIPAL DE CLIENTES
        return Redirect::to('ventas/cliente');
    }

    // BUSCAR POR ID, PARA MOSTRAR EN EL INDEX
    public function show($id)
    {
        return view("ventas.cliente.show", ["persona" => Persona::findOrFail($id)]); // BUSCANDO POR ID
    }

    // BUSCAR POR ID, PARA MODIFICAR
    public function edit($id)
    {
        return view("ventas.cliente.edit", ["persona" => Persona::findOrFail($id)]);
    }

    // ACTUALIZAR UN REGISTRO
    public function update(PersonaFormRequest $request, $id)
    {
        // CAPTURANDO EL ID DEL REGISTRO SELECCIONADO
        $persona = Persona::findOrFail($id);
        // CAPTURANDO LOS VALORES INGRESADOS
        $persona->nombre = $request->get('nombre');
        $persona->tipoDocumento = $request->get('tipoDocumento');
        $persona->numDocumento = $request->get('numDocumento');
        $persona->direccion = $request->get('direccion');
        $persona->telefono = $request->get('telefono');
        $persona->email = $request->get('email');
        // UNA VEZ CAPTURADOS LOS VALORES, SE PROCEDEN A GUARDAR CON EL METODO UPDATE
        $persona->update();

        // UNA VEZ GUARDADOS, PROCEDE A REDIRIGIR A LA VISTA PRINCIPAL DE CLIENTE
        return Redirect::to('ventas/cliente');
    }

    // ELIMINAR O DESHABILITAR
    public function destroy($id)
    {
        $persona = Persona::findOrFail($id); // BUSCAR POR EL ID SELECCIONADO
        $persona->tipoPersona = 'Inactivo'; // HACIENDO LA MODIFICACION
        $persona->update(); // GUARDANDO
        // REDIRIGIR A LA VISTA PRINCIPAL DE CLIENTE
        return Redirect::to('ventas/cliente');
    }

    // GENERANDO REPORTES
    public function clientPDF()
    {
        // $proveedores = Persona::get();
        // $proveedores = Persona::all()->where('tipoPersona', '=', 'Proveedor');

        // CAPTURANDO LOS DATOS NECESARIOS PARA MOSTRAR EN EL REPORTE
        $clientes = DB::table('persona')
            ->where('tipoPersona', '=', 'Cliente') // QUE TRAIGA TODOS LOS QUE EN 'TIPO PERSONA' SEAN IGUAL A 'CLIENTE'
            ->get(); // OBTENIENDO ESOS REGISTROA

        // CARGANDO LOS DATOS A UNA VARIABLE, PARA QUE ME LO MUESTRE EN UNA VISTA
        $pdf = PDF::loadView('ventas.cliente.clientPDF', compact('clientes'));
        // STREAM ES UN METODO PARA QUE LO ABRA EN EL NAVEGADOR
        return $pdf->stream('ListaClientes.pdf');
        // return $pdf->download('ListaCategorias.pdf');
    }
}