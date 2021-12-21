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

<h2>Lista de Articulos</h2>

<table class="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Articulo</th>
            <th>Categoría</th>
            <th>Código</th>
            <th>stock</th>
            <th>Descripción</th>
            <!-- <th >Condición</th> -->
        </tr>
    </thead>
    @foreach($articulos as $art)
    <tbody>
        <tr>
            <td>{{$art->idArticulo}}</td>
            <td>{{$art->nombre}}</td>
            <td>{{$art->categoria}}</td>
            <td>{{$art->codigo}}</td>
            <td>{{$art->stock}}</td>
            <td>{{$art->descripcion}}</td>
        </tr>
    </tbody>
    @endforeach
</table>