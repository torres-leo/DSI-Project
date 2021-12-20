<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Usuarios</title>
    <!-- <link rel="stylesheet" href="../Css/Style.css"> -->
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

    <h2>Lista de Usuarios</h2>

    <table class="table">
        <thead>
            <tr>
                <th style="margin-right: 15px;">Id</th>
                <th style="margin-right: 15px;">Nombre de Usuario</th>
                <th style="margin-right: 15px;">Email</th>
            </tr>
        </thead>
        @foreach($users as $user)
        <tbody>
            <tr>
                <td style="margin-right: 35px;">{{$user->id}}</td>
                <td style="margin-right: 35px;">{{$user->name}}</td>
                <td style="margin-right: 35px;">{{$user->email}}</td>
            </tr>
        </tbody>
        @endforeach
    </table>
</body>



</html>