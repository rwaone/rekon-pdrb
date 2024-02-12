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
                padding: 5px;
            }
        </style>
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item active">Rekonsiliasi</li>
    </x-slot>
    <form id="monitoring">
        @csrf
        <div class="row mb-5">
            <div class="col-2">
                <select class="form-control select2bs4" id="type" name="type">
                    <option value="" selected>-- Pilih Jenis PDRB --</option>
                    <option {{ old('type', $filter['type']) == 'Pengeluaran' ? 'selected' : '' }} value='Pengeluaran'>
                        Pengeluaran</option>
                </select>
            </div>
            <div class="col-2">
                <select class="form-control select2bs4" id="year" name="year">
                    <option value="" selected>-- Pilih Periode Tahun --</option>
                    @if ($years)
                        @foreach ($years as $year)
                            <option {{ old('year', $filter['year']) == $year->year ? 'selected' : '' }}
                                value="{{ $year->year }}">{{ $year->year }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-2">
                <select class="form-control select2bs4" id="quarter" name="quarter">
                    <option value="" selected>-- Pilih Periode Triwulan --</option>
                    @if ($quarters)
                        @foreach ($quarters as $quarter)
                            <option {{ old('quarter', $filter['quarter']) == $quarter->quarter ? 'selected' : '' }}
                                value="{{ $quarter->quarter }}">
                                {{ $quarter->quarter == 'F' ? 'Lengkap' : ($quarter->quarter == 'T' ? 'Tahunan' : 'Triwulan ' . $quarter->quarter) }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-2">
                <select class="form-control select2bs4" id="period" name="period">
                    <option value="" selected>-- Pilih Periode Putaran --</option>
                    @if ($periods)
                        @foreach ($periods as $period)
                            <option {{ old('period', $filter['period_id']) == $period->id ? 'selected' : '' }}
                                value="{{ $period->id }}">{{ $period->description }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-2">
                <div class="row">
                    <button class="btn btn-info col-8 mr-1" id="showData">Tampilkan</button>
                    <div class="btn btn-danger col-3" id="refresh"><i class="bi bi-x-lg"></i></div>
                </div>
            </div>
        </div>
    </form>
    <span class="loader d-none"></span>
    <div id="monitoring-container">
        @include('pengeluaran.monitoring-container')
    </div>

    <x-slot name="script">
        <!-- Additional JS resources -->
        <script src="{{ url('') }}/plugins/select2/js/select2.full.min.js"></script>
        <script src="{{ asset('js/pdrb-monitoring.js') }}"></script>
        <script>
            const url_fetch_year = new URL("{{ route('fetchYear') }}")
            const url_fetch_quarter = new URL("{{ route('fetchQuarter') }}")
            const url_fetch_period = new URL("{{ route('fetchPeriod') }}")
            const tokens = "{{ csrf_token() }}"
            $(document).ready(function() {
                $('.views').each(function() {
                    if ($(this).attr('id') !== $("#year").val()) {
                        $(this).addClass('d-none');
                    }
                })
            })
            $('#showData').on('click', function(e) {
                e.preventDefault();
                const datas = $("#monitoring").serialize();
                $.ajax({
                    data: datas,
                    url: "{{ route('pengeluaran.getMonitoring') }}",
                    type: "GET",
                    beforeSend: function() {
                        $(".loader").removeClass("d-none");
                    },
                    complete: function() {
                        setTimeout(() => {
                            $(".loader").addClass("d-none");
                        }, 320);
                    },
                    success: function(datas) {
                        $("#monitoring-container").html(datas);
                        $('#monitoring-kuarter tbody tr td span.status').each(function() {
                            if ($(this).text() === "Entry") {
                                $(this).addClass("badge bg-warning");
                            } else if ($(this).text() === "Submitted") {
                                $(this).addClass("badge bg-success");
                            } else if ($(this).text() === "Belum Input") {
                                $(this).addClass("badge bg-danger");
                            }
                        })
                    },
                    error: function(error) {
                        alert(error.message);
                    }
                })
            });
            $('#monitoring-kuarter tbody tr td span.status').each(function() {
                if ($(this).text() === "Entry") {
                    $(this).addClass("badge bg-warning");
                } else if ($(this).text() === "Submitted") {
                    $(this).addClass("badge bg-success");
                } else if ($(this).text() === "Belum Input") {
                    $(this).addClass("badge bg-danger");
                }
            })

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
