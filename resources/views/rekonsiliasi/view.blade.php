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
        <script></script>
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

            #btn-back-to-top {
                position: fixed;
                bottom: 20px;
                right: 20px;
                display: none;
                border-radius: 100%
            }
        </style>
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item active">Rekonsiliasi</li>
    </x-slot>
    <div id="my-cat" data-cat="{{ json_encode($cat) }}"></div>

    @include('rekonsiliasi.filter')

    <span class="loader d-none"></span>

    @if ($type == 'Lapangan Usaha')
        <div id="fullFormContainer" class="card d-none">@include('lapangan.full-form')</div>
        <div id="singleFormContainer" class="card d-none">@include('lapangan.single-form')</div>
    @elseif ($type == 'Pengeluaran')
        <div id="fullFormContainer" class="card d-none">@include('pengeluaran.full-form')</div>
        <div id="singleFormContainer" class="card d-none">@include('pengeluaran.single-form')</div>
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

                    </div>
                    <div class="modal-footer">
                        <button id="copySubmit" type="button" class="btn btn-success float-right">Salin</button>
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
        <script>
            //Get the button
            let mybutton = document.getElementById("btn-back-to-top");

            // When the user scrolls down 20px from the top of the document, show the button
            window.onscroll = function() {
                scrollFunction();
            };

            function scrollFunction() {
                if (
                    document.body.scrollTop > 20 ||
                    document.documentElement.scrollTop > 20
                ) {
                    mybutton.style.display = "block";
                } else {
                    mybutton.style.display = "none";
                }
            }
            // When the user clicks on the button, scroll to the top of the document
            mybutton.addEventListener("click", backToTop);

            function backToTop() {
                document.body.scrollTop = 0;
                document.documentElement.scrollTop = 0;
            }

            $(document).on('focus', '.select2-selection', function(e) {
                $(this).closest(".select2-container").siblings('select:enabled').select2('open');
            })


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

            $(document).ready(function() {

                let cat = JSON.parse($("#my-cat").data('cat'))
                let catArray = cat.split(", ")

                $('#type').on('change', function() {
                    var pdrb_type = this.value;
                    $("#year").html('');
                    $('#region_id').val('').change();
                    $('#price_base').val('').change();

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('fetchYear') }}',
                        data: {
                            type: pdrb_type,
                            _token: '{{ csrf_token() }}',
                        },
                        dataType: 'json',

                        success: function(result) {
                            $('#year').html('<option value=""> Pilih Tahun </option>');
                            $.each(result.years, function(key, value) {
                                $('#year').append('<option value="' + value.year + '">' +
                                    value.year + '</option>');
                            });
                            $.each(result.years, function(key, value) {
                                $('#year-copy').append('<option value="' + value.year +
                                    '">' +
                                    value.year + '</option>');
                            });
                            $('#quarter').append(
                                '<option value="" disabled selected> Pilih Triwulan </option>');
                            $('#period').append(
                                '<option value="" selected> Pilih Periode </option>');
                        },
                    })
                });

                $('#year').on('change', function() {
                    var pdrb_type = $('#type').val();
                    var pdrb_year = this.value;
                    $("#quarter").html('');
                    $('#region_id').val('').change();
                    $('#price_base').val('').change();

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('fetchQuarter') }}',
                        data: {
                            type: pdrb_type,
                            year: pdrb_year,
                            _token: '{{ csrf_token() }}',
                        },
                        dataType: 'json',

                        success: function(result) {
                            $('#quarter').html(
                                '<option value="" selected> Pilih Triwulan </option>');
                            $.each(result.quarters, function(key, value) {
                                var description = (value.quarter == 'Y') ? 'Tahunan' :
                                    'Triwulan ' + value.quarter;
                                $('#quarter').append('<option value="' + value.quarter +
                                    '">' + description + '</option>');
                            });
                            $('#period').append(
                                '<option value="" selected> Pilih Periode </option>');
                        },
                    })
                });

                $('#year-copy').on('change', function() {
                    var pdrb_type = $('#type').val();
                    var pdrb_year = this.value;
                    $("#quarter-copy").html('');

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('fetchQuarter') }}',
                        data: {
                            type: pdrb_type,
                            year: pdrb_year,
                            _token: '{{ csrf_token() }}',
                        },
                        dataType: 'json',

                        success: function(result) {
                            $('#quarter-copy').html(
                                '<option value="" selected> Pilih Triwulan </option>');
                            $.each(result.quarters, function(key, value) {
                                var description = (value.quarter == 'Y') ? 'Tahunan' :
                                    'Triwulan ' + value.quarter;
                                $('#quarter-copy').append('<option value="' + value
                                    .quarter +
                                    '">' + description + '</option>');
                            });
                            $('#period-copy').append(
                                '<option value="" selected> Pilih Periode </option>');
                        },
                    })
                });

                $('#quarter').on('change', function() {
                    var pdrb_type = $('#type').val();
                    var pdrb_year = $('#year').val();
                    var pdrb_quarter = this.value;
                    $("#period").html('');
                    $('#region_id').val('').change();
                    $('#price_base').val('').change();

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('fetchPeriod') }}',
                        data: {
                            type: pdrb_type,
                            year: pdrb_year,
                            quarter: pdrb_quarter,
                            _token: '{{ csrf_token() }}',
                        },
                        dataType: 'json',

                        success: function(result) {
                            $('#period').html('<option value="" selected> Pilih Periode </option>');
                            $.each(result.periods, function(key, value) {
                                $('#period').append('<option value="' + value.id + '">' +
                                    value.description + ' (' + value.status + ')' +
                                    '</option>');
                            });
                        },
                    })
                });

                $('#quarter-copy').on('change', function() {
                    var pdrb_type = $('#type').val();
                    var pdrb_year = $('#year-copy').val();
                    var pdrb_quarter = this.value;
                    $("#period-copy").html('');

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('fetchPeriod') }}',
                        data: {
                            type: pdrb_type,
                            year: pdrb_year,
                            quarter: pdrb_quarter,
                            _token: '{{ csrf_token() }}',
                        },
                        dataType: 'json',

                        success: function(result) {
                            $('#period-copy').html(
                                '<option value="" selected> Pilih Periode </option>');
                            $.each(result.periods, function(key, value) {
                                $('#period-copy').append('<option value="' + value.id +
                                    '">' +
                                    value.description + ' (' + value.status + ')' +
                                    '</option>');
                            });
                        },
                    })
                });

                $('#period').change(function() {
                    $('#region_id').val('').change();
                    $('#price_base').val('').change();
                    if ($('#period').text().includes('Aktif')) {
                        console.log('Aktif')
                        $('#singleFormSave').prop('disabled', false);
                        $('#fullFormSave').prop('disabled', false);
                    } else {
                        console.log('Tidak Aktif')
                        $('#fullFormSave').prop('disabled', true);
                        $('#singleFormSave').prop('disabled', true);
                    }
                });

                $('#region_id').change(function() {
                    $('#price_base').val('').change();
                });

                $('#price_base').change(function() {
                    if (this.value != '') {
                        showForm();
                    } else {
                        $('#fullFormContainer').addClass('d-none');
                        $('#fullForm')[0].reset();
                        $('#singleFormContainer').addClass('d-none');
                        $('#singleForm')[0].reset();
                    }
                });

                function showForm() {
                    $('.loader').removeClass('d-none')
                    var quarter = $('#quarter').val();
                    setTimeout(function() {
                        if (quarter == 'Y') {
                            getSingleData();
                            $('#fullFormContainer').addClass('d-none');
                            $('#singleFormContainer').removeClass('d-none');
                        } else if (quarter != null) {
                            getFullData();
                            $('input[name*=value_]').prop('disabled', false);
                            $('input[name*=id_]').prop('disabled', false);
                            if (quarter < 4) {
                                for (let index = +quarter + 1; index < 5; index++) {
                                    console.log(index);
                                    $('input[name*=value_' + index + '_]').prop('disabled', true);
                                    $('input[name*=id_' + index + '_]').prop('disabled', true);
                                }
                            }
                            $('input[name*=value_Y]').prop('disabled', true);
                        } else {
                            $('#fullFormContainer').addClass('d-none');
                            $('#singleFormContainer').addClass('d-none');
                        }
                        $('.loader').addClass('d-none')
                    }, 500)
                };


                function getSingleData() {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('getSingleData') }}',
                        data: {
                            filter: $('#filterForm').serializeArray().reduce(function(obj, item) {
                                obj[item.name] = item.value;
                                return obj;
                            }, {}),
                            _token: '{{ csrf_token() }}',
                        },

                        success: function(result) {
                            $('#singleForm')[0].reset();
                            if ($('#price_base').val() == 'adhk') {
                                $.each(result, function(key, value) {
                                    pdrbValue = ((value.adhk != null) ? formatRupiah(value.adhk
                                        .replace('.', ','),
                                        'Rp. ') : formatRupiah(0,
                                        'Rp. '));
                                    $('input[name=value_' + value.subsector_id + ']').val(
                                        pdrbValue);
                                    $('input[name=id_' + value.subsector_id + ']').val(
                                        value.id);
                                });

                            } else {

                                $.each(result, function(key, value) {
                                    pdrbValue = ((value.adhb != null) ? formatRupiah(value.adhb
                                        .replace('.', ','),
                                        'Rp. ') : formatRupiah(0,
                                        'Rp. '));
                                    $('input[name=value_' + value.subsector_id + ']').val(
                                        pdrbValue);
                                    $('input[name=id_' + value.subsector_id + ']').val(
                                        value.id);
                                });
                            }

                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });

                            Toast.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Data berhasil ditampilkan.'
                            })
                        },
                    });
                }

                function getFullData() {
                    $('#fullFormContainer').removeClass('d-none');
                    $('#singleFormContainer').addClass('d-none');
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('getFullData') }}',
                        data: {
                            filter: $('#filterForm').serializeArray().reduce(function(obj, item) {
                                obj[item.name] = item.value;
                                return obj;
                            }, {}),
                            _token: '{{ csrf_token() }}',
                        },

                        success: function(result) {
                            console.log(result);
                            $('#fullForm')[0].reset();
                            if ($('#price_base').val() == 'adhk') {
                                $.each(result, function(quarter, value) {
                                    $.each(value, function(key, value) {
                                        pdrbValue = ((value.adhk != null) ? formatRupiah(
                                            value.adhk
                                            .replace('.', ','),
                                            'Rp. ') : formatRupiah(0,
                                            'Rp. '));
                                        $('input[name=value_' + quarter + '_' + value
                                            .subsector_id + ']').val(
                                            pdrbValue);
                                        $('input[name=id_' + quarter + '_' + value
                                            .subsector_id + ']').val(
                                            value.id);
                                    });
                                });

                            } else {
                                $.each(result, function(quarter, value) {
                                    $.each(value, function(key, value) {
                                        pdrbValue = ((value.adhb != null) ? formatRupiah(
                                            value.adhb
                                            .replace('.', ','),
                                            'Rp. ') : formatRupiah(0,
                                            'Rp. '));
                                        $('input[name=value_' + quarter + '_' + value
                                            .subsector_id + ']').val(
                                            pdrbValue);
                                        $('input[name=id_' + quarter + '_' + value
                                            .subsector_id + ']').val(
                                            value.id);
                                    });
                                });
                            }

                            let jumlahSector1 = calculateSector('sector-Y-1').toFixed(2);
                            let queSector1 = String(jumlahSector1).replaceAll(/[.]/g, ',');
                            $('#adhk_1_A_Y').val(formatRupiah(queSector1, 'Rp '));


                            let jumlahSector8 = calculateSector('sector-Y-8').toFixed(2);
                            let queSector8 = String(jumlahSector8).replaceAll(/[.]/g, ',');
                            $('#adhk_1_C_Y').val(formatRupiah(queSector8, 'Rp '));

                            for (let j = 1; j < 18; j++) {
                                let jumlah = calculateSector(`category-Y-${j}`).toFixed(2);
                                let que = String(jumlah).replaceAll(/[.]/g, ',');
                                $(`#adhk_${catArray[j - 1]}_Y`).val(formatRupiah(que,
                                    'Rp '))
                            }

                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });

                            Toast.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Data berhasil ditampilkan.'
                            })
                        },
                    });
                }

                $("#copySubmit").on('click', function() {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('copyData') }}',
                        data: {
                            filter: $('#filterForm').serializeArray().reduce(function(obj, item) {
                                obj[item.name] = item.value;
                                return obj;
                            }, {}),
                            copy: $('#copyDataForm').serializeArray().reduce(function(obj, item) {
                                obj[item.name] = item.value;
                                return obj;
                            }, {}),
                            _token: '{{ csrf_token() }}',
                        },

                        success: function(result) {
                            console.log(result);
                            if ($('#price_base').val() == 'adhk') {
                                $.each(result, function(quarter, value) {
                                    $.each(value, function(key, value) {
                                        pdrbValue = ((value.adhk != null) ?
                                            formatRupiah(
                                                value.adhk
                                                .replace('.', ','),
                                                'Rp. ') : formatRupiah(0,
                                                'Rp. '));
                                        $('input[name=value_' + quarter + '_' +
                                            value
                                            .subsector_id + ']').val(
                                            pdrbValue);
                                        $('input[name=id_' + quarter + '_' + value
                                            .subsector_id + ']').val(
                                            value.id);
                                    });
                                });

                            } else {
                                $.each(result, function(quarter, value) {
                                    $.each(value, function(key, value) {
                                        pdrbValue = ((value.adhb != null) ?
                                            formatRupiah(
                                                value.adhb
                                                .replace('.', ','),
                                                'Rp. ') : formatRupiah(0,
                                                'Rp. '));
                                        $('input[name=value_' + quarter + '_' +
                                            value
                                            .subsector_id + ']').val(
                                            pdrbValue);
                                        $('input[name=id_' + quarter + '_' + value
                                            .subsector_id + ']').val(
                                            value.id);
                                    });
                                });
                            }

                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });

                            Toast.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Data berhasil disalin.'
                            })
                        },
                    })
                });

                $("#singleFormSave").on('click', function() {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('saveSingleData') }}',
                        data: {
                            filter: $('#filterForm').serializeArray().reduce(function(obj, item) {
                                obj[item.name] = item.value;
                                return obj;
                            }, {}),
                            input: $('#singleForm').serializeArray().reduce(function(obj, item) {
                                obj[item.name] = item.value;
                                return obj;
                            }, {}),
                            _token: '{{ csrf_token() }}',
                        },

                        success: function(result) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });

                            Toast.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Data berhasil disimpan.'
                            })
                        },
                    });
                });

                $("#fullFormSave").click(function() {
                    input = $('#fullForm').serializeArray().reduce(function(obj, item) {
                        obj[item.name] = item.value;
                        return obj;
                    }, {});
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('saveFullData') }}',
                        data: {
                            filter: $('#filterForm').serializeArray().reduce(function(obj, item) {
                                obj[item.name] = item.value;
                                return obj;
                            }, {}),
                            input: $('#fullForm').serializeArray().reduce(function(obj, item) {
                                obj[item.name] = item.value;
                                return obj;
                            }, {}),
                            _token: '{{ csrf_token() }}',
                        },

                        success: function(result) {
                            console.log(result)
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });

                            Toast.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Data berhasil disimpan.'
                            })
                        },
                    });
                });
            });
        </script>
    </x-slot>
</x-dashboard-Layout>
