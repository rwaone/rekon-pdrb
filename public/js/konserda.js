//dropDown
$(document).ready(function () {
    $("#type").on("change", function () {
        let pdrb_type = $(this).val();
        if (pdrb_type) {
            $.ajax({
                type: "POST",
                // url: "{{ route('konserdaYear') }}",
                url: url_konserda_year.href,
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
                url: url_konserda_quarter.href,
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
                url: url_konserda_periode.href,
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

function getStored(type) {
    const dataStored = sessionStorage.getItem("dataLU");
    if (dataStored) {
        let data = JSON.parse(dataStored);
        getAdhb(data, type);
        $("#view-body").removeClass("d-none");
    }
}
function toFixedView() {
    $("#rekon-view tbody tr").each(function (index) {
        let data = {};
        $(this)
            .find("td:not(:first-child)")
            .each(function (indeX) {
                let data = $(this)
                    .text()
                    .replaceAll(/[.]/g, "")
                    .replaceAll(/[,]/g, ".");
                let Y = $(this).text(
                    formatRupiah(
                        Number(data).toFixed(2).replaceAll(/[.]/g, ",")
                    )
                );
                // $(this).text(Y)
            });
    });
}

function fetchData(type) {
    let period_id;
    if ($("#period").val() !== "") {
        period_id = $("#period").val();
        sessionStorage.setItem("filters", period_id);
    } else {
        period_id = sessionStorage.getItem("filters");
    }
    data_quarter = $("#data_quarter").val();
    url_key.searchParams.set("period_id", encodeURIComponent(period_id));
    url_key.searchParams.set("type", encodeURIComponent(type));
    url_key.searchParams.set("data_quarter", encodeURIComponent(data_quarter));
    return new Promise(function (resolve, reject) {
        $.ajax({
            type: "GET",
            url: url_key.href,
            dataType: "json",
            success: function (data) {
                resolve(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                reject(errorThrown);
            },
        });
    });
}

//get the data
$(document).ready(function () {
    $("#showData").click(async function (e) {
        e.preventDefault();
        $(".loader").removeClass("d-none");
        $(".loader").removeClass("d-none");
        // $("#select-cat").val("nav-adhb")
        $("#select-cat option[value='nav-adhb']").prop("selected", true);
        $("#select-cat").trigger("change");
        sessionStorage.clear();

        try {
            const data = await fetchData("show");
            console.log(data);
            getAdhb(data.data, types);
            toFixedView();
            $(".loader").addClass("d-none");
            $("#view-body").removeClass("d-none");
            sessionStorage.setItem("dataLU", JSON.stringify(data.data));
        } catch (e) {
            $(".loader").addClass("d-none");
            alert("Error : " + e.message);
        }
    });

    $("#refresh").click(function () {
        sessionStorage.clear();
        $("#view-body").addClass("d-none");
    });
});

//change
$(document).ready(function () {
    $("#select-cat").on("change", async function (e) {
        e.preventDefault();
        let checkVal = $(this).val();
        console.log(checkVal);
        switch (checkVal) {
            case "nav-adhb":
                e.preventDefault();
                $(".loader").removeClass("d-none");
                setTimeout(function () {
                    $(".loader").addClass("d-none");
                    showOff();
                    getStored(types);
                    toFixedView();
                    switchPlay("2");
                }, 200);
                break;
            case "nav-adhk":
                e.preventDefault();
                $(".loader").removeClass("d-none");
                try {
                    let data = JSON.parse(sessionStorage.getItem("AdhkStored"));
                    if (!data) {
                        data = await fetchData("show");
                        sessionStorage.setItem(
                            "AdhkStored",
                            JSON.stringify(data)
                        );
                    }
                    showOff();
                    getAdhk(data.data, types);
                    toFixedView();
                    switchPlay("2");
                    $(".loader").addClass("d-none");
                } catch (e) {
                    $(".loader").addClass("d-none");
                    alert("Error : " + e.message);
                }
                break;
            case "nav-distribusi":
                e.preventDefault();
                $(".loader").removeClass("d-none");
                setTimeout(function () {
                    getStored(types);
                    $("#rekon-view tbody td").removeClass(function (
                        index,
                        className
                    ) {
                        return (className.match(/(^|\s)view-\S+/g) || []).join(
                            " "
                        );
                    });
                    for (let q = 1; q <= 16; q++) {
                        for (let i = 0; i <= rowComponent; i++) {
                            $(`#value-${i}-${q}`).addClass(
                                `view-distribusi-${q}`
                            );
                            $(`#sector-${i}-${q}`).addClass(
                                `view-distribusi-${q}`
                            );
                        }
                        for (let index of catArray) {
                            $(`#categories-${index}-${q}`).addClass(
                                `view-distribusi-${q}`
                            );
                        }
                    }
                    $("#rekon-view tbody td:nth-child(2)").each(function () {
                        $(this).addClass(`view-distribusi-totalKabkot`);
                    });
                    $(".loader").addClass("d-none");
                    showOff();
                    getDist();
                    switchPlay("2");
                }, 500);
                break;
            case "nav-pertumbuhan-year":
                e.preventDefault();
                $(".loader").removeClass("d-none");
                try {
                    let data = JSON.parse(
                        sessionStorage.getItem("growth-year-stored")
                    );
                    if (!data) {
                        data = await fetchData("year");
                        sessionStorage.setItem(
                            "growth-year-stored",
                            JSON.stringify(data)
                        );
                    }
                    console.log(data);
                    showOff();
                    if (data.before === null || data.before.length === 0) {
                        alert("Data tahun lalu tidak ada");
                    } else {
                        getGrowth(data.data, data.before, types);
                        switchPlay("2");
                    }
                    $(".loader").addClass("d-none");
                } catch (e) {
                    $(".loader").addClass("d-none");
                    alert("Error : " + e.message);
                }
                break;
            case "nav-pertumbuhan-quarter":
                e.preventDefault();
                $(".loader").removeClass("d-none");
                try {
                    let data = JSON.parse(
                        sessionStorage.getItem("growth-quarter-stored")
                    );
                    if (!data) {
                        data = await fetchData("quarter");
                        sessionStorage.setItem(
                            "growth-quarter-stored",
                            JSON.stringify(data)
                        );
                    }
                    showOff();
                    if (data.before === null || data.before.length === 0) {
                        alert("Data kuarter sebelumnya tidak ada");
                    } else {
                        getGrowth(data.data, data.before, types);
                        switchPlay("2");
                    }
                    $(".loader").addClass("d-none");
                } catch (e) {
                    $(".loader").addClass("d-none");
                    alert("Error : " + e.message);
                }
                break;
            case "nav-pertumbuhan-cumulative":
                e.preventDefault();
                $(".loader").removeClass("d-none");
                try {
                    let data = JSON.parse(
                        sessionStorage.getItem("growth-cumulative-stored")
                    );
                    if (!data) {
                        data = await fetchData("cumulative");
                        sessionStorage.setItem(
                            "growth-cumulative-stored",
                            JSON.stringify(data)
                        );
                    }
                    showOff();
                    if (data.before === null || data.before.length === 0) {
                        alert("Data tahun lalu tidak ada");
                    } else {
                        getGrowth(data.data, data.before, types);
                        switchPlay("2");
                    }
                    $(".loader").addClass("d-none");
                } catch (e) {
                    $(".loader").addClass("d-none");
                    alert("Error : " + e.message);
                }
                break;
            case "nav-indeks":
                e.preventDefault();
                $(".loader").removeClass("d-none");
                try {
                    let data = JSON.parse(
                        sessionStorage.getItem("IndeksStored")
                    );
                    if (!data) {
                        data = await fetchData("show");
                        sessionStorage.setItem(
                            "IndeksStored",
                            JSON.stringify(data)
                        );
                    }
                    showOff();
                    getIndex(data.data, types);
                    switchPlay("2");
                    $(".loader").addClass("d-none");
                } catch (e) {
                    $(".loader").addClass("d-none");
                    alert("Error : " + e.message);
                }
                break;
            case "nav-laju-year":
                e.preventDefault();
                $(".loader").removeClass("d-none");
                try {
                    let data = JSON.parse(
                        sessionStorage.getItem("laju-year-stored")
                    );
                    if (!data) {
                        data = await fetchData("year");
                        sessionStorage.setItem(
                            "laju-year-stored",
                            JSON.stringify(data)
                        );
                    }
                    showOff();
                    if (data.before === null || data.before.length === 0) {
                        alert("Data tahun lalu tidak ada");
                    } else {
                        let first = getIndex(data.data, types);
                        let before = getIndex(data.before, types);
                        getLaju(first, before);
                        switchPlay("2");
                    }
                    $(".loader").addClass("d-none");
                } catch (e) {
                    $(".loader").addClass("d-none");
                    alert("Error : " + e.message);
                }
                break;
            case "nav-laju-quarter":
                e.preventDefault();
                $(".loader").removeClass("d-none");
                try {
                    let data = JSON.parse(
                        sessionStorage.getItem("laju-quarter-stored")
                    );
                    if (!data) {
                        data = await fetchData("quarter");
                        sessionStorage.setItem(
                            "laju-quarter-stored",
                            JSON.stringify(data)
                        );
                    }
                    showOff();
                    if (data.before === null || data.before.length === 0) {
                        alert("Data kuarter sebelumnya tidak ada");
                    } else {
                        let first = getIndex(data.data, types);
                        let before = getIndex(data.before, types);
                        getLaju(first, before);
                        switchPlay("2");
                    }
                    $(".loader").addClass("d-none");
                } catch (e) {
                    $(".loader").addClass("d-none");
                    alert("Error : " + e.message);
                }
                break;
            case "nav-laju-cumulative":
                e.preventDefault();
                $(".loader").removeClass("d-none");
                try {
                    let data = JSON.parse(
                        sessionStorage.getItem("laju-cumulative-stored")
                    );
                    if (!data) {
                        data = await fetchData("cumulative");
                        sessionStorage.setItem(
                            "laju-cumulative-stored",
                            JSON.stringify(data)
                        );
                    }
                    showOff();
                    if (data.before === null || data.before.length === 0) {
                        alert("Data tahun lalu tidak ada");
                    } else {
                        let first = getIndex(data.data, types);
                        let before = getIndex(data.before, types);
                        getLaju(first, before);
                        switchPlay("2");
                    }
                    $(".loader").addClass("d-none");
                } catch (e) {
                    $(".loader").addClass("d-none");
                    alert("Error : " + e.message);
                }
                break;
            case "nav-struktur-antar":
                e.preventDefault();
                $(".loader").removeClass("d-none");
                try {
                    let data = JSON.parse(
                        sessionStorage.getItem("santar-stored")
                    );
                    if (!data) {
                        data = await fetchData("show");
                        sessionStorage.setItem(
                            "santar-stored",
                            JSON.stringify(data)
                        );
                    }
                    showOff();
                    getAntar(data.data, types);
                    switchPlay("2");
                    $("#change-query").prop("disabled", true);
                    $(".loader").addClass("d-none");
                } catch (e) {
                    $(".loader").addClass("d-none");
                    alert("Error : " + e.message);
                }
                break;
            default:
                break;
        }
    });

    // $("#nav-distribusi").on("click", function (e) {
    //     e.preventDefault();
    //     $(".nav-item").removeClass("active");
    //     $(this).addClass("active");
    //     $(".loader").removeClass("d-none");
    //     setTimeout(function () {
    //         getStored(types);
    //         $("#rekon-view tbody td").removeClass(function (index, className) {
    //             return (className.match(/(^|\s)view-\S+/g) || []).join(" ");
    //         });
    //         for (let q = 1; q <= 16; q++) {
    //             for (let i = 0; i <= rowComponent; i++) {
    //                 $(`#value-${i}-${q}`).addClass(`view-distribusi-${q}`);
    //                 $(`#sector-${i}-${q}`).addClass(`view-distribusi-${q}`);
    //             }
    //             for (let index of catArray) {
    //                 $(`#categories-${index}-${q}`).addClass(
    //                     `view-distribusi-${q}`
    //                 );
    //             }
    //         }
    //         $("#rekon-view tbody td:nth-child(2)").each(function () {
    //             $(this).addClass(`view-distribusi-totalKabkot`);
    //         });
    //         $(".loader").addClass("d-none");
    //         showOff();
    //         getDist();
    //         switchPlay("2");
    //     }, 500);
    // });

    // $("#nav-adhb").on("click", function (e) {
    //     e.preventDefault();
    //     $(".nav-item").removeClass("active");
    //     $(this).addClass("active");
    //     $(".loader").removeClass("d-none");
    //     setTimeout(function () {
    //         $(".loader").addClass("d-none");
    //         showOff();
    //         getStored(types);
    //         toFixedView();
    //         switchPlay("2");
    //     }, 200);
    // });

    // $("#nav-adhk").on("click", async function (e) {
    //     e.preventDefault();
    //     $(".nav-item").removeClass("active");
    //     $(this).addClass("active");
    //     $(".loader").removeClass("d-none");
    //     try {
    //         let data = JSON.parse(sessionStorage.getItem("AdhkStored"));
    //         if (!data) {
    //             data = await fetchData("show");
    //             sessionStorage.setItem("AdhkStored", JSON.stringify(data));
    //         }
    //         showOff();
    //         getAdhk(data.data, types);
    //         toFixedView();
    //         switchPlay("2");
    //         $(".loader").addClass("d-none");
    //     } catch (e) {
    //         $(".loader").addClass("d-none");
    //         alert("Error : " + e.message);
    //     }
    // });

    // //indeks implisit adhb/adhk
    // $("#nav-indeks").on("click", async function (e) {
    //     e.preventDefault();
    //     $(".nav-item").removeClass("active");
    //     $(this).addClass("active");
    //     $(".loader").removeClass("d-none");
    //     try {
    //         let data = JSON.parse(sessionStorage.getItem("IndeksStored"));
    //         if (!data) {
    //             data = await fetchData("show");
    //             sessionStorage.setItem("IndeksStored", JSON.stringify(data));
    //         }
    //         showOff();
    //         getIndex(data.data, types);
    //         switchPlay("2");
    //         $(".loader").addClass("d-none");
    //     } catch (e) {
    //         $(".loader").addClass("d-none");
    //         alert("Error : " + e.message);
    //     }
    // });

    // $("#nav-laju-year").on("click", async function (e) {
    //     e.preventDefault();
    //     $(".nav-item").removeClass("active");
    //     $(this).addClass("active");
    //     $(".loader").removeClass("d-none");
    //     try {
    //         let data = JSON.parse(sessionStorage.getItem("laju-year-stored"));
    //         if (!data) {
    //             data = await fetchData("year");
    //             sessionStorage.setItem(
    //                 "laju-year-stored",
    //                 JSON.stringify(data)
    //             );
    //         }
    //         showOff();
    //         if (data.before === null || data.before.length === 0) {
    //             alert("Data tahun lalu tidak ada");
    //         } else {
    //             let first = getIndex(data.data, types);
    //             let before = getIndex(data.before, types);
    //             getLaju(first, before);
    //             switchPlay("2");
    //         }
    //         $(".loader").addClass("d-none");
    //     } catch (e) {
    //         $(".loader").addClass("d-none");
    //         alert("Error : " + e.message);
    //     }
    // });

    // $("#nav-laju-quarter").on("click", async function (e) {
    //     e.preventDefault();
    //     $(".nav-item").removeClass("active");
    //     $(this).addClass("active");
    //     $(".loader").removeClass("d-none");
    //     try {
    //         let data = JSON.parse(
    //             sessionStorage.getItem("laju-quarter-stored")
    //         );
    //         if (!data) {
    //             data = await fetchData("quarter");
    //             sessionStorage.setItem(
    //                 "laju-quarter-stored",
    //                 JSON.stringify(data)
    //             );
    //         }
    //         showOff();
    //         if (data.before === null || data.before.length === 0) {
    //             alert("Data kuarter sebelumnya tidak ada");
    //         } else {
    //             let first = getIndex(data.data, types);
    //             let before = getIndex(data.before, types);
    //             getLaju(first, before);
    //             switchPlay("2");
    //         }
    //         $(".loader").addClass("d-none");
    //     } catch (e) {
    //         $(".loader").addClass("d-none");
    //         alert("Error : " + e.message);
    //     }
    // });

    // $("#nav-laju-cumulative").on("click", async function (e) {
    //     e.preventDefault();
    //     $(".nav-item").removeClass("active");
    //     $(this).addClass("active");
    //     $(".loader").removeClass("d-none");
    //     try {
    //         let data = JSON.parse(
    //             sessionStorage.getItem("laju-cumulative-stored")
    //         );
    //         if (!data) {
    //             data = await fetchData("cumulative");
    //             sessionStorage.setItem(
    //                 "laju-cumulative-stored",
    //                 JSON.stringify(data)
    //             );
    //         }
    //         showOff();
    //         if (data.before === null || data.before.length === 0) {
    //             alert("Data tahun lalu tidak ada");
    //         } else {
    //             let first = getIndex(data.data, types);
    //             let before = getIndex(data.before, types);
    //             getLaju(first, before);
    //             switchPlay("2");
    //         }
    //         $(".loader").addClass("d-none");
    //     } catch (e) {
    //         $(".loader").addClass("d-none");
    //         alert("Error : " + e.message);
    //     }
    // });

    // //growth
    // $("#nav-pertumbuhan-year").on("click", async function (e) {
    //     e.preventDefault();
    //     $(".nav-item").removeClass("active");
    //     $(this).addClass("active");
    //     $(".loader").removeClass("d-none");
    //     try {
    //         let data = JSON.parse(sessionStorage.getItem("growth-year-stored"));
    //         if (!data) {
    //             data = await fetchData("year");
    //             sessionStorage.setItem(
    //                 "growth-year-stored",
    //                 JSON.stringify(data)
    //             );
    //         }
    //         console.log(data);
    //         showOff();
    //         if (data.before === null || data.before.length === 0) {
    //             alert("Data tahun lalu tidak ada");
    //         } else {
    //             getGrowth(data.data, data.before, types);
    //             switchPlay("2");
    //         }
    //         $(".loader").addClass("d-none");
    //     } catch (e) {
    //         $(".loader").addClass("d-none");
    //         alert("Error : " + e.message);
    //     }
    // });

    // $("#nav-pertumbuhan-quarter").on("click", async function (e) {
    //     e.preventDefault();
    //     $(".nav-item").removeClass("active");
    //     $(this).addClass("active");
    //     $(".loader").removeClass("d-none");
    //     try {
    //         let data = JSON.parse(
    //             sessionStorage.getItem("growth-quarter-stored")
    //         );
    //         if (!data) {
    //             data = await fetchData("quarter");
    //             sessionStorage.setItem(
    //                 "growth-quarter-stored",
    //                 JSON.stringify(data)
    //             );
    //         }
    //         showOff();
    //         if (data.before === null || data.before.length === 0) {
    //             alert("Data kuarter sebelumnya tidak ada");
    //         } else {
    //             getGrowth(data.data, data.before, types);
    //             switchPlay("2");
    //         }
    //         $(".loader").addClass("d-none");
    //     } catch (e) {
    //         $(".loader").addClass("d-none");
    //         alert("Error : " + e.message);
    //     }
    // });

    // $("#nav-pertumbuhan-cumulative").on("click", async function (e) {
    //     e.preventDefault();
    //     $(".nav-item").removeClass("active");
    //     $(this).addClass("active");
    //     $(".loader").removeClass("d-none");
    //     try {
    //         let data = JSON.parse(
    //             sessionStorage.getItem("growth-cumulative-stored")
    //         );
    //         if (!data) {
    //             data = await fetchData("cumulative");
    //             sessionStorage.setItem(
    //                 "growth-cumulative-stored",
    //                 JSON.stringify(data)
    //             );
    //         }
    //         showOff();
    //         if (data.before === null || data.before.length === 0) {
    //             alert("Data tahun lalu tidak ada");
    //         } else {
    //             getGrowth(data.data, data.before, types);
    //             switchPlay("2");
    //         }
    //         $(".loader").addClass("d-none");
    //     } catch (e) {
    //         $(".loader").addClass("d-none");
    //         alert("Error : " + e.message);
    //     }
    // });
    // //struktur antar
    // $("#nav-struktur-antar").on("click", async function (e) {
    //     e.preventDefault();
    //     $(".nav-item").removeClass("active");
    //     $(this).addClass("active");
    //     $(".loader").removeClass("d-none");
    //     try {
    //         let data = JSON.parse(sessionStorage.getItem("santar-stored"));
    //         if (!data) {
    //             data = await fetchData("show");
    //             sessionStorage.setItem("santar-stored", JSON.stringify(data));
    //         }
    //         showOff();
    //         getAntar(data.data, types);
    //         switchPlay("2");
    //         $("#change-query").prop("disabled", true);
    //         $(".loader").addClass("d-none");
    //     } catch (e) {
    //         $(".loader").addClass("d-none");
    //         alert("Error : " + e.message);
    //     }
    // });
});

window.addEventListener("beforeunload", function () {
    sessionStorage.clear();
});

setTimeout(function () {
    sessionStorage.clear();
}, 5 * 60 * 1000);

$(document).ready(function () {
    // getStored('lapangan')
    getTotalKabkot();
    $("#change-query").click(function () {
        $(this).prop("disabled", true);
    });
});

function switchPlay(type) {
    if (type === "1") {
        let tr = $("#rekon-view tbody tr");
        let td_2 = [];
        let td_3 = [];
        tr.each(function () {
            let X = $(this).find("td:nth-child(2)").text();
            td_2.push(X);

            let Y = $(this).find("td:nth-child(3)").text();
            td_3.push(Y);
        });

        tr.find("td:nth-child(2)").each(function (index) {
            $(this).text(td_3[index]);
        });
        tr.find("td:nth-child(3)").each(function (index) {
            $(this).text(td_2[index]);
        });
        $("#rekon-view thead tr")
            .find("th:nth-child(2)")
            .text("Provinsi Sulawesi Utara");
        $("#rekon-view thead tr")
            .find("th:nth-child(3)")
            .text("Total Kabupaten/Kota");
    } else if (type === "2") {
        $("#rekon-view thead tr")
            .find("th:nth-child(2)")
            .text("Total Kabupaten/Kota");
        $("#rekon-view thead tr")
            .find("th:nth-child(3)")
            .text("Provinsi Sulawesi Utara");
        $("#change-query").prop("disabled", false);
    }
}

function getSummarise(type) {
    $(".values").each(function () {
        $(this).text(formatRupiah($(this).text()));
    });
    if (type === "lapangan-usaha") {
        rowComponent = 55;
        let sum = 0;
        for (let q = 1; q <= 16; q++) {
            for (let i = 1; i <= 7; i++) {
                let X = $(`#value-${i}-${q}`)
                    .text()
                    .replaceAll(/[A-Za-z.]/g, "");
                // let X = $(`#value-${i}`).text()
                let Y = X.replaceAll(/[,]/g, ".");
                sum += Number(Y);
            }
            $(`#sector-1-${q}`).text(
                formatRupiah(String(sum.toFixed(2)).replaceAll(/[.]/g, ","))
            );
            sum = sum - sum;
        }
        sum = sum - sum;
        for (let q = 1; q <= 16; q++) {
            for (let i = 14; i <= 15; i++) {
                let X = $(`#value-${i}-${q}`)
                    .text()
                    .replaceAll(/[A-Za-z.]/g, "");
                let Y = X.replaceAll(/[,]/g, ".");
                sum += Number(Y);
            }

            $(`#sector-14-${q}`).text(
                formatRupiah(String(sum.toFixed(2)).replaceAll(/[.]/g, ","))
            );
            sum = sum - sum;
        }
        sum = sum - sum;
        for (let q = 1; q <= 16; q++) {
            for (let index of catArray) {
                let jumlah = calculateSector(
                    `categories-${index}-${q}`
                ).toFixed(2);
                let que = String(jumlah).replaceAll(/[.]/g, ",");
                $(`#categories-${index}-${q}`).text(formatRupiah(que));
                $(`#categories-${index}-${q}`).addClass(
                    `text-bold pdrb-total-${q}`
                );
            }
        }
        for (let q = 1; q <= 16; q++) {
            let pdrb = calculateSector(`pdrb-total-${q}`).toFixed(2);
            let nonmigas =
                simpleSum(`#value-10-${q}`) + simpleSum(`#value-15-${q}`);
            $(`#total-${q}`).text(
                formatRupiah(String(pdrb).replaceAll(/[.]/g, ","))
            );
            let pdrbNonmigas = (pdrb - nonmigas).toFixed(2);
            $(`#total-nonmigas-${q}`).text(
                formatRupiah(String(pdrbNonmigas).replaceAll(/[.]/g, ","))
            );
        }
    } else if (type === "pengeluaran") {
        rowComponent = 14;
        let sum = 0;
        for (let q = 1; q <= 16; q++) {
            for (let i = 1; i <= 7; i++) {
                let X = $(`#value-${i}-${q}`)
                    .text()
                    .replaceAll(/[A-Za-z.]/g, "");
                let Y = X.replaceAll(/[,]/g, ".");
                sum += Number(Y);
            }
            $(`#sector-1-${q}`).text(
                formatRupiah(String(sum.toFixed(2)).replaceAll(/[.]/g, ","))
            );
            $(`#sector-1-${q}`).addClass(`text-bold pdrb-total-${q}`);
            sum = sum - sum;
        }
        sum = sum - sum;
        for (let q = 1; q <= 16; q++) {
            for (let i = 10; i <= 11; i++) {
                let X = $(`#value-${i}-${q}`)
                    .text()
                    .replaceAll(/[A-Za-z.]/g, "");
                let Y = X.replaceAll(/[,]/g, ".");
                sum += Number(Y);
            }

            $(`#sector-10-${q}`).text(
                formatRupiah(String(sum.toFixed(2)).replaceAll(/[.]/g, ","))
            );
            $(`#sector-10-${q}`).addClass(`text-bold pdrb-total-${q}`);
            sum = sum - sum;
        }
        sum = sum - sum;
        for (let q = 1; q <= 16; q++) {
            let Exports = $(`#value-13-${q}`)
                .text()
                .replaceAll(/[A-Za-z.]/g, "")
                .replaceAll(/[,]/g, ".");
            let Imports = $(`#value-14-${q}`)
                .text()
                .replaceAll(/[A-Za-z.]/g, "")
                .replaceAll(/[,]/g, ".");

            let Nets = Exports - Imports;

            $(`#sector-13-${q}`).text(
                formatRupiah(String(Nets.toFixed(2)).replaceAll(/[.]/g, ","))
            );
            $(`#sector-13-${q}`).addClass(`text-bold pdrb-total-${q}`);
            sum = sum - sum;
        }
        sum = sum - sum;
        for (let q = 1; q <= 16; q++) {
            let pdrb = calculateSector(`pdrb-total-${q}`).toFixed(2);
            $(`#total-${q}`).text(
                formatRupiah(String(pdrb).replaceAll(/[.]/g, ","))
            );
        }
    }
}

function simpleSum(atri) {
    let X = $(`${atri}`)
        .text()
        .replaceAll(/[A-Za-z.]/g, "");
    let Y = X.replaceAll(/[,]/g, ".");
    return Number(Y);
}

function distribusi(values, index) {
    let X = simpleSum(values);
    let Y = simpleSum(`#total-${index}`);
    // let score = Y > 0 ? (X / Y) * 100 : 0;
    // return score > 0 ? score.toFixed(2) : 0;
    let score = (X / Y) * 100;
    return score.toFixed(2);
}

function getDist() {
    for (let q = 1; q <= 16; q++) {
        $(`.view-distribusi-${q}`).each(function () {
            let id = "#" + $(this).attr("id");
            let y = distribusi(id, q);
            $(this).text(y);
        });
        $(`#total-nonmigas-${q}`).text(distribusi(`#total-nonmigas-${q}`, q));
        $(`#total-${q}`).text(distribusi(`#total-${q}`, q));
    }
    $(".view-distribusi-totalKabkot").each(function () {
        let id = "#" + $(this).attr("id");
        let X = simpleSum(id);
        let Y = simpleSum("#totalKabkot-migas");
        let score = (X / Y) * 100;
        // let score = Y > 0 ? (X / Y) * 100 : 0;
        $(this).text(score.toFixed(2));
    });
    let Y = simpleSum("#totalKabkot-migas");
    let nonmigas = simpleSum("#totalKabkot-nonmigas");
    let Kabkotnonmigas = nonmigas > 0 ? (nonmigas / Y) * 100 : 0;
    $("#totalKabkot-nonmigas").text(Kabkotnonmigas);
    $("totalKabkot-migas").text("100");
    selisih("percentage");
}

function getIdx(adhb, adhk) {
    // let result = adhb > 0 ? (adhb / adhk) * 100 : "";
    // return result > 0 ? result.toFixed(2) : "";
    let result = (adhb / adhk) * 100;
    return result.toFixed(2);
}

function diskrepansi() {
    $("#rekon-view tbody tr:not(:last-child):not(:nth-last-child(2)) td:first-child").each(function () {
        $(this).css("background-color", "");
        $(this).css("color", "black");
    });
    $("#rekon-view tbody td:first-child").each(function () {
        let X = Number(
            $(this)
                .closest("tr")
                .find("td:nth-child(3)")
                .text()
                .replaceAll(/[A-Za-z.]/g, "")
                .replaceAll(/[,]/g, ".")
        );
        let Y = Number(
            $(this)
                .closest("tr")
                .find("td:nth-child(2)")
                .text()
                .replaceAll(/[A-Za-z.]/g, "")
                .replaceAll(/[,]/g, ".")
        );
        // let score = X > 0 ? ((Y - X) / X) * 100 : 0;
        let score = ((Y - X) / X) * 100;
        // console.log(Y, X, score);
        $(this).addClass("text-right");
        if (isNaN(score)) {
            score = "-";
            $(this).text(score);
        } else {
            score = score.toFixed(5).replaceAll(/[.]/g, ",");
            $(this).text(score);
        }
        score = Number(score.replaceAll(",", "."));
        if (score > 5 || score < -5) {
            $(this).css("background-color", "#DB3131");
            $(this).css("color", "aliceblue");
            // console.log(score, "merah")
        } else if ((score > 2 && score < 6) || (score < -2 && score > -6)) {
            $(this).css("background-color", "#E6ED18");
            $(this).css("color", "black");
            // console.log(score, "kuning")
        }
    });
    $("#head-purpose").text("Cek Diskrepansi");
}

function selisih(type) {
    $("#rekon-view tbody td:first-child").each(function () {
        if (type === "percentage") {
            let X = Number(
                $(this).closest("tr").find("td:nth-child(3)").text()
            );
            let Y = Number(
                $(this).closest("tr").find("td:nth-child(2)").text()
            );
            let score = Y - X;
            if (isNaN(score)) {
                score = "-";
            } else {
                $(this).text(score.toFixed(2));
            }
        } else {
            let X = Number(
                $(this)
                    .closest("tr")
                    .find("td:nth-child(3)")
                    .text()
                    .replaceAll(/[A-Za-z.]/g, "")
                    .replaceAll(/[,]/g, ".")
            );
            let Y = Number(
                $(this)
                    .closest("tr")
                    .find("td:nth-child(2)")
                    .text()
                    .replaceAll(/[A-Za-z.]/g, "")
                    .replaceAll(/[,]/g, ".")
            );
            let score = Y - X;
            if (isNaN(score)) {
                score = "-";
            } else {
                $(this).text(score.toFixed(2));
            }
        }
        $(this).addClass("text-right");
        $(this).css("background-color", "");
        $(this).css("color", "");
    });
    $("#head-purpose").text("Selisih");
}

function getAdhb(data, type) {
    if (type === "lapangan-usaha") {
        rowComponent = 55;
    } else if (type === "pengeluaran") {
        rowComponent = 14;
    }
    $("#rekon-view tbody td:not(:first-child)").removeClass(function (
        index,
        className
    ) {
        return (className.match(/(^|\s)view-\S+/g) || []).join(" ");
    });
    $("#rekon-view tbody td:not(:first-child)").addClass("view-adhb");
    for (let q = 1; q <= 16; q++) {
        for (let i = 1; i <= rowComponent; i++) {
            let X = data[`pdrb-${q}`][i - 1]["adhb"];
            let Y = String(X).replaceAll(/[.]/g, ",");
            $(`#value-${i}-${q}`).text(Y);
        }
    }
    getSummarise(type);
    getTotalKabkot();
    diskrepansi();
}

function getAdhk(data, type) {
    if (type === "lapangan-usaha") {
        rowComponent = 55;
    } else if (type === "pengeluaran") {
        rowComponent = 14;
    }
    $("#rekon-view tbody td:not(:first-child)").removeClass(function (
        index,
        className
    ) {
        return (className.match(/(^|\s)view-\S+/g) || []).join(" ");
    });
    $("#rekon-view tbody td:not(:first-child)").addClass("view-adhk");
    for (let q = 1; q <= 16; q++) {
        for (let i = 1; i <= rowComponent; i++) {
            let X = data[`pdrb-${q}`][i - 1]["adhk"];
            let Y = String(X).replaceAll(/[.]/g, ",");
            $(`#value-${i}-${q}`).text(Y);
        }
    }
    getSummarise(type);
    getTotalKabkot();
    diskrepansi();
    console.log("HELYEA")
}

function getGrowth(data, before, type) {
    if (type === "lapangan-usaha") {
        rowComponent = 55;
    } else if (type === "pengeluaran") {
        rowComponent = 14;
    }
    $("tbody td:nth-child(n+2):nth-child(-n+6)").removeClass(function (
        index,
        className
    ) {
        return (className.match(/(^|\s)view-\S+/g) || []).join(" ");
    });
    $("tbody td:nth-child(n+2):nth-child(-n+6)").addClass("view-pertumbuhan");
    let adhk_now = [];
    let adhk_before = [];
    let growth = [];
    for (let q = 1; q <= 16; q++) {
        for (let i = 1; i <= rowComponent; i++) {
            let X = data[`pdrb-${q}`][i - 1]["adhk"];
            let Y = String(X).replaceAll(/[.]/g, ",");
            $(`#value-${i}-${q}`).text(Y);
        }
    }
    getSummarise(type);
    getTotalKabkot();
    $("#rekon-view tbody td:not(:first-child)").each(function () {
        let X = $(this)
            .text()
            .replaceAll(/[A-Za-z.]/g, "");
        let Y = X.replaceAll(/[,]/g, ".");
        adhk_now.push(Number(Y));
    });
    for (let q = 1; q <= 16; q++) {
        for (let i = 1; i <= rowComponent; i++) {
            let X = before[`pdrb-${q}`][i - 1]["adhk"];
            let Y = String(X).replaceAll(/[.]/g, ",");
            $(`#value-${i}-${q}`).text(Y);
        }
    }
    getSummarise(type);
    getTotalKabkot();
    $("#rekon-view tbody td:not(:first-child)").each(function () {
        let X = $(this)
            .text()
            .replaceAll(/[A-Za-z.]/g, "");
        let Y = X.replaceAll(/[,]/g, ".");
        adhk_before.push(Number(Y));
    });

    for (let i = 0; i < adhk_now.length; i++) {
        let score =
            // adhk_before[i] > 0
            //     ? ((adhk_now[i] / adhk_before[i]) * 100 - 100).toFixed(2)
            //     : "-";
            ((adhk_now[i] / adhk_before[i]) * 100 - 100).toFixed(2);
        growth.push(score);
    }
    $("#rekon-view tbody td:not(:first-child)").each(function (index) {
        $(this).text(growth[index]);
    });
    selisih("percentage");
}

function getIndex(data, type) {
    if (type === "lapangan-usaha") {
        rowComponent = 55;
    } else if (type === "pengeluaran") {
        rowComponent = 14;
    }
    $("#rekon-view tbody td:not(:first-child)").removeClass(function (
        index,
        className
    ) {
        return (className.match(/(^|\s)view-\S+/g) || []).join(" ");
    });
    $("#rekon-view tbody td:not(:first-child)").addClass("view-indeks");
    let idx_adhb = [];
    let idx_adhk = [];
    let idx = [];
    for (let q = 1; q <= 16; q++) {
        for (let i = 1; i <= rowComponent; i++) {
            let X = data[`pdrb-${q}`][i - 1]["adhb"];
            let Y = String(X).replaceAll(/[.]/g, ",");
            $(`#value-${i}-${q}`).text(Y);
        }
    }
    getSummarise(type);
    getTotalKabkot();
    $("#rekon-view tbody td:not(:first-child)").each(function () {
        let X = $(this)
            .text()
            .replaceAll(/[A-Za-z.]/g, "");
        let Y = X.replaceAll(/[,]/g, ".");
        idx_adhb.push(Number(Y));
    });
    for (let q = 1; q <= 16; q++) {
        for (let i = 1; i <= rowComponent; i++) {
            let X = data[`pdrb-${q}`][i - 1]["adhk"];
            let Y = String(X).replaceAll(/[.]/g, ",");
            $(`#value-${i}-${q}`).text(Y);
        }
    }
    getSummarise(type);
    getTotalKabkot();
    $("#rekon-view tbody td:not(:first-child)").each(function () {
        let X = $(this)
            .text()
            .replaceAll(/[A-Za-z.]/g, "");
        let Y = X.replaceAll(/[,]/g, ".");
        idx_adhk.push(Number(Y));
    });
    for (let i = 0; i < idx_adhb.length; i++) {
        idx.push(getIdx(idx_adhb[i], idx_adhk[i]));
    }
    $("#rekon-view tbody td:not(:first-child)").each(function (index) {
        $(this).text(idx[index]);
    });
    selisih("percentage");
    return idx;
}

function getAntar(data, type) {
    getAdhb(data, type);
    let dividen = [];
    $(".sum-of-kabkot").each(function () {
        let X = $(this)
            .text()
            .replaceAll(/[A-Za-z.]/g, "");
        let Y = X.replaceAll(/[,]/g, ".");
        dividen.push(Number(Y));
    });
    // console.log(dividen)
    $("#rekon-view tbody td:first-child").each(function () {
        $(this).addClass("d-none");
        $("#rekon-view thead th:first-child").addClass("d-none");
    });
    $("#rekon-view tbody td:not(:first-child)").each(function () {
        let X = $(this)
            .text()
            .replaceAll(/[A-Za-z.]/g, "");
        let Y = X.replaceAll(/[,]/g, ".");
        let rowIndex = $(this).closest("tr").index();
        let colIndex = $(this).closest("td").index();
        if (colIndex === 2) {
            $(this).addClass("d-none");
            $("#rekon-view thead th:nth-child(3)").addClass("d-none");
        }
        let score = Y > 0 ? (Y / dividen[rowIndex]) * 100 : 0;
        $(this).text(score.toFixed(2));
    });
}

function showOff() {
    $("#rekon-view thead th").removeClass("d-none");
    $("#rekon-view tbody td").removeClass("d-none");
}

function getLaju(first, before) {
    $("#rekon-view tbody td:not(:first-child)").removeClass(function (
        index,
        className
    ) {
        return (className.match(/(^|\s)view-\S+/g) || []).join(" ");
    });
    $("#rekon-view tbody td:not(:first-child)").addClass("view-laju");
    let growth = [];
    for (let i = 0; i < first.length; i++) {
        let score =
            // before[i] > 0
            //     ? ((first[i] / before[i]) * 100 - 100).toFixed(2)
            //     : "";
            ((first[i] / before[i]) * 100 - 100).toFixed(2);
        growth.push(score);
    }
    $("#rekon-view tbody td:not(:first-child)").each(function (index) {
        $(this).text(growth[index]);
    });
    selisih("percentage");
}

function getTotalKabkot() {
    $("#rekon-view").each(function () {
        let table = $(this);
        let numRows = table.find("tr").length;
        let numCols = table.find("tr:first-child td").length;
        for (let row = 1; row <= numRows; row++) {
            let sum = 0;
            for (let col = 4; col <= numCols; col++) {
                let cellValue = table
                    .find("tr:nth-child(" + row + ") td:nth-child(" + col + ")")
                    .text();
                let X = cellValue.replaceAll(/[A-Za-z.]/g, "");
                let Y = X.replaceAll(/[,]/g, ".");
                if (!isNaN(Number(Y))) {
                    sum += Number(Y);
                }
            }
            table
                .find("tr:nth-child(" + row + ") td:nth-child(2)")
                .text(
                    formatRupiah(String(sum.toFixed(2)).replaceAll(/[.]/g, ","))
                );
        }
    });
}

$("#download-csv").on("click", function (e) {
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

$("#download-all").on("click", async function (e) {
    e.preventDefault();
    $(".loader").removeClass("d-none");
    try {
        await downloadExcelAll();
        $(".loader").addClass("d-none");
    } catch (e) {
        $(".loader").addClass("d-none");
        alert("Error: " + e.message);
    }
});

//sum of each value in sector and category
function calculateSector(sector) {
    let sum = 0;
    // let sector = sector.replaceAll(",","");
    $(`.${sector}`).each(function (index) {
        let X = $(this)
            .text()
            .replaceAll(/[A-Za-z.]/g, "");
        let Y = X.replaceAll(/[,]/g, ".");
        // sum += Y > 0 ? Number(Y) : 0;
        sum += Number(Y);
    });
    return sum;
}

//change the value of inputed number to Rupiah
function formatRupiah(angka, prefix) {
    var number_string = String(angka)
            .replace(/[^\-,\d]/g, "")
            .toString(),
        isNegative = false;

    if (number_string.startsWith("-")) {
        isNegative = true;
        number_string = number_string.substr(1);
    }

    var split = number_string.split(","),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;

    if (isNegative) {
        rupiah = "-" + rupiah;
    }

    return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
}

//

//filter
