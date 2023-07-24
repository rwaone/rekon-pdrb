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

            #monitoring-kuarter td {
                padding: 2px;
            }
        </style>
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item active">Rekonsiliasi</li>
    </x-slot>

    <div class="row">
        <div class="col-4 col-md-4 col-sm-4">
        </div>
        <div class="col-8 col-md-8 col-sm-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md">
                            <select class="form-control select2bs4" id="type" name="type">
                                <option value="" selected>-- Pilih Jenis PDRB --</option>
                                <option {{ old('type', $filter['type']) == 'Lapangan Usaha' ? 'selected' : '' }}
                                    value='Lapangan Usaha'>Lapangan Usaha</option>
                                <option value="Pengeluaran">Pengeluaran</option>
                            </select>
                        </div>
                        <div class="col-md">
                            <select class="form-control select2bs4" id="year" name="year">
                                <option value="" selected>-- Pilih Tahun --</option>
                                @if ($years)
                                    @foreach ($years as $year)
                                        <option {{ old('year', $filter['year']) == $year->year ? 'selected' : '' }}
                                            value="{{ $year->year }}">{{ $year->year }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md">
                            <select class="form-control select2bs4" id="quarter" name="quarter">
                                <option value="" selected>-- Pilih Triwulan --</option>
                                @if ($quarters)
                                    @foreach ($quarters as $quarter)
                                        <option
                                            {{ old('quarter', $filter['quarter']) == $quarter->quarter ? 'selected' : '' }}
                                            value="{{ $quarter->quarter }}">
                                            {{ $quarter->quarter == 'F' ? 'Lengkap' : ($quarter->quarter == 'T' ? 'Tahunan' : 'Triwulan ' . $quarter->quarter) }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md">
                            <button class="btn btn-info col-md-10" id="showData"><i class="bi bi-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <span class="loader d-none"></span>
    <div id="showTime" class="d-none">
        <h4 class="ml-2">Monitoring Pemasukan Fenomena PDRB <span id="type_fenomena"></span> <span id="year_fenomena"></span></h4>
        <div class="card p-4">
            <h5>Kuarter <span id="quarter_fenomena"></span>
            </h5>
            <div class="card-body p-0">
                <table class="table table-bordered table-striped" id="monitoring-kuarter">
                    <thead>
                        <th>Kabupaten/Kota</th>
                        <th>Cek</th>
                    </thead>
                    <tbody>
                        @foreach ($regions as $index => $region)
                            <tr>
                                <td id="region-{{ $region->name }}" class="pl-2">{{ $region->name }}</td>
                                <td id="value-{{ $index+1 }}"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <x-slot name="script">
        <!-- Additional JS resources -->
        <script src="{{ url('') }}/plugins/select2/js/select2.full.min.js"></script>
        <script src="{{ asset('js/fenomena.js') }}"></script>
        <script>
            const url_fenomena_year = new URL("{{ route('fenomenaYear') }}")
            const url_fenomena_quarter = new URL("{{ route('fenomenaQuarter') }}")
            const tokens = '{{ csrf_token() }}'
            const url_key = new URL('{{ route('fenomena.getMonitoring') }}')


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
        </script>
    </x-slot>
</x-dashboard-Layout>
