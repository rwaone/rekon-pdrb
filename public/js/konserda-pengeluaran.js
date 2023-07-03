function getStored(type) {
    const dataStored = localStorage.getItem('dataPengeluaran')
    if (dataStored) {
        let data = JSON.parse(dataStored)
        getAdhb(data, type)
        $('#view-body').removeClass('d-none')
    }
}

//get the data
$(document).ready(function () {
    $("#showData").click(function (e) {
        e.preventDefault();

        const period_id = $("#period").val();
        // const url_key = new URL('{{ route("pengeluaran-usaha.getKonserda") }}')
        url_key.searchParams.set("period_id", encodeURIComponent(period_id));
        url_key.searchParams.set("type", encodeURIComponent("show"));

        $.ajax({
            beforeSend: function () {
                $(".loader").removeClass("d-none");
            },
            type: "GET",
            // url: 'getKonserda/' + period_id,
            url: url_key.href,
            dataType: "json",
            success: function (data) {
                setTimeout(function () {
                    console.log(data);
                    getAdhb(data.data, "pengeluaran");
                    $(".loader").addClass("d-none");
                    $("#view-body").removeClass("d-none");
                }, 200);
                localStorage.setItem("dataLU", JSON.stringify(data.data));
                localStorage.setItem("filters", period_id);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $(".loader").addClass("d-none");
                localStorage.clear();
                alert("Error : Pilihan Error");
            },
        });
    });

    $("#refresh").click(function () {
        localStorage.clear();
        $("#view-body").addClass("d-none");
    });
});

