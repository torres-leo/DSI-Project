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

<h2>Lista de Categorias</h2>

<table class="table">
    <thead>
        <tr>
            <th style="margin-right: 15px;">Id</th>
            <th style="margin-right: 15px;">Categoría</th>
            <th style="margin-right: 15px;">Descripción</th>
            <th style="margin-right: 15px;">Condición</th>
        </tr>
    </thead>
    @foreach($categorias as $cat)
    <tbody>
        <tr>
            <td style="margin-right: 15px;">{{$cat->idCategoria}}</td>
            <td style="margin-right: 15px;">{{$cat->nombre}}</td>
            <td style="margin-right: 15px;">{{$cat->descripcion}}</td>
            <td style="margin-right: 15px;">{{$cat->condicion}}</td>
        </tr>
    </tbody>
    @endforeach
</table>