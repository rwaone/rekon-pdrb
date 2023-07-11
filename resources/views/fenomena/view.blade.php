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
        <li class="breadcrumb-item active">Fenomena</li>
    </x-slot>

    @include('fenomena.filter')
    <span class="loader d-none"></span>

    <div id="fenomenaFormContainer" class="card">
        @include('fenomena.single-form')
    </div>


    <!-- Back to top button -->
    <button type="button" class="btn btn-light btn-floating btn-lg" id="btn-back-to-top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <x-slot name="script">
        <!-- Additional JS resources -->
        <script src="{{ url('') }}/plugins/select2/js/select2.full.min.js"></script>
        <script src="{{ url('') }}/plugins/datatables/jquery.dataTables.min.js"></script>
        <script>
            //Get the button
            let mybutton = document.getElementById("btn-back-to-top");

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
                        },
                    })
                });

                $('#year').on('change', function() {
                    var pdrb_type = $('#type').val();
                    var pdrb_year = this.value;
                    $('#region_id').val('').change();
                });

                $('#quarter').on('change', function() {
                    var pdrb_quarter = this.value;
                    $('#region_id').val('').change();
                });

                $('#region_id').change(function() {
                    if (this.value != '') {
                        $('#fenomenaFormContainer').removeClass('d-none');
                        showFenomena();
                    } else {
                        $('#fenomenaForm')[0].reset();
                        $('#fenomenaFormContainer').addClass('d-none');
                    }
                });

                function showFenomena() {
                    $('.loader').removeClass('d-none')
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('getFenomena') }}',
                        data: {
                            filter: $('#filterForm').serializeArray().reduce(function(obj, item) {
                                obj[item.name] = item.value;
                                return obj;
                            }, {}),
                            _token: '{{ csrf_token() }}',
                        },

                        success: function(result) {

                            console.log(result);
                            
                            $('#fenomenaForm')[0].reset();

                            $.each(result, function(key, value) {
                                sector_id = (value.sector_id != null) ? value.sector_id : 'NULL';
                                subsector_id = (value.subsector_id != null) ? value.subsector_id : 'NULL';
                                $('textarea[name=value_' + value.category_id + '_' + sector_id + '_' + subsector_id + ']').val(
                                    value.description);
                                $('input[name=id_' + value.category_id + '_' + sector_id + '_' + subsector_id + ']').val(
                                    value.id);
                            });


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

                            $('.loader').addClass('d-none')
                        },
                    });
                };

                $("#fenomenaSave").on('click', function() {
                    fenomena = $('#fenomenaForm').serializeArray().reduce(function(obj, item) {
                                obj[item.name] = item.value;
                                return obj;
                            }, {}),
                    console.log(fenomena);
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('saveFenomena') }}',
                        data: {
                            filter: $('#filterForm').serializeArray().reduce(function(obj, item) {
                                obj[item.name] = item.value;
                                return obj;
                            }, {}),
                            fenomena: $('#fenomenaForm').serializeArray().reduce(function(obj, item) {
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