//change
$(document).ready(function () {
    let tbody = $("#rekon-view").find("tbody");
    $("#nav-distribusi").on("click", function (e) {
        e.preventDefault();
        $(".nav-item").removeClass("active");
        $(this).addClass("active");
        $(".loader").removeClass("d-none");
        setTimeout(function () {
            getStored("pengeluaran");
            $("#rekon-view tbody td").removeClass(function (index, className) {
                return (className.match(/(^|\s)view-\S+/g) || []).join(" ");
            });
            for (let q = 1; q <= 16; q++) {
                for (let i = 0; i <= rowComponent; i++) {
                    $(`#value-${i}-${q}`).addClass(`view-distribusi-${q}`);
                    $(`#sector-${i}-${q}`).addClass(`view-distribusi-${q}`);
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
        }, 200);
    });

    $("#nav-adhb").on("click", function (e) {
        e.preventDefault();
        $(".nav-item").removeClass("active");
        $(this).addClass("active");
        $(".loader").removeClass("d-none");
        setTimeout(function () {
            $(".loader").addClass("d-none");
            showOff();
            getStored("pengeluaran");
            switchPlay("2");
        }, 200);
    });

    $("#nav-adhk").on("click", function (e) {
        e.preventDefault();
        $(".nav-item").removeClass("active");
        $(this).addClass("active");
        let period_id;
        if ($("#period").val() !== "") {
            period_id = $("#period").val();
        } else {
            period_id = localStorage.getItem("filters");
        }
        // const url_key = new URL('{{ route("pengeluaran-usaha.getKonserda") }}')
        url_key.searchParams.set("period_id", encodeURIComponent(period_id));
        url_key.searchParams.set("type", encodeURIComponent("show"));

        $.ajax({
            beforeSend: function () {
                $(".loader").removeClass("d-none");
            },
            type: "GET",
            // url: 'getKonserda/' + period_id,
            url: url_key.href,
            dataType: "json",
            success: function (data) {
                setTimeout(function () {
                    $(".loader").addClass("d-none");
                    showOff();
                    getAdhk(data.data, "pengeluaran");
                    switchPlay("2");
                }, 200);
            },
        });
    });

    //indeks implisit adhb/adhk
    $("#nav-indeks").on("click", function (e) {
        e.preventDefault();
        $(".nav-item").removeClass("active");
        $(this).addClass("active");
        let period_id;
        if ($("#period").val() !== "") {
            period_id = $("#period").val();
        } else {
            period_id = localStorage.getItem("filters");
        }
        // const url_key = new URL('{{ route("pengeluaran-usaha.getKonserda") }}')
        url_key.searchParams.set("period_id", encodeURIComponent(period_id));
        url_key.searchParams.set("type", encodeURIComponent("show"));

        $.ajax({
            beforeSend: function () {
                $(".loader").removeClass("d-none");
            },
            type: "GET",
            // url: 'getKonserda/' + period_id,
            url: url_key.href,

            dataType: "json",
            success: function (data) {
                setTimeout(function () {
                    $(".loader").addClass("d-none");
                    showOff();
                    getIndex(data.data, "pengeluaran");
                    switchPlay("2");
                }, 200);
            },
        });
    });

    $("#nav-laju-year").on("click", function (e) {
        e.preventDefault();
        $(".nav-item").removeClass("active");
        $(this).addClass("active");
        let period_id;
        if ($("#period").val() !== "") {
            period_id = $("#period").val();
        } else {
            period_id = localStorage.getItem("filters");
        }
        // const url_key = new URL('{{ route("pengeluaran-usaha.getKonserda") }}')
        url_key.searchParams.set("period_id", encodeURIComponent(period_id));
        url_key.searchParams.set("type", encodeURIComponent("year"));

        $.ajax({
            beforeSend: function () {
                $(".loader").removeClass("d-none");
            },
            type: "GET",
            // url: 'getKonserda/' + period_id,
            url: url_key.href,
            dataType: "json",
            success: function (data) {
                setTimeout(function () {
                    $(".loader").addClass("d-none");
                    showOff();
                    if (data.before === null || data.before.length === 0) {
                        alert("Data tahun lalu tidak ada");
                    } else {
                        let first = getIndex(data.data, "pengeluaran");
                        let before = getIndex(data.before, "pengeluaran");
                        getLaju(first, before);
                        switchPlay("2");
                    }
                }, 200);
            },
        });
    });
    $("#nav-laju-quarter").on("click", function (e) {
        e.preventDefault();
        $(".nav-item").removeClass("active");
        $(this).addClass("active");
        let period_id;
        if ($("#period").val() !== "") {
            period_id = $("#period").val();
        } else {
            period_id = localStorage.getItem("filters");
        }
        // const url_key = new URL('{{ route("pengeluaran-usaha.getKonserda") }}')
        url_key.searchParams.set("period_id", encodeURIComponent(period_id));
        url_key.searchParams.set("type", encodeURIComponent("quarter"));

        $.ajax({
            beforeSend: function () {
                $(".loader").removeClass("d-none");
            },
            type: "GET",
            // url: 'getKonserda/' + period_id,
            url: url_key.href,
            dataType: "json",
            success: function (data) {
                setTimeout(function () {
                    $(".loader").addClass("d-none");
                    showOff();
                    if (data.before === null || data.before.length === 0) {
                        alert("Data tahun lalu tidak ada");
                    } else {
                        let first = getIndex(data.data, "pengeluaran");
                        let before = getIndex(data.before, "pengeluaran");
                        getLaju(first, before);
                        switchPlay("2");
                    }
                }, 200);
            },
        });
    });
    $("#nav-laju-cumulative").on("click", function (e) {
        e.preventDefault();
        $(".nav-item").removeClass("active");
        $(this).addClass("active");
        let period_id;
        if ($("#period").val() !== "") {
            period_id = $("#period").val();
        } else {
            period_id = localStorage.getItem("filters");
        }
        // const url_key = new URL('{{ route("pengeluaran-usaha.getKonserda") }}')
        url_key.searchParams.set("period_id", encodeURIComponent(period_id));
        url_key.searchParams.set("type", encodeURIComponent("cumulative"));

        $.ajax({
            beforeSend: function () {
                $(".loader").removeClass("d-none");
            },
            type: "GET",
            // url: 'getKonserda/' + period_id,
            url: url_key.href,
            dataType: "json",
            success: function (data) {
                setTimeout(function () {
                    $(".loader").addClass("d-none");
                    showOff();
                    if (data.before === null || data.before.length === 0) {
                        alert("Data tahun lalu tidak ada");
                    } else {
                        let first = getIndex(data.data, "pengeluaran");
                        let before = getIndex(data.before, "pengeluaran");
                        getLaju(first, before);
                        switchPlay("2");
                    }
                }, 200);
            },
        });
    });

    //growth
    $("#nav-pertumbuhan-year").on("click", function (e) {
        e.preventDefault();
        $(".nav-item").removeClass("active");
        $(this).addClass("active");
        let period_id;
        if ($("#period").val() !== "") {
            period_id = $("#period").val();
        } else {
            period_id = localStorage.getItem("filters");
        }
        // const url_key = new URL('{{ route("pengeluaran-usaha.getKonserda") }}')
        url_key.searchParams.set("period_id", encodeURIComponent(period_id));
        url_key.searchParams.set("type", encodeURIComponent("year"));

        $.ajax({
            beforeSend: function () {
                $(".loader").removeClass("d-none");
            },
            type: "GET",
            // url: 'getKonserda/' + period_id,
            url: url_key.href,
            dataType: "json",
            success: function (data) {
                setTimeout(function () {
                    $(".loader").addClass("d-none");
                    showOff();
                    if (data.before === null || data.before.length === 0) {
                        alert("Data tahun lalu tidak ada");
                    } else {
                        getGrowth(data.data, data.before, "pengeluaran");
                        switchPlay("2");
                    }
                }, 200);
            },
        });
    });

    $("#nav-pertumbuhan-quarter").on("click", function (e) {
        e.preventDefault();
        $(".nav-item").removeClass("active");
        $(this).addClass("active");
        let period_id;
        if ($("#period").val() !== "") {
            period_id = $("#period").val();
        } else {
            period_id = localStorage.getItem("filters");
        }
        // const url_key = new URL('{{ route("pengeluaran-usaha.getKonserda") }}')
        url_key.searchParams.set("period_id", encodeURIComponent(period_id));
        url_key.searchParams.set("type", encodeURIComponent("quarter"));

        $.ajax({
            beforeSend: function () {
                $(".loader").removeClass("d-none");
            },
            type: "GET",
            // url: 'getKonserda/' + period_id,
            url: url_key.href,
            dataType: "json",
            success: function (data) {
                setTimeout(function () {
                    $(".loader").addClass("d-none");
                    showOff();
                    if (data.before === null || data.before.length === 0) {
                        alert("Data tahun lalu tidak ada");
                    } else {
                        getGrowth(data.data, data.before, "pengeluaran");
                        switchPlay("2");
                    }
                }, 200);
            },
        });
    });

    $("#nav-pertumbuhan-cumulative").on("click", function (e) {
        e.preventDefault();
        $(".nav-item").removeClass("active");
        $(this).addClass("active");
        let period_id;
        if ($("#period").val() !== "") {
            period_id = $("#period").val();
        } else {
            period_id = localStorage.getItem("filters");
        }
        // const url_key = new URL('{{ route("pengeluaran-usaha.getKonserda") }}')
        url_key.searchParams.set("period_id", encodeURIComponent(period_id));
        url_key.searchParams.set("type", encodeURIComponent("cumulative"));

        $.ajax({
            beforeSend: function () {
                $(".loader").removeClass("d-none");
            },
            type: "GET",
            // url: 'getKonserda/' + period_id,
            url: url_key.href,
            dataType: "json",
            success: function (data) {
                setTimeout(function () {
                    console.log(data);
                    localStorage.setItem("skewer", JSON.stringify(data.data));
                    $(".loader").addClass("d-none");
                    showOff();
                    if (data.before === null || data.before.length === 0) {
                        alert("Data tahun lalu tidak ada");
                    } else {
                        getGrowth(data.data, data.before, "pengeluaran");
                        switchPlay("2");
                    }
                    // localStorage.setItem('filters', period_id)
                }, 200);
            },
        });
    });
    //struktur antar
    $("#nav-struktur-antar").on("click", function (e) {
        e.preventDefault();
        $(".nav-item").removeClass("active");
        $(this).addClass("active");
        let period_id;
        if ($("#period").val() !== "") {
            period_id = $("#period").val();
        } else {
            period_id = localStorage.getItem("filters");
        }
        // const url_key = new URL('{{ route("pengeluaran-usaha.getKonserda") }}')
        url_key.searchParams.set("period_id", encodeURIComponent(period_id));
        url_key.searchParams.set("type", encodeURIComponent("show"));

        $.ajax({
            beforeSend: function () {
                $(".loader").removeClass("d-none");
            },
            type: "GET",
            // url: 'getKonserda/' + period_id,
            url: url_key.href,
            dataType: "json",
            success: function (data) {
                setTimeout(function () {
                    $(".loader").addClass("d-none");
                    getAntar(data.data, "pengeluaran");
                    switchPlay("2");
                    $("#change-query").prop("disabled", true);
                }, 200);
            },
        });
    });
});