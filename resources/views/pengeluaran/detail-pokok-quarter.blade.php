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

            #rekon-view tr:not(:last-child) td:not(:first-child) {
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
    
    <div class="card save-container" id="navList">
        <ul class="nav nav-pills p-2">
            <li class="nav-item"><a class="nav-link tab-item" type="button" id="nav-adhb">ADHB</a></li>
            <li class="nav-item"><a class="nav-link tab-item" type="button" id="nav-adhk">ADHK</a></li>
            <li class="nav-item"><a class="nav-link tab-item" type="button" id="nav-distribusi">Distribusi</a></li>
            <li class="nav-item"><a class="nav-link tab-item" type="button" id="nav-qtoq">Growth (Q to Q)</a></li>
            <li class="nav-item"><a class="nav-link tab-item" type="button" id="nav-ytoy">Growth (Y on Y)</a></li>
            <li class="nav-item"><a class="nav-link tab-item" type="button" id="nav-ctoc">Growth (C to C)</a></li>
            <li class="nav-item"><a class="nav-link tab-item" type="button" id="nav-indeks">Indeks Implisit</a></li>
            <li class="nav-item"><a class="nav-link tab-item" type="button" id="nav-lajuQ">Laju Implisit (Q to Q)</a></li>
            <li class="nav-item"><a class="nav-link tab-item" type="button" id="nav-lajuY">Laju Implisit (Y on Y)</a></li>
            <li class="nav-item"><a class="nav-link tab-item" type="button" id="nav-sogQ">SOG (Q to Q)</a></li>
            <li class="nav-item"><a class="nav-link tab-item" type="button" id="nav-sogY">SOG (Y on Y)</a></li>
        </ul>
    </div>
    
    <div class="card mb-3" id="view-body">
        <div class="card-body pt-2">
            <nav class="navbar p-0">
                <ul class="nav-item ml-auto">
                    <button class="btn btn-success" id="download-all" data-toogle="tooltip" data-placement="bottom"
                        title="Download All"><i class="bi bi-file-earmark-arrow-down-fill"></i></button>
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
                            <th class="total-column">Total</th>
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
                                    <td class="total-column text-bold"></td>
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
                                    <td id="{{ 'value-' . $index + 1 . '-1' }}"
                                        class="values {{ 'categories-' . $item->sector->category->code }}-1 {{ 'sector-Q1-' . $item->sector_id }} {{ 'category-Q1-' . $item->sector->category_id }}">
                                    </td>
                                    <td id="{{ 'value-' . $index + 1 . '-2' }}"
                                        class="values {{ 'categories-' . $item->sector->category->code }}-2 {{ 'sector-Q2-' . $item->sector_id }} {{ 'category-Q2-' . $item->sector->category_id }}">
                                    </td>
                                    <td id="{{ 'value-' . $index + 1 . '-3' }}"
                                        class="values {{ 'categories-' . $item->sector->category->code }}-3 {{ 'sector-Q3-' . $item->sector_id }} {{ 'category-Q3-' . $item->sector->category_id }}">
                                    </td>
                                    <td id="{{ 'value-' . $index + 1 . '-4' }}"
                                        class="values {{ 'categories-' . $item->sector->category->code }}-4 {{ 'sector-Q4-' . $item->sector_id }} {{ 'category-Q4-' . $item->sector->category_id }}">
                                    </td>
                                    <td class="total-column"></td>                                    
                                </tr>
                            @elseif ($item->code == null && $item->sector->code != null)
                                <tr>
                                    <td>
                                        <p class="text-bold ml-1" style="margin-bottom:0rem;"
                                            for="{{ $item->sector->code . '_' . $item->sector->name }}">
                                            {{ $item->sector->code . '. ' . $item->sector->name }}
                                        </p>
                                    </td>
                                    <td id="{{ 'value-' . $index + 1 . '-1' }}"
                                        class="values text-bold pdrb-total-1 {{ 'categories-' . $item->sector->category->code }}-1 {{ 'sector-Q1-' . $item->sector_id }} {{ 'category-Q1-' . $item->sector->category_id }}">
                                    </td>
                                    <td id="{{ 'value-' . $index + 1 . '-2' }}"
                                        class="values text-bold pdrb-total-2 {{ 'categories-' . $item->sector->category->code }}-2 {{ 'sector-Q2-' . $item->sector_id }} {{ 'category-Q2-' . $item->sector->category_id }}">
                                    </td>
                                    <td id="{{ 'value-' . $index + 1 . '-3' }}"
                                        class="values text-bold pdrb-total-3 {{ 'categories-' . $item->sector->category->code }}-3 {{ 'sector-Q3-' . $item->sector_id }} {{ 'category-Q3-' . $item->sector->category_id }}">
                                    </td>
                                    <td id="{{ 'value-' . $index + 1 . '-4' }}"
                                        class="values text-bold pdrb-total-4 {{ 'categories-' . $item->sector->category->code }}-4 {{ 'sector-Q4-' . $item->sector_id }} {{ 'category-Q4-' . $item->sector->category_id }}">
                                    </td>
                                    <td class="total-column text-bold"></td>
                                </tr>
                            @elseif ($item->code == null && $item->sector->code == null)
                                <tr>
                                    <td>
                                        <label class="" style="margin-bottom:0rem;"
                                            for="{{ $item->sector->category->code . '_' . $item->name }}">{{ $item->sector->category->code . '. ' . $item->name }}</label>
                                    </td>
                                    <td id="{{ 'value-' . $index + 1 . '-1' }}"
                                        class="values {{ 'categories-' . $item->sector->category->code }}-1 {{ 'sector-Q1' . $item->sector_id }} {{ 'category-Q1' . $item->sector->category_id }} text-bold pdrb-total-1">
                                    </td>
                                    <td id="{{ 'value-' . $index + 1 . '-2' }}"
                                        class="values {{ 'categories-' . $item->sector->category->code }}-2 {{ 'sector-Q2' . $item->sector_id }} {{ 'category-Q2' . $item->sector->category_id }} text-bold pdrb-total-2">
                                    </td>
                                    <td id="{{ 'value-' . $index + 1 . '-3' }}"
                                        class="values {{ 'categories-' . $item->sector->category->code }}-3 {{ 'sector-Q3' . $item->sector_id }} {{ 'category-Q3' . $item->sector->category_id }} text-bold pdrb-total-3">
                                    </td>
                                    <td id="{{ 'value-' . $index + 1 . '-4' }}"
                                        class="values {{ 'categories-' . $item->sector->category->code }}-4 {{ 'sector-Q4' . $item->sector_id }} {{ 'category-Q4' . $item->sector->category_id }} text-bold pdrb-total-4">
                                    </td>
                                    <td class="total-column text-bold"></td>
                                </tr>
                            @endif
                        @endforeach
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
                            <td class="total-column" style="margin-bottom:0rem;"></td>
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
            const types = getUrl.pathname.split('/')[1]
            getUrl.searchParams.set('period_id', urlParams.get('period_id'))
            getUrl.searchParams.set('region_id', urlParams.get('region_id'))
            getUrl.searchParams.set('quarter', urlParams.get('quarter'))

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
