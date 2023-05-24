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
            .table td {
                vertical-align: middle;
                padding: 0.25rem;
            }

            #rekon-view td {
                word-wrap: break-word;
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
                                <option {{ old('type', $filter['type']) == 'Pengeluaran' ? 'selected' : '' }}
                                    value='Pengeluaran'>Pengeluaran</option>
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
                                        <option {{ old('quarter', $filter['quarter']) == $quarter->quarter ? 'selected' : '' }}
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
                            <div class="btn btn-danger col-md-1" id = "refresh"><i class="bi bi-x-lg"></i></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <span class="loader d-none"></span>
        <div class="card mb-3 d-none" id="view-body">
            <div class="card-body">
                <nav class="navbar">
                    <ul class="nav nav-tabs d-flex">
                        <a class="nav-item nav-link" id = "nav-adhb" href="#">ADHB</a>
                        <a class="nav-item nav-link" id = "nav-adhk" href="#">ADHK</a>
                        <a class="nav-item nav-link" id = "nav-distribusi" href="#">Distribusi</a>
                        <a class="nav-item nav-link" id = "nav-pertumbuhan" href="#">Pertumbuhan</a>
                        <a class="nav-item nav-link" id = "nav-indeks" href="#">Indeks Implisit</a>
                        <a class="nav-item nav-link" id = "nav-laju" href="#">Laju Implisit</a>
                        <a class="nav-item nav-link" id = "nav-sumber" href="#">Sumber Pertumbuhan</a>
                    </ul>
                </nav>
                <table class="table table-bordered" id="rekon-view">
                    <thead class="text-center" style="background-color: steelblue; color:aliceblue;">
                        <tr>
                            <th>Komponen</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subsectors as $index => $item)
                            @if (($item->code != NULL && $item->code == "a" && $item->sector->code == "1") || ($item->code == NULL && $item->sector->code == "1"))
                                <tr>
                                    <td>
                                        <label class="col" style="margin-bottom:0rem;"
                                            for="">{{ $item->sector->category->code . '. ' . $item->sector->category->name }}</label>
                                    </td>
                                    <td id="categories-{{ $item->sector->category->code }}" class="categories values"></td>
                                </tr>
                            @endif
                            @if ($item->code != null && $item->code == 'a')
                            <tr>
                                <td>
                                    <p class="col ml-4" style="margin-bottom:0rem;" for="">
                                        {{ $item->sector->code . '. ' . $item->sector->name }}</p>
                                </td>
                                <td id="sector-{{ $index+1 }}" class="values"></td>
                            </tr>
                        @endif
                        @if ($item->code != null)
                            <tr>
                                <td>
                                    <p class="col ml-5" style="margin-bottom:0rem;"
                                        for="{{ $item->code }}_{{ $item->name }}">
                                        {{ $item->code . '. ' . $item->name }}</p>
                                </td>
                                <td id="{{ "value-".$item->id }}" class ="values {{ 'categories-'.$item->sector->category->code }}"></td>
                            </tr>
                        @elseif ($item->code == null && $item->sector->code != null)
                            <tr>
                                <td>
                                    <p class="col ml-4" style="margin-bottom:0rem;"
                                        for="{{ $item->sector->code . '_' . $item->sector->name }}">
                                        {{ $item->sector->code . '. ' . $item->sector->name }}</p>
                                </td>
                                <td id="{{ "value-".$item->id }}" class ="values {{ 'categories-'.$item->sector->category->code }}"></td>
                            </tr>
                        @elseif ($item->code == null && $item->sector->code == null)
                            <tr>
                                <td>
                                    <label class="col" style="margin-bottom:0rem;"
                                        for="{{ $item->sector->category->code . '_' . $item->name }}">{{ $item->sector->category->code . '. ' . $item->name }}</label>
                                </td>
                                <td id="{{ "value-".$item->id }}" class = "values {{ 'categories-'.$item->sector->category->code }} text-bold pdrb-total"></td>
                            </tr>
                        @endif
                        @endforeach
                        <tr class = "PDRB-footer text-center" style="background-color: steelblue; color:aliceblue; font-weight: bold;">
                        <td>
                            <p class="col mt-1 mb-1" style="margin-bottom:0rem;"> Produk Domestik Regional Bruto (PDRB) Nonmigas </p>
                        </td>
                        <td id="total-nonmigas" style="margin-bottom:0rem;"></td>
                        </td>
                    </tr>
                    <tr class = "PDRB-footer text-center" style="background-color: steelblue; color:aliceblue; font-weight: bold;">
                        <td>
                            <p class="col mt-1 mb-1" style="margin-bottom:0rem;"> Produk Domestik Regional Bruto (PDRB) </p>
                        </td>
                        <td id="total" style="margin-bottom:0rem;"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <x-slot name="script">
        <!-- Additional JS resources -->
        <script src="{{ url('') }}/plugins/select2/js/select2.full.min.js"></script>
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

            function simpleSum(atri) {
                let X = $(`${atri}`).text().replaceAll(/[A-Za-z.]/g,'')
                let Y = X.replaceAll(/[,]/g, '.')
                return Number(Y)
            }

            function distribusi(values){
                let X = simpleSum(values)
                let Y = simpleSum('#total')
                let score = X > 0 ? X/Y * 100 : 0 
                return score > 0 ? score.toFixed(2) : 0
            }

            function getDist(){
                $('.view-distribusi').each(function(){
                    let id = '#' + $(this).attr('id')
                    let y = distribusi(id)
                    $(this).text(y)
                })
                $('#total-nonmigas').text(distribusi('#total-nonmigas'))
                $('#total').text(distribusi('#total'))
            }

            function getIdx(adhb, adhk) {
                let result = adhb > 0 ? adhb/adhk * 100 : ''
                return result > 0 ? result.toFixed(2) : ''
            }
            function getFilter() {
                const dataStored = localStorage.getItem('dataStored')
                if (dataStored){
                    let data = JSON.parse(dataStored)
                    for (let i = 0; i < data.length; i++) {
                            $(`#value-${i+1}`).text(data[i].adhb)
                        }
                    getSummarise()
                    $('#view-body').removeClass('d-none')
                }
            }

            //change
            $(document).ready(function() {
                let tbody = $('#rekon-view').find('tbody')
                $('#nav-distribusi').on('click', function(){
                    $('tbody td:nth-child(2)').removeClass(function(index, className) {
                        return (className.match(/(^|\s)view-\S+/g) || []).join(' ')
                    })
                    getFilter()
                    $('tbody tr:not(:last-child):not(:nth-last-child(2)) td:nth-child(2)').addClass('view-distribusi')
                    getDist()
                })
            
                $('#nav-adhb').on('click', function(){
                    $('tbody td:nth-child(2)').removeClass(function(index, className) {
                        return (className.match(/(^|\s)view-\S+/g) || []).join(' ')
                    })
                    $('tbody td:nth-child(2)').addClass('view-adhb')
                    getFilter()
                })

                $('#nav-adhk').on('click', function(){
                    $('tbody td:nth-child(2)').removeClass(function(index, className) {
                        return (className.match(/(^|\s)view-\S+/g) || []).join(' ')
                    })
                    $('tbody td:nth-child(2)').addClass('view-adhk')
                    getFilter()
                    const period_id = $('#period').val()
                    $.ajax({
                        type: 'GET',
                        url: '/getKonserda/' + period_id,
                        dataType: 'json',
                        success: function (data) {
                            for (let i = 0; i < data.length; i++) {
                                $(`#value-${i+1}`).text(data[i].adhk)
                            }
                            getSummarise()
                        }  
                    })
                })
                
                //belum tau gimana
                // $('#nav-pertumbuhan').on('click', function(){
                //     $('tbody td:nth-child(2)').removeClass(function(index, className) {
                //         return (className.match(/(^|\s)view-\S+/g) || []).join(' ')
                //     })
                //     $('tbody td:nth-child(2)').addClass('view-pertumbuhan')
                // })

                //indeks implisit adhb/adhk
                $('#nav-indeks').on('click', function(){
                    $('tbody td:nth-child(2)').removeClass(function(index, className) {
                        return (className.match(/(^|\s)view-\S+/g) || []).join(' ')
                    })
                    $('tbody td:nth-child(2)').addClass('view-indeks')
                    const period_id = $('#period').val()
                    $.ajax({
                        type: 'GET',
                        url: '/getKonserda/' + period_id,
                        dataType: 'json',
                        success: function (data) {
                            for (let i = 0; i < data.length; i++) {
                                $(`#value-${i+1}`).text(data[i].adhb)
                            }
                            getSummarise()
                            let adhb = []
                            $('tbody td:not(:first-child)').each(function() {
                                let X = $(this).text().replaceAll(/[A-Za-z.]/g,'')
                                let Y = X.replaceAll(/[,]/g, '.')
                                adhb.push(Number(Y))
                            })
                            for (let i = 0; i < data.length; i++) {
                                $(`#value-${i+1}`).text(data[i].adhk)
                            }
                            getSummarise()
                            let adhk = []
                            $('tbody td:not(:first-child)').each(function() {
                                let X = $(this).text().replaceAll(/[A-Za-z.]/g,'')
                                let Y = X.replaceAll(/[,]/g, '.')
                                adhk.push(Number(Y))
                            })
                            let idx = []
                            for (let i = 0; i < adhb.length; i++){
                                idx.push(getIdx(adhb[i], adhk[i]))
                            }
                            $('tbody td:not(:first-child)').each(function(index) {
                                $(this).text(idx[index])
                            })
                        }  
                    })
                })
            })

            //summarise
            function getSummarise(){
                let sum = 0
                $('.values').each(function () {
                    $(this).text(formatRupiah($(this).text(), 'Rp '))
                })
                for (let i = 1; i <= 7; i++) {
                    let X = $(`#value-${i}`).text().replaceAll(/[A-Za-z.]/g,'')
                    // let X = $(`#value-${i}`).text()
                    let Y = X.replaceAll(/[,]/g, '.')
                    sum += Y > 0 ? Number(Y) : 0
                }
                $('#sector-1').text(formatRupiah(String(sum).replaceAll(/[.]/g, ','), 'Rp '))
                sum = sum - sum
                for (let i = 14; i <= 15; i++) {
                    let X = $(`#value-${i}`).text().replaceAll(/[A-Za-z.]/g,'')
                    let Y = X.replaceAll(/[,]/g, '.')
                    sum += Y > 0 ? Number(Y) : 0
                }
                $('#sector-14').text(formatRupiah(String(sum).replaceAll(/[.]/g, ','), 'Rp '))
                sum = sum - sum
                for (let index of catArray){    
                    let jumlah = calculateSector(`categories-${index}`)
                    let que = String(jumlah).replaceAll(/[.]/g, ',')
                    $(`#categories-${index}`).text(formatRupiah(que, 'Rp '))
                    $(`#categories-${index}`).addClass('text-bold pdrb-total')
                }
                let pdrb = calculateSector('pdrb-total')
                let nonmigas = simpleSum('#value-10') + simpleSum('#value-15')
                $('#total').text(formatRupiah(String(pdrb), 'Rp '))
                
                let pdrbNonmigas = pdrb - nonmigas
                $('#total-nonmigas').text(formatRupiah(String(pdrbNonmigas), 'Rp '))
            }

            //filter
            $(document).ready(function() {
                $('#type').on('change', function() {
                    let pdrb_type = $(this).val()
                    if(pdrb_type){
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
                    if(pdrb_year){
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
                    if(pdrb_quarter){
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

            //get the data
            $(document).ready(function() {
                $('#showData').click(function(e){
                    e.preventDefault()
                    const period_id = $('#period').val()
                    $.ajax({
                        beforeSend: function(){
                          $('.loader').removeClass('d-none')  
                        },
                        type: 'GET',
                        url: '/getKonserda/' + period_id,
                        dataType: 'json',
                        success: function (data) {
                            for (let i = 0; i < data.length; i++) {
                                $(`#value-${i+1}`).text(data[i].adhb)
                            }
                            getSummarise()
                            setTimeout(function() {
                                $('.loader').addClass('d-none')
                                $('#view-body').removeClass('d-none')
                            }, 1000)
                            localStorage.setItem('dataStored', JSON.stringify(data))
                        },
                        error: function (jqXHR, textStatus, errorThrown){
                            $('.loader').addClass('d-none')
                            localStorage.clear()
                            alert('Error : Pilihan Error')
                        },
                    })
                })

                $('#refresh').click(function(){
                    $('#view-body').addClass('d-none')
                })
            })

            //get localized storage data
            $(document).ready(function(){
                getFilter()
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
