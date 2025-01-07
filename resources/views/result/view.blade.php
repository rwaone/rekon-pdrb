<x-dashboard-Layout>
    <x-slot name="title">
        {{ __('Rekonsiliasi') }}
    </x-slot>
    <x-slot name="head">
        <!-- Additional resources here -->
        <meta name="csrf-token" content="content">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2/css/select2.min.css">
        <style type="text/css">
            .table td {
                vertical-align: middle;
                padding: 0.25rem;
                white-space: nowrap;
                text-overflow: ellipsis;
                overflow: hidden;
            }

            .table tbody td:not(:first-child) {
                text-align: end;
            }

            .desc-col {
                column-width: 100px;
                word-wrap: break-word;
            }

            .desc-col p {
                word-break: break-all;
            }

            #rekonsiliasi-table td {
                word-wrap: break-word;
            }

            #rekonsiliasi-table .PDRB-footer td p {
                text-align: center !important;
            }
        </style>
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item active">Hasil</li>
    </x-slot>

    <div id="my-cat" data-cat="{{ json_encode($cat) }}"></div>

    @include('rekonsiliasi.filter')

    <div class="card save-container d-none" id="navList">
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
        </ul>
        <div class="ml-auto">
            <button id="download-result" type="button" class="btn btn-success"><i
                    class="bi bi-file-earmark-arrow-down-fill"></i> Download</button>
        </div>
    </div>

    @if ($type == 'Lapangan Usaha')
    <div class="card">
        <div class="card-body p-3">
            <table class="table table-bordered current-result-table" id="result-kabkot-table-adhb">
                <thead class="text-center" style="background-color: #09c140; color:aliceblue;">
                    <tr>
                        <th>Komponen</th>
                        <th>Triwulan I</th>
                        <th>Triwulan II</th>
                        <th>Triwulan III</th>
                        <th>Triwulan IV</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="desc-col">
                            <label class="mb-0">
                                Primer
                            </label>
                        </td>
                        <td class="result-kabkot primer" id="primer_adhb_Q1"></td>
                        <td class="result-kabkot primer" id="primer_adhb_Q2"></td>
                        <td class="result-kabkot primer" id="primer_adhb_Q3"></td>
                        <td class="result-kabkot primer" id="primer_adhb_Q4"></td>
                        <td class="result-kabkot primer" id="primer_adhb_total"></td>
                    </tr>
                    <tr>
                        <td class="desc-col">
                            <label class="mb-0">
                                Sekunder
                            </label>
                        </td>
                        <td class="result-kabkot sekunder" id="sekunder_adhb_Q1"></td>
                        <td class="result-kabkot sekunder" id="sekunder_adhb_Q2"></td>
                        <td class="result-kabkot sekunder" id="sekunder_adhb_Q3"></td>
                        <td class="result-kabkot sekunder" id="sekunder_adhb_Q4"></td>
                        <td class="result-kabkot sekunder" id="sekunder_adhb_total"></td>
                    </tr>
                    <tr>
                        <td class="desc-col">
                            <label class="mb-0">
                                Tersier
                            </label>
                        </td>
                        <td class="result-kabkot tersier" id="tersier_adhb_Q1"></td>
                        <td class="result-kabkot tersier" id="tersier_adhb_Q2"></td>
                        <td class="result-kabkot tersier" id="tersier_adhb_Q3"></td>
                        <td class="result-kabkot tersier" id="tersier_adhb_Q4"></td>
                        <td class="result-kabkot tersier" id="tersier_adhb_total"></td>
                    </tr>
                    <tr class="PDRB-footer text-center"
                        style="background-color: #09c140; color:aliceblue; font-weight: bold;">
                        <td>
                            <label class="mb-0">Total</label>
                        </td>
                        <td id="adhb_total-1" class="total-cell result-kabkot">
                        </td>
                        <td id="adhb_total-2" class="total-cell result-kabkot">
                        </td>
                        <td id="adhb_total-3" class="total-cell result-kabkot">
                        </td>
                        <td id="adhb_total-4" class="total-cell result-kabkot">
                        </td>
                        <td id="adhb_total-5" class="total-cell result-kabkot">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card">
        <div class="card-body p-3">
            <table class="table table-bordered current-result-table" id="result-kabkot-table-adhk">
                <thead class="text-center" style="background-color: #09c140; color:aliceblue;">
                    <tr>
                        <th>Komponen</th>
                        <th>Triwulan I</th>
                        <th>Triwulan II</th>
                        <th>Triwulan III</th>
                        <th>Triwulan IV</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="desc-col">
                            <label class="mb-0">
                                Primer
                            </label>
                        </td>
                        <td class="result-kabkot primer" id="primer_adhk_Q1"></td>
                        <td class="result-kabkot primer" id="primer_adhk_Q2"></td>
                        <td class="result-kabkot primer" id="primer_adhk_Q3"></td>
                        <td class="result-kabkot primer" id="primer_adhk_Q4"></td>
                        <td class="result-kabkot primer" id="primer_adhk_total"></td>
                    </tr>
                    <tr>
                        <td class="desc-col">
                            <label class="mb-0">
                                Sekunder
                            </label>
                        </td>
                        <td class="result-kabkot sekunder" id="sekunder_adhk_Q1"></td>
                        <td class="result-kabkot sekunder" id="sekunder_adhk_Q2"></td>
                        <td class="result-kabkot sekunder" id="sekunder_adhk_Q3"></td>
                        <td class="result-kabkot sekunder" id="sekunder_adhk_Q4"></td>
                        <td class="result-kabkot sekunder" id="sekunder_adhk_total"></td>
                    </tr>
                    <tr>
                        <td class="desc-col">
                            <label class="mb-0">
                                Tersier
                            </label>
                        </td>
                        <td class="result-kabkot tersier" id="tersier_adhk_Q1"></td>
                        <td class="result-kabkot tersier" id="tersier_adhk_Q2"></td>
                        <td class="result-kabkot tersier" id="tersier_adhk_Q3"></td>
                        <td class="result-kabkot tersier" id="tersier_adhk_Q4"></td>
                        <td class="result-kabkot tersier" id="tersier_adhk_total"></td>
                    </tr>
                    <tr class="PDRB-footer text-center"
                        style="background-color: #09c140; color:aliceblue; font-weight: bold;">
                        <td>
                            <label class="mb-0">Total</label>
                        </td>
                        <td id="adhk_total-1" class="total-cell result-kabkot">
                        </td>
                        <td id="adhk_total-2" class="total-cell result-kabkot">
                        </td>
                        <td id="adhk_total-3" class="total-cell result-kabkot">
                        </td>
                        <td id="adhk_total-4" class="total-cell result-kabkot">
                        </td>
                        <td id="adhk_total-5" class="total-cell result-kabkot">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card">
        <div class="card-body p-3">
            <table class="table table-bordered previous-result-table" id="previous-result-kabkot-table-adhb">
                <thead class="text-center" style="background-color: #09c140; color:aliceblue;">
                    <tr>
                        <th>Komponen</th>
                        <th>Triwulan I</th>
                        <th>Triwulan II</th>
                        <th>Triwulan III</th>
                        <th>Triwulan IV</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="desc-col">
                            <label class="mb-0">
                                Primer
                            </label>
                        </td>
                        <td class="result-kabkot primer" id="primer_adhb_Q1"></td>
                        <td class="result-kabkot primer" id="primer_adhb_Q2"></td>
                        <td class="result-kabkot primer" id="primer_adhb_Q3"></td>
                        <td class="result-kabkot primer" id="primer_adhb_Q4"></td>
                        <td class="result-kabkot primer" id="primer_adhb_total"></td>
                    </tr>
                    <tr>
                        <td class="desc-col">
                            <label class="mb-0">
                                Sekunder
                            </label>
                        </td>
                        <td class="result-kabkot sekunder" id="sekunder_adhb_Q1"></td>
                        <td class="result-kabkot sekunder" id="sekunder_adhb_Q2"></td>
                        <td class="result-kabkot sekunder" id="sekunder_adhb_Q3"></td>
                        <td class="result-kabkot sekunder" id="sekunder_adhb_Q4"></td>
                        <td class="result-kabkot sekunder" id="sekunder_adhb_total"></td>
                    </tr>
                    <tr>
                        <td class="desc-col">
                            <label class="mb-0">
                                Tersier
                            </label>
                        </td>
                        <td class="result-kabkot tersier" id="tersier_adhb_Q1"></td>
                        <td class="result-kabkot tersier" id="tersier_adhb_Q2"></td>
                        <td class="result-kabkot tersier" id="tersier_adhb_Q3"></td>
                        <td class="result-kabkot tersier" id="tersier_adhb_Q4"></td>
                        <td class="result-kabkot tersier" id="tersier_adhb_total"></td>
                    </tr>
                    <tr class="PDRB-footer text-center"
                        style="background-color: #09c140; color:aliceblue; font-weight: bold;">
                        <td>
                            <label class="mb-0">Total</label>
                        </td>
                        <td id="adhb_total-1" class="total-cell result-kabkot">
                        </td>
                        <td id="adhb_total-2" class="total-cell result-kabkot">
                        </td>
                        <td id="adhb_total-3" class="total-cell result-kabkot">
                        </td>
                        <td id="adhb_total-4" class="total-cell result-kabkot">
                        </td>
                        <td id="adhb_total-5" class="total-cell result-kabkot">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card">
        <div class="card-body p-3">
            <table class="table table-bordered previous-result-table" id="previous-result-kabkot-table-adhk">
                <thead class="text-center" style="background-color: #09c140; color:aliceblue;">
                    <tr>
                        <th>Komponen</th>
                        <th>Triwulan I</th>
                        <th>Triwulan II</th>
                        <th>Triwulan III</th>
                        <th>Triwulan IV</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="desc-col">
                            <label class="mb-0">
                                Primer
                            </label>
                        </td>
                        <td class="result-kabkot primer" id="primer_adhk_Q1"></td>
                        <td class="result-kabkot primer" id="primer_adhk_Q2"></td>
                        <td class="result-kabkot primer" id="primer_adhk_Q3"></td>
                        <td class="result-kabkot primer" id="primer_adhk_Q4"></td>
                        <td class="result-kabkot primer" id="primer_adhk_total"></td>
                    </tr>
                    <tr>
                        <td class="desc-col">
                            <label class="mb-0">
                                Sekunder
                            </label>
                        </td>
                        <td class="result-kabkot sekunder" id="sekunder_adhk_Q1"></td>
                        <td class="result-kabkot sekunder" id="sekunder_adhk_Q2"></td>
                        <td class="result-kabkot sekunder" id="sekunder_adhk_Q3"></td>
                        <td class="result-kabkot sekunder" id="sekunder_adhk_Q4"></td>
                        <td class="result-kabkot sekunder" id="sekunder_adhk_total"></td>
                    </tr>
                    <tr>
                        <td class="desc-col">
                            <label class="mb-0">
                                Tersier
                            </label>
                        </td>
                        <td class="result-kabkot tersier" id="tersier_adhk_Q1"></td>
                        <td class="result-kabkot tersier" id="tersier_adhk_Q2"></td>
                        <td class="result-kabkot tersier" id="tersier_adhk_Q3"></td>
                        <td class="result-kabkot tersier" id="tersier_adhk_Q4"></td>
                        <td class="result-kabkot tersier" id="tersier_adhk_total"></td>
                    </tr>
                    <tr class="PDRB-footer text-center"
                        style="background-color: #09c140; color:aliceblue; font-weight: bold;">
                        <td>
                            <label class="mb-0">Total</label>
                        </td>
                        <td id="adhk_total-1" class="total-cell result-kabkot">
                        </td>
                        <td id="adhk_total-2" class="total-cell result-kabkot">
                        </td>
                        <td id="adhk_total-3" class="total-cell result-kabkot">
                        </td>
                        <td id="adhk_total-4" class="total-cell result-kabkot">
                        </td>
                        <td id="adhk_total-5" class="total-cell result-kabkot">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div id="adhbFormContainer" class="card form-container d-none"> @include('result.lapangan-adhb-form') </div>
    <div id="adhkFormContainer" class="card form-container d-none"> @include('result.lapangan-adhk-form') </div>
    <div id="tableFormContainer" class="card form-container d-none"> @include('result.lapangan-rekon-table') </div>
    <div id="prevadhbDataContainer" class="card d-none"> @include('result.lapangan-prev-adhb-form') </div>
    <div id="prevadhkDataContainer" class="card d-none"> @include('result.lapangan-prev-adhk-form' )</div>
    @elseif ($type == 'Pengeluaran')
    <div id="adhbFormContainer" class="card form-container d-none"> @include('result.pengeluaran-adhb-form') </div>
    <div id="adhkFormContainer" class="card form-container d-none"> @include('result.pengeluaran-adhk-form') </div>
    <div id="tableFormContainer" class="card form-container d-none"> @include('result.pengeluaran-rekon-table') </div>
    <div id="prevadhbDataContainer" class="card d-none"> @include('result.pengeluaran-prev-adhb-form') </div>
    <div id="prevadhkDataContainer" class="card d-none"> @include('result.pengeluaran-prev-adhk-form') </div>
    @endif

    <!-- Back to top button -->
    <button type="button" class="btn btn-light btn-floating btn-lg" id="btn-back-to-top">
        <i class="fas fa-arrow-up"></i>
    </button>


    <x-slot name="script">
        <!-- Additional JS resources -->
        <script src="{{ url('') }}/plugins/select2/js/select2.full.min.js"></script>
        <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
        @if ($type == 'Lapangan Usaha')
        <script src="{{ asset('js/rekon-lapangan-usaha.js') }}"></script>
        @elseif ($type == 'Pengeluaran')
        <script src="{{ asset('js/rekon-pengeluaran.js') }}"></script>
        @endif
        <script src="{{ asset('js/download.js') }}"></script>
        <script src="{{ asset('js/result.js') }}"></script>
        <script>
            const tokens = '{{ csrf_token() }}'
            const url_fetch_year = new URL("{{ route('fetchYear') }}")
            const url_fetch_quarter = new URL("{{ route('fetchQuarter') }}")
            const url_fetch_period = new URL("{{ route('fetchPeriod') }}")
            const url_save_single_data = new URL("{{ route('saveSingleData') }}")
            const url_save_full_data = new URL("{{ route('saveFullData') }}")
            const url_get_single_data = new URL("{{ route('getSingleData') }}")
            const url_get_full_data = new URL("{{ route('getFullData') }}")
            const url_copy_data = new URL("{{ route('copyData') }}")

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            //Get the button
            let mybutton = document.getElementById("btn-back-to-top");

            $(document).on('focus', '.select2-selection', function(e) {
                $(this).closest(".select2-container").siblings('select:enabled').select2('open');
            })


            //change the value of inputed number to Rupiah 
            function formatRupiah(angka, prefix) {
                var number_string = String(angka)
                    .replace(/[^\-,\d]/g, "")
                    .toString(),
                    isNegative = false;

                if (number_string.startsWith("-")) {
                    isNegative = true;
                    number_string = number_string.substr(1);
                }

                var split = number_string.split(","),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    separator = sisa ? "." : "";
                    rupiah += separator + ribuan.join(".");
                }

                rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;

                if (isNegative) {
                    rupiah = "-" + rupiah;
                }

                return prefix == undefined ? rupiah : rupiah ? "" + rupiah : "";
            }
            //

            $(document).on('select2:open', () => {
                document.querySelector('.select2-search__field').focus();
            });

            $(function() {
                //Initialize Select2 Elements
                $('.select2').select2()

                //Initialize Select2 Elements
                $('.select2bs4').select2({
                    theme: 'bootstrap4',
                    width: '100%',
                })
            });
        </script>
    </x-slot>
</x-dashboard-Layout>