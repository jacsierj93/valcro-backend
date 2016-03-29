<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (Session::get('DATAUSER')->id )
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{url('/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>{{ Session::get('DATAUSER')->name}}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
        @endif

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">HEADER</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="active"><a href="{{ url('/') }}"><i class='fa fa-link'></i> <span>Inicio</span></a></li>

            <li class="treeview">
                <a href="#"><i class='fa fa-users'></i> <span>Usuarios</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{url('users/usersList')}}"><i class='fa fa-user'></i> Usuarios</a></li>
                </ul>
            </li>


            <li class="treeview">
                <a href="#"><i class='fa fa-database'></i> <span>Catalogo</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{url('catalogs/departamentList')}}">Departamentos</a></li>
                    <li><a href="{{url('catalogs/positionList')}}">Cargos</a></li>
                    <li><a href="{{url('catalogs/sucursalList')}}">Sucursales</a></li>
                    <li><a href="{{url('catalogs/providerTypesList')}}">Tipos de Provedor</a></li><!---add for miguel -->
                    <li><a href="{{url('catalogs/providerTypesSendList')}}">Tipos de Envíos</a></li><!---lista tipos de envios -->
                </ul>
            </li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
