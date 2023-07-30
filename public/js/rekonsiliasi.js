$(document).ready(function () {

    let cat = JSON.parse($("#my-cat").data('cat'))
    let catArray = cat.split(", ")

    $('#type').on('change', function () {
        var pdrb_type = this.value;
        $("#year").html('');
        // $('#region_id').val('').change();
        $('#navList').addClass('d-none');

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
        // $('#region_id').val('').change();
        $('#navList').addClass('d-none');

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
        // $('#region_id').val('').change();
        $('#navList').addClass('d-none');

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
        // $('#region_id').val('').change();
        $('#navList').addClass('d-none');
        if ($('#period').text().includes('Aktif')) {
            $('#fullFormSave').prop('disabled', false);
        } else {
            $('#fullFormSave').prop('disabled', true);
        }
    });

    $('#region_id').change(function () {
        $('#navList').removeClass('d-none');
        $('.nav-link').removeClass('active');
        $('input[name*=id_]').prop('disabled', false);
        $('input[name*=adhk_value_]').prop('disabled', false);
        $('input[name*=adhb_value_]').prop('disabled', false);
        var quarter = $('#quarter').val();
        if (quarter < 4) {
            for (let index = +quarter + 1; index < 5; index++) {
                $('input[name*=id_' + index + '_]').prop('disabled', true);
                $('input[name*=adhk_value_' + index + '_]').prop('disabled', true);
                $('input[name*=adhb_value_' + index + '_]').prop('disabled', true);
            }
        }
        getFullData();
        $('#nav-adhb').addClass('active');
        $('#adhbFormContainer').removeClass('d-none');

    });

    $('#nav-adhb').click(function () {
        showForm('adhb');
    });

    $('#nav-adhk').click(function () {
        showForm('adhk');
    });

    $('#nav-distribusi').click(function () {
        const previous_data = JSON.parse(sessionStorage.getItem('previous_data'));
        // console.log(previous_data);
        showTable();
        for (let col = 1; col <= 5 ; col++) {
            
        }
        $('td[id^="value"]').each(function () {
            const value_id = this.id.replace('value_', '');
            console.log(this.id);
            console.log('#adhb_' + value_id);
            console.log($('#adhb_' + value_id).val());
            $('#value_' + value_id).html($('#adhb_' + value_id).val());
        })
    });

    function showTable() {
        $('.loader').removeClass('d-none');
        $('.form-container').addClass('d-none');
        $('#tableFormContainer').removeClass('d-none');
        $('.nav-link').removeClass('active');
        $('#nav-distribusi').addClass('active');
        
        setTimeout(function () {
            
            $('.loader').addClass('d-none');
        }, 200);
    };

    function showForm(price_base) {

        $('.loader').removeClass('d-none');
        $('.form-container').addClass('d-none');
        $('#' + price_base + 'FormContainer').removeClass('d-none');
        $('.nav-link').removeClass('active');
        $('#nav-' + price_base).addClass('active');

        setTimeout(function () {
            allSumPDRBLapus(price_base);
            $('.loader').addClass('d-none');
        }, 200);

    };

    function getFullData() {
        $('.loader').removeClass('d-none');
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
                $.each(result.current_data, function (quarter, value) {
                    $.each(value, function (key, value) {
                        adhkValue = ((value.adhk != null) ? formatRupiah(
                            value.adhk
                                .replace('.', ','),
                            '') : formatRupiah(0,
                                ''));
                        $('input[name=adhk_value_' + quarter + '_' + value
                            .subsector_id + ']').val(
                                adhkValue);
                        $('input[name=id_' + quarter + '_' + value
                            .subsector_id + ']').val(
                                value.id);

                        adhbbValue = ((value.adhb != null) ? formatRupiah(
                            value.adhb
                                .replace('.', ','),
                            '') : formatRupiah(0,
                                ''));
                        $('input[name=adhb_value_' + quarter + '_' + value
                            .subsector_id + ']').val(
                                adhbbValue);
                        $('input[name=id_' + quarter + '_' + value
                            .subsector_id + ']').val(
                                value.id);
                    });
                });

                ($('#type').val() == 'Pengeluaran') ? allSumPDRBPengeluaran('adhb') : allSumPDRBLapus('adhb');

                sessionStorage.setItem('previous_data', JSON.stringify(result.previous_data));

                Toast.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Data berhasil ditampilkan.'
                })

                $('.loader').addClass('d-none')
            },
        });
    }
    $('#copy-adhb').click(function () {

        $('#copy-price-base').val('adhb');
        $('#copy-modal').modal();

    });

    $('#copy-adhk').click(function () {

        $('#copy-price-base').val('adhk');
        $('#copy-modal').modal();

    });

    $("#copySubmit").click(function () {

        $('#copy-modal').modal('toggle');
        price_base = $('#copy-price-base').val();
        copyData(price_base);

    });

    function copyData(price_base) {
        $('.loader').removeClass('d-none');
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
                if (price_base == 'adhk') {
                    $.each(result, function (quarter, value) {
                        $.each(value, function (key, value) {
                            pdrbValue = ((value.adhk != null) ?
                                formatRupiah(
                                    value.adhk
                                        .replace('.', ','),
                                    '') : formatRupiah(0,
                                        ''));
                            $('input[name=adhk_value_' + quarter + '_' +
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
                            $('input[name=adhb_value_' + quarter + '_' +
                                value
                                    .subsector_id + ']').val(
                                        pdrbValue);
                        });
                    });
                }

                ($('#type').val() == 'Pengeluaran') ? allSumPDRBPengeluaran(price_base) : allSumPDRBLapus(price_base);

                $('.loader').addClass('d-none')

                Toast.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Data berhasil disalin.'
                })
            },
        })
    }

    $("#fullFormSave").click(function () {
        $.ajax({
            type: 'POST',
            url: url_save_full_data.href,
            data: {
                filter: $('#filterForm').serializeArray().reduce(function (obj, item) {
                    obj[item.name] = item.value;
                    return obj;
                }, {}),
                adhb: $('#adhbForm').serializeArray().reduce(function (obj, item) {
                    obj[item.name] = item.value;
                    return obj;
                }, {}),
                adhk: $('#adhkForm').serializeArray().reduce(function (obj, item) {
                    obj[item.name] = item.value;
                    return obj;
                }, {}),
                _token: tokens,
            },

            success: function (result) {
                
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

    function allSumPDRBLapus(price_base) {
        for (let i = 1; i < 5; i++) {

            let jumlah = calculateSector(price_base + `-sector-Q${i}-1`).toFixed(2);
            let que = String(jumlah).replaceAll(/[.]/g, ',');
            $(`#` + price_base + `_1_1_Q${i}`).val(formatRupiah(que, ''));


            jumlah = calculateSector(price_base + `-sector-Q${i}-8`).toFixed(2);
            que = String(jumlah).replaceAll(/[.]/g, ',');
            $(`#` + price_base + `_8_3_Q${i}`).val(formatRupiah(que, ''))

            for (let j = 1; j < 18; j++) {

                let jumlah = calculateSector(price_base + `-category-Q${i}-${j}`).toFixed(2);
                let que = String(jumlah).replaceAll(/[.]/g, ',');
                $(`#` + price_base + `_${catArray[j - 1]}_Q${i}`).val(formatRupiah(que, ''))

            }

        }

        let table = $('#' + price_base + '-table');
        let tbody = table.find('tbody');
        let tr = tbody.find('tr');
        let catB = "1,2,3,4,7,8,9,11"
        let catSpecific = catB.split(",")
        let catLast = catArray.filter(value => !catSpecific.includes(value))
        $('#' + price_base + '-table tr').each(function (i, j) {
            let $currentRow = $(this).closest('tr')
            let $totalCol = $currentRow.find('td:last')
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

                let row = $(`#` + price_base + `_${index}_T`).closest('tr')
                let subsection = $(`#${price_base}_1_${index}_T`).closest('tr')

                row.find('td input:not(#' + price_base + '_' + index + '_T):not(#' + price_base + '_' + index + '_Y)').each(function () {
                    if (!$(this).hasClass(`${price_base}_${index}_T`)) {
                        let X = $(this).val().replaceAll(/[A-Za-z.]/g, '');
                        let Y = X.replaceAll(/[,]/g, '.');
                        darksum += Number(Y);
                    }
                })

                subsection.find('td input:not(#' + price_base + '_1_' + index + '_T):not(#' + price_base + '_1_' + index + '_Y)').each(function () {
                    if (!$(this).hasClass(`${price_base}_${index}_T`)) {
                        let X = $(this).val().replaceAll(/[A-Za-z.]/g, '');
                        let Y = X.replaceAll(/[,]/g, '.');
                        lightsum += Number(Y);
                    }
                })

                let lightsumRp = String(lightsum.toFixed(2)).replaceAll(/[.]/g, ',');
                let darksumRp = String(darksum.toFixed(2)).replaceAll(/[.]/g, ',');
                $(`#${price_base}_1_${index}_T`).val(formatRupiah(lightsumRp, ''))
                $(`#${price_base}_${index}_T`).val(formatRupiah(darksumRp, ''))
            }

            let numRows = tr.length - 2
            for (let col = 1; col < $('#' + price_base + '-table tr:first-child td').length; col++) {
                let sum = 0
                let pdrb = 0
                let nonmigas = 0
                for (let row = 0; row < numRows; row++) {
                    let cell = $('#' + price_base + '-table tr').eq(row + 1).find('td').eq(col)
                    if (cell.hasClass('categories')) {
                        let X = cell.find('input').val().replaceAll(/[A-Za-z.]/g, '')
                        let Y = X.replaceAll(/[,]/g, '.')
                        sum += Number(Y)
                    }
                    for (let index of catLast) {
                        if (cell.find(`input[id^='${price_base}___${index}_']`).length > 0) {
                            let X = cell.find(`input[id^='${price_base}___${index}_']`).val().replaceAll(
                                /[A-Za-z.]/g, '')
                            let Y = X.replaceAll(/[,]/g, '.')
                            pdrb += Number(Y)
                        }
                    }
                    cell.find('input').each(function () {
                        let inputId = $(this).attr('id');
                        if (inputId && (inputId.includes(price_base + '__1_B_') || inputId.includes(price_base + '_b_1_C_'))) {
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
                let totalnm = $('#' + price_base + '-table tr').last().prev().find('td').eq(col)
                let totalCell = $('#' + price_base + '-table tr').last().find('td').eq(col)
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