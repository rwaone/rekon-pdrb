$(document).ready(function () {

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
        $('#region_id').val('').change()
    });

    $('#region_id').change(function () {
        if ($('#region_id').val() != '') {
            getFullData()
        }
    });

    $('#filter-button').click(function () {
        $('.loader').removeClass('d-none');

        $('input[name*=id_]').prop('disabled', false)
        $('input[name*=adhk_value_]').prop('disabled', false)
        $('input[name*=adhb_value_]').prop('disabled', false)

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

                Toast.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Data berhasil ditampilkan.'
                })

                $('.loader').addClass('d-none')
            },
        });
    });



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