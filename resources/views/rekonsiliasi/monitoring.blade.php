<x-dashboard-Layout>
    <x-slot name="title">
        {{ __('Monitoring') }}
    </x-slot>
    <x-slot name="head">
        <!-- Additional resources here -->
        <meta name="csrf-token" content="content">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2/css/select2.min.css">
        <script></script>
        <style type="text/css">
            #monitoring-kuarter thead {
                text-align: center;
            }
        </style>
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item active">Rekonsiliasi</li>
    </x-slot>

    <span class="loader d-none"></span>
    <div class="card">
        <div class="card-body">
            <h4>Monitoring Pemasukan Tabel PDRB Kuarter</h4>
            <table class="table table-bordered table-striped" id="monitoring-kuarter">
                <thead>
                    <th>Kabupaten/Kota</th>
                    @foreach ($daftar_quarters as $quarter)
                    <th>Putaran ke {{ $quarter->description }}</th>
                    @endforeach
                </thead>
                <tbody>
                    @foreach ($regions as $index => $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        @foreach ($daftar_quarters as $quarter => $items)
                        <td>{{ $data_regions_quarters[$index][$quarter] }}</td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card">
        <div class="card-body p-2">
            <h4>Monitoring Pemasukan Tabel PDRB Tahunan</h4>
            <table class="table table-bordered table-striped" id="monitoring-kuarter">
                <thead>
                    <th>Kabupaten/Kota</th>
                    @foreach ($daftar_years as $year)
                    <th>Putaran ke {{ $year->description }}</th>
                    @endforeach
                </thead>
                <tbody>
                    @foreach ($regions as $index => $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        @foreach ($daftar_years as $year => $items)
                        <td>{{ $data_regions_years[$index][$year] }}</td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <x-slot name="script">
        <!-- Additional JS resources -->
        <script src="{{ url('') }}/plugins/select2/js/select2.full.min.js"></script>
        <script src="{{ asset('js/rekon-lapangan-usaha.js') }}"></script>
        <script src="{{ asset('js/rekon-pengeluaran.js') }}"></script>
        <script>
            $('#monitoring-kuarter tbody tr td').each(function() {
                if ($(this).text() === '0') {
                    $(this).html('<i class="bi bi-x-lg"></i>');
                    $(this).addClass('text-center')
                }
            })
        </script>
    </x-slot>
</x-dashboard-Layout>