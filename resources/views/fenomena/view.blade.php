<x-dashboard-Layout>
    <x-slot name="title">
        {{ __('Fenomena') }}
    </x-slot>
    <x-slot name="head">
        <!-- Additional resources here -->
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
        <script></script>
        <style type="text/css">
        .table td { 
            vertical-align: middle;
            padding: 0.25rem;
        }
        .table tr:nth-child(even) {
            background-color: ; 
        }
        </style>
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item active">Fenomena</li>
    </x-slot>

    @include('rekonsiliasi.filter')
    <span class="loader d-none"></span>

    <div class="card">
        @include('fenomena.single-form')
    </div>

    <x-slot name="script">
        <!-- Additional JS resources -->
        <script src="{{ url('') }}/plugins/select2/js/select2.full.min.js"></script>
        <script src="{{ url('') }}/plugins/datatables/jquery.dataTables.min.js"></script>
        <script>
            $(document).on('focus', '.select2-selection', function(e) {
                $(this).closest(".select2-container").siblings('select:enabled').select2('open');
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

            $(document).ready(function() {
                
                $('#type').on('change', function() {
                    var pdrb_type = this.value;
                    $("#year").html('');
                    $('#region_id').val('').change();
                    $('#price_base').val('').change();

                    $.ajax({
                        type: 'POST',
                        url: '{{ route("fetchYear") }}',
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
                        url: '{{ route("fetchQuarter") }}',
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
                        url: '{{ route("fetchPeriod") }}',
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
                        showFenomena();
                    } else {
                        $('#fenomenaSingleForm')[0].reset();
                    }
                });

                function showFenomena() {
                    $('.loader').removeClass('d-none')
                    $.ajax({
                        type: 'POST',
                        url: '{{ route("getFenomena") }}',
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
                };

                $("#singleFormSave").on('click', function() {
                    // console.log(data);
                    $.ajax({
                        type: 'POST',
                        url: '{{ route("saveSingleData") }}',
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

            });
            
        </script>
    </x-slot>
</x-dashboard-Layout>
