$(document).ready(function () {
    let links = window.location.pathname.split("/")[1];
    if (links !== "fenomena") {
        $("#type").on("change", function () {
            var pdrb_type = this.value;
            $("#year").html("");
            $("#region_id").val("").change();
            $("#price_base").val("").change();

            $.ajax({
                type: "POST",
                url: fetchYear,
                data: {
                    type: pdrb_type,
                    _token: tokens,
                },
                dataType: "json",

                success: function (result) {
                    $("#year").html('<option value=""> Pilih Tahun </option>');
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
        });
        $("#year").on("change", function () {
            var pdrb_type = $("#type").val();
            var pdrb_year = this.value;
            $("#region_id").val("").change();
        });
        $("#quarter").on("change", function () {
            var pdrb_quarter = this.value;
            $("#region_id").val("").change();
        });
        $("#region_id").change(function () {
            if (this.value != "") {
                $("#fenomenaFormContainer").removeClass("d-none");
                showFenomena();
            } else {
                $("#fenomenaForm")[0].reset();
                $("#fenomenaFormContainer").addClass("d-none");
            }
        });

        function showFenomena() {
            $(".loader").removeClass("d-none");
            $.ajax({
                type: "POST",
                url: getFenomena,
                data: {
                    filter: $("#filterForm")
                        .serializeArray()
                        .reduce(function (obj, item) {
                            obj[item.name] = item.value;
                            return obj;
                        }, {}),
                    _token: tokens,
                },

                success: function (result) {
                    console.log(result);

                    $("#fenomenaForm")[0].reset();

                    $.each(result, function (key, value) {
                        sector_id =
                            value.sector_id != null ? value.sector_id : "NULL";
                        subsector_id =
                            value.subsector_id != null
                                ? value.subsector_id
                                : "NULL";
                        $(
                            "textarea[name=value_" +
                                value.category_id +
                                "_" +
                                sector_id +
                                "_" +
                                subsector_id +
                                "]"
                        ).val(value.description);
                        $(
                            "input[name=id_" +
                                value.category_id +
                                "_" +
                                sector_id +
                                "_" +
                                subsector_id +
                                "]"
                        ).val(value.id);
                    });

                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                    });

                    Toast.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Data berhasil ditampilkan.",
                    });

                    $(".loader").addClass("d-none");
                },
            });
        }

        $("#fenomenaSave").on("click", function () {
            (fenomena = $("#fenomenaForm")
                .serializeArray()
                .reduce(function (obj, item) {
                    obj[item.name] = item.value;
                    return obj;
                }, {})),
                console.log(fenomena);
            $.ajax({
                type: "POST",
                url: saveFenomena,
                data: {
                    filter: $("#filterForm")
                        .serializeArray()
                        .reduce(function (obj, item) {
                            obj[item.name] = item.value;
                            return obj;
                        }, {}),
                    fenomena: $("#fenomenaForm")
                        .serializeArray()
                        .reduce(function (obj, item) {
                            obj[item.name] = item.value;
                            return obj;
                        }, {}),
                    _token: tokens,
                },

                success: function (result) {
                    console.log(result);
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                    });

                    Toast.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Data berhasil disimpan.",
                    });
                },
            });
        });
        $("#fenomena-table").on("paste", "textarea", function (e) {
            const $this = $(this);
            // let panjang_ndas = $('thead').children().length
            $.each(e.originalEvent.clipboardData.items, function (i, v) {
                if (v.type === "text/plain") {
                    v.getAsString(function (text) {
                        var x = $this.closest("td").index() - 2,
                            y = $this.closest("tr").index() + 1,
                            obj = {};
                        text = text.trim("\r\n");
                        $.each(text.split("\r\n"), function (i2, v2) {
                            $.each(v2.split("\t"), function (i3, v3) {
                                var row = y + i2,
                                    col = x + i3;
                                obj["cell-" + row + "-" + col] = v3;
                                $this
                                    .closest("table")
                                    .find(
                                        "tr:eq(" +
                                            row +
                                            ") td:eq(" +
                                            col +
                                            ") textarea"
                                    )
                                    .val(v3);
                            });
                        });
                    });
                }
            });
            return false;
        });
    }
});
function fetchData() {
    return new Promise(function (resolve, reject) {
        $.ajax({
            type: "GET",
            url: url_key.href,
            dataType: "json",
            success: function (data) {
                resolve(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                reject(errorThrown, textStatus);
            },
        });
    });
}

function showData() {
    const types = $("#type").val();
    const years = $("#year").val();
    const quarters = $("#quarter").val();
    url_key.searchParams.set("type", types);
    url_key.searchParams.set("year", encodeURIComponent(years));
    url_key.searchParams.set("quarter", encodeURIComponent(quarters));
    $.ajax({
        type: "GET",
        url: url_key.href,
        dataType: "json",
        success: function (data) {
            console.log(data);
            for (i = 1; i <= 15; i++) {
                let cells = [];
                $("#rekon-view tbody tr").each(function (index) {
                    $(this)
                        .find("td")
                        .eq(i - 1)
                        .text(data[`fenomena-${i + 1}`][index]["description"]);
                });
            }
        },
    });
}
