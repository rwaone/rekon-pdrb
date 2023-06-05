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
            Hai! Selamat datang di Aplikasi Rekonsiliasi PDRB Online Badan Pusat Statistik Provinsi Sulawesi Utara.
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

    <x-slot name="script">
        <!-- Additional JS resources -->
    </x-slot>

</x-dashboard-Layout>
