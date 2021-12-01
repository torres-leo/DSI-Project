<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articulos</title>
</head>

<body>
    <!-- <h1>Prueba de PDF</h1> -->
    <h2>Listado de artículos</h2>

    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Código</th>
                <th>Stock</th>
                <th>Categoría</th>
                <th>Descripción</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($articulos as art)
            <tr>
                <td>{{ $art-idArticulo> }}</td>
                <td>{{ $art-nombre> }}</td>
                <td>{{ $art-codigo> }}</td>
                <td>{{ $art-stock> }}</td>
                <td>{{ $art-categoria> }}</td>
                <td>{{ $art-descripcion> }}</td>
                <td>{{ $art-estado> }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>