$(document).ready(function () {

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

                sessionStorage.setItem("data", JSON.stringify(result));
                fetchData(1)
                getTotal()

                Toast.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Data berhasil ditampilkan.'
                })

                $('.loader').addClass('d-none')
            },
        });
    });

    function fetchData(quarter){
        var data = JSON.parse(sessionStorage.getItem("data"));
        $.each(data['current'], function(index, data){
            $(`#adhb-inisial-${index}`).text(formatRupiah(data[quarter-1]['adhb'].replaceAll('.', ','),''))
            $(`#adhk-inisial-${index}`).text(formatRupiah(data[quarter-1]['adhk'].replaceAll('.', ','),''))
        })
    }

    function getTotal(){
        let totalADHB = 0
        let totalADHK = 0
        for (let i = 2; i <= 16; i++){
            totalADHB += Number($(`#adhb-inisial-${i}`).text().replaceAll('.', '').replaceAll(',', '.'))
            totalADHK += Number($(`#adhk-inisial-${i}`).text().replaceAll('.', '').replaceAll(',', '.'))
        }
        $(`#adhb-inisial-total`).text(formatRupiah(String(totalADHB).replaceAll('.', ','), ''))
        $(`#adhk-inisial-total`).text(formatRupiah(String(totalADHK).replaceAll('.', ','), ''))
        
        ProvADHB = Number($(`#adhb-inisial-1`).text().replaceAll('.', '').replaceAll(',', '.'))
        ProvADHK = Number($(`#adhk-inisial-1`).text().replaceAll('.', '').replaceAll(',', '.'))

        selisihADHB = totalADHB - ProvADHB
        $(`#adhb-inisial-selisih`).text(formatRupiah(String(selisihADHB).replaceAll('.', ','), ''))

        selisihADHK = totalADHK - ProvADHK
        $(`#adhk-inisial-selisih`).text(formatRupiah(String(selisihADHK).replaceAll('.', ','), ''))

        diskrepansiADHB = (selisihADHB/ProvADHB)*100
        $(`#adhb-inisial-diskrepansi`).text(formatRupiah(String(diskrepansiADHB).replaceAll('.', ','), ''))

        diskrepansiADHK = (selisihADHK/ProvADHK)*100
        $(`#adhk-inisial-diskrepansi`).text(formatRupiah(String(diskrepansiADHK).replaceAll('.', ','), ''))
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