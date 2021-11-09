<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1"
    id="modal-delete-{{ $user->id }}">

    {{ Form::Open(array('action'=>array('UsuarioController@destroy', $user->id), 'method'=>'delete')) }}

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
                <h4 class="modal-title"><b> Eliminar Usuario</b></h4>
            </div>
            <div class="modal-body">
                <p style="font-size: 16px !important;"> Desea eliminar al usuario <span
                        style="border-bottom: 1px solid red;">
                        <b>{{ $user->name }}</b>, correo <em>{{$user->email}}</em> </span>
                    ?
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Confirmar</button>
            </div>
        </div>
    </div>

    {{ Form::close() }}
</div>