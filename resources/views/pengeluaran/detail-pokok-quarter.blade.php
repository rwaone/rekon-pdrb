<x-dashboard-Layout>
    <x-slot name="title">
        {{ __('Tabel') }}
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
                white-space: nowrap;
                text-overflow: ellipsis;
                overflow: hidden;
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

            tbody td:not(:first-child) {
                width: 200px;
            }
        </style>
        @vite(['resources/css/app.css'])
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item active">Konserda</li>
        <div id="my-cat" data-cat="{{ json_encode($cat) }}"></div>
    </x-slot>
    <div class="card mb-3" id="view-body">
        <div class="card-body">
            <nav class="navbar d-flex justify-content-center">
                <ul class="nav nav-tabs d-flex">
                    <a class="nav-item nav-link" id="nav-adhb" href="">ADHB</a>
                    <a class="nav-item nav-link" id="nav-adhk" href="">ADHK</a>
                    <a class="nav-item nav-link" id="nav-distribusi" href="">Distribusi</a>
                    <a class="nav-item nav-link" id="nav-pertumbuhan" href="">Pertumbuhan</a>
                    <a class="nav-item nav-link" id="nav-indeks" href="">Indeks Implisit</a>
                    <a class="nav-item nav-link" id="nav-laju" href="">Laju Implisit</a>
                </ul>
            </nav>
            <span class="loader d-none"></span>
            <div class="table-container">
                <table class="table table-bordered" id="rekon-view">
                    <thead class="text-center" style="background-color: steelblue; color:aliceblue;">
                        <tr>
                            <th>Komponen</th>
                            <th>Triwulan I</th>
                            <th>Triwulan II</th>
                            <th>Triwulan III</th>
                            <th>Triwulan IV</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subsectors as $index => $item)
                            @if ($item->code != null && $item->code == 'a')
                                <tr>
                                    <td>
                                        <p class="text-bold ml-1" style="margin-bottom:0rem;" for="">
                                            {{ $item->sector->code . '. ' . $item->sector->name }}
                                        </p>
                                    </td>
                                    <td id="sector-{{ $index + 1 }}-1" class="values"></td>
                                    <td id="sector-{{ $index + 1 }}-2" class="values"></td>
                                    <td id="sector-{{ $index + 1 }}-3" class="values"></td>
                                    <td id="sector-{{ $index + 1 }}-4" class="values"></td>
                                </tr>
                            @endif
                            @if ($item->code != null)
                                <tr>
                                    <td>
                                        <p class="ml-4" style="margin-bottom:0rem;"
                                            for="{{ $item->code }}_{{ $item->name }}">
                                            {{ $item->code . '. ' . $item->name }}
                                        </p>
                                    </td>
                                    <td id="{{ 'value-' . $item->id . '-1' }}"
                                        class="values {{ 'categories-' . $item->sector->category->code }}-1 {{ 'sector-Q1-' . $item->sector_id }} {{ 'category-Q1-' . $item->sector->category_id }}">
                                    </td>
                                    <td id="{{ 'value-' . $item->id . '-2' }}"
                                        class="values {{ 'categories-' . $item->sector->category->code }}-2 {{ 'sector-Q2-' . $item->sector_id }} {{ 'category-Q2-' . $item->sector->category_id }}">
                                    </td>
                                    <td id="{{ 'value-' . $item->id . '-3' }}"
                                        class="values {{ 'categories-' . $item->sector->category->code }}-3 {{ 'sector-Q3-' . $item->sector_id }} {{ 'category-Q3-' . $item->sector->category_id }}">
                                    </td>
                                    <td id="{{ 'value-' . $item->id . '-4' }}"
                                        class="values {{ 'categories-' . $item->sector->category->code }}-4 {{ 'sector-Q4-' . $item->sector_id }} {{ 'category-Q4-' . $item->sector->category_id }}">
                                    </td>
                                </tr>
                            @elseif ($item->code == null && $item->sector->code != null)
                                <tr>
                                    <td>
                                        <p class="text-bold ml-1" style="margin-bottom:0rem;"
                                            for="{{ $item->sector->code . '_' . $item->sector->name }}">
                                            {{ $item->sector->code . '. ' . $item->sector->name }}
                                        </p>
                                    </td>
                                    <td id="{{ 'value-' . $item->id . '-1' }}"
                                        class="values {{ 'categories-' . $item->sector->category->code }}-1 {{ 'sector-Q1-' . $item->sector_id }} {{ 'category-Q1-' . $item->sector->category_id }}">
                                    </td>
                                    <td id="{{ 'value-' . $item->id . '-2' }}"
                                        class="values {{ 'categories-' . $item->sector->category->code }}-2 {{ 'sector-Q2-' . $item->sector_id }} {{ 'category-Q2-' . $item->sector->category_id }}">
                                    </td>
                                    <td id="{{ 'value-' . $item->id . '-3' }}"
                                        class="values {{ 'categories-' . $item->sector->category->code }}-3 {{ 'sector-Q3-' . $item->sector_id }} {{ 'category-Q3-' . $item->sector->category_id }}">
                                    </td>
                                    <td id="{{ 'value-' . $item->id . '-4' }}"
                                        class="values {{ 'categories-' . $item->sector->category->code }}-4 {{ 'sector-Q4-' . $item->sector_id }} {{ 'category-Q4-' . $item->sector->category_id }}">
                                    </td>
                                </tr>
                            @elseif ($item->code == null && $item->sector->code == null)
                                <tr>
                                    <td>
                                        <label class="" style="margin-bottom:0rem;"
                                            for="{{ $item->sector->category->code . '_' . $item->name }}">{{ $item->sector->category->code . '. ' . $item->name }}</label>
                                    </td>
                                    <td id="{{ 'value-' . $item->id . '-1' }}"
                                        class="values {{ 'categories-' . $item->sector->category->code }}-1 {{ 'sector-Q1' . $item->sector_id }} {{ 'category-Q1' . $item->sector->category_id }} text-bold pdrb-total-1">
                                    </td>
                                    <td id="{{ 'value-' . $item->id . '-2' }}"
                                        class="values {{ 'categories-' . $item->sector->category->code }}-2 {{ 'sector-Q2' . $item->sector_id }} {{ 'category-Q2' . $item->sector->category_id }} text-bold pdrb-total-2">
                                    </td>
                                    <td id="{{ 'value-' . $item->id . '-3' }}"
                                        class="values {{ 'categories-' . $item->sector->category->code }}-3 {{ 'sector-Q3' . $item->sector_id }} {{ 'category-Q3' . $item->sector->category_id }} text-bold pdrb-total-3">
                                    </td>
                                    <td id="{{ 'value-' . $item->id . '-4' }}"
                                        class="values {{ 'categories-' . $item->sector->category->code }}-4 {{ 'sector-Q4' . $item->sector_id }} {{ 'category-Q4' . $item->sector->category_id }} text-bold pdrb-total-4">
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        <tr class="PDRB-footer text-center"
                            style="background-color: steelblue; color:aliceblue; font-weight: bold;">
                            <td>
                                <p class="col mt-1 mb-1" style="margin-bottom:0rem;"> Produk Domestik Regional Bruto
                                    (PDRB) Nonmigas </p>
                            </td>
                            <td id="total-nonmigas-1" style="margin-bottom:0rem;"></td>
                            <td id="total-nonmigas-2" style="margin-bottom:0rem;"></td>
                            <td id="total-nonmigas-3" style="margin-bottom:0rem;"></td>
                            <td id="total-nonmigas-4" style="margin-bottom:0rem;"></td>
                        </tr>
                        <tr class="PDRB-footer text-center"
                            style="background-color: steelblue; color:aliceblue; font-weight: bold;">
                            <td>
                                <p class="col mt-1 mb-1" style="margin-bottom:0rem;"> Produk Domestik Regional Bruto
                                    (PDRB) </p>
                            </td>
                            <td id="total-1" style="margin-bottom:0rem;"></td>
                            <td id="total-2" style="margin-bottom:0rem;"></td>
                            <td id="total-3" style="margin-bottom:0rem;"></td>
                            <td id="total-4" style="margin-bottom:0rem;"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <x-slot name="script">
        <!-- Additional JS resources -->
        <script src="{{ url('') }}/plugins/select2/js/select2.full.min.js"></script>
        <script src="{{ asset('js/detail-pokok-quarter.js') }}"></script>
        <script>
            $(document).on('focus', '.select2-selection', function(e) {
                $(this).closest(".select2-container").siblings('select:enabled').select2('open');
            })
            let cat = JSON.parse($("#my-cat").data('cat'))
            let adhk_data = ($("#my-adhk").data('adhk'))
            let adhb_data = ($("#my-adhb").data('adhb'))
            let catArray = cat.split(", ")
            let urlParams = new URLSearchParams(window.location.search)
            let getUrl = new URL('{{ route('pengeluaran.getDetail') }}')
            getUrl.searchParams.set('period_id', urlParams.get('period_id'))
            getUrl.searchParams.set('region_id', urlParams.get('region_id'))
            getUrl.searchParams.set('quarter', urlParams.get('quarter'))

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
            $(document).ready(function() {
                $.ajax({
                    type: 'GET',
                    url: getUrl.href,
                    dataType: 'json',
                    success: function (data) {
                        setTimeout(function () {
                            console.log(data)
                            localStorage.setItem("data", JSON.stringify(data.data))
                            getAdhb(data.data)
                        })
                    }
                })
            })
            //change
            $(document).ready(function() {
                let tbody = $('#rekon-view').find('tbody')
                $('#nav-distribusi').on('click', function(e) {
                    e.preventDefault()
                    $('.loader').removeClass('d-none')
                    setTimeout(function() {
                        getAdhb()
                        $('tbody td:nth-child(n+2):nth-child(-n+6)').removeClass(function(index,
                            className) {
                            return (className.match(/(^|\s)view-\S+/g) || []).join(' ')
                        })
                        for (let q = 1; q <= 5; q++) {
                            for (let i = 0; i <= 55; i++) {
                                $(`#value-${i}-${q}`).addClass(`view-distribusi-${q}`)
                                $(`#sector-${i}-${q}`).addClass(`view-distribusi-${q}`)
                            }
                            for (let index of catArray) {
                                $(`#categories-${index}-${q}`).addClass(`view-distribusi-${q}`)
                            }
                        }
                        getDist()
                        $('.loader').addClass('d-none')
                    }, 500)
                })

                $('#nav-adhb').on('click', function(e) {
                    e.preventDefault()
                    $('.loader').removeClass('d-none')
                    setTimeout(function() {
                        getAdhb()
                        $('.loader').addClass('d-none')
                    }, 500)
                })

                $('#nav-adhk').on('click', function(e) {
                    e.preventDefault()
                    $('.loader').removeClass('d-none')
                    setTimeout(function() {
                        getAdhk()
                        $('.loader').addClass('d-none')
                    }, 500)
                })

                //belum tau gimana
                $('#nav-pertumbuhan').on('click', function(e) {
                    e.preventDefault()
                    $('.loader').removeClass('d-none')
                    setTimeout(function() {
                        getGrowth()
                        $('.loader').addClass('d-none')
                    }, 500)
                })

                //indeks implisit adhb/adhk
                $('#nav-indeks').on('click', function(e) {
                    e.preventDefault()
                    $('.loader').removeClass('d-none')
                    setTimeout(function() {
                        getIndex()
                        $('.loader').addClass('d-none')
                    }, 500)
                })

                //laju index
                $('#nav-laju').on('click', function(e) {
                    e.preventDefault()
                    $('.loader').removeClass('d-none')
                    setTimeout(function() {
                        let laju = getIndex()
                        getLaju(laju)
                        $('.loader').addClass('d-none')
                    }, 500)
                })
            })

            //summarise

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
