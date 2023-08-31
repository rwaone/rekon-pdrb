$(document).ready(function () {

    let cat = JSON.parse($("#my-cat").data('cat'))
    let catArray = cat.split(", ")

    $('#type').on('change', function () {
        var pdrb_type = this.value
        $("#year").html('')
        closeContainer()

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
        var pdrb_type = $('#type').val()
        var pdrb_year = this.value
        $("#quarter").html('')
        closeContainer()

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
        var pdrb_type = $('#type').val()
        var pdrb_year = $('#year').val()
        var pdrb_quarter = this.value
        $("#period").html('')
        closeContainer()

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
        if ($('#period').text().includes('Aktif')) {
            $('#fullFormSave').prop('disabled', false)
        } else {
            $('#fullFormSave').prop('disabled', true)
        }
        closeContainer()
    });

    $('#filter-button').click(function () {
        if (validateFilter()){
            getFullData()
        } else {
            Toast.fire({
                icon: 'warning',
                title: 'Gagal',
                text: 'Isian filter tidak boleh kosong'
            })
        }
    });
    
    function validateFilter() {
    
        if($(`#type`).val() == ''){
            return false
        } else if ($(`#year`).val() == ''){
            return false
        } else if ($(`#quarter`).val() == ''){
            return false
        } else if ($(`#period`).val() == ''){
            return false
        } else if ($(`#region_id`).val() == ''){
            return false
        }

        return true

    }

    $('#nav-adhb').click(function () {
        showForm('adhb');
    });

    $('#nav-adhk').click(function () {
        showForm('adhk');
    });

    $('#nav-distribusi').click(function () {
        $('.tab-item').removeClass('active');
        $('#nav-distribusi').addClass('active');
        showTable();

        let tableRekon = $('#rekon-table');
        let tbodyRekon = tableRekon.find('tbody');
        let trRekon = tbodyRekon.find('tr');

        let numRows = ($('#type').val() == 'Lapangan Usaha') ? trRekon.length - 2 : trRekon.length - 1

        for (let col = 1; col < $('#rekon-table tr:first-child td').length; col++) {
            let totalnm = Number($('#adhb-table tr').last().prev().find('td').eq(col).text().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
            let nmCell = $('#rekon-table tr').last().prev().find('td').eq(col)

            let totalPDRB = Number($('#adhb-table tr').last().find('td').eq(col).text().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
            let totalCell = $('#rekon-table tr').last().find('td').eq(col)

            nmCell.text(String(((totalnm / totalPDRB) * 100).toFixed(9)).replaceAll(/[.]/g, ','))
            totalCell.text(String(((totalPDRB / totalPDRB) * 100).toFixed(9)).replaceAll(/[.]/g, ','))

            for (let row = 0; row < numRows; row++) {
                let inputCell = $('#adhb-table tr').eq(row + 1).find('td').eq(col)
                let rekonCell = $('#rekon-table tr').eq(row + 1).find('td').eq(col)
                let X = inputCell.find(`input[id^='adhb']`).val().replaceAll(/[A-Za-z.]/g, '')
                let Y = Number(X.replaceAll(/[,]/g, '.'))
                let Z = (Y / totalPDRB) * 100
                rekonCell.text(String(Z.toFixed(2)).replaceAll(/[.]/g, ','))
            }
        }
    });

    $('#nav-qtoq').click(function () {
        // const previous_data = JSON.parse(sessionStorage.getItem('previous_data'));
        $('.tab-item').removeClass('active');
        $('#nav-qtoq').addClass('active');
        showTable();

        let tableRekon = $('#rekon-table');
        let tbodyRekon = tableRekon.find('tbody');
        let trRekon = tbodyRekon.find('tr');

        let numRows = trRekon.length
        let lastInputRow = ($('#type').val() == 'Lapangan Usaha') ? trRekon.length - 2 : trRekon.length - 1

        for (let col = 1; col < $('#rekon-table tr:first-child td').length; col++) {
            for (let row = 0; row < numRows; row++) {
                let rekonCell = $('#rekon-table tr').eq(row + 1).find('td').eq(col)
                let currentCell = $('#adhk-table tr').eq(row + 1).find('td').eq(col)

                if (col == 1) {
                    var previousCell = $('#prev-adhk-table tr').eq(row + 1).find('td').eq(4)
                } else if (col == 5) {
                    var previousCell = $('#prev-adhk-table tr').eq(row + 1).find('td').eq(5)
                } else {
                    var previousCell = $('#adhk-table tr').eq(row + 1).find('td').eq(col - 1)
                }

                if (row >= lastInputRow) {
                    var currentQ = Number(currentCell.text().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
                    var previousQ = Number(previousCell.text().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
                } else {
                    var currentQ = Number(currentCell.find(`input[id^='adhk']`).val().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
                    var previousQ = Number(previousCell.find(`input[id*='adhk']`).val().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
                }

                let QtoQ = ((currentQ / previousQ) * 100) - 100
                let QtoQval = !isFinite(QtoQ) ? '-' : QtoQ.toFixed(2)
                rekonCell.text(String(QtoQval).replaceAll(/[.]/g, ','));
            }
        }
    });

    $('#nav-ytoy').click(function () {
        // const previous_data = JSON.parse(sessionStorage.getItem('previous_data'));
        $('.tab-item').removeClass('active');
        $('#nav-ytoy').addClass('active');
        showTable();

        let tableRekon = $('#rekon-table');
        let tbodyRekon = tableRekon.find('tbody');
        let trRekon = tbodyRekon.find('tr');

        let numRows = trRekon.length
        let lastInputRow = ($('#type').val() == 'Lapangan Usaha') ? trRekon.length - 2 : trRekon.length - 1

        for (let col = 1; col < $('#rekon-table tr:first-child td').length; col++) {
            for (let row = 0; row < numRows; row++) {
                let rekonCell = $('#rekon-table tr').eq(row + 1).find('td').eq(col)
                let currentCell = $('#adhk-table tr').eq(row + 1).find('td').eq(col)
                let previousCell = $('#prev-adhk-table tr').eq(row + 1).find('td').eq(col)
                if (row >= lastInputRow) {
                    var currentValue = Number(currentCell.text().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
                    var previousValue = Number(previousCell.text().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
                } else {
                    var currentValue = Number(currentCell.find(`input[id^='adhk']`).val().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
                    var previousValue = Number(previousCell.find(`input[id*='adhk']`).val().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
                }
                let YtoY = ((currentValue / previousValue) * 100) - 100
                let YtoYval = !isFinite(YtoY) ? '-' : YtoY.toFixed(2)
                rekonCell.text(String(YtoYval).replaceAll(/[.]/g, ','));
            }
        }
    });

    $('#nav-ctoc').click(function () {
        // const previous_data = JSON.parse(sessionStorage.getItem('previous_data'));
        $('.tab-item').removeClass('active');
        $('#nav-ctoc').addClass('active');
        showTable();

        let tableRekon = $('#rekon-table');
        let tbodyRekon = tableRekon.find('tbody');
        let trRekon = tbodyRekon.find('tr');

        let numRows = trRekon.length
        let lastInputRow = ($('#type').val() == 'Lapangan Usaha') ? trRekon.length - 2 : trRekon.length - 1

        for (let col = 1; col < $('#rekon-table tr:first-child td').length; col++) {
            for (let row = 0; row < numRows; row++) {
                let rekonCell = $('#rekon-table tr').eq(row + 1).find('td').eq(col)
                let sumCurrentValue = 0
                let sumPreviousValue = 0
                for (let length = 1; length <= col; length++) {
                    let currentCell = $('#adhk-table tr').eq(row + 1).find('td').eq(length)
                    let previousCell = $('#prev-adhk-table tr').eq(row + 1).find('td').eq(length)
                    if (row >= lastInputRow) {
                        var currentValue = Number(currentCell.text().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
                        var previousValue = Number(previousCell.text().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
                    } else {
                        var currentValue = Number(currentCell.find(`input[id^='adhk']`).val().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
                        var previousValue = Number(previousCell.find(`input[id*='adhk']`).val().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
                    }
                    sumCurrentValue += currentValue
                    sumPreviousValue += previousValue
                }
                let CtoC = ((sumCurrentValue / sumPreviousValue) * 100) - 100
                let CtoCval = !isFinite(CtoC) ? '-' : CtoC.toFixed(2)
                rekonCell.text(String(CtoCval).replaceAll(/[.]/g, ','))
            }
        }
    });

    $('#nav-indeks').click(function () {
        // const previous_data = JSON.parse(sessionStorage.getItem('previous_data'));
        $('.tab-item').removeClass('active');
        $('#nav-indeks').addClass('active');
        showTable();

        let tableRekon = $('#rekon-table');
        let tbodyRekon = tableRekon.find('tbody');
        let trRekon = tbodyRekon.find('tr');

        let numRows = trRekon.length
        let lastInputRow = ($('#type').val() == 'Lapangan Usaha') ? trRekon.length - 2 : trRekon.length - 1

        for (let col = 1; col < $('#rekon-table tr:first-child td').length; col++) {
            for (let row = 0; row < numRows; row++) {
                let rekonCell = $('#rekon-table tr').eq(row + 1).find('td').eq(col)
                let adhbCell = $('#adhb-table tr').eq(row + 1).find('td').eq(col)
                let adhkCell = $('#adhk-table tr').eq(row + 1).find('td').eq(col)
                if (row >= lastInputRow) {
                    var adhbValue = Number(adhbCell.text().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
                    var adhkValue = Number(adhkCell.text().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
                } else {
                    var adhbValue = Number(adhbCell.find(`input[id^='adhb']`).val().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
                    var adhkValue = Number(adhkCell.find(`input[id^='adhk']`).val().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
                }
                let implisit = ((adhbValue / adhkValue) * 100)
                let indeks = !isFinite(implisit) ? '-' : implisit.toFixed(2)
                rekonCell.text(String(indeks).replaceAll(/[.]/g, ','))
            }
        }
    });

    $('#nav-lajuQ').click(function () {
        // const previous_data = JSON.parse(sessionStorage.getItem('previous_data'));
        $('.tab-item').removeClass('active');
        $('#nav-lajuQ').addClass('active');
        showTable();

        let tableRekon = $('#rekon-table');
        let tbodyRekon = tableRekon.find('tbody');
        let trRekon = tbodyRekon.find('tr');

        let numRows = trRekon.length
        let lastInputRow = ($('#type').val() == 'Lapangan Usaha') ? trRekon.length - 2 : trRekon.length - 1

        for (let col = 1; col < $('#rekon-table tr:first-child td').length; col++) {
            for (let row = 0; row < numRows; row++) {
                let rekonCell = $('#rekon-table tr').eq(row + 1).find('td').eq(col)
                let adhbCell = $('#adhb-table tr').eq(row + 1).find('td').eq(col)
                let adhkCell = $('#adhk-table tr').eq(row + 1).find('td').eq(col)
                if (col == 1) {
                    var previousAdhbCell = $('#prev-adhb-table tr').eq(row + 1).find('td').eq(4)
                    var previousAdhkCell = $('#prev-adhk-table tr').eq(row + 1).find('td').eq(4)
                } else if (col == 5) {
                    var previousAdhbCell = $('#prev-adhb-table tr').eq(row + 1).find('td').eq(5)
                    var previousAdhkCell = $('#prev-adhk-table tr').eq(row + 1).find('td').eq(5)
                } else {
                    var previousAdhbCell = $('#adhb-table tr').eq(row + 1).find('td').eq(col - 1)
                    var previousAdhkCell = $('#adhk-table tr').eq(row + 1).find('td').eq(col - 1)
                }
                if (row >= lastInputRow) {
                    var adhbValue = Number(adhbCell.text().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
                    var adhkValue = Number(adhkCell.text().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
                    var previousAdhbValue = Number(previousAdhbCell.text().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
                    var previousAdhkValue = Number(previousAdhkCell.text().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
                } else {
                    var adhbValue = Number(adhbCell.find(`input[id^='adhb']`).val().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
                    var adhkValue = Number(adhkCell.find(`input[id^='adhk']`).val().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
                    var previousAdhbValue = Number(previousAdhbCell.find(`input[id*='adhb']`).val().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
                    var previousAdhkValue = Number(previousAdhkCell.find(`input[id*='adhk']`).val().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
                }
                let currentImplisit = ((adhbValue / adhkValue) * 100)
                let previousImplisit = ((previousAdhbValue / previousAdhkValue) * 100)
                let laju = ((currentImplisit / previousImplisit) * 100) - 100
                let value = !isFinite(laju) ? '-' : laju.toFixed(2)
                rekonCell.text(String(value).replaceAll(/[.]/g, ','))
            }
        }
    });

    $('#nav-lajuY').click(function () {
        // const previous_data = JSON.parse(sessionStorage.getItem('previous_data'));
        $('.tab-item').removeClass('active');
        $('#nav-lajuY').addClass('active');
        showTable();

        let tableRekon = $('#rekon-table');
        let tbodyRekon = tableRekon.find('tbody');
        let trRekon = tbodyRekon.find('tr');

        let numRows = trRekon.length
        let lastInputRow = ($('#type').val() == 'Lapangan Usaha') ? trRekon.length - 2 : trRekon.length - 1

        for (let col = 1; col < $('#rekon-table tr:first-child td').length; col++) {
            for (let row = 0; row < numRows; row++) {
                let rekonCell = $('#rekon-table tr').eq(row + 1).find('td').eq(col)
                let adhbCell = $('#adhb-table tr').eq(row + 1).find('td').eq(col)
                let adhkCell = $('#adhk-table tr').eq(row + 1).find('td').eq(col)
                var previousAdhbCell = $('#prev-adhb-table tr').eq(row + 1).find('td').eq(col)
                var previousAdhkCell = $('#prev-adhk-table tr').eq(row + 1).find('td').eq(col)

                if (row >= lastInputRow) {
                    var adhbValue = Number(adhbCell.text().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
                    var adhkValue = Number(adhkCell.text().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
                    var previousAdhbValue = Number(previousAdhbCell.text().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
                    var previousAdhkValue = Number(previousAdhkCell.text().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
                } else {
                    var adhbValue = Number(adhbCell.find(`input[id^='adhb']`).val().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
                    var adhkValue = Number(adhkCell.find(`input[id^='adhk']`).val().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
                    var previousAdhbValue = Number(previousAdhbCell.find(`input[id*='adhb']`).val().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
                    var previousAdhkValue = Number(previousAdhkCell.find(`input[id*='adhk']`).val().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
                }

                let currentImplisit = ((adhbValue / adhkValue) * 100)
                let previousImplisit = ((previousAdhbValue / previousAdhkValue) * 100)
                let laju = ((currentImplisit / previousImplisit) * 100) - 100
                let value = !isFinite(laju) ? '-' : laju.toFixed(2)
                rekonCell.text(String(value).replaceAll(/[.]/g, ','))
            }
        }
    });

    function showTable() {
        $('.loader').removeClass('d-none')
        $('.form-container').addClass('d-none')
        $('#tableFormContainer').removeClass('d-none')
        $('.save-container').removeClass('d-none')
        setTimeout(function () {
            $('.loader').addClass('d-none')
        }, 200);
    };

    function closeContainer() {
        $('.loader').removeClass('d-none')
        setTimeout(function () {
            $('.form-container').addClass('d-none')
            $('.save-container').addClass('d-none')
            $('#navList').addClass('d-none')
            $('.loader').addClass('d-none')
        }, 200);
    }

    function showForm(price_base) {

        $('.form-container').addClass('d-none')
        $('#' + price_base + 'FormContainer').removeClass('d-none')
        $('.save-container').removeClass('d-none')
        
        $('.tab-item').removeClass('active')
        $('#nav-' + price_base).addClass('active')

        setTimeout(function () {
            if ($('#type').val() == 'Pengeluaran') {
                allSumPDRBPengeluaran(price_base);
            } else {
                allSumPDRBLapus(price_base);
            }
        }, 200);

    };

    function getFullData() {
        showForm('adhb')

        $('.loader').removeClass('d-none');

        $('#adhbForm')[0].reset();
        $('#adhkForm')[0].reset();

        $('input[name*=id_]').prop('disabled', false)
        $('input[name*=adhk_value_]').prop('disabled', false)
        $('input[name*=adhb_value_]').prop('disabled', false)

        var quarter = $('#quarter').val()
        if (quarter < 4) {
            for (let index = +quarter + 1; index < 5; index++) {
                $('input[name*=id_' + index + '_]').prop('disabled', true)
                $('input[name*=adhk_value_' + index + '_]').prop('disabled', true)
                $('input[name*=adhb_value_' + index + '_]').prop('disabled', true)
            }
        }
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
                console.log(result)
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

                $.each(result.previous_data, function (quarter, value) {
                    $.each(value, function (key, value) {
                        adhkValue = ((value.adhk != null) ? formatRupiah(
                            value.adhk
                                .replace('.', ','),
                            '') : formatRupiah(0,
                                ''));
                        $('input[name=prev-adhk_value_' + quarter + '_' + value
                            .subsector_id + ']').val(
                                adhkValue);

                        adhbbValue = ((value.adhb != null) ? formatRupiah(
                            value.adhb
                                .replace('.', ','),
                            '') : formatRupiah(0,
                                ''));
                        $('input[name=prev-adhb_value_' + quarter + '_' + value
                            .subsector_id + ']').val(
                                adhbbValue);
                    });
                });

                if ($('#type').val() == 'Pengeluaran') {
                    allSumPDRBPengeluaran('adhb')
                    allSumPDRBPengeluaran('adhk')
                    allSumPDRBPengeluaran('prev-adhb')
                    allSumPDRBPengeluaran('prev-adhk')
                } else {
                    allSumPDRBLapus('adhb')
                    allSumPDRBLapus('adhk')
                    allSumPDRBLapus('prev-adhb')
                    allSumPDRBLapus('prev-adhk')
                }

                $.each(result.messages, function (index, message) {
                    window.showToastr(message['type'], message['text'])
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

    function allSumPDRBPengeluaran(price_base) {

        for (let i = 1; i <= 4; i++) {

            let jumlah = calculateSector(price_base + `-sector-Q${i}-49`).toFixed(9);
            let que = String(jumlah).replaceAll(/[.]/g, ',');
            $(`#` + price_base + `_1_X_Q${i}`).val(formatRupiah(que, ''));

            jumlah = calculateSector(price_base + `-sector-Q${i}-52`).toFixed(9);
            que = String(jumlah).replaceAll(/[.]/g, ',');
            $(`#` + price_base + `_4_X_Q${i}`).val(formatRupiah(que, ''))

            let X = $(`#` + price_base + `_a_6_X_Q${i}`).val().replaceAll(/[A-Za-z.]/g, '')
            let I = $(`#` + price_base + `_b_6_X_Q${i}`).val().replaceAll(/[A-Za-z.]/g, '')
            let XM = X.replaceAll(/[,]/g, '.')
            let IM = I.replaceAll(/[,]/g, '.')
            let sumXI = Number(XM) - Number(IM)
            let valueXI = String(sumXI.toFixed(9)).replaceAll(/[.]/g, ',')
            $(`#` + price_base + `_6_X_Q${i}`).val(formatRupiah(valueXI, ''))

        }

        let table = $('#' + price_base + '-table');
        let tbody = table.find('tbody');
        let tr = tbody.find('tr');
        let rows = tr.length - 1
        for (let row = 0; row < rows; row++) {
            let rowSum = 0
            for (let col = 1; col < $('#' + price_base + '-table tr:first-child td').length; col++) {
                if (col != 5) {
                    let cell = $('#' + price_base + '-table tr').eq(row + 1).find('td').eq(col)
                    let value = Number(cell.find(`input[id^='` + price_base + `']`).val().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
                    if (price_base == 'adhb') {
                    }
                    rowSum += value
                } else {
                    let cell = $('#' + price_base + '-table tr').eq(row + 1).find('td').eq(col)
                    let sumText = String(rowSum.toFixed(9)).replaceAll(/[.]/g, ',')
                    cell.find(`input[id^='` + price_base + `']`).val(formatRupiah(sumText, ''))
                }
            }
        }

        let numRows = tr.length - 1
        for (let col = 1; col < $('#' + price_base + '-table tr:first-child td').length; col++) {
            let sum = 0
            for (let row = 0; row < numRows; row++) {
                let cell = $('#' + price_base + '-table tr').eq(row + 1).find('td').eq(col)
                if (cell.hasClass('sectors')) {
                    let X = cell.find(`input[id^='` + price_base + `']`).val().replaceAll(/[A-Za-z.]/g, '')
                    let Y = X.replaceAll(/[,]/g, '.')
                    sum += Number(Y)
                }
            }
            let pdrbs = sum.toFixed(9)
            let sumPDRB = String(pdrbs).replaceAll(/[.]/g, ',')
            let totalCell = $('#' + price_base + '-table tr').last().find('td').eq(col)
            totalCell.text(formatRupiah(sumPDRB, ''))
        }

    }

    function allSumPDRBLapus(price_base) {
        for (let i = 1; i < 5; i++) {

            let jumlah = calculateSector(price_base + `-sector-Q${i}-1`).toFixed(9);
            let que = String(jumlah).replaceAll(/[.]/g, ',');
            $(`#` + price_base + `_1_1_Q${i}`).val(formatRupiah(que, ''));


            jumlah = calculateSector(price_base + `-sector-Q${i}-8`).toFixed(9);
            que = String(jumlah).replaceAll(/[.]/g, ',');
            $(`#` + price_base + `_8_3_Q${i}`).val(formatRupiah(que, ''))

            for (let j = 1; j < 18; j++) {

                let jumlah = calculateSector(price_base + `-category-Q${i}-${j}`).toFixed(9);
                let que = String(jumlah).replaceAll(/[.]/g, ',');
                $(`#` + price_base + `_${catArray[j - 1]}_Q${i}`).val(formatRupiah(que, ''))

            }

        }

        let table = $('#' + price_base + '-table');
        let tbody = table.find('tbody');
        let tr = tbody.find('tr');
        let rows = tr.length - 2
        for (let row = 0; row < rows; row++) {
            let rowSum = 0
            for (let col = 1; col < $('#' + price_base + '-table tr:first-child td').length; col++) {
                if (col != 5) {
                    let cell = $('#' + price_base + '-table tr').eq(row + 1).find('td').eq(col)
                    let value = Number(cell.find(`input[id^='` + price_base + `']`).val().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
                    if (price_base == 'adhb') {
                    }
                    rowSum += value
                } else {
                    let cell = $('#' + price_base + '-table tr').eq(row + 1).find('td').eq(col)
                    let sumText = String(rowSum.toFixed(9)).replaceAll(/[.]/g, ',')
                    cell.find(`input[id^='` + price_base + `']`).val(formatRupiah(sumText, ''))
                }
            }
        }

        let numRows = tr.length - 2
        for (let col = 1; col < $('#' + price_base + '-table tr:first-child td').length; col++) {
            let sum = 0
            let pdrb = 0
            let nonmigas = 0
            for (let row = 0; row < numRows; row++) {
                let cell = $('#' + price_base + '-table tr').eq(row + 1).find('td').eq(col)
                if (cell.hasClass('categories')) {
                    let X = cell.find(`input[id^='${price_base}']`).val().replaceAll(/[A-Za-z.]/g, '')
                    let Y = X.replaceAll(/[,]/g, '.')
                    sum += Number(Y)
                }
                cell.find('input').each(function () {
                    let inputId = $(this).attr('id');
                    if (inputId && (inputId.includes(price_base + '_10_4_2_') || inputId.includes(price_base + '_15_8_3_'))) {
                        let X = $(this).val().replaceAll(/[A-Za-z.]/g, '');
                        let Y = X.replaceAll(/[,]/g, '.');
                        nonmigas += Number(Y);
                    }
                });
            }
            let pdrbs = sum + pdrb
            let PdrbNonmigas = pdrbs - nonmigas
            let sumPDRB = String(pdrbs.toFixed(9)).replaceAll(/[.]/g, ',')
            let sumPDRBnm = String(PdrbNonmigas.toFixed(9)).replaceAll(/[.]/g, ',')
            let totalnm = $('#' + price_base + '-table tr').last().prev().find('td').eq(col)
            let totalCell = $('#' + price_base + '-table tr').last().find('td').eq(col)
            totalnm.text(formatRupiah(sumPDRBnm, ''))
            totalCell.text(formatRupiah(sumPDRB, ''))
        }
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