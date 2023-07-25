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
        <li class="breadcrumb-item active">Entri Rekonsiliasi</li>
    </x-slot>
    <div id="my-cat" data-cat="{{ json_encode($cat) }}"></div>

    @include('rekonsiliasi.filter')

    <span class="loader d-none"></span>

    <div class="card d-none" id="navList">
        <ul class="nav nav-pills p-2">
            <li class="nav-item"><a class="nav-link" href="#" id="nav-adhb">ADHB</a></li>
            <li class="nav-item"><a class="nav-link" href="#" id="nav-adhk">ADHK</a></li>
            <li class="nav-item"><a class="nav-link" href="#" id="nav-distribusi">Distribusi</a></li>
            <li class="nav-item"><a class="nav-link" href="#" id="nav-qtoq">Q to Q</a></li>
            <li class="nav-item"><a class="nav-link" href="#" id="nav-ytoy">Y to Y</a></li>
            <li class="nav-item"><a class="nav-link" href="#" id="nav-ctoc">C to C</a></li>
            <li class="nav-item"><a class="nav-link" href="#" id="nav-idx-implisit">Indeks Implisit</a></li>
            <li class="nav-item"><a class="nav-link" href="#" id="nav-laju">Laju Implisit</a></li>
            <div class="ml-auto">
                <button id="fullFormSave" type="button" class="btn btn-success">Simpan</button>
            </div>
        </ul>
    </div>

    @if ($type == 'Lapangan Usaha')
        <div id="adhbFormContainer" class="card form-container d-none">@include('lapangan.adhb-form')</div>
        <div id="adhkFormContainer" class="card form-container d-none">@include('lapangan.adhk-form')</div>
        <div id="tableFormContainer" class="card form-container">@include('lapangan.rekon-table')</div>
    @elseif ($type == 'Pengeluaran')
        <div id="fullFormContainer" class="card d-none">@include('pengeluaran.full-form')</div>
    @endif

    <!-- Back to top button -->
    <button type="button" class="btn btn-light btn-floating btn-lg" id="btn-back-to-top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <div class="modal fade" id="copy-modal">

        <div class="modal-dialog modal-md">
            <form id="copyDataForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Salin Data Sebelumnya</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label class="col-form-label" for="year-copy">Tahun:</label>
                            <select id="year-copy" class="form-control select2bs4" style="width: 100%;" name="yearCopy">
                                <option value="" disabled selected>Pilih Tahun</option>
                            </select>
                            <div class="help-block"></div>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="quarter-copy">Triwulan:</label>
                            <select id="quarter-copy" class="form-control select2bs4" style="width: 100%;"
                                name="quarterCopy">
                                <option value="" disabled selected>Pilih Triwulan</option>
                            </select>
                            <div class="help-block"></div>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="period-copy">Periode:</label>
                            <select id="period-copy" class="form-control select2bs4" style="width: 100%;"
                                name="periodCopy">
                                <option value="" disabled selected>Pilih Putaran</option>
                            </select>
                            <div class="help-block"></div>
                        </div>


                        <input type="hidden" id="copy-price-base">

                    </div>
                    <div class="modal-footer">
                        <button onclick="" id="copySubmit" type="button"
                            class="btn btn-success float-right">Salin</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <x-slot name="script">
        <!-- Additional JS resources -->
        <script src="{{ url('') }}/plugins/select2/js/select2.full.min.js"></script>
        <script src="{{ asset('js/rekon-lapangan-usaha.js') }}"></script>
        <script src="{{ asset('js/rekon-pengeluaran.js') }}"></script>
        <script src="{{ asset('js/rekonsiliasi.js') }}"></script>
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
                    theme: 'bootstrap4'
                })
            });
        </script>
    </x-slot>
</x-dashboard-Layout>
