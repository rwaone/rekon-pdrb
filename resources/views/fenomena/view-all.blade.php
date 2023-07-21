<x-dashboard-Layout>
    <x-slot name="title">
        {{ __('Fenomena') }}
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
                /* max-height: 48px !important;
                min-height: 48px !important; */
                /* max-height: 100px !important; */
                /* min-height: 100px !important; */
                height: 100px;
            }

            .table td {
                padding: 0rem !important;
            }

            #komponen {
                table-layout: fixed;
                width: 300px;
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
                width: calc(100% - 300px);
            }

            .table-data-wrapper table {
                border-left: 0;
            }

            .table-data-wrapper th {
                min-width: 480px;
                max-width: 480px;
            }

            .table-data-wrapper td {
                min-width: 480px;
                max-width: 480px;
                padding: 0rem !important;
                word-break:break-all;
                cursor: pointer;
            }
            
            .table-data-wrapper td span {
                display:block;
                overflow: hidden;
                text-overflow: ellipsis;
                /* white-space: nowrap; */
                padding-left: 1.2rem;
                
            }

            .table-data-wrapper td:hover span {
                /* overflow: visible; */
                /* height: auto; */
                background-color:whitesmoke ! important;
                contain: paint;
                display: inline-flex;
                min-width: 100%;
                /* text-align: right ! important; */
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
                height: 100px;
                padding: 0rem !important;
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
    <div class="row">
        <div class="col-2 col-md-2 col-sm-2">
        </div>
        <div class="col-10 col-md-10 col-sm-10">
            <div class="card mb-3 p-0">
                <div class="card-body">
                    <form>
                        @csrf
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
                                <button class="btn btn-info col-md-10" id="showData">Tampilkan Data</button>
                                <div class="btn btn-danger" id="refresh"><i class="bi bi-x-lg"></i></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <span class="loader d-none"></span>
    <div class="card mb-3 d-none" id="view-body">
        {{-- <div class="card mb-3" id="view-body"> --}}
        <div class="card-body">
            <nav class="navbar">
                <ul class="nav-item ml-auto">
                    <button class="btn btn-success" id="download-all" data-toogle="tooltip" data-placement="bottom"
                        title="Download All"><i class="bi bi-file-earmark-arrow-down-fill"></i></button>
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
                                        <tr class="{{ str_replace(' ', '', $item->type) }}">
                                            <td class="first-columns">
                                                <label style="margin-bottom:0rem;"
                                                    for="">{{ $item->sector->category->code . '. ' . $item->sector->category->name }}</label>
                                            </td>
                                        </tr>
                                    @endif
                                    @if ($item->code != null && $item->code == 'a')
                                        <tr class="{{ str_replace(' ', '', $item->type) }}">
                                            <td class="first-columns">
                                                <p class="ml-4" style="margin-bottom:0rem;" for="">
                                                    {{ $item->sector->code . '. ' . $item->sector->name }}
                                                </p>
                                            </td>
                                        </tr>
                                    @endif
                                    @if ($item->code != null)
                                        <tr class="{{ str_replace(' ', '', $item->type) }}">
                                            <td class="first-columns">
                                                <p class=" ml-5" style="margin-bottom:0rem;"
                                                    for="{{ $item->code }}_{{ $item->name }}">
                                                    {{ $item->code . '. ' . $item->name }}
                                                </p>
                                            </td>
                                        </tr>
                                    @elseif ($item->code == null && $item->sector->code != null)
                                        <tr class="{{ str_replace(' ', '', $item->type) }}">
                                            <td class="first-columns">
                                                <p class=" ml-4" style="margin-bottom:0rem;"
                                                    for="{{ $item->sector->code . '_' . $item->sector->name }}">
                                                    {{ $item->sector->code . '. ' . $item->sector->name }}
                                                </p>
                                            </td>
                                        </tr>
                                    @elseif ($item->code == null && $item->sector->code == null)
                                        <tr class="{{ str_replace(' ', '', $item->type) }}">
                                            <td class="first-columns">
                                                <label class="" style="margin-bottom:0rem;"
                                                    for="{{ $item->sector->category->code . '_' . $item->name }}">{{ $item->sector->category->code . '. ' . $item->name }}</label>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="table-data-wrapper">
                        <table class="table table-bordered" id="rekon-view">
                            <thead class="text-center" style="background-color: steelblue; color:aliceblue;">
                                <tr>
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
                                        <tr class="{{ str_replace(' ', '', $item->type) }}">
                                            @foreach ($regions as $region)
                                                <td id="categories-{{ $item->sector->category->code . '-' . $region->id }}"
                                                    class="categories text-left values other-columns"><span></span>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endif
                                    @if ($item->code != null && $item->code == 'a')
                                        <tr class="{{ str_replace(' ', '', $item->type) }}">
                                            @foreach ($regions as $region)
                                                <td id="sector-{{ $index + 1 }}-{{ $region->id }}"
                                                    class="text-left values other-columns"><span></span>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endif
                                    @if ($item->code != null)
                                        <tr class="{{ str_replace(' ', '', $item->type) }}">
                                            @foreach ($regions as $region)
                                                <td id="{{ 'value-' . $item->id }}-{{ $region->id }}"
                                                    class="text-left values other-columns {{ 'categories-' . $item->sector->category->code }}-{{ $region->id }}">
                                                    <span></span>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @elseif ($item->code == null && $item->sector->code != null)
                                        <tr class="{{ str_replace(' ', '', $item->type) }}">
                                            @foreach ($regions as $region)
                                                <td id="{{ 'value-' . $item->id }}-{{ $region->id }}"
                                                    class="text-left values other-columns {{ 'categories-' . $item->sector->category->code }}-{{ $region->id }}">
                                                    <span></span>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @elseif ($item->code == null && $item->sector->code == null)
                                        <tr class="{{ str_replace(' ', '', $item->type) }}">
                                            @foreach ($regions as $region)
                                                <td id="{{ 'value-' . $item->id }}-{{ $region->id }}"
                                                    class="text-left values other-columns {{ 'categories-' . $item->sector->category->code }}-{{ $region->id }} text-bold pdrb-total-{{ $region->id }}">
                                                    <span></span>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endif
                                @endforeach
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
        <script src="{{ asset('js/fenomena.js') }}"></script>
        <script src="{{ asset('js/download.js') }}"></script>
        <script>
            $(document).on('focus', '.select2-selection', function(e) {
                $(this).closest(".select2-container").siblings('select:enabled').select2('open');
            })
            let cat = JSON.parse($("#my-cat").data('cat'))
            let catArray = cat.split(", ")

            const url_key = new URL('{{ route('fenomena.getData') }}')
            const url_fenomena_year = new URL("{{ route('fenomenaYear') }}")
            const url_fenomena_quarter = new URL("{{ route('fenomenaQuarter') }}")
            const tokens = '{{ csrf_token() }}'

            $(function() {
                $('[data-toggle="tooltip"]').tooltip()
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
