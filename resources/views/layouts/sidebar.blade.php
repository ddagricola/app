<aside class="main-sidebar">
    <section class="sidebar">
        @if(Auth::check())
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('/bower_components/AdminLTE/dist/img/avatar5.png') }}" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>{{ \App\Colaborador::nombreAuth() }}</p>
                <!-- Status -->
                <a href="#" style="font-size:9px"><i class="fa fa-circle text-success"></i> 
                    {{ \App\Jefatura::find(Auth::user()->id_jefatura)->nombre }}
                </a>
            </div>
        </div>
        @endif
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Buscar..."/>
                    <span class="input-group-btn">
                        <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                    </span>
            </div>
        </form>

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            @if(!Auth::check())
                <li>
                    <a href="#">
                        <i class="fa fa-question"></i>
                        <span>Ayuda</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-folder-open"></i>
                        <span>Información Publica</span>
                    </a>
                </li>
                <!--<li class="treeview">
                    <a href="#"><span>Multilevel</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="#">Link in level 2</a></li>
                        <li><a href="#">Link in level 2</a></li>
                    </ul>
                </li>-->
            @else
                @if (Auth::user()->id_rol == 2)
                    <li>
                        <a href="{{ url('intervenciones/listado') }}" class="js_menu">
                            <i class="fa fa-folder-o"></i>
                            <span>Intervenciones</span>
                        </a>
                    </li>
                @elseif(Auth::user()->id_rol == 3)
                    <li>
                        <a href="{{ url('distribuciones/departamentos') }}">
                            <i class="fa fa-folder-o"></i>
                            <span>Distribuciones</span>
                        </a>
                    </li>
                @elseif(Auth::user()->id_rol == 4)
                    <li>
                        <a href="{{ url('/') }}">
                            <i class="fa fa-home"></i>
                            <span>Recepción</span>
                        </a>
                    </li>
                @elseif(Auth::user()->id_rol == 5)
                    <li>
                        <a href="{{ url('recepcion/colaboradores/listado') }}">
                            <i class="fa  fa-male"></i>
                            <span>Empleados</span>
                        </a>
                    </li> 
                @else
                <li>
                    <a href="{{ url('recepcion/colaboradores/listado') }}">
                        <i class="fa  fa-male"></i>
                        <span>Empleados</span>
                    </a>
                </li> 
                    <li>
                        <a href="{{ url('mantenimiento/puestos') }}">
                            <i class="fa fa-newspaper-o"></i>
                            <span>Puestos</span>
                        </a>
                    </li>
                <li>
                    <a href="{{ url('configuration/usuario') }}">
                        <i class="fa fa-users"></i>
                        <span>Usuarios</span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('beneficiarios') }}">
                        <i class="fa fa-folder-o"></i>
                        <span>Beneficiarios</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('mantenimiento/partidas') }}">
                        <i class="fa fa-folder-o"></i>
                        <span>Partidas</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('mantenimiento/paises') }}">
                        <i class="fa fa-folder-o"></i>
                        <span>Paises</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('mantenimiento/departamentos') }}">
                        <i class="fa fa-folder-o"></i>
                        <span>Departamentos</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('mantenimiento/municipios') }}">
                        <i class="fa fa-folder-o"></i>
                        <span>Municipios</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('mantenimiento/divisiones') }}">
                        <i class="fa fa-folder-o"></i>
                        <span>Divisiones</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('mantenimiento/ministerios') }}">
                        <i class="fa fa-folder-o"></i>
                        <span>Ministerios</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('mantenimiento/direcciones') }}">
                        <i class="fa fa-folder-o"></i>
                        <span>Direcciones</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('mantenimiento/programas') }}">
                        <i class="fa fa-folder-o"></i>
                        <span>Programas</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('mantenimiento/actividades') }}">
                        <i class="fa fa-folder-o"></i>
                        <span>Actividades</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('mantenimiento/proyectos') }}">
                        <i class="fa fa-folder-o"></i>
                        <span>Proyectos</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('mantenimiento/renglones') }}">
                        <i class="fa fa-folder-o"></i>
                        <span>Renglones</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('mantenimiento/fuentes-financiamiento') }}">
                        <i class="fa fa-folder-o"></i>
                        <span>Fuentes de financiamiento</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('mantenimiento/municipio-renglon') }}">
                        <i class="fa fa-folder-o"></i>
                        <span>Municipio - Renglon</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('mantenimiento/insumos') }}">
                        <i class="fa fa-folder-o"></i>
                        <span>Insumos</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('mantenimiento/tipo-insumo') }}">
                        <i class="fa fa-folder-o"></i>
                        <span>Tipos de insumos</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('mantenimiento/tipo-division') }}">
                        <i class="fa fa-folder-o"></i>
                        <span>Tipos de divisiones</span>
                    </a>
                </li>
                @endif
            @endif
        </ul>
    </section>
</aside>