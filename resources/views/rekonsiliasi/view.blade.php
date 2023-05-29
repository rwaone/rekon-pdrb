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

            #rekonsiliasi-table tr:not(:last-child):not(:nth-last-child(2)) td:not(:first-child) {
                text-align: right;
            }
        </style>
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item active">Rekonsiliasi</li>
    </x-slot>
    <div id="my-cat" data-cat="{{ json_encode($cat) }}"></div>

    @include('rekonsiliasi.filter')

    <div id="fullFormContainer" class="card d-none">@include('rekonsiliasi.full-form')</div>
    <div id="singleFormContainer" class="card d-none">@include('rekonsiliasi.single-form')</div>

    <x-slot name="script">
        <!-- Additional JS resources -->
        <script src="{{ url('') }}/plugins/select2/js/select2.full.min.js"></script>
        <script>
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

            $(document).ready(function() {
                // Your jQuery code goes here
                let cat = JSON.parse($("#my-cat").data('cat'))
                let catArray = cat.split(", ")
                let catB = "A,B,C,D,G,H,I,K"
                let catSpecific = catB.split(",")
                let catLast = catArray.filter(value => !catSpecific.includes(value))
                let sum = 0

                //full-form last column sum
                let table = $('#rekonsiliasi-table');
                let tbody = table.find('tbody');
                let tr = tbody.find('tr');

                tr.on('blur', 'td input', function(e) {
                    let sum = 0;
                    let $currentRow = $(this).closest('tr');
                    let $lastCol = $currentRow.find('td:last');
                    $currentRow.find('td:not(:last-child) input').each(function() {
                        let X = $(this).val().replaceAll(/[A-Za-z.]/g, '');
                        let Y = X.replaceAll(/[,]/g, '.');
                        sum += Y > 0 ? Number(Y) : 0;
                    });
                    let sumRp = String(sum).replaceAll(/[.]/g, ',');
                    $lastCol.find('input').val(formatRupiah(sumRp, 'Rp '));

                    for (let index of catSpecific) {
                        let darksum = 0
                        let lightsum = 0

                        let row = $(`#adhk_${index}_Y`).closest('tr')
                        let subsection = $(`#adhk_1_${index}_Y`).closest('tr')

                        row.find('td input:not(#adhk_' + index + '_Y)').each(function() {
                            if (!$(this).hasClass(`adhk_${index}_Y`)) {
                                let X = $(this).val().replaceAll(/[A-Za-z.]/g, '');
                                let Y = X.replaceAll(/[,]/g, '.');
                                darksum += Y > 0 ? Number(Y) : 0;
                            }
                        })

                        subsection.find('td input:not(#adhk_1_' + index + '_Y)').each(function() {
                            if (!$(this).hasClass(`adhk_${index}_Y`)) {
                                let X = $(this).val().replaceAll(/[A-Za-z.]/g, '');
                                let Y = X.replaceAll(/[,]/g, '.');
                                lightsum += Y > 0 ? Number(Y) : 0;
                            }
                        })

                        let lightsumRp = String(lightsum).replaceAll(/[.]/g, ',');
                        let darksumRp = String(darksum).replaceAll(/[.]/g, ',');
                        $(`#adhk_1_${index}_Y`).val(formatRupiah(lightsumRp, 'Rp '))
                        $(`#adhk_${index}_Y`).val(formatRupiah(darksumRp, 'Rp '))
                    }

                    let numRows = tr.length - 2
                    for (let col = 1; col < $('#rekonsiliasi-table tr:first-child td').length; col++) {
                        let sum = 0
                        let pdrb = 0
                        let nonmigas = 0
                        for (let row = 0; row < numRows; row++) {
                            let cell = $('#rekonsiliasi-table tr').eq(row + 1).find('td').eq(col)
                            if (cell.hasClass('categories')) {
                                let X = cell.find('input').val().replaceAll(/[A-Za-z.]/g, '')
                                let Y = X.replaceAll(/[,]/g, '.')
                                sum += Y > 0 ? Number(Y) : 0
                            }
                            for (let index of catLast) {
                                if (cell.find(`input[id^='adhk___${index}_']`).length > 0) {
                                    let X = cell.find(`input[id^='adhk___${index}_']`).val().replaceAll(
                                        /[A-Za-z.]/g, '')
                                    let Y = X.replaceAll(/[,]/g, '.')
                                    pdrb += Y > 0 ? Number(Y) : 0
                                }
                            }
                            if (cell.find('input').attr('id').includes('adhk__1_B_') || cell.find('input').attr(
                                    'id').includes('adhk_b_1_C_')) {
                                let X = cell.find('input').val().replaceAll(/[A-Za-z.]/g, '')
                                let Y = X.replaceAll(/[,]/g, '.')
                                nonmigas += Y > 0 ? Number(Y) : 0
                            }
                        }
                        let pdrbs = sum + pdrb
                        let PdrbNonmigas = pdrbs - nonmigas
                        let sumPDRB = String(pdrbs).replaceAll(/[.]/g, ',')
                        let sumPDRBnm = String(PdrbNonmigas).replaceAll(/[.]/g, ',')
                        let totalnm = $('#rekonsiliasi-table tr').last().prev().find('td').eq(col)
                        let totalCell = $('#rekonsiliasi-table tr').last().find('td').eq(col)
                        totalnm.text(formatRupiah(sumPDRBnm, 'Rp '))
                        totalCell.text(formatRupiah(sumPDRB, 'Rp '))
                    }
                });
                //

                //Single-Form Sum Last Column
                let tableSingle = $('#rekonsiliasi-table-single')
                let tbodySingle = tableSingle.find('tbody')
                let trSingle = tbodySingle.find('tr')

                trSingle.on('blur', 'td input', function(e) {
                    let numRows = trSingle.length - 2
                    let sum = 0
                    let pdrb = 0
                    let nonmigas = 0
                    for (let row = 0; row < numRows; row++) {
                        let cell = $('#rekonsiliasi-table-single tr').eq(row + 1).find('td').eq(1)
                        if (cell.hasClass('categories')) {
                            let X = cell.find('input').val().replaceAll(/[A-Za-z.]/g, '')
                            let Y = X.replaceAll(/[,]/g, '.')
                            sum += Y > 0 ? Number(Y) : 0
                        }
                        for (let index of catLast) {
                            if (cell.find(`input[id^='adhk___${index}']`).length > 0) {
                                let X = cell.find(`input[id^='adhk___${index}']`).val().replaceAll(
                                    /[A-Za-z.]/g, '')
                                let Y = X.replaceAll(/[,]/g, '.')
                                pdrb += Y > 0 ? Number(Y) : 0
                            }
                        }
                        if (cell.find('input').attr('id').includes('adhk__1_B') || cell.find('input').attr(
                                'id').includes('adhk_b_1_C')) {
                            let X = cell.find('input').val().replaceAll(/[A-Za-z.]/g, '')
                            let Y = X.replaceAll(/[,]/g, '.')
                            nonmigas += Y > 0 ? Number(Y) : 0
                        }
                    }
                    let pdrbs = sum + pdrb
                    let PdrbNonmigas = pdrbs - nonmigas
                    let sumPDRB = String(pdrbs).replaceAll(/[.]/g, ',')
                    let sumPDRBnm = String(PdrbNonmigas).replaceAll(/[.]/g, ',')
                    let totalnm = $('#rekonsiliasi-table-single tr').last().prev().find('td').eq(1)
                    let totalCell = $('#rekonsiliasi-table-single tr').last().find('td').eq(1)
                    totalnm.text(formatRupiah(sumPDRBnm, 'Rp '))
                    totalCell.text(formatRupiah(sumPDRB, 'Rp '))
                })
                //

                //single and full, sum for every category and sector
                for (let i = 1; i < 5; i++) {
                    $(`.sector-Q${i}-1`).keyup(function(e) {
                        let jumlah = calculateSector(`sector-Q${i}-1`);
                        let que = String(jumlah).replaceAll(/[.]/g, ',');
                        $(`#adhk_1_A_Q${i}`).val(formatRupiah(que, 'Rp '));
                    });
                    $(`.sector-Q${i}-8`).keyup(function(e) {
                        let jumlah = calculateSector(`sector-Q${i}-8`);
                        let que = String(jumlah).replaceAll(/[.]/g, ',');
                        $(`#adhk_1_C_Q${i}`).val(formatRupiah(que, 'Rp '))
                    });
                    for (let j = 1; j < 18; j++) {
                        $(`.category-Q${i}-${j}`).keyup(function(e) {
                            let jumlah = calculateSector(`category-Q${i}-${j}`);
                            let que = String(jumlah).replaceAll(/[.]/g, ',');
                            $(`#adhk_${catArray[j-1]}_Q${i}`).val(formatRupiah(que, 'Rp '))
                        });
                        $(`.category-${j}`).keyup(function(e) {
                            let jumlah = calculateSector(`category-${j}`);
                            let que = String(jumlah).replaceAll(/[.]/g, ',');
                            $(`#adhk_${catArray[j-1]}`).val(formatRupiah(que, 'Rp '))
                        });
                    }
                    for (let j = 1; j < 49; j++) {
                        $(`.sector-Q${i}-${j}`).keyup(function(e) {
                            $(this).val(formatRupiah($(this).val(), 'Rp '))
                            var charCode = (e.which) ? e.which : event.keyCode
                            if (String.fromCharCode(charCode).match(/[^0-9.,]/g))
                                return false;
                        })
                        $(`.sector-${j}`).keyup(function(e) {
                            $(this).val(formatRupiah($(this).val(), 'Rp '))
                            var charCode = (e.which) ? e.which : event.keyCode
                            if (String.fromCharCode(charCode).match(/[^0-9.,]/g))
                                return false;
                        })
                    }
                }

                $('.sector-1').keyup(function(e) {
                    let jumlah = calculateSector('sector-1');
                    let que = String(jumlah).replaceAll(/[.]/g, ',');
                    $('#adhk_1_A').val(formatRupiah(que, 'Rp '));
                })

                $('.sector-8').keyup(function(e) {
                    let jumlah = calculateSector('sector-8');
                    let que = String(jumlah).replaceAll(/[.]/g, ',');
                    $('#adhk_1_C').val(formatRupiah(que, 'Rp '));
                })

            })
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
                        showForm();
                    } else {
                        $('#fullFormContainer').addClass('d-none');
                        $('#fullForm')[0].reset();
                        $('#singleFormContainer').addClass('d-none');
                        $('#singleForm')[0].reset();
                    }
                });

                function showForm() {
                    var quarter = $('#quarter').val();
                    if (quarter == 'F') {
                        $('#fullFormContainer').removeClass('d-none');
                        $('#singleFormContainer').addClass('d-none');
                        getFullData()
                    } else if (quarter != null) {
                        $('#fullFormContainer').addClass('d-none');
                        $('#singleFormContainer').removeClass('d-none');
                        getSingleData();
                    } else {
                        $('#fullFormContainer').addClass('d-none');
                        $('#singleFormContainer').addClass('d-none');
                    }
                };


                function getSingleData() {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route("getSingleData") }}',
                        data: {
                            filter: $('#filterForm').serializeArray().reduce(function(obj, item) {
                                obj[item.name] = item.value;
                                return obj;
                            }, {}),
                            _token: '{{ csrf_token() }}',
                        },

                        success: function(result) {

                            // console.log(result);
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
                    $.ajax({
                        type: 'POST',
                        url: '{{ route("getFullData") }}',
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
                                    pdrbValue = ((value.adhk != null) ? formatRupiah(value.adhk
                                        .replace('.', ','),
                                        'Rp. ') : formatRupiah(0,
                                        'Rp. '));
                                    $('input[name=value_'+ quarter + '_' + value.subsector_id + ']').val(
                                        pdrbValue);
                                    $('input[name=id_' + quarter + '_' + value.subsector_id + ']').val(
                                        value.id);
                                    });
                                });

                            } else {
                                $.each(result, function(quarter, value) {
                                    $.each(value, function(key, value) {
                                    pdrbValue = ((value.adhb != null) ? formatRupiah(value.adhb
                                        .replace('.', ','),
                                        'Rp. ') : formatRupiah(0,
                                        'Rp. '));
                                    $('input[name=value_'+ quarter + '_' + value.subsector_id + ']').val(
                                        pdrbValue);
                                    $('input[name=id_' + quarter + '_' + value.subsector_id + ']').val(
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

                $("#fullFormSave").click(function() {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route("saveFullData") }}',
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
