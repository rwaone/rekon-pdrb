var links = window.location.pathname.split("/")[1];
var paramsLink = window.location.pathname.split("/")[2];

$(document).ready(function () {
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
                                    .find("tr:eq("+ row +") td:eq(" + col + ") textarea")
                                    .val(v3);
                            });
                        });
                    });
                }
            });
            return false;
        });
    } else {
        $("#type").on("change", function () {
            let pdrb_type = $(this).val();
            if (pdrb_type) {
                $.ajax({
                    type: "POST",
                    url: url_fenomena_year,
                    data: {
                        type: pdrb_type,
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
                $("#year").append(
                    '<option value="">-- Pilih Tahun --</option>'
                );
                $("#quarter").empty();
                $("#quarter").append(
                    '<option value="" selected>-- Pilih Triwulan --</option>'
                );
            }
        });

        $("#year").on("change", function () {
            var pdrb_type = $("#type").val();
            var pdrb_year = this.value;
            if (pdrb_year) {
                $.ajax({
                    type: "POST",
                    url: url_fenomena_quarter,
                    data: {
                        type: pdrb_type,
                        year: pdrb_year,
                        _token: tokens,
                    },
                    dataType: "json",

                    success: function (result) {
                        console.log(result);
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
            }
        });
    }
});

function fetchData() {
    const types = $("#type").val();
    const years = $("#year").val();
    const quarters = $("#quarter").val();
    url_key.searchParams.set("type", types);
    url_key.searchParams.set("year", encodeURIComponent(years));
    url_key.searchParams.set("quarter", encodeURIComponent(quarters));
    return new Promise(function (resolve, reject) {
        $.ajax({
            type: "GET",
            url: url_key.href,
            dataType: "json",
            success: function (data) {
                //check data
                console.log(data);
                resolve(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                reject(errorThrown, textStatus);
            },
        });
    });
}
if (paramsLink == "monitoring") {
    $("#showData").on("click", async function (e) {
        e.preventDefault();
        try {
            const data = await fetchData();
            console.log(data)
            const year_fenomena = Object.keys(data)[0];
            const quarter_fenomena = Object.keys(data[year_fenomena])[0];
            const type_fenomena = $("#type").val();

            $("#year_fenomena").text(year_fenomena);
            $("#quarter_fenomena").text(quarter_fenomena);
            $("#type_fenomena").text(type_fenomena);

            const kotakey = Object.keys(data[year_fenomena][quarter_fenomena]);

            for (let i = 1; i <= 15; i++) {
                $(`#value-${i}`).text(
                    data[year_fenomena][quarter_fenomena][kotakey[i - 1]][
                        "description"
                    ]
                );
                $(`#counts-${i}`).text(
                    data[year_fenomena][quarter_fenomena][kotakey[i - 1]][
                        "counts"
                    ]
                );
            }
            $("#monitoring-kuarter tbody tr td.values").each(function () {
                if ($(this).text() === "0") {
                    $(this).html(
                        '<i class="bi bi-x-circle-fill" style = "color: red;"></i>'
                    );
                    $(this).addClass("text-center");
                }
                if ($(this).text() === "1") {
                    $(this).html(
                        '<i class="bi bi-check-circle-fill" style = "color: green;"></i>'
                    );
                    $(this).addClass("text-center");
                }
                if ($(this).text() === "2") {
                    $(this).html(
                        '<i class="bi bi-check-circle-fill" style = "color: orange;"></i>'
                    );
                    $(this).addClass("text-center");
                }
            });
        } catch (error) {
            error.message;
        }
        $(".loader").removeClass("d-none");
        setTimeout(() => {
            $(".loader").addClass("d-none");
            $("#showTime").removeClass("d-none");
        }, 500);
    });
}

$("#download-all").on("click", function (e) {
    e.preventDefault();
    $(".loader").removeClass("d-none");
    setTimeout(function () {
        let datas = getReady();
        // const csvData = convertToCSV(datas);
        $(".loader").addClass("d-none");
        // downloadCSV(csvData, "download-data.csv");
        downloadExcel(datas);
    }, 200);
});

$("#showData").click(async function (e) {
    e.preventDefault();
    $(".loader").removeClass("d-none");
    $(".loader").removeClass("d-none");
    $("#view-body").removeClass("d-none");
    let types = $("#type").val();
    types = types.replace(/\s/g, "");

    try {
        const data = await fetchData();
        $(".loader").addClass("d-none");
        $("#view-body").removeClass("d-none");
        for (i = 1; i <= 15; i++) {
            $(`#rekon-view tbody tr.${types}`).each(function (index) {
                if (data[`fenomena-${i + 1}`].length !== 0) {
                    $(this)
                        .find("td span")
                        .eq(i - 1)
                        .text(data[`fenomena-${i + 1}`][index]["description"]);
                }
            });
        }
        $("#komponen tbody tr").each(function (index) {
            if (!$(this).hasClass(`${types}`)) {
                $(this).addClass("d-none");
            } else {
                $(this).removeClass("d-none");
            }
        });
        $("#rekon-view tbody tr").each(function (index) {
            if (!$(this).hasClass(`${types}`)) {
                $(this).addClass("d-none");
            } else {
                $(this).removeClass("d-none");
            }
        });
    } catch (e) {
        $(".loader").addClass("d-none");
        sessionStorage.clear();
        alert("Error : " + e.message);
    }
});

$("#refresh").click(function () {
    sessionStorage.clear();
    $("#view-body").addClass("d-none");
});
