<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Clientes</title>
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

    <h2>Lista de Clientes</h2>

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
        @foreach($clientes as $client)
        <tbody>
            <tr>
                <td>{{$client->idPersona}}</td>
                <td>{{$client->nombre}}</td>
                <td>{{$client->tipoPersona}}</td>
                <td>{{$client->tipoDocumento}}</td>
                <td>{{$client->numDocumento}}</td>
                <td>{{$client->direccion}}</td>
                <td>{{$client->telefono}}</td>
                <td>{{$client->email}}</td>
            </tr>
        </tbody>
        @endforeach
    </table>
</body>

</html>