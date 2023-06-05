<aside class="main-sidebar sidebar-light-success elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('') }}" class="brand-link">
        <img src="{{ url('') }}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
       with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ url('dashboard') }}" class="nav-link {{ Request::is('/', 'dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('rekonsiliasi', 'fenomena') ? 'menu-open' : '' }}">
                    <a href="../widgets.html" class="nav-link {{ Request::is('rekonsiliasi', 'fenomena') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            PDRB
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('rekonsiliasi') }}" class="nav-link {{ Request::is('rekonsiliasi') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Rekonsiliasi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('fenomena') }}" class="nav-link {{ Request::is('fenomena') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Fenomena</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('daftarPokok') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Daftar Tabel Pokok</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Tables
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="../tables/simple.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Simple Tables</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../tables/data.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>DataTables</p>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <li class="nav-header">PENGATURAN</li>
                <li class="nav-item">
                    <a href="{{ url('user')}}" class="nav-link {{ Request::is('user*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Pengguna
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('period') }}" class="nav-link {{ Request::is('period*') ? 'active' : '' }}">
                        <i class="nav-icon far fa-calendar-alt"></i>
                        <p>
                            Jadwal
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>