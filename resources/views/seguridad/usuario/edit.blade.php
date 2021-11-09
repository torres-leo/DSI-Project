@extends('layouts.admin')
@section('contenido')

<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h3>Editar Usuario:
            <span style="border-bottom: 1px solid green; margin-left: 15px;">
                <i>{{ $usuario->name.': '.$usuario->email}}
                </i>
            </span>
        </h3>
        @if (count($errors)>0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {!!Form::model($usuario, ['method'=>'PATCH' ,'route'=>['seguridad.usuario.update',$usuario->id]]
        )
        !!}
        {{Form::token()}}
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="col-md-4 control-label">Nombre de usuario <span font-size: 16px; color:
                    black;></label>

            <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" value="{{ $usuario->name }}">

                @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email" class="col-md-4 control-label">Correo</label>

            <div class="col-md-6">
                <input id="email" type="email" class="form-control" name="email" value="{{ $usuario->email }}">

                @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password" class="col-md-4 control-label">Contraseña</label>

            <div class="col-md-6">
                <input id="password" type="password" class="form-control" name="password">

                @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
            <label for="password-confirm" class="col-md-4 control-label">Confirmar contraseña</label>

            <div class="col-md-6">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                @if ($errors->has('password_confirmation'))
                <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group" style="margin-top: 15px;">
            <button class="btn btn-primary" type="submit">Guardar</button>
            <br>
            <br>
            <button class="btn btn-danger" type="reset"><a href="{{url('seguridad/usuario')}}"
                    style="text-decoration: none; color: white;">Cancelar</a></button>
        </div>

        {!!Form::close()!!}

        @endsection