<x-dashboard-Layout>
    <x-slot name="title">
        {{ __('Daftar Tabel Pokok') }}
    </x-slot>
    <x-slot name="head">
        <!-- Additional resources here -->
        <meta name="csrf-token" content="content">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
        <script></script>
        <style type="text/css">
            .table td {
                vertical-align: middle;
                padding: 0.25rem;
            }

            #rekon-view td {
                word-wrap: break-word;
            }

            #view-main-table thead th{
                background-color: steelblue;
                color: aliceblue;
                text-align: center;
            }

            #view-quarter-table thead th{
                background-color: steelblue;
                color: aliceblue;
                text-align: center;
            }
            
            #view-main-table th {
                padding:0.25rem;
            }

            #rekon-view .values {
                text-align: right;
            }

            #rekon-view .PDRB-footer td p {
                text-align: center !important;
            }

            #rekon-view tr:not(:last-child):not(:nth-last-child(2)) td:not(:first-child) {
                text-align: right;
            }
            a.nav-item {
                color: black !important;
            }
        </style>
        @vite(['resources/css/app.css'])
    </x-slot>
    <x-slot name="breadcrumb">
        <li class="breadcrumb-item active">Daftar Tabel Pokok</li>
    </x-slot>
    <div class="row">    
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered" id="view-main-table">
                        <thead>
                            <th>No.</th>
                            <th>Kabupaten/Kota</th>
                            <th>Tahun</th>
                            <th>Liat</th>
                        </thead>
                        <tbody>
                            @foreach($daftar_1 as $item)
                            <tr>
                                <td class="text-center">{{ $item->number }}</td>
                                <td>{{ $item->region->name }}</td>
                                <td class="text-center">{{ $item->period->year }}</td>
                                <td class="text-center">
                                    <a href="{{ url('detailPokok').'/'.$item->period->id.'/Y' }}" class="btn btn-primary">
                                        <span class="bi bi-check2-square"></span>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered" id="view-quarter-table">
                        <thead>
                            <th>No.</th>
                            <th>Kabupaten/Kota</th>
                            <th>Tahun</th>
                            <th>Triwulan</th>
                            <th>Liat</th>
                        </thead>
                        <tbody>
                            <form>
                                @csrf
                                @foreach($daftar_2 as $item)
                                <tr>
                                    <td class="text-center">{{ $item->number }}</td>
                                    <td>{{ $item->region->name }}</td>
                                    <td class="text-center">{{ $item->period->year }}</td>
                                    <td class="text-center">{{ $item->quarter }}</td>
                                    <td class="text-center">
                                        <input value="{{ $item->period->id.'-'.$item->quarter }}" class="hiddenInput" hidden>
                                        <a href="{{ url('detailPokok').'/'.$item->period->id.'/'.$item->quarter }}" class="btn btn-primary">
                                            <span class="bi bi-check2-square"></span>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </form>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="script">
        <!-- Additional JS resources -->
        <script src="{{ url('') }}/plugins/select2/js/select2.full.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
        
        
        <script>
            $(document).on('focus', '.select2-selection', function(e) {
                $(this).closest(".select2-container").siblings('select:enabled').select2('open');
            })

            $(document).on('select2:open', () => {
                document.querySelector('.select2-search__field').focus();
            });

            $(function() {
                //Initialize Select2 Elements
                $('.select2').select2()

                //Initialize Select2 Elements
                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                })
            });

            $(document).ready(function() {
                $('#view-main-table').DataTable()
                // $('#view-main-table tbody tr').each(function(index) {
                //     $(this).find('td:first').text(index + 1);
                // });
                $('#view-quarter-table').DataTable()
                // $('#view-quarter-table tbody tr').each(function(index) {
                //     $(this).find('td:first').text(index + 1);
                // });
            })
        </script>
    </x-slot>
</x-dashboard-Layout>
