<x-dashboard-Layout>

    <x-slot name="title">
        {{ __('Dashboard') }}
    </x-slot>

    <x-slot name="head">
        <!-- Additional resources here -->
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item active">Dashboard</li>
    </x-slot>

    <!-- Default box -->
    <div class="card">
        {{-- <div class="card-header">

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div> --}}
        <div class="card-body">
            Hai! Selamat datang di <b>Karlota-Apps</b>, Aplikasi Peningkatan Kualitas Rekonsiliasi PDRB Kabupaten / Kota Triwulanan Badan Pusat Statistik Provinsi Sulawesi Utara
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

    <div class="card">
        <div class="card-header border-0">
            <h3 class="card-title"><span class="badge bg-primary">Putaran Aktif</span></h3>
            <div class="card-tools">
                {{-- <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-download"></i>
                </a>
                <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-bars"></i>
                </a> --}}
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-striped table-valign-middle">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">PDRB</th>
                        <th class="text-center">Tahun</th>
                        <th class="text-center">Triwulan</th>
                        <th class="text-center">Deskripsi</th>
                        <th class="text-center">Tanggal Mulai</th>
                        <th class="text-center">Tanggal Selesai</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">More</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($periods as $period)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $period->type }}</td>
                            <td class="text-center">{{ $period->year }}</td>
                            <td class="text-center">
                                @switch($period->quarter)
                                    @case('T')
                                        Tahunan
                                    @break

                                    @case('F')
                                        Lengkap
                                    @break

                                    @default
                                        Triwulan {{ $period->quarter }}
                                @endswitch
                            </td>
                            <td class="text-center">{{ $period->description }}</td>
                            <td class="text-center">{{ $period->started_at }}</td>
                            <td class="text-center">{{ $period->ended_at }}</td>
                            <td class="text-center">
                                @switch($period->status)
                                    @case('Aktif')
                                        <span class="badge bg-warning"> {{ $period->status }} </span>
                                    @break

                                    @case('Selesai')
                                        <span class="badge bg-success"> {{ $period->status }} </span>
                                    @break

                                    @case('Final')
                                        <span class="badge bg-primary"> {{ $period->status }} </span>
                                    @break

                                    @default
                                @endswitch
                            </td>
                            <td class="project-actions text-center">
                                <a href="{{ url(($period->type == 'Pengeluaran' ? 'pengeluaran/rekonsiliasi' : 'lapangan-usaha/rekonsiliasi')) }}" class="text-muted" class="btn btn-info btn-sm">
                                    <i class="fas fa-search"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>

    <x-slot name="script">
        <!-- Additional JS resources -->
    </x-slot>

</x-dashboard-Layout>
