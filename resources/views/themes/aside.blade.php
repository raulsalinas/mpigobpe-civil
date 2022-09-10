<aside class="main-sidebar elevation-2 sidebar-light-danger sidebar-no-expand">
    <a href="{{ route('inicio') }}" class="brand-link navbar-white">
        <img src="{{ asset('images/isotipo.png') }}" alt="logo_okc" class="brand-image" style="opacity: .8">
        <span class="brand-text font-weight-bold">Registro civil</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-legacy nav-flat nav-compact" data-widget="treeview" role="menu" data-accordion="true">
                <li class="nav-header"><a href="#">Operativas</a></li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-baby text-warning"></i>
                        <p>Nacimientos<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('nacimientos.index') }}" class="nav-link" title="Listado" >
                                <i class="far fa-circle nav-icon" title="Listado"></i> <p>Listado</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('nacimientos.control.index') }}" class="nav-link" title="Control">
                                <i class="far fa-circle nav-icon"></i> <p>Control</p>
                            </a>
                        </li>
                        <li class="nav-item">
                        <a href="{{ route('nacimientos.consistencia.index') }}" class="nav-link" title="Consistencia">
                                <i class="far fa-circle nav-icon"></i> <p>Consistencia</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-ring text-warning"></i>
                        <p>Matrimonios<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('matrimonios.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i> <p>Listado</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('matrimonios.control.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i> <p>Control</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('matrimonios.consistencia.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i> <p>Consistencia</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-skull text-warning"></i>
                        <p>Defunciones<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('defunciones.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i> <p>Listado</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('defunciones.control.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i> <p>Control</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('defunciones.consistencia.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i> <p>Consistencia</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <ul class="nav nav-pills nav-sidebar flex-column nav-legacy nav-flat nav-compact" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header"><a href="#">Utlidades</a></li>
                <li class="nav-item">
                    <a href="{{ route('utilidades.cobros.index') }}" class="nav-link">
                        <i class="nav-icon fa-sharp fa-solid fa-cash-register nav-icon text-warning"></i>
                        <p>Cobros</p>
                    </a>
                </li>
            </ul>
            <ul class="nav nav-pills nav-sidebar flex-column nav-legacy nav-flat nav-compact" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header"><a href="#">Configuración</a></li>
                <li class="nav-item">
                    <a href="{{ route('configuracion.gestionar-usuarios-index') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-cog nav-icon text-warning"></i>
                        <p>Gestión de usuarios</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('configuracion.maestros-index') }}" class="nav-link">
                        <i class="nav-icon fas fa-wrench nav-icon text-warning"></i>
                        <p>Maestros</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>