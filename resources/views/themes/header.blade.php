<nav class="main-header navbar navbar-expand navbar-light navbar-white">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="index3.html" class="nav-link">Documentación</a>
        </li>
    </ul>
    
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown user-menu">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                <span class="hidden-xs">Usuario: {{ Auth::user()->nombre_corto }}</span>
            </a>
            <ul class="dropdown-menu">
                <li class="user-header">
                    <p>{{ Auth::user()->nombre_largo }}</p>
                </li>
                <li class="user-footer">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <a href="javascript: void(0)" onclick="changePassword();" class="btn btn-info btn-xs btn-block btn-flat">Cambiar Clave</a>
                        </div>
                        <div class="col-sm-12 col-md-6 text-right">
                            <a href="{{ route('logout') }}" class="btn btn-danger btn-xs btn-block btn-flat">Cerrar sesion</a>
                        </div>
                    </div>
                </li>
            </ul>
        </li>
    </ul>
</nav>