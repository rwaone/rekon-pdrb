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
                            <option {{ old('type', $filter['type']) == 'Lapangan Usaha' ? 'selected' : '' }} value='Lapangan Usaha'>Lapangan Usaha</option>
                            <option {{ old('type', $filter['type']) == 'Pengeluaran' ? 'selected' : '' }} value='Pengeluaran'>Pengeluaran</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-control select2bs4" id="year" name="year">
                            <option value="" selected>-- Pilih Tahun --</option>
                            @if ($years)
                            @foreach ($years as $year)
                            <option {{ old('year', $filter['year']) == $year->year ? 'selected' : '' }} value="{{ $year->year }}">{{ $year->year }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-control select2bs4" id="quarter" name="quarter">
                            <option value="" selected>-- Pilih Triwulan --</option>
                            @if ($quarters)
                            @foreach ($quarters as $quarter)
                            <option {{ old('quarter', $filter['quarter']) == $quarter->quarter ? 'selected' : '' }} value="{{ $quarter->quarter }}">
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
                            <option {{ old('period', $filter['period_id']) == $period->id ? 'selected' : '' }} value="{{ $period->id }}">{{ $period->description }}</option>
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
    <div class="card mb-3" id="view-body">
        <div class="card-body">
            <nav class="navbar">
                <ul class="nav nav-tabs d-flex">
                    <a class="nav-item nav-link" id="nav-adhb" href="">ADHB</a>
                    <a class="nav-item nav-link" id="nav-adhk" href="">ADHK</a>
                    <a class="nav-item nav-link" id="nav-distribusi" href="">Struktur Dalam</a>
                    <a class="nav-item nav-link" id="nav-struktur-antar" href="">Struktur Antar</a>
                    <a class="nav-item nav-link" id="nav-pertumbuhan" href="">Pertumbuhan</a>
                    <a class="nav-item nav-link" id="nav-indeks" href="">Indeks Implisit</a>
                    <a class="nav-item nav-link" id="nav-laju" href="">Laju Implisit</a>
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
                                @if (($item->code != NULL && $item->code == "a" && $item->sector->code == "1") || ($item->code == NULL && $item->sector->code == "1"))
                                <tr>
                                    <td class="first-columns">
                                        <label style="margin-bottom:0rem;" for="">{{ $item->sector->category->code . '. ' . $item->sector->category->name }}</label>
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
                                        <p class=" ml-5" style="margin-bottom:0rem;" for="{{ $item->code }}_{{ $item->name }}">
                                            {{ $item->code . '. ' . $item->name }}
                                        </p>
                                    </td>
                                </tr>
                                @elseif ($item->code == null && $item->sector->code != null)
                                <tr>
                                    <td class="first-columns">
                                        <p class=" ml-4" style="margin-bottom:0rem;" for="{{ $item->sector->code . '_' . $item->sector->name }}">
                                            {{ $item->sector->code . '. ' . $item->sector->name }}
                                        </p>
                                    </td>
                                </tr>
                                @elseif ($item->code == null && $item->sector->code == null)
                                <tr>
                                    <td class="first-columns">
                                        <label class="" style="margin-bottom:0rem;" for="{{ $item->sector->category->code . '_' . $item->name }}">{{ $item->sector->category->code . '. ' . $item->name }}</label>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                                <tr class="PDRB-footer text-center" style="background-color: steelblue; color:aliceblue; font-weight: bold;">
                                    <td>Produk Domestik Regional Bruto (PDRB) Nonmigas</td>
                                </tr>
                                <tr class="PDRB-footer text-center" style="background-color: steelblue; color:aliceblue; font-weight: bold;">
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
                                    <th>{{$region->name}}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subsectors as $index => $item)
                                @if (($item->code != NULL && $item->code == "a" && $item->sector->code == "1") || ($item->code == NULL && $item->sector->code == "1"))
                                <tr>
                                    <td id="purpose-categories-{{ $index+1 }}" class="text-bold"></td>
                                    <td id="categories-totalKabkot-{{ $index+1 }}" class="sum-of-kabkot text-bold"></td>
                                    @foreach ($regions as $region)
                                    <td id="categories-{{ $item->sector->category->code.'-'.$region->id }}" class="categories text-right values other-columns"></td>
                                    @endforeach
                                </tr>
                                @endif
                                @if ($item->code != null && $item->code == 'a')
                                <tr>
                                    <td id="sector-purpose-{{ $index+1 }}" class=""></td>
                                    <td id="sector-totalKabkot-{{ $index+1 }}" class="sum-of-kabkot"></td>
                                    @foreach ($regions as $region)
                                    <td id="sector-{{ $index+1 }}-{{ $region->id }}" class="text-right values other-columns"></td>
                                    @endforeach
                                </tr>
                                @endif
                                @if ($item->code != null)
                                <tr>
                                    <td id="purpose-{{ $index+1 }}" class=""></td>
                                    <td id="totalKabkot-{{ $index+1 }}" class="sum-of-kabkot"></td>
                                    @foreach ($regions as $region)
                                    <td id="{{ 'value-'.$item->id }}-{{ $region->id }}" class="text-right values other-columns {{ 'categories-'.$item->sector->category->code }}-{{ $region->id }}"></td>
                                    @endforeach
                                </tr>
                                @elseif ($item->code == null && $item->sector->code != null)
                                <tr>
                                    <td id="purpose-{{ $index+1 }}" class=""></td>
                                    <td id="totalKabkot-{{ $index+1 }}" class="sum-of-kabkot"></td>
                                    @foreach ($regions as $region)
                                    <td id="{{ 'value-'.$item->id }}-{{ $region->id }}" class="text-right values other-columns {{ 'categories-'.$item->sector->category->code }}-{{ $region->id }}"></td>
                                    @endforeach
                                </tr>
                                @elseif ($item->code == null && $item->sector->code == null)
                                <tr>
                                    <td id="purpose-{{ $index+1 }}" class=" text-bold"></td>
                                    <td id="totalKabkot-{{ $index+1 }}" class="sum-of-kabkot text-bold"></td>
                                    @foreach ($regions as $region)
                                    <td id="{{ 'value-'.$item->id }}-{{ $region->id }}" class="text-right values other-columns {{ 'categories-'.$item->sector->category->code }}-{{ $region->id }} text-bold pdrb-total"></td>
                                    @endforeach
                                </tr>
                                @endif
                                @endforeach
                                <tr class="PDRB-footer text-right" style="background-color: steelblue; color:aliceblue; font-weight: bold;">
                                    <td class="text-right" id="purpose-nonmigas"></td>
                                    <td class="sum-of-kabkot text-right" id="totalKabkot-nonmigas"></td>
                                    @foreach ($regions as $region)
                                    <td id="total-nonmigas-{{ $region->id }}" style="margin-bottom:0rem;"></td>
                                    @endforeach
                                </tr>
                                <tr class="PDRB-footer text-right" style="background-color: steelblue; color:aliceblue; font-weight: bold;">
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
        <x-slot name="script">
            <!-- Additional JS resources -->
            <script src="{{ url('') }}/plugins/select2/js/select2.full.min.js"></script>
            <script src="{{ asset('js/konserda.js') }}"></script>
            <script>
                $(document).on('focus', '.select2-selection', function(e) {
                    $(this).closest(".select2-container").siblings('select:enabled').select2('open');
                })
                let cat = JSON.parse($("#my-cat").data('cat'))
                let catArray = cat.split(", ")

                //sum of each value in sector and category
                function calculateSector(sector) {
                    let sum = 0;
                    // let sector = sector.replaceAll(",","");
                    $(`.${sector}`).each(function(index) {
                        let X = $(this).text().replaceAll(/[A-Za-z.]/g, '');
                        let Y = X.replaceAll(/[,]/g, '.')
                        sum += Y > 0 ? Number(Y) : 0;
                    });
                    return sum;
                }

                //change the value of inputed number to Rupiah 
                function formatRupiah(angka, prefix) {
                    var number_string = String(angka).replace(/[^,\d]/g, '').toString(),
                        split = number_string.split(','),
                        sisa = split[0].length % 3,
                        rupiah = split[0].substr(0, sisa),
                        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                    if (ribuan) {
                        separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                    }

                    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
                }
                //

                function getStored() {
                    const dataStored = localStorage.getItem('dataStored')
                    if (dataStored) {
                        let data = JSON.parse(dataStored)
                        getAdhb(data)
                        $('#view-body').removeClass('d-none')
                    }
                }

                //get the data
                $(document).ready(function() {
                    $('#showData').click(function(e) {
                        e.preventDefault()
                        const period_id = $('#period').val()
                        $.ajax({
                            beforeSend: function() {
                                $('.loader').removeClass('d-none')
                            },
                            type: 'GET',
                            url: '/getKonserda/' + period_id,
                            dataType: 'json',
                            success: function(data) {
                                setTimeout(function() {
                                    // console.log(data)
                                    getAdhb(data.data)
                                    $('.loader').addClass('d-none')
                                    $('#view-body').removeClass('d-none')
                                }, 200)
                                localStorage.setItem('dataStored', JSON.stringify(data.data))
                                localStorage.setItem('filters', period_id)
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                $('.loader').addClass('d-none')
                                localStorage.clear()
                                alert('Error : Pilihan Error')
                            },
                        })
                    })

                    $('#refresh').click(function() {
                        localStorage.clear()
                        $('#view-body').addClass('d-none')
                    })
                })

                //change
                $(document).ready(function() {
                    let tbody = $('#rekon-view').find('tbody')
                    $('#nav-distribusi').on('click', function(e) {
                        e.preventDefault()
                        $('.loader').removeClass('d-none')
                        setTimeout(function() {
                            getStored()
                            $('#rekon-view tbody td').removeClass(function(index, className) {
                                return (className.match(/(^|\s)view-\S+/g) || []).join(' ')
                            })
                            for (let q = 1; q <= 16; q++) {
                                for (let i = 0; i <= 55; i++) {
                                    $(`#value-${i}-${q}`).addClass(`view-distribusi-${q}`)
                                    $(`#sector-${i}-${q}`).addClass(`view-distribusi-${q}`)
                                }
                                for (let index of catArray) {
                                    $(`#categories-${index}-${q}`).addClass(`view-distribusi-${q}`)
                                }
                            }
                            $('#rekon-view tbody td:nth-child(2)').each(function() {
                                $(this).addClass(`view-distribusi-totalKabkot`)
                            })
                            $('.loader').addClass('d-none')
                            showOff()
                            getDist()
                        }, 200)
                    })

                    $('#nav-adhb').on('click', function(e) {
                        e.preventDefault()
                        $('.loader').removeClass('d-none')
                        setTimeout(function() {
                            $('.loader').addClass('d-none')
                            showOff()
                            getStored()
                        }, 200)
                    })

                    $('#nav-adhk').on('click', function(e) {
                        e.preventDefault()
                        let period_id
                        if ($('#period').val() !== '') {
                            period_id = $('#period').val()
                        } else {
                            period_id = localStorage.getItem('filters')
                        }
                        $.ajax({
                            beforeSend: function() {
                                $('.loader').removeClass('d-none')
                            },
                            type: 'GET',
                            url: '/getKonserda/' + period_id,
                            dataType: 'json',
                            success: function(data) {
                                setTimeout(function() {
                                    $('.loader').addClass('d-none')
                                    showOff()
                                    getAdhk(data.data)
                                }, 200)
                            }
                        })
                    })

                    //indeks implisit adhb/adhk
                    $('#nav-indeks').on('click', function(e) {
                        e.preventDefault()
                        let period_id
                        if ($('#period').val() !== '') {
                            period_id = $('#period').val()
                        } else {
                            period_id = localStorage.getItem('filters')
                        }
                        $.ajax({
                            beforeSend: function() {
                                $('.loader').removeClass('d-none')
                            },
                            type: 'GET',
                            url: '/getKonserda/' + period_id,
                            dataType: 'json',
                            success: function(data) {
                                setTimeout(function() {
                                    $('.loader').addClass('d-none')
                                    showOff()
                                    getIndex(data.data)
                                }, 200)
                            }
                        })
                    })

                    $('#nav-laju').on('click', function(e) {
                        e.preventDefault()
                        let period_id
                        if ($('#period').val() !== '') {
                            period_id = $('#period').val()
                        } else {
                            period_id = localStorage.getItem('filters')
                        }
                        $.ajax({
                            beforeSend: function() {
                                $('.loader').removeClass('d-none')
                            },
                            type: 'GET',
                            url: '/getKonserda/' + period_id,
                            dataType: 'json',
                            success: function(data) {
                                setTimeout(function() {
                                    $('.loader').addClass('d-none')
                                    showOff()
                                    if (data.before === null || data.before.length === 0) {
                                        alert('Data tahun lalu tidak ada')
                                    } else {
                                        let first = getIndex(data.data)
                                        let before = getIndex(data.before)
                                        getLaju(first, before)
                                    }
                                }, 200)
                            }
                        })
                    })

                    //growth
                    $('#nav-pertumbuhan').on('click', function(e) {
                        e.preventDefault()
                        let period_id
                        if ($('#period').val() !== '') {
                            period_id = $('#period').val()
                        } else {
                            period_id = localStorage.getItem('filters')
                        }
                        $.ajax({
                            beforeSend: function() {
                                $('.loader').removeClass('d-none')
                            },
                            type: 'GET',
                            url: '/getKonserda/' + period_id,
                            dataType: 'json',
                            success: function(data) {
                                setTimeout(function() {
                                    $('.loader').addClass('d-none')
                                    showOff()
                                    if (data.before === null || data.before.length === 0) {
                                        alert('Data tahun lalu tidak ada')
                                    } else {
                                        getGrowth(data.data, data.before)
                                    }
                                }, 200)
                            }
                        })
                    })

                    //struktur antar
                    $('#nav-struktur-antar').on('click', function(e) {
                        e.preventDefault()
                        let period_id
                        if ($('#period').val() !== '') {
                            period_id = $('#period').val()
                        } else {
                            period_id = localStorage.getItem('filters')
                        }
                        $.ajax({
                            beforeSend: function() {
                                $('.loader').removeClass('d-none')
                            },
                            type: 'GET',
                            url: '/getKonserda/' + period_id,
                            dataType: 'json',
                            success: function(data) {
                                setTimeout(function() {
                                    $('.loader').addClass('d-none')
                                    getAntar(data.data)
                                }, 200)
                            }
                        })
                    })
                })

                //filter
                $(document).ready(function() {
                    $('#type').on('change', function() {
                        let pdrb_type = $(this).val()
                        if (pdrb_type) {
                            $.ajax({
                                type: 'POST',
                                url: "{{ route('fetchYear') }}",
                                data: {
                                    type: pdrb_type,
                                    _token: '{{csrf_token()}}',
                                },
                                dataType: 'json',

                                success: function(result) {
                                    $('#year').empty()
                                    $('#year').append('<option value="">-- Pilih Tahun --</option>')
                                    $.each(result.years, function(key, value) {
                                        $('#year').append('<option value="' + value.year + '">' + value.year + '</option>')
                                    })
                                },
                            })
                        } else {
                            $('#year').empty()
                            $('#year').append('<option value="">-- Pilih Tahun --</option>')
                            $('#quarter').empty()
                            $('#quarter').append('<option value="" selected>-- Pilih Triwulan --</option>')
                            $('#period').empty()
                            $('#period').append('<option value="" selected>-- Pilih Putaran --</option>')
                        }
                    })

                    $('#year').on('change', function() {
                        var pdrb_type = $('#type').val()
                        var pdrb_year = this.value
                        if (pdrb_year) {
                            $.ajax({
                                type: 'POST',
                                url: "{{ route('fetchQuarter') }}",
                                data: {
                                    type: pdrb_type,
                                    year: pdrb_year,
                                    _token: '{{csrf_token()}}',
                                },
                                dataType: 'json',

                                success: function(result) {
                                    $('#quarter').empty()
                                    $('#quarter').append('<option value="" selected>-- Pilih Triwulan --</option>')
                                    $.each(result.quarters, function(key, value) {
                                        var description = (value.quarter == 'F') ? 'Lengkap' : ((value.quarter == 'T') ? 'Tahunan' : 'Triwulan ' + value.quarter)
                                        $('#quarter').append('<option value="' + value.quarter + '">' + description + '</option>')
                                    })
                                },
                            })
                        } else {
                            $('#quarter').empty()
                            $('#quarter').append('<option value="" selected>-- Pilih Triwulan --</option>')
                            $('#period').empty()
                            $('#period').append('<option value="" selected>-- Pilih Putaran --</option>')
                        }
                    })

                    $('#quarter').on('change', function() {
                        var pdrb_type = $('#type').val()
                        var pdrb_year = $('#year').val()
                        var pdrb_quarter = this.value
                        if (pdrb_quarter) {
                            $.ajax({
                                type: 'POST',
                                url: "{{ route('fetchPeriod') }}",
                                data: {
                                    type: pdrb_type,
                                    year: pdrb_year,
                                    quarter: pdrb_quarter,
                                    _token: '{{csrf_token()}}',
                                },
                                dataType: 'json',

                                success: function(result) {
                                    $('#period').empty()
                                    $('#period').append('<option value="" selected>-- Pilih Putaran --</option>')
                                    $.each(result.periods, function(key, value) {
                                        $('#period').append('<option value="' + value.id + '">' + value.description + '</option>')
                                    })
                                },
                            })
                        } else {
                            $('#period').empty()
                            $('#period').append('<option value="" selected>-- Pilih Putaran --</option>')
                        }
                    })
                })

                //get localized storage data
                $(document).ready(function() {
                    getStored()
                    getTotalKabkot()
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