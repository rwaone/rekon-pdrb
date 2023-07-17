$(document).ready(function () {

    let cat = JSON.parse($("#my-cat").data('cat'))
    let catArray = cat.split(", ")

    $('#type').on('change', function () {
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

            success: function (result) {
                $('#year').html('<option value=""> Pilih Tahun </option>');
                $.each(result.years, function (key, value) {
                    $('#year').append('<option value="' + value.year + '">' +
                        value.year + '</option>');
                });
                $.each(result.years, function (key, value) {
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

    $('#year').on('change', function () {
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

            success: function (result) {
                $('#quarter').html(
                    '<option value="" selected> Pilih Triwulan </option>');
                $.each(result.quarters, function (key, value) {
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

    $('#year-copy').on('change', function () {
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

            success: function (result) {
                $('#quarter-copy').html(
                    '<option value="" selected> Pilih Triwulan </option>');
                $.each(result.quarters, function (key, value) {
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

    $('#quarter').on('change', function () {
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

            success: function (result) {
                $('#period').html('<option value="" selected> Pilih Periode </option>');
                $.each(result.periods, function (key, value) {
                    $('#period').append('<option value="' + value.id + '">' +
                        value.description + ' (' + value.status + ')' +
                        '</option>');
                });
            },
        })
    });

    $('#quarter-copy').on('change', function () {
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

            success: function (result) {
                $('#period-copy').html(
                    '<option value="" selected> Pilih Periode </option>');
                $.each(result.periods, function (key, value) {
                    $('#period-copy').append('<option value="' + value.id +
                        '">' +
                        value.description + ' (' + value.status + ')' +
                        '</option>');
                });
            },
        })
    });

    $('#period').change(function () {
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

    $('#region_id').change(function () {
        $('#price_base').val('').change();
    });

    $('#price_base').change(function () {
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
        setTimeout(function () {
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
                filter: $('#filterForm').serializeArray().reduce(function (obj, item) {
                    obj[item.name] = item.value;
                    return obj;
                }, {}),
                _token: tokens,
            },

            success: function (result) {
                $('#singleForm')[0].reset();
                if ($('#price_base').val() == 'adhk') {
                    $.each(result, function (key, value) {
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

                    $.each(result, function (key, value) {
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
                filter: $('#filterForm').serializeArray().reduce(function (obj, item) {
                    obj[item.name] = item.value;
                    return obj;
                }, {}),
                _token: tokens,
            },

            success: function (result) {
                console.log(result);
                $('#fullForm')[0].reset();
                if ($('#price_base').val() == 'adhk') {
                    $.each(result, function (quarter, value) {
                        $.each(value, function (key, value) {
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
                    $.each(result, function (quarter, value) {
                        $.each(value, function (key, value) {
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

                ($('#type').val() == 'Pengeluaran') ? allSumPDRBPengeluaran() : allSumPDRBLapus();

                // jumlahSector1 = calculateSector('sector-Y-1').toFixed(2);
                // queSector1 = String(jumlahSector1).replaceAll(/[.]/g, ',');
                // $('#adhk_1_A_Y').val(formatRupiah(queSector1, 'Rp '));

                // let jumlahSector8 = calculateSector('sector-Y-8').toFixed(2);
                // let queSector8 = String(jumlahSector8).replaceAll(/[.]/g, ',');
                // $('#adhk_1_C_Y').val(formatRupiah(queSector8, 'Rp '));

                // for (let j = 1; j < 18; j++) {
                //     let jumlah = calculateSector(`category-Y-${j}`).toFixed(2);
                //     let que = String(jumlah).replaceAll(/[.]/g, ',');
                //     $(`#adhk_${catArray[j - 1]}_Y`).val(formatRupiah(que,
                //         'Rp '))
                // }

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

    $("#copySubmit").on('click', function () {
        $.ajax({
            type: 'POST',
            url: url_copy_data.href,
            data: {
                filter: $('#filterForm').serializeArray().reduce(function (obj, item) {
                    obj[item.name] = item.value;
                    return obj;
                }, {}),
                copy: $('#copyDataForm').serializeArray().reduce(function (obj, item) {
                    obj[item.name] = item.value;
                    return obj;
                }, {}),
                _token: tokens,
            },

            success: function (result) {
                console.log(result);
                if ($('#price_base').val() == 'adhk') {
                    $.each(result, function (quarter, value) {
                        $.each(value, function (key, value) {
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
                    $.each(result, function (quarter, value) {
                        $.each(value, function (key, value) {
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

    $("#singleFormSave").on('click', function () {
        $.ajax({
            type: 'POST',
            url: url_save_single_data.href,
            data: {
                filter: $('#filterForm').serializeArray().reduce(function (obj, item) {
                    obj[item.name] = item.value;
                    return obj;
                }, {}),
                input: $('#singleForm').serializeArray().reduce(function (obj, item) {
                    obj[item.name] = item.value;
                    return obj;
                }, {}),
                _token: tokens,
            },

            success: function (result) {
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

    $("#fullFormSave").click(function () {
        input = $('#fullForm').serializeArray().reduce(function (obj, item) {
            obj[item.name] = item.value;
            return obj;
        }, {});
        console.log(input);
        $.ajax({
            type: 'POST',
            url: url_save_full_data.href,
            data: {
                filter: $('#filterForm').serializeArray().reduce(function (obj, item) {
                    obj[item.name] = item.value;
                    return obj;
                }, {}),
                input: $('#fullForm').serializeArray().reduce(function (obj, item) {
                    obj[item.name] = item.value;
                    return obj;
                }, {}),
                _token: tokens,
            },

            success: function (result) {
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

    function allSumPDRBPengeluaran() {

        for (let i = 1; i <= 4; i++) {

            let jumlah = calculateSector(`sector-Q${i}-49`).toFixed(2);
            let que = String(jumlah).replaceAll(/[.]/g, ',');
            $(`#adhk_1_X_Q${i}`).val(formatRupiah(que, ''));

            jumlah = calculateSector(`sector-Q${i}-52`).toFixed(2);
            que = String(jumlah).replaceAll(/[.]/g, ',');
            $(`#adhk_4_X_Q${i}`).val(formatRupiah(que, ''))

            let X = $(`#adhk_a_6_X_Q${i}`).val().replaceAll(/[A-Za-z.]/g, '');
            
            let I = $(`#adhk_b_6_X_Q${i}`).val().replaceAll(/[A-Za-z.]/g, '');
            let XM = X.replaceAll(/[,]/g, '.')
            let IM = I.replaceAll(/[,]/g, '.')
            sum = Number(XM) - Number(IM);
            $(`#adhk_6_X_Q${i}`).val(formatRupiah(sum, ''))


        }

    }

    function allSumPDRBLapus() {
        for (let i = 1; i < 5; i++) {

            let jumlah = calculateSector(`sector-Q${i}-1`).toFixed(2);
            let que = String(jumlah).replaceAll(/[.]/g, ',');
            $(`#adhk_1_A_Q${i}`).val(formatRupiah(que, ''));


            jumlah = calculateSector(`sector-Q${i}-8`).toFixed(2);
            que = String(jumlah).replaceAll(/[.]/g, ',');
            $(`#adhk_1_C_Q${i}`).val(formatRupiah(que, ''))

            for (let j = 1; j < 18; j++) {

                let jumlah = calculateSector(`category-Q${i}-${j}`).toFixed(2);
                let que = String(jumlah).replaceAll(/[.]/g, ',');
                $(`#adhk_${catArray[j - 1]}_Q${i}`).val(formatRupiah(que, ''))

            }

        }

        let table = $('#rekonsiliasi-table');
        let tbody = table.find('tbody');
        let tr = tbody.find('tr');
        let catB = "A,B,C,D,G,H,I,K"
        let catSpecific = catB.split(",")
        let catLast = catArray.filter(value => !catSpecific.includes(value))
        $('#rekonsiliasi-table tr').each(function (i, j) {
            let $currentRow = $(this).closest('tr')
            let $totalCol = $currentRow.find('td:last').prev()
            let sum = 0
            $currentRow.find('input:not(:hidden):not(:disabled)').each(function () {
                let X = $(this).val().replaceAll(/[A-Za-z.]/g, '')
                let Y = X.replaceAll(/[,]/g, '.')

                sum += Number(Y)
            })
            let sumRp = String(sum.toFixed(2)).replaceAll(/[.]/g, ',')
            $totalCol.find('input').val(formatRupiah(sumRp, ''))

            for (let index of catSpecific) {
                let darksum = 0
                let lightsum = 0

                let row = $(`#adhk_${index}_T`).closest('tr')
                let subsection = $(`#adhk_1_${index}_T`).closest('tr')

                row.find('td input:not(#adhk_' + index + '_T):not(#adhk_' + index + '_Y)').each(function () {
                    if (!$(this).hasClass(`adhk_${index}_T`)) {
                        let X = $(this).val().replaceAll(/[A-Za-z.]/g, '');
                        let Y = X.replaceAll(/[,]/g, '.');
                        darksum += Number(Y);
                    }
                })

                subsection.find('td input:not(#adhk_1_' + index + '_T):not(#adhk_1_' + index + '_Y)').each(function () {
                    if (!$(this).hasClass(`adhk_${index}_T`)) {
                        let X = $(this).val().replaceAll(/[A-Za-z.]/g, '');
                        let Y = X.replaceAll(/[,]/g, '.');
                        lightsum += Number(Y);
                    }
                })

                let lightsumRp = String(lightsum.toFixed(2)).replaceAll(/[.]/g, ',');
                let darksumRp = String(darksum.toFixed(2)).replaceAll(/[.]/g, ',');
                $(`#adhk_1_${index}_T`).val(formatRupiah(lightsumRp, ''))
                $(`#adhk_${index}_T`).val(formatRupiah(darksumRp, ''))
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
                        sum += Number(Y)
                    }
                    for (let index of catLast) {
                        if (cell.find(`input[id^='adhk___${index}_']`).length > 0) {
                            let X = cell.find(`input[id^='adhk___${index}_']`).val().replaceAll(
                                /[A-Za-z.]/g, '')
                            let Y = X.replaceAll(/[,]/g, '.')
                            pdrb += Number(Y)
                        }
                    }
                    cell.find('input').each(function () {
                        let inputId = $(this).attr('id');
                        if (inputId && (inputId.includes('adhk__1_B_') || inputId.includes('adhk_b_1_C_'))) {
                            let X = $(this).val().replaceAll(/[A-Za-z.]/g, '');
                            let Y = X.replaceAll(/[,]/g, '.');
                            nonmigas += Number(Y);
                        }
                    });
                }
                let pdrbs = sum + pdrb
                let PdrbNonmigas = pdrbs - nonmigas
                let sumPDRB = String(pdrbs.toFixed(2)).replaceAll(/[.]/g, ',')
                let sumPDRBnm = String(PdrbNonmigas.toFixed(2)).replaceAll(/[.]/g, ',')
                let totalnm = $('#rekonsiliasi-table tr').last().prev().find('td').eq(col)
                let totalCell = $('#rekonsiliasi-table tr').last().find('td').eq(col)
                totalnm.text(formatRupiah(sumPDRBnm, ''))
                totalCell.text(formatRupiah(sumPDRB, ''))
            }
        });
    }


    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function () {
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
});