<?php
// Incluyendo la clase

use CompraVenta\Http\Controllers\ArticuloController;

require('PDF_MC_Table.php');

// Instanciando la clase
$pdf = new PDF_MC_Table();

// Agregando la primera pagina al documento 
$pdf->AddPage();

// Setear el inicio de margen superior en 25px
$y_axis_initial = 25;

//Seteamos el tipo de letra y creamos el título de la página. No es un encabezado no se repetirá
$pdf->SetFont('Arial', 'B', 12);

$pdf->Cell(40, 6, '', 0, 0, 'C');
$pdf->Cell(100, 6, 'LISTA DE ARTICULOS', 1, 0, 'C');
$pdf->Ln(10);

//Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra
$pdf->SetFillColor(232, 232, 232);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(58, 6, 'Nombre', 1, 0, 'C', 1);
$pdf->Cell(50, 6, utf8_decode('Categoría'), 1, 0, 'C', 1);
$pdf->Cell(30, 6, utf8_decode('Código'), 1, 0, 'C', 1);
$pdf->Cell(12, 6, 'Stock', 1, 0, 'C', 1);
$pdf->Cell(35, 6, utf8_decode('Descripción'), 1, 0, 'C', 1);
$pdf->Ln(10);

// Llamando al controlador
require_once('../../../app/Articulo.php');

$articulo = new Articulo();
$rptArticulos = DB::table('articulo as a')
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
    ->orderBy('idArticulo', 'desc');

while ($reg = $rptArticulos->fetch_object()) {
    $nombre = $reg->nombre;
    $categoria = $reg->categoria;
    $codigo = $reg->codigo;
    $stock = $reg->stock;
    $descripcion = $reg->descripcion;

    $pdf->SetFont('Arial', '', 10);
    $pdf->Row(array(utf8_decode($nombre), utf8_decode($categoria), $codigo, $stock, utf8_decode($descripcion)));
}