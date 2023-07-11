function getSummarise(type) {
    $(".values").each(function () {
        $(this).text(formatRupiah($(this).text(), "Rp "));
    });
    if (type === "lapangan-usaha") {
        rowComponent = 55;
        let sum = 0;
        for (let q = 1; q <= 4; q++) {
            for (let i = 1; i <= 7; i++) {
                let X = $(`#value-${i}-${q}`)
                    .text()
                    .replaceAll(/[A-Za-z.]/g, "");
                // let X = $(`#value-${i}`).text()
                let Y = X.replaceAll(/[,]/g, ".");
                sum += Number(Y);
            }
            $(`#sector-1-${q}`).text(
                formatRupiah(
                    String(sum.toFixed(2)).replaceAll(/[.]/g, ","),
                    "Rp "
                )
            );
            sum = sum - sum;
        }
        sum = sum - sum;
        for (let q = 1; q <= 4; q++) {
            for (let i = 14; i <= 15; i++) {
                let X = $(`#value-${i}-${q}`)
                    .text()
                    .replaceAll(/[A-Za-z.]/g, "");
                let Y = X.replaceAll(/[,]/g, ".");
                sum += Number(Y);
            }

            $(`#sector-14-${q}`).text(
                formatRupiah(
                    String(sum.toFixed(2)).replaceAll(/[.]/g, ","),
                    "Rp "
                )
            );
            sum = sum - sum;
        }
        sum = sum - sum;
        for (let q = 1; q <= 4; q++) {
            for (let index of catArray) {
                let jumlah = calculateSector(
                    `categories-${index}-${q}`
                ).toFixed(2);
                let que = String(jumlah).replaceAll(/[.]/g, ",");
                $(`#categories-${index}-${q}`).text(formatRupiah(que, "Rp "));
                $(`#categories-${index}-${q}`).addClass(
                    `text-bold pdrb-total-${q}`
                );
            }
        }
        for (let q = 1; q <= 4; q++) {
            let pdrb = calculateSector(`pdrb-total-${q}`).toFixed(2);
            let nonmigas =
                simpleSum(`#value-10-${q}`) + simpleSum(`#value-15-${q}`);
            $(`#total-${q}`).text(
                formatRupiah(String(pdrb).replaceAll(/[.]/g, ","), "Rp ")
            );
            let pdrbNonmigas = (pdrb - nonmigas).toFixed(2);
            $(`#total-nonmigas-${q}`).text(
                formatRupiah(
                    String(pdrbNonmigas).replaceAll(/[.]/g, ","),
                    "Rp "
                )
            );
        }
    } else if (type === "pengeluaran") {
        rowComponent = 14;
        let sum = 0;
        for (let q = 1; q <= 4; q++) {
            for (let i = 1; i <= 7; i++) {
                let X = $(`#value-${i}-${q}`)
                    .text()
                    .replaceAll(/[A-Za-z.]/g, "");
                let Y = X.replaceAll(/[,]/g, ".");
                sum += Number(Y);
            }
            $(`#sector-1-${q}`).text(
                formatRupiah(
                    String(sum.toFixed(2)).replaceAll(/[.]/g, ","),
                    "Rp "
                )
            );
            $(`#sector-1-${q}`).addClass(`text-bold pdrb-total-${q}`);
            sum = sum - sum;
        }
        sum = sum - sum;
        for (let q = 1; q <= 4; q++) {
            for (let i = 10; i <= 11; i++) {
                let X = $(`#value-${i}-${q}`)
                    .text()
                    .replaceAll(/[A-Za-z.]/g, "");
                let Y = X.replaceAll(/[,]/g, ".");
                sum += Number(Y);
            }

            $(`#sector-10-${q}`).text(
                formatRupiah(
                    String(sum.toFixed(2)).replaceAll(/[.]/g, ","),
                    "Rp "
                )
            );
            $(`#sector-10-${q}`).addClass(`text-bold pdrb-total-${q}`);
            sum = sum - sum;
        }
        sum = sum - sum;
        for (let q = 1; q <= 4; q++) {
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
                formatRupiah(
                    String(Nets.toFixed(2)).replaceAll(/[.]/g, ","),
                    "Rp "
                )
            );
            $(`#sector-13-${q}`).addClass(`text-bold pdrb-total-${q}`);
            sum = sum - sum;
        }
        sum = sum - sum;
        for (let q = 1; q <= 4; q++) {
            let pdrb = calculateSector(`pdrb-total-${q}`).toFixed(2);
            $(`#total-${q}`).text(
                formatRupiah(String(pdrb).replaceAll(/[.]/g, ","), "Rp ")
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
    let score = (X / Y) * 100;
    return score.toFixed(2);
}

function getDist() {
    for (let q = 1; q <= 4; q++) {
        $(`.view-distribusi-${q}`).each(function () {
            let id = "#" + $(this).attr("id");
            let y = distribusi(id, q);
            $(this).text(y);
        });
        $(".view-distribusi-total").each(function (index) {
            let X = $(this)
                .text()
                .replaceAll(/[A-Za-z.]/g, "")
                .replaceAll(/[,]/g, ".");
            let Xnumber = Number(X);
            let Y = $(".view-distribusi-total")
                .eq(-1)
                .text()
                .replaceAll(/[A-Za-z.]/g, "")
                .replaceAll(/[,]/g, ".");
            let Ynumber = Number(Y);
            // console.log(Xnumber / Ynumber);
            let score = (Xnumber / Ynumber) * 100;
            $(this).text(score.toFixed(2));
        });
        $(`#total-nonmigas-${q}`).text(distribusi(`#total-nonmigas-${q}`, q));
        $(`#total-${q}`).text(distribusi(`#total-${q}`, q));
    }
}

function getIdx(adhb, adhk) {
    let result = (adhb / adhk) * 100;
    return result.toFixed(2);
}

function getAdhb(data, type) {
    console.log(type);
    console.log(data);
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
    $("tbody td:nth-child(n+2):nth-child(-n+6)").addClass("view-adhb");
    for (let q = 1; q <= 4; q++) {
        for (let i = 1; i <= rowComponent; i++) {
            let X = data[`pdrb-${q}`][i - 1]["adhb"];
            let Y = String(X).replaceAll(/[.]/g, ",");
            $(`#value-${i}-${q}`).text(Y);
        }
    }
    getSummarise(types);
    getTotal();
}

function getAdhk(data, type) {
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
    $("tbody td:nth-child(n+2):nth-child(-n+6)").addClass("view-adhk");
    for (let q = 1; q <= 4; q++) {
        for (let i = 1; i <= rowComponent; i++) {
            let X = data[`pdrb-${q}`][i - 1]["adhk"];
            let Y = String(X).replaceAll(/[.]/g, ",");
            $(`#value-${i}-${q}`).text(Y);
        }
    }
    getSummarise(types);
    getTotal();
}

function getGrowth(data, type) {
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
    let idx_adhk = [];
    let growth = [];
    for (let q = 1; q <= 4; q++) {
        for (let i = 1; i <= rowComponent; i++) {
            $(`#value-${i}-${q}`).text(data[`pdrb-${q}`][i - 1]["adhk"]);
        }
    }
    getSummarise(types);
    $("tbody td:not(:first-child):not(:last-child)").each(function () {
        let X = $(this)
            .text()
            .replaceAll(/[A-Za-z.]/g, "");
        let Y = X.replaceAll(/[,]/g, ".");
        idx_adhk.push(Number(Y));
    });

    for (let i = 0; i < idx_adhk.length; i++) {
        if (i % 4 != 0 && i > 0) {
            let score =
                idx_adhk[i - 1] > 0
                    ? ((idx_adhk[i] / idx_adhk[i - 1]) * 100 - 100).toFixed(2)
                    : "";
            growth.push(score);
        } else {
            score = "-";
            growth.push(score);
        }
    }
    $("tbody td:not(:first-child):not(:last-child)").each(function (index) {
        $(this).text(growth[index]);
    });
}

function getIndex(data, type) {
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
    $("tbody td:nth-child(n+2):nth-child(-n+6)").addClass("view-indeks");
    let idx_adhb = [];
    let idx_adhk = [];
    let idx = [];
    for (let q = 1; q <= 4; q++) {
        for (let i = 1; i <= rowComponent; i++) {
            $(`#value-${i}-${q}`).text(data[`pdrb-${q}`][i - 1]["adhb"]);
        }
    }
    getSummarise(types);
    getTotal();
    $("tbody td:not(:first-child)").each(function () {
        let X = $(this)
            .text()
            .replaceAll(/[A-Za-z.]/g, "");
        let Y = X.replaceAll(/[,]/g, ".");
        idx_adhb.push(Number(Y));
    });
    for (let q = 1; q <= 4; q++) {
        for (let i = 1; i <= rowComponent; i++) {
            $(`#value-${i}-${q}`).text(data[`pdrb-${q}`][i - 1]["adhk"]);
        }
    }
    getSummarise(types);
    getTotal();
    $("tbody td:not(:first-child)").each(function () {
        let X = $(this)
            .text()
            .replaceAll(/[A-Za-z.]/g, "");
        let Y = X.replaceAll(/[,]/g, ".");
        idx_adhk.push(Number(Y));
    });
    console.log(idx_adhk[4],idx_adhb[4])
    for (let i = 0; i < idx_adhb.length; i++) {
        idx.push(getIdx(idx_adhb[i], idx_adhk[i]));
    }
    $("tbody td:not(:first-child)").each(function (index) {
        $(this).text(idx[index]);
    });
    return idx;
}

function getLaju(laju) {
    $("tbody td:nth-child(n+2):nth-child(-n+6)").removeClass(function (
        index,
        className
    ) {
        return (className.match(/(^|\s)view-\S+/g) || []).join(" ");
    });
    $("tbody td:nth-child(n+2):nth-child(-n+6)").addClass("view-laju");
    let growth = [];
    laju = laju.filter((item) => item !== "");
    for (let i = 0; i < laju.length; i++) {
        if (i % 4 != 0 && i > 0) {
            let score = ((laju[i] / laju[i - 1]) * 100 - 100).toFixed(2);
            growth.push(score);
        } else {
            score = "-";
            growth.push(score);
        }
    }

    $("tbody td:not(:first-child):not(:last-child)").each(function (index) {
        $(this).text(growth[index]);
    });
}

function getTotal() {
    $("#rekon-view").each(function () {
        let table = $(this);
        let numRows = table.find("tr").length;
        let numCols = table.find("tr:first-child td:not(:last-child)").length;
        for (let row = 1; row <= numRows; row++) {
            let sum = 0;
            for (let col = 2; col <= numCols; col++) {
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
                .find("tr:nth-child(" + row + ") td:last-child")
                .text(
                    formatRupiah(
                        String(sum.toFixed(2)).replaceAll(/[.]/g, ","),
                        "Rp "
                    )
                );
        }
    });
}
$("#download-all").on("click", async function (e) {
    e.preventDefault();
    $(".loader").removeClass("d-none");
    await downloadKonserda();
    $(".loader").addClass("d-none");
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
        sum +=  Number(Y);
    });
    return sum;
}

//change the value of inputed number to Rupiah
function formatRupiah(angka, prefix) {
    var number_string = String(angka)
            .replace(/[^,\d]/g, "")
            .toString(),
        split = number_string.split(","),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
}

function fetchData() {
    return new Promise(function (resolve, reject) {
        $.ajax({
            type: "GET",
            url: getUrl.href,
            dataType: "json",
            success: function (data) {
                resolve(data);
                // console.log(data.data)
                localStorage.setItem("data", JSON.stringify(data.data));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                reject(errorThrown);
            },
        });
    });
}
$(document).ready(async function () {
    const data = await fetchData();
    getAdhb(data.data, types);
});

//change
$(document).ready(function () {
    let tbody = $("#rekon-view").find("tbody");
    var datas = JSON.parse(localStorage.getItem("data"));
    $("#nav-distribusi").on("click", function (e) {
        e.preventDefault();
        $(".loader").removeClass("d-none");
        setTimeout(function () {
            getAdhb(datas, types);
            $("tbody td:nth-child(n+2):nth-child(-n+6)").removeClass(function (
                index,
                className
            ) {
                return (className.match(/(^|\s)view-\S+/g) || []).join(" ");
            });
            for (let q = 1; q <= 5; q++) {
                for (let i = 0; i <= 55; i++) {
                    $(`#value-${i}-${q}`).addClass(`view-distribusi-${q}`);
                    $(`#sector-${i}-${q}`).addClass(`view-distribusi-${q}`);
                }
                for (let index of catArray) {
                    $(`#categories-${index}-${q}`).addClass(
                        `view-distribusi-${q}`
                    );
                }
            }
            tbody.find(".total-column").each(function () {
                $(this).addClass("view-distribusi-total");
            });
            getDist();
            $(".loader").addClass("d-none");
        }, 500);
    });

    $("#nav-adhb").on("click", function (e) {
        e.preventDefault();
        $(".loader").removeClass("d-none");
        setTimeout(function () {
            getAdhb(datas, types);
            $(".loader").addClass("d-none");
        }, 500);
    });

    $("#nav-adhk").on("click", function (e) {
        e.preventDefault();
        $(".loader").removeClass("d-none");
        setTimeout(function () {
            getAdhk(datas, types);
            $(".loader").addClass("d-none");
        }, 500);
    });

    //belum tau gimana
    $("#nav-pertumbuhan").on("click", function (e) {
        e.preventDefault();
        $(".loader").removeClass("d-none");
        setTimeout(function () {
            getGrowth(datas, types);
            $(".loader").addClass("d-none");
        }, 500);
    });

    //indeks implisit adhb/adhk
    $("#nav-indeks").on("click", function (e) {
        e.preventDefault();
        $(".loader").removeClass("d-none");
        setTimeout(function () {
            getIndex(datas, types);
            $(".loader").addClass("d-none");
        }, 500);
    });

    //laju index
    $("#nav-laju").on("click", function (e) {
        e.preventDefault();
        $(".loader").removeClass("d-none");
        setTimeout(function () {
            let laju = getIndex(datas, types);
            getLaju(laju);
            $(".loader").addClass("d-none");
        }, 500);
    });
});
