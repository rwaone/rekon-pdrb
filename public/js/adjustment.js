$(document).ready(function () {

    let price_list = ['adhb', 'adhk']

    //change input value into formated accounting input
    $('input[type="text"]').keyup(function (e) {
        $(this).val(formatRupiah($(this).val(), ''))
        var charCode = (e.which) ? e.which : event.keyCode
        if (String.fromCharCode(charCode).match(/[^0-9.,]/g))
            return false;
    })

    $('#type').on('change', function () {
        var pdrb_type = this.value
        $("#year").html('')
        $('#region_id').val('').change()

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
        $('#region_id').val('').change()


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

    $('#quarter').on('change', function () {
        var pdrb_type = $('#type').val()
        var pdrb_year = $('#year').val()
        var pdrb_quarter = this.value
        $("#period").html('')
        $('#region_id').val('').change()


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

    $('#period').change(function () {
        $('#subsector').val('').change()
    });

    $('#filter-button').click(function () {
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
                sessionStorage.setItem("data", JSON.stringify(result));
                fetchData(1)

                Toast.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Data berhasil ditampilkan.'
                })

                $('.loader').addClass('d-none')
            },
        });
    });

    $("#adjustment-save").click(function () {
        $.ajax({
            type: 'POST',
            url: url_save_full_data.href,
            data: {
                filter: $('#filterForm').serializeArray().reduce(function (obj, item) {
                    obj[item.name] = item.value;
                    return obj;
                }, {}),
                adjustment: $('#adjustForm').serializeArray().reduce(function (obj, item) {
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

    for (let quarter = 1; quarter <= 4; quarter++) {
        $(`#tab_${quarter}`).click(function () {
            fetchData(quarter)
            $('.tab-item').removeClass('active')
            $(`#tab_${quarter}`).addClass('active')
        })
    }


    function fetchData(quarter) {
        var data = JSON.parse(sessionStorage.getItem("data"));
        $.each(data['current'], function (index, data) {
            $(`#adhb-inisial-${index}`).text(formatRupiah(data[quarter]['adhb'].replaceAll('.', ','), ''))
            $(`#adhk-inisial-${index}`).text(formatRupiah(data[quarter]['adhk'].replaceAll('.', ','), ''))
            $(`#adhb-berjalan-${index}`).text(formatRupiah(data[quarter]['adhb'].replaceAll('.', ','), ''))
            $(`#adhk-berjalan-${index}`).text(formatRupiah(data[quarter]['adhk'].replaceAll('.', ','), ''))
            $(`#adhb-adjust-${index}`).val(formatRupiah(data[quarter]['adjust_adhb'].replaceAll('.', ','), ''))
            $(`#adhk-adjust-${index}`).val(formatRupiah(data[quarter]['adjust_adhk'].replaceAll('.', ','), ''))
            getTotalInisial()
            getTotalBerjalan()
        })
    }

    function getTotalInisial() {
        $.each(price_list, function (index, price_base) {
            let total = 0

            for (let i = 2; i <= 16; i++) {
                total += Number($(`#${price_base}-inisial-${i}`).text().replaceAll('.', '').replaceAll(',', '.'))
            }
            $(`#${price_base}-inisial-total`).text(formatRupiah(String(total.toFixed(2)).replaceAll('.', ','), ''))

            let prov = Number($(`#${price_base}-inisial-1`).text().replaceAll('.', '').replaceAll(',', '.'))

            let selisih = total - prov
            $(`#${price_base}-inisial-selisih`).text(formatRupiah(String(selisih.toFixed(2)).replaceAll('.', ','), ''))

            let diskrepansi = (selisih / prov) * 100
            $(`#${price_base}-inisial-diskrepansi`).text(String(diskrepansi.toFixed(2)).replaceAll('.', ','))

        })
    }

    function getTotalBerjalan() {
        $.each(price_list, function (index, price_base) {
            let total = 0

            for (let i = 2; i <= 16; i++) {
                total += Number($(`#${price_base}-berjalan-${i}`).text().replaceAll('.', '').replaceAll(',', '.'))
            }
            $(`#${price_base}-berjalan-total`).text(formatRupiah(String(total.toFixed(2)).replaceAll('.', ','), ''))

            let prov = Number($(`#${price_base}-berjalan-1`).text().replaceAll('.', '').replaceAll(',', '.'))

            let selisih = total - prov
            $(`#${price_base}-berjalan-selisih`).text(formatRupiah(String(selisih.toFixed(2)).replaceAll('.', ','), ''))

            let diskrepansi = (selisih / prov) * 100
            $(`#${price_base}-berjalan-diskrepansi`).text(String(diskrepansi.toFixed(2)).replaceAll('.', ','))

        })
    }

    $.each(price_list, function (index, price_base) {
        for (let indeks = 2; indeks <= 16; indeks++) {
            $(`#${price_base}-adjust-${indeks}`).keyup(function (e) {
                countBerjalan(price_base, indeks)
                getTotalBerjalan()
            })
        }
    })

    function countBerjalan(price_base, indeks) {
        let adjust = Number($(`#${price_base}-adjust-${indeks}`).val().replaceAll('.', '').replaceAll(',', '.'))
        let inisial = Number($(`#${price_base}-inisial-${indeks}`).text().replaceAll('.', '').replaceAll(',', '.'))
        let value = adjust + inisial
        $(`#${price_base}-berjalan-${indeks}`).text(formatRupiah(String(value.toFixed(2)).replaceAll('.', ','), ''))
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