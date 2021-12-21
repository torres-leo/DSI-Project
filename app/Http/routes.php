<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\App\Articulo;

Route::get('/', function () {
    return view('auth/login');
});

// ACA VAN TODAS LAS VISTAS PARA CADA UNO DE LOS MODULOS
Route::resource('almacen/categoria', 'CategoriaController');
Route::resource('almacen/articulo', 'ArticuloController');
Route::resource('ventas/cliente', 'ClienteController');
Route::resource('compras/proveedor', 'ProveedorController');
Route::resource('compras/ingreso', 'IngresoController');
Route::resource('ventas/venta', 'VentaController');
Route::resource('seguridad/usuario', 'UsuarioController');
Route::auth();

// ACÁ VAN LAS VISTAS DE LOS METODOS QUE GENERAN EL PDF
Route::get('articulo-pdf', 'ArticuloController@artPDF')->name('articulos.pdf');
Route::get('categoria-pdf', 'CategoriaController@catPDF')->name('categorias.pdf');
Route::get('usuario-pdf', 'UsuarioController@UserPDF')->name('usuario.pdf');
Route::get('Proveedor-pdf', 'ProveedorController@provPDF')->name('proveedor.pdf');
Route::get('Cliente-pdf', 'ClienteController@clientPDF')->name('cliente.pdf');

Route::get('/home', 'HomeController@index');
Route::get('/{slug?}', 'HomeController@index');