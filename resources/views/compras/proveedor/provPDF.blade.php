<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Proveedores</title>
    <link rel="stylesheet" href="../Css/Style.css">
</head>

<body>

    <style>
    table {
        border: 1px solid #333;
        width: 95%;
    }

    td {
        padding: 5px;
        text-align: center;
    }
    </style>

    <h2>Lista de Proveedores</h2>

    <table class="table">
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Rol</th>
                <th>Documento</th>
                <th>Número de Documento</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Email</th>
            </tr>

        </thead>
        @foreach($proveedores as $prov)
        <tbody>
            <tr>
                <td>{{$prov->idPersona}}</td>
                <td>{{$prov->nombre}}</td>
                <td>{{$prov->tipoPersona}}</td>
                <td>{{$prov->tipoDocumento}}</td>
                <td>{{$prov->numDocumento}}</td>
                <td>{{$prov->direccion}}</td>
                <td>{{$prov->telefono}}</td>
                <td>{{$prov->email}}</td>
            </tr>
        </tbody>
        @endforeach
    </table>
</body>

</html>