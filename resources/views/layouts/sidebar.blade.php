<aside class="main-sidebar sidebar-light-success elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('') }}" class="brand-link">
        <img src="{{ url('') }}/dist/img/karlota-logo.png" alt="Karlota Logo"
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
                    <a href="{{ url('dashboard') }}"
                        class="nav-link {{ Request::is('/', 'dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{ url('monitoring') }}" class="nav-link {{ Request::is('monitoring') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Monitoring PDRB
                        </p>
                    </a>
                </li> --}}
                <li class="nav-item {{ Request::is('lapangan-usaha*') ? 'menu-open' : '' }}">
                    <a href="" class="nav-link {{ Request::is('lapangan-usaha*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Lapangan Usaha
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('lapangan-usaha/rekonsiliasi') }}"
                                class="nav-link {{ Request::is('lapangan-usaha/rekonsiliasi') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Entri PDRB</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('lapangan-usaha/diskrepansi') }}"
                                class="nav-link {{ Request::is('lapangan-usaha/diskrepansi') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Diskrepansi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('lapangan-usaha/adjustment') }}"
                                class="nav-link {{ Request::is('lapangan-usaha/adjustment') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Adjustment</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('lapangan-usaha/daftarPokok') }}"
                                class="nav-link {{ Request::is('lapangan-usaha/daftarPokok') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tabel Pokok</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('lapangan-usaha/fenomena') }}"
                                class="nav-link {{ Request::is('lapangan-usaha/fenomena') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Entri Fenomena</p>
                            </a>
                        </li>
                        @if (auth()->user()->satker_id == 1)
                            <li class="nav-item">
                                <a href="{{ url('lapangan-usaha/monitoring') }}"
                                    class="nav-link {{ Request::is('lapangan-usaha/monitoring') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Monitoring PDRB</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
                <li class="nav-item {{ Request::is('pengeluaran*') ? 'menu-open' : '' }}">
                    <a href="" class="nav-link {{ Request::is('pengeluaran*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-coins"></i>
                        <p>
                            Pengeluaran
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('pengeluaran/rekonsiliasi') }}"
                                class="nav-link {{ Request::is('pengeluaran/rekonsiliasi') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Entri PDRB</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('pengeluaran/diskrepansi') }}"
                                class="nav-link {{ Request::is('pengeluaran/diskrepansi') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Diskrepansi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('pengeluaran/adjustment') }}"
                                class="nav-link {{ Request::is('pengeluaran/adjustment') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Adjustment</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('pengeluaran/daftarPokok') }}"
                                class="nav-link {{ Request::is('pengeluaran/daftarPokok') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tabel Pokok</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('pengeluaran/fenomena') }}"
                                class="nav-link {{ Request::is('pengeluaran/fenomena') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Entri Fenomena</p>
                            </a>
                        </li>
                        @if (auth()->user()->satker_id == 1)
                            <li class="nav-item">
                                <a href="{{ url('pengeluaran/monitoring') }}"
                                    class="nav-link {{ Request::is('pengeluaran/monitoring') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Monitoring PDRB</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ url('fenomena/viewAll') }}"
                        class="nav-link {{ Request::is('fenomena/viewAll') ? 'active' : '' }}">
                        <i class="far fa-star nav-icon"></i>
                        <p>Lihat Fenomena</p>
                    </a>
                </li>
                @if (auth()->user()->satker_id == 1)
                    <li class="nav-item">
                        <a href="{{ url('fenomena/monitoring') }}"
                            class="nav-link {{ Request::is('fenomena/monitoring') ? 'active' : '' }}">
                            <i class="far fa-star-half nav-icon"></i>
                            <p>Monitoring Fenomena</p>
                        </a>
                    </li>
                @endif

                @can('admin')
                    <li class="nav-header">PENGATURAN</li>
                    <li class="nav-item">
                        <a href="{{ url('user') }}" class="nav-link {{ Request::is('user*') ? 'active' : '' }}">
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
                @endcan
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
