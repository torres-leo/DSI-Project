<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Compra&Venta</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-select.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/font-awesome.css')}}">
    <link rel="stylesheet" href="{{asset('css/AdminLTE.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/_all-skins.min.css')}}">
    <link rel="apple-touch-icon" href="{{asset('img/apple-touch-icon.png')}}">
    <link rel="shortcut icon" href="{{asset('img/favicon.ico')}}">

</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <header class="main-header">

            <a href="" class="logo" style="background-color: #AF252D;">
                <span class="logo-mini"><b>C&</b>V</span>
                <span class="logo-lg"><b>Compra & Ventas</b></span>
            </a>

            <nav class="navbar navbar-static-top bg-red" role="navigation">
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Navegación</span>
                </a>
                <div class="navbar-custom-menu bg-red">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu" style="background-color: #AF252D;">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <small class="bg-green"
                                    style="color: black; padding: 1px; margin-right: 2px;">Online</small>
                                <span class="hidden-xs">{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-header">

                                    <p>
                                        <b><i> Elaborado por:</i></b>
                                    <ol>
                                        <b>
                                            <li>Kevin Torrez Mendoza</li>
                                        </b>
                                        <b>
                                            <li>William Molina Pérez</li>
                                        </b>
                                        <b>
                                            <li>Mynor Guido Silva</li>
                                        </b>
                                        <b>
                                            <li>Jerog Gonzales</li>
                                        </b>
                                        <b>
                                            <li>Leonardo Torres Solórzano</li>
                                        </b>
                                    </ol>
                                    </p>
                                </li>

                                <li class="user-footer">

                                    <div class="pull-right">
                                        <a href="{{ url('/logout') }}" class="btn btn-default btn-flat">Cerrar
                                            Sesión</a>
                                    </div>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>

            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->

                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu">
                    <li class="header"></li>

                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-laptop"></i>
                            <span>Almacén</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ url('almacen/articulo') }}"><i class="fa fa-circle-o"></i> Artículos</a>
                            </li>
                            <li><a href="{{ url('almacen/categoria') }}"><i class="fa fa-circle-o"></i> Categorías</a>
                            </li>
                        </ul>
                    </li>

                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-th"></i>
                            <span>Compras</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ url('compras/ingreso') }}"><i class="fa fa-circle-o"></i> Ingresos</a></li>
                            <li><a href="{{ url('compras/proveedor') }}"><i class="fa fa-circle-o"></i> Proveedores</a>
                            </li>
                        </ul>
                    </li>

                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-shopping-cart"></i>
                            <span>Ventas</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ url('ventas/venta') }}"><i class="fa fa-circle-o"></i> Ventas</a></li>
                            <li><a href="{{ url('ventas/cliente') }}"><i class="fa fa-circle-o"></i> Clientes</a></li>
                        </ul>
                    </li>

                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-folder"></i> <span>Acceso</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{url('seguridad/usuario')}}"><i class="fa fa-circle-o"></i> Usuarios</a></li>

                        </ul>
                    </li>

                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-plus-square"></i> <span>Reportes</span>
                            <small class="label pull-right bg-red">PDF</small>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{url('seguridad/usuario')}}"><i class="fa fa-circle-o"></i> Ventas</a></li>

                        </ul>
                    </li>

                    <!-- <li>
                        <a href="#">
                            <i class="fa fa-info-circle"></i> <span>Acerca De...</span>
                            <small class="label pull-right bg-yellow">IT</small>
                        </a>
                    </li> -->

                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>





        <!--Contenido-->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Main content -->
            <section class="content">

                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Sistema de Ventas</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i></button>

                                    <button class="btn btn-box-tool" data-widget="remove"><i
                                            class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <!--Contenido-->
                                        @yield('contenido')
                                        <!--Fin Contenido-->
                                    </div>
                                </div>

                            </div>
                        </div><!-- /.row -->
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->

    </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
    <!--Fin-Contenido-->
    <footer class="main-footer bg-black">
        <div class="pull-right hidden-xs" style=" color: white;">
            <i> Diseño de sistemas de Internet </i> <span class="bg-yellow"
                style="padding: 3px; color:black !important; border-radius: 4px;"><b>
                    5T1-IS</b></span>
        </div>
        <strong>Copyright &copy; 2021 <span
                style=" background-color: #EA8916; padding: 5px; color: black; border-radius: 5px;">UNI-RUPAP</span></strong>
        Todos los derechos reservados
    </footer>

    <!-- jQuery 2.1.4 -->
    <script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
    @stack('scripts')
    <!-- Bootstrap 3.3.5 -->
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('js/app.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-select.min.js')}}"></script>

</body>

</html>