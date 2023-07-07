<x-dashboard-Layout>
    <x-slot name="title">
        {{ __('Konserda') }}
    </x-slot>
    <x-slot name="head">
        <!-- Additional resources here -->
        <meta name="csrf-token" content="content">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2/css/select2.min.css">
        <script></script>
        <style type="text/css">
            table {
                border-collapse: collapse;
                background: #fff;
            }

            #komponen tbody tr {
                max-height: 48px !important;
                min-height: 48px !important;
            }

            .table td {
                padding: 0rem !important;
            }

            #komponen {
                table-layout: fixed;
                width: 500px;
                /* display: inline-block; */
                background: #f9fafc;
                border-right: 1px solid #e6eaf0;
                vertical-align: top;
                white-space: nowrap;
                text-overflow: ellipsis;
                overflow: hidden;
            }

            #komponen th {
                background-color: steelblue !important;
                color: aliceblue !important;
                text-align: center;
            }

            a.nav-item {
                color: black !important;
            }

            .table-data-wrapper {
                /* display: inline-block; */
                overflow-x: auto;
                vertical-align: top;
                width: calc(100% - 500px);
            }

            .table-data-wrapper table {
                border-left: 0;
            }

            .table-data-wrapper td,
            .table-data-wrapper th {
                min-width: 180px;
                max-width: 180px;
                padding: 0rem !important;
            }

            .table-data-wrapper td:not(:last-child),
            .table-data-wrapper th:not(:last-child) {
                border-right: 1px solid #e6eaf0;
            }

            thead {
                background: #f9fafc;
            }

            #komponen thead th,
            #rekon-view thead th {
                height: 50px;
                vertical-align: middle;
                padding: .1rem;
                /* white-space: nowrap; */
                text-overflow: ellipsis;
                overflow: hidden;
            }

            #rekon-view tbody tr {
                /* height: 48px; */
                padding: 0rem !important;
            }

            .sum-of-kabkot {
                text-align: right;
            }

            thead tr,
            tbody tr:not(:last-child) {
                border-bottom: 1px solid #e6eaf0;
            }
        </style>
        @vite(['resources/css/app.css'])
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item active">Konserda</li>
        <div id="my-cat" data-cat="{{ json_encode($cat) }}"></div>
    </x-slot>
    <div class="card mb-3 p-0">
        <div class="card-body">
            <form>
                @csrf
                <div class="row">
                    <div class="col-md-2">
                        <select class="form-control select2bs4" id="type" name="type">
                            <option value="" selected>-- Pilih Jenis PDRB --</option>
                            <option {{ old('type', $filter['type']) == 'Lapangan Usaha' ? 'selected' : '' }}
                                value='Lapangan Usaha'>Lapangan Usaha</option>
                        </select>
                    </div>
                    <div class="col-md-2">
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
                    <div class="col-md-2">
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
                    <div class="col-md-2">
                        <select class="form-control select2bs4" id="period" name="period">
                            <option value="" selected>-- Pilih Putaran --</option>
                            @if ($periods)
                                @foreach ($periods as $period)
                                    <option {{ old('period', $filter['period_id']) == $period->id ? 'selected' : '' }}
                                        value="{{ $period->id }}">{{ $period->description }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-info col-md-10" id="showData">Tampilkan Data</button>
                        <div class="btn btn-danger col-md-1" id="refresh"><i class="bi bi-x-lg"></i></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <span class="loader d-none"></span>
    {{-- <div class="card mb-3 d-none" id="view-body"> --}}
    <div class="card mb-3" id="view-body">
        <div class="card-body">
            <nav class="navbar">
                <ul class="nav-item ml-auto">
                    <button class="btn btn-warning" id="download-csv" data-toogle="tooltip" data-placement="bottom"
                        title="Download"><i class="bi bi-file-earmark-arrow-down"></i></button>
                    <button class="btn btn-success" id="download-all" data-toogle="tooltip" data-placement="bottom"
                        title="Download All"><i class="bi bi-file-earmark-arrow-down-fill"></i></button>
                    <button class="btn btn-primary" id="change-query" onclick="switchPlay('1')" data-toogle="tooltip"
                        data-placement="bottom" title="Tukar Posisi Kolom"><i class="bi bi-toggles"></i></button>
                </ul>
            </nav>
            <nav class="navbar justify-content-center">
                <ul class="nav nav-tabs d-flex">
                    <a class="nav-item nav-link" id="nav-adhb" href="">ADHB</a>
                    <a class="nav-item nav-link" id="nav-adhk" href="">ADHK</a>
                    <a class="nav-item nav-link" id="nav-distribusi" href="">S.Dalam</a>
                    <a class="nav-item nav-link" id="nav-struktur-antar" href="">S.Antar</a>
                    <a class="nav-item nav-link" id="nav-pertumbuhan-year" href="">Growth (Y to Y)</a>
                    <a class="nav-item nav-link" id="nav-pertumbuhan-quarter" href="">Growth (Q to Q)</a>
                    <a class="nav-item nav-link" id="nav-pertumbuhan-cumulative" href="">Growth (C to
                        C)</a>
                    <a class="nav-item nav-link" id="nav-indeks" href="">Indeks Implisit</a>
                    <a class="nav-item nav-link" id="nav-laju-year" href="">Laju Implisit (Y to Y)</a>
                    <a class="nav-item nav-link" id="nav-laju-quarter" href="">Laju Implisit (Q to Q)</a>
                    <a class="nav-item nav-link" id="nav-laju-cumulative" href="">Laju Implisit (C to C)</a>
                </ul>
            </nav>
            <div class="table-container">
                <div class="row">
                    <div class="overflow-x-scroll">
                        <table class="table table-striped table-bordered" id="komponen">
                            <thead>
                                <tr>
                                    <th>Komponen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subsectors as $index => $item)
                                    @if (
                                        ($item->code != null && $item->code == 'a' && $item->sector->code == '1') ||
                                            ($item->code == null && $item->sector->code == '1'))
                                        <tr>
                                            <td class="first-columns">
                                                <label style="margin-bottom:0rem;"
                                                    for="">{{ $item->sector->category->code . '. ' . $item->sector->category->name }}</label>
                                            </td>
                                        </tr>
                                    @endif
                                    @if ($item->code != null && $item->code == 'a')
                                        <tr>
                                            <td class="first-columns">
                                                <p class="ml-4" style="margin-bottom:0rem;" for="">
                                                    {{ $item->sector->code . '. ' . $item->sector->name }}
                                                </p>
                                            </td>
                                        </tr>
                                    @endif
                                    @if ($item->code != null)
                                        <tr>
                                            <td class="first-columns">
                                                <p class=" ml-5" style="margin-bottom:0rem;"
                                                    for="{{ $item->code }}_{{ $item->name }}">
                                                    {{ $item->code . '. ' . $item->name }}
                                                </p>
                                            </td>
                                        </tr>
                                    @elseif ($item->code == null && $item->sector->code != null)
                                        <tr>
                                            <td class="first-columns">
                                                <p class=" ml-4" style="margin-bottom:0rem;"
                                                    for="{{ $item->sector->code . '_' . $item->sector->name }}">
                                                    {{ $item->sector->code . '. ' . $item->sector->name }}
                                                </p>
                                            </td>
                                        </tr>
                                    @elseif ($item->code == null && $item->sector->code == null)
                                        <tr>
                                            <td class="first-columns">
                                                <label class="" style="margin-bottom:0rem;"
                                                    for="{{ $item->sector->category->code . '_' . $item->name }}">{{ $item->sector->category->code . '. ' . $item->name }}</label>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                <tr class="PDRB-footer text-center"
                                    style="background-color: steelblue; color:aliceblue; font-weight: bold;">
                                    <td>Produk Domestik Regional Bruto (PDRB) Nonmigas</td>
                                </tr>
                                <tr class="PDRB-footer text-center"
                                    style="background-color: steelblue; color:aliceblue; font-weight: bold;">
                                    <td>Produk Domestik Regional Bruto (PDRB)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="table-data-wrapper">
                        <table class="table table-bordered" id="rekon-view">
                            <thead class="text-center" style="background-color: steelblue; color:aliceblue;">
                                <tr>
                                    <th id="head-purpose" class=""></th>
                                    <th>Total Kabupaten/Kota</th>
                                    @foreach ($regions as $region)
                                        <th>{{ $region->name }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subsectors as $index => $item)
                                    @if (
                                        ($item->code != null && $item->code == 'a' && $item->sector->code == '1') ||
                                            ($item->code == null && $item->sector->code == '1'))
                                        <tr>
                                            <td id="purpose-categories-{{ $index + 1 }}" class="text-bold"></td>
                                            <td id="categories-totalKabkot-{{ $index + 1 }}"
                                                class="sum-of-kabkot text-bold"></td>
                                            @foreach ($regions as $region)
                                                <td id="categories-{{ $item->sector->category->code . '-' . $region->id }}"
                                                    class="categories text-right values other-columns"></td>
                                            @endforeach
                                        </tr>
                                    @endif
                                    @if ($item->code != null && $item->code == 'a')
                                        <tr>
                                            <td id="sector-purpose-{{ $index + 1 }}" class=""></td>
                                            <td id="sector-totalKabkot-{{ $index + 1 }}" class="sum-of-kabkot">
                                            </td>
                                            @foreach ($regions as $region)
                                                <td id="sector-{{ $index + 1 }}-{{ $region->id }}"
                                                    class="text-right values other-columns"></td>
                                            @endforeach
                                        </tr>
                                    @endif
                                    @if ($item->code != null)
                                        <tr>
                                            <td id="purpose-{{ $index + 1 }}" class=""></td>
                                            <td id="totalKabkot-{{ $index + 1 }}" class="sum-of-kabkot"></td>
                                            @foreach ($regions as $region)
                                                <td id="{{ 'value-' . $item->id }}-{{ $region->id }}"
                                                    class="text-right values other-columns {{ 'categories-' . $item->sector->category->code }}-{{ $region->id }}">
                                                </td>
                                            @endforeach
                                        </tr>
                                    @elseif ($item->code == null && $item->sector->code != null)
                                        <tr>
                                            <td id="purpose-{{ $index + 1 }}" class=""></td>
                                            <td id="totalKabkot-{{ $index + 1 }}" class="sum-of-kabkot"></td>
                                            @foreach ($regions as $region)
                                                <td id="{{ 'value-' . $item->id }}-{{ $region->id }}"
                                                    class="text-right values other-columns {{ 'categories-' . $item->sector->category->code }}-{{ $region->id }}">
                                                </td>
                                            @endforeach
                                        </tr>
                                    @elseif ($item->code == null && $item->sector->code == null)
                                        <tr>
                                            <td id="purpose-{{ $index + 1 }}" class=" text-bold"></td>
                                            <td id="totalKabkot-{{ $index + 1 }}" class="sum-of-kabkot text-bold">
                                            </td>
                                            @foreach ($regions as $region)
                                                <td id="{{ 'value-' . $item->id }}-{{ $region->id }}"
                                                    class="text-right values other-columns {{ 'categories-' . $item->sector->category->code }}-{{ $region->id }} text-bold pdrb-total-{{ $region->id }}">
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endif
                                @endforeach
                                <tr class="PDRB-footer text-right"
                                    style="background-color: steelblue; color:aliceblue; font-weight: bold;">
                                    <td class="text-right" id="purpose-nonmigas"></td>
                                    <td class="sum-of-kabkot text-right" id="totalKabkot-nonmigas"></td>
                                    @foreach ($regions as $region)
                                        <td id="total-nonmigas-{{ $region->id }}" style="margin-bottom:0rem;"></td>
                                    @endforeach
                                </tr>
                                <tr class="PDRB-footer text-right"
                                    style="background-color: steelblue; color:aliceblue; font-weight: bold;">
                                    <td class="text-right" id="purpose-migas"></td>
                                    <td class="sum-of-kabkot text-right" id="totalKabkot-migas"></td>
                                    @foreach ($regions as $region)
                                        <td id="total-{{ $region->id }}" style="margin-bottom:0rem;"></td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="script">
        <!-- Additional JS resources -->
        <script src="{{ url('') }}/plugins/select2/js/select2.full.min.js"></script>
        <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
        <script src="{{ asset('js/konserda.js') }}"></script>
        <script src="{{ asset('js/download.js') }}"></script>
        <script>
            $(document).on('focus', '.select2-selection', function(e) {
                $(this).closest(".select2-container").siblings('select:enabled').select2('open');
            })
            let cat = JSON.parse($("#my-cat").data('cat'))
            let catArray = cat.split(", ")
            let rowComponent = 55
            const url_key = new URL('{{ route('lapangan-usaha.getKonserda') }}')
            const types = url_key.pathname.split('/')[1]
            const url_konserda_year = new URL("{{ route('konserdaYear') }}")
            const tokens = '{{ csrf_token() }}'
            const url_konserda_quarter = new URL("{{ route('konserdaQuarter') }}")
            const url_konserda_periode = new URL("{{ route('konserdaPeriod') }}")

            $(function() {
                $('[data-toggle="tooltip"]').tooltip()
            })
            // const csvData = convertToCSV()

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
