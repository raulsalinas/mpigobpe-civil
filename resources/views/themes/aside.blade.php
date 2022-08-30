<aside class="main-sidebar elevation-2 sidebar-light-danger sidebar-no-expand">
    <a href="{{ route('inicio') }}" class="brand-link navbar-white">
        <img src="{{ asset('images/isotipo.png') }}" alt="logo_okc" class="brand-image" style="opacity: .8">
        <span class="brand-text font-weight-bold">Registro civil</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-legacy nav-flat nav-compact" data-widget="treeview" role="menu" data-accordion="true">
                <li class="nav-header"><a href="#">Inicio</a></li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-baby text-warning"></i>
                        <p>Nacimientos<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('nacimientos.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i> <p>Listado</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('nacimientos.control.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i> <p>Control</p>
                            </a>
                        </li>
                        <li class="nav-item">
                        <a href="{{ route('nacimientos.consistencia.index') }}" class="nav-link">
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
                            <a href="#" class="nav-link">
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
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i> <p>Listado</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i> <p>Consistencia</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- <ul class="nav nav-pills nav-sidebar flex-column nav-legacy nav-flat nav-compact" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header"><a href="#">Utilidades</a></li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-circle nav-icon text-warning"></i>
                        <p>Localidades/lugares</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-circle nav-icon text-warning"></i>
                        <p>Constancia de nacimientos</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-circle nav-icon text-warning"></i>
                        <p>Constancia de matrimonio</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-circle nav-icon text-warning"></i>
                        <p>Constancia de defunciones</p>
                    </a>
                </li>
            </ul> -->
            <ul class="nav nav-pills nav-sidebar flex-column nav-legacy nav-flat nav-compact" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header"><a href="#">Configuración</a></li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-circle nav-icon text-warning"></i>
                        <p>Gestión de usuarios</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-circle nav-icon text-warning"></i>
                        <p>Variables</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>