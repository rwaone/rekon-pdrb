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
            }
        </style>
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item active">Rekonsiliasi</li>
    </x-slot>
    <div id="my-cat" data-cat="{{ json_encode($cat) }}"></div>

    @include('rekonsiliasi.filter')

    <span class="loader d-none"></span>

    <div id="fullFormContainer" class="card d-none">@include('rekonsiliasi.full-form')</div>
    <div id="singleFormContainer" class="card d-none">@include('rekonsiliasi.single-form')</div>

    <!-- Back to top button -->
    <button type="button" class="btn btn-light btn-floating btn-lg" id="btn-back-to-top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <x-slot name="script">
        <!-- Additional JS resources -->
        <script src="{{ url('') }}/plugins/select2/js/select2.full.min.js"></script>
        <script src="{{ asset('js/rekonsiliasi.js') }}"></script>
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

            //sum of each value in sector and category
            function calculateSector(sector) {
                let sum = 0;
                // let sector = sector.replaceAll(",","");
                $(`.${sector}`).each(function(index) {
                    let X = $(this).val().replaceAll(/[A-Za-z.]/g, '');
                    let Y = X.replaceAll(/[,]/g, '.')
                    sum += Y > 0 ? Number(Y) : 0;
                });
                return sum;
            }
            //

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
                                var description = (value.quarter == 'F') ? 'Lengkap' : ((
                                        value.quarter == 'Y') ? 'Tahunan' :
                                    'Triwulan ' + value.quarter);
                                $('#quarter').append('<option value="' + value.quarter +
                                    '">' + description + '</option>');
                            });
                            $('#period').append(
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
                                    value.description + '</option>');
                            });
                        },
                    })
                });

                $('#period').change(function() {
                    $('#region_id').val('').change();
                    $('#price_base').val('').change();
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
                        if (quarter == 'F') {
                            getFullData()
                        } else if (quarter != null) {
                            getSingleData();
                        } else {
                            $('#fullFormContainer').addClass('d-none');
                            $('#singleFormContainer').addClass('d-none');
                        }
                        $('.loader').addClass('d-none')
                    }, 500)
                };


                function getSingleData() {
                    $('#fullFormContainer').addClass('d-none');
                    $('#singleFormContainer').removeClass('d-none');
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

                            console.log(result);
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

                $("#singleFormSave").on('click', function() {
                    // console.log(data);
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

                            console.log(result);
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

                            console.log(result);
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
