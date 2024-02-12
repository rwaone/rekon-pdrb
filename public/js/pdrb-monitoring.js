$(document).ready(function () {
    $("#type").on("change", function () {
        let pdrb_type = $(this).val();
        if (pdrb_type) {
            $.ajax({
                type: "POST",
                // url: "{{ route('konserdaYear') }}",
                url: url_fetch_year.href,
                data: {
                    type: pdrb_type,
                    // _token: '{{ csrf_token() }}',
                    _token: tokens,
                },
                dataType: "json",

                success: function (result) {
                    $("#year").empty();
                    $("#year").append(
                        '<option value="">-- Pilih Tahun --</option>'
                    );
                    $.each(result.years, function (key, value) {
                        $("#year").append(
                            '<option value="' +
                                value.year +
                                '">' +
                                value.year +
                                "</option>"
                        );
                    });
                },
            });
        } else {
            $("#year").empty();
            $("#year").append('<option value="">-- Pilih Tahun --</option>');
            $("#quarter").empty();
            $("#quarter").append(
                '<option value="" selected>-- Pilih Triwulan --</option>'
            );
            $("#period").empty();
            $("#period").append(
                '<option value="" selected>-- Pilih Putaran --</option>'
            );
        }
    });

    $("#year").on("change", function () {
        var pdrb_type = $("#type").val();
        var pdrb_year = this.value;
        if (pdrb_year) {
            $.ajax({
                type: "POST",
                // url: "{{ route('konserdaQuarter') }}",
                url: url_fetch_quarter.href,
                data: {
                    type: pdrb_type,
                    year: pdrb_year,
                    // _token: '{{ csrf_token() }}',
                    _token: tokens,
                },
                dataType: "json",

                success: function (result) {
                    $("#quarter").empty();
                    $("#quarter").append(
                        '<option value="" selected>-- Pilih Triwulan --</option>'
                    );
                    $.each(result.quarters, function (key, value) {
                        var description =
                            value.quarter == "F"
                                ? "Lengkap"
                                : value.quarter == "T"
                                ? "Tahunan"
                                : "Triwulan " + value.quarter;
                        $("#quarter").append(
                            '<option value="' +
                                value.quarter +
                                '">' +
                                description +
                                "</option>"
                        );
                    });
                },
            });
        } else {
            $("#quarter").empty();
            $("#quarter").append(
                '<option value="" selected>-- Pilih Triwulan --</option>'
            );
            $("#period").empty();
            $("#period").append(
                '<option value="" selected>-- Pilih Putaran --</option>'
            );
        }
    });

    $("#quarter").on("change", function () {
        var pdrb_type = $("#type").val();
        var pdrb_year = $("#year").val();
        var pdrb_quarter = this.value;
        if (pdrb_quarter) {
            $.ajax({
                type: "POST",
                // url: "{{ route('konserdaPeriod') }}",
                url: url_fetch_period.href,
                data: {
                    type: pdrb_type,
                    year: pdrb_year,
                    quarter: pdrb_quarter,
                    // _token: '{{ csrf_token() }}',
                    _token: tokens,
                },
                dataType: "json",

                success: function (result) {
                    $("#period").empty();
                    $("#period").append(
                        '<option value="" selected>-- Pilih Putaran --</option>'
                    );

                    $.each(result.periods, function (key, value) {
                        $("#period").append(
                            '<option value="' +
                                value.id +
                                '">' +
                                value.description +
                                "</option>"
                        );
                    });

                    $("#data_quarter").empty();
                    $("#data_quarter").append(
                        '<option value="" selected>-- Pilih Data --</option>'
                    );

                    for (let i = 1; i <= pdrb_quarter; i++) {
                        $("#data_quarter").append(
                            '<option value="' +
                                i +
                                '" selected>Triwulan ' +
                                i +
                                "</option>"
                        );
                    }
                },
            });
        } else {
            $("#period").empty();
            $("#period").append(
                '<option value="" selected>-- Pilih Putaran --</option>'
            );
        }
    });
});