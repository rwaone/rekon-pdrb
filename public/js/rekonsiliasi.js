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
            url: url_fetch_year.href,
            data: {
                type: pdrb_type,
                _token: tokens,
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
            url: url_fetch_quarter.href,
            data: {
                type: pdrb_type,
                year: pdrb_year,
                _token: tokens,
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
            url: url_fetch_quarter.href,
            data: {
                type: pdrb_type,
                year: pdrb_year,
                _token: tokens,
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
            url: url_fetch_period.href,
            data: {
                type: pdrb_type,
                year: pdrb_year,
                quarter: pdrb_quarter,
                _token: tokens,
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
            url: url_fetch_period.href,
            data: {
                type: pdrb_type,
                year: pdrb_year,
                quarter: pdrb_quarter,
                _token: tokens,
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
            url: url_get_single_data.href,
            data: {
                filter: $('#filterForm').serializeArray().reduce(function(obj, item) {
                    obj[item.name] = item.value;
                    return obj;
                }, {}),
                _token: tokens,
            },

            success: function(result) {
                $('#singleForm')[0].reset();
                if ($('#price_base').val() == 'adhk') {
                    $.each(result, function(key, value) {
                        pdrbValue = ((value.adhk != null) ? formatRupiah(value.adhk
                            .replace('.', ','),
                            '') : formatRupiah(0,
                            ''));
                        $('input[name=value_' + value.subsector_id + ']').val(
                            pdrbValue);
                        $('input[name=id_' + value.subsector_id + ']').val(
                            value.id);
                    });

                } else {

                    $.each(result, function(key, value) {
                        pdrbValue = ((value.adhb != null) ? formatRupiah(value.adhb
                            .replace('.', ','),
                            '') : formatRupiah(0,
                            ''));
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
            url: url_get_full_data.href,
            data: {
                filter: $('#filterForm').serializeArray().reduce(function(obj, item) {
                    obj[item.name] = item.value;
                    return obj;
                }, {}),
                _token: tokens,
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
                                '') : formatRupiah(0,
                                ''));
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
                                '') : formatRupiah(0,
                                ''));
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
            url: url_copy_data.href,
            data: {
                filter: $('#filterForm').serializeArray().reduce(function(obj, item) {
                    obj[item.name] = item.value;
                    return obj;
                }, {}),
                copy: $('#copyDataForm').serializeArray().reduce(function(obj, item) {
                    obj[item.name] = item.value;
                    return obj;
                }, {}),
                _token: tokens,
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
                                    '') : formatRupiah(0,
                                    ''));
                            $('input[name=value_' + quarter + '_' +
                                value
                                .subsector_id + ']').val(
                                pdrbValue);
                        });
                    });

                } else {
                    $.each(result, function(quarter, value) {
                        $.each(value, function(key, value) {
                            pdrbValue = ((value.adhb != null) ?
                                formatRupiah(
                                    value.adhb
                                    .replace('.', ','),
                                    '') : formatRupiah(0,
                                    ''));
                            $('input[name=value_' + quarter + '_' +
                                value
                                .subsector_id + ']').val(
                                pdrbValue);
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
            url: url_save_single_data.href,
            data: {
                filter: $('#filterForm').serializeArray().reduce(function(obj, item) {
                    obj[item.name] = item.value;
                    return obj;
                }, {}),
                input: $('#singleForm').serializeArray().reduce(function(obj, item) {
                    obj[item.name] = item.value;
                    return obj;
                }, {}),
                _token: tokens,
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
        console.log(input);
        $.ajax({
            type: 'POST',
            url: url_save_full_data.href,
            data: {
                filter: $('#filterForm').serializeArray().reduce(function(obj, item) {
                    obj[item.name] = item.value;
                    return obj;
                }, {}),
                input: $('#fullForm').serializeArray().reduce(function(obj, item) {
                    obj[item.name] = item.value;
                    return obj;
                }, {}),
                _token: tokens,
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