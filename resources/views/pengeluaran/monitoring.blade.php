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
                padding:2px;
            }
        </style>
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item active">Rekonsiliasi</li>
    </x-slot>
    <div class="row">
        <div class="col-md-8">
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            <select class="form-control select2bs4" id="year" name="year">
                                <option value="" selected>-- Pilih Tahun --</option>
                                @foreach ($monitoring_quarter as $year => $quarters)
                                    <option value="{{ $year }}" {{ $year == $max_year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-info col-md-10" id="showData"><i class="bi bi-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <span class="loader d-none"></span>
    @foreach ($monitoring_quarter as $year => $quarters)
        <div id="{{ $year }}" class="views">
            <h4 class="ml-2">Monitoring Pemasukan Tabel PDRB Pengeluaran Tahun {{ $year }}</h4>
            @foreach ($quarters as $quarter => $regions)
                <div class="card p-4">
                    <h5>Kuarter {{ $quarter }},
                        {{ $monitoring_quarter[$year][$quarter]['Provinsi Sulawesi Utara']['description'][0] }}</h5>
                    <div class="card-body p-0">
                        <table class="table table-bordered table-striped" id="monitoring-kuarter">
                            <thead>
                                <th>Kabupaten/Kota</th>
                                <th>ADHK</th>
                                <th>ADHB</th>
                            </thead>
                            <tbody>
                                @foreach ($regions as $region => $item)
                                    <tr>
                                        <td>{{ $region }}</td>
                                        <td>{{ $item['adhk'] }}</td>
                                        <td>{{ $item['adhb'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach

    <x-slot name="script">
        <!-- Additional JS resources -->
        <script src="{{ url('') }}/plugins/select2/js/select2.full.min.js"></script>
        <script src="{{ asset('js/rekon-lapangan-usaha.js') }}"></script>
        <script src="{{ asset('js/rekon-pengeluaran.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('.views').each(function() {
                    if ($(this).attr('id') !== $("#year").val()) {
                        $(this).addClass('d-none');
                    }
                })
            })
            $('#showData').on('click', function() {
                $('.loader').removeClass('d-none');
                setTimeout(() => {
                    $('.views').each(function() {
                        $(this).addClass('d-none');
                    });
                    let showIndex = $('#year').val();
                    $(`#${showIndex}`).removeClass('d-none');
                    $('.loader').addClass('d-none');
                }, 500);
            });

            $('#monitoring-kuarter tbody tr td').each(function() {
                if ($(this).text() === '0') {
                    $(this).html('<i class="bi bi-x-circle-fill" style = "color: red;"></i>');
                    $(this).addClass('text-center')
                }
                if ($(this).text() === '1') {
                    $(this).html('<i class="bi bi-check-circle-fill" style = "color: green;"></i>');
                    $(this).addClass('text-center')
                }
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
        </script>
    </x-slot>
</x-dashboard-Layout>
