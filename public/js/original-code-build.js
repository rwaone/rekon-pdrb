function getIndex(data, befores, type) {
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
    for (i = 1; i <= 5; i++) {
        let cells = [];
        $("tbody tr").each(function () {
            let value = $(this).find("td").eq(i).text();
            cells.push(
                Number(
                    value.replaceAll(/[A-Za-z.]/g, "").replaceAll(/[,]/g, ".")
                )
            );
        });
        idx_adhb[i] = cells;
    }
    for (let q = 1; q <= 4; q++) {
        for (let i = 1; i <= rowComponent; i++) {
            $(`#value-${i}-${q}`).text(data[`pdrb-${q}`][i - 1]["adhk"]);
        }
    }
    getSummarise(types);
    getTotal();
    for (i = 1; i <= 5; i++) {
        let cells = [];
        $("tbody tr").each(function () {
            let value = $(this).find("td").eq(i).text();
            cells.push(
                Number(
                    value.replaceAll(/[A-Za-z.]/g, "").replaceAll(/[,]/g, ".")
                )
            );
        });
        idx_adhk[i] = cells;
    }
    for (i = 1; i <= 5; i++) {
        let result = [];
        for (let j = 0; j <= idx_adhb[i].length; j++) {
            let score;
            score = getIdx(idx_adhb[i][j], idx_adhk[i][j]);
            if (!isFinite(score) || isNaN(score)) {
                result.push("-");
            } else {
                result.push(score);
            }
        }
        idx[i] = result;
    }
    $("tbody td:nth-child(2)").each(function () {
        for (let i = 1; i <= rowComponent; i++) {
            $(`#value-${i}-1`).text(befores["pdrb-before"][i - 1]["adhb"]);
        }
    });
    getSummarise(types);
    getTotal();
    let cells = [];
    $("tbody tr").each(function () {
        let value = $(this).find("td").eq(1).text();
        cells.push(
            Number(value.replaceAll(/[A-Za-z.]/g, "").replaceAll(/[,]/g, "."))
        );
    });
    idx_adhb["before"] = cells;
    $("tbody td:nth-child(2)").each(function () {
        for (let i = 1; i <= rowComponent; i++) {
            $(`#value-${i}-1`).text(befores["pdrb-before"][i - 1]["adhk"]);
        }
    });
    getSummarise(types);
    getTotal();
    cells = [];
    $("tbody tr").each(function () {
        let value = $(this).find("td").eq(1).text();
        cells.push(
            Number(value.replaceAll(/[A-Za-z.]/g, "").replaceAll(/[,]/g, "."))
        );
    });
    idx_adhk["before"] = cells;

    let result = [];
    for (let j = 0; j <= idx_adhb["before"].length; j++) {
        let score;
        score = getIdx(idx_adhb["before"][j], idx_adhk["before"][j]);
        if (!isFinite(score) || isNaN(score)) {
            result.push("-");
        } else {
            result.push(score);
        }
    }
    idx["before"] = result;

    for (let q = 1; q <= 4; q++) {
        $("tbody tr").each(function (index) {
            $(this).find("td").eq(q).text(idx[q][index]);
        });
    }
    $("tbody tr").each(function (index) {
        $(this).find("td").eq(5).text(idx[5][index]);
    });
    return idx;
}

function getGrowth(data, befores, type) {
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

    let details = [];
    for (i = 1; i <= 4; i++) {
        let cells = [];
        $("tbody tr").each(function () {
            let value = $(this).find("td").eq(i).text();
            cells.push(
                Number(
                    value.replaceAll(/[A-Za-z.]/g, "").replaceAll(/[,]/g, ".")
                )
            );
        });
        details[i] = cells;
    }

    let before = [];
    $("tbody td:nth-child(2)").each(function () {
        for (let i = 1; i <= rowComponent; i++) {
            $(`#value-${i}-1`).text(befores["pdrb-before"][i - 1]["adhk"]);
        }
    });
    getSummarise(types);
    $("tbody td:nth-child(2)").each(function () {
        let X = $(this)
            .text()
            .replaceAll(/[A-Za-z.]/g, "")
            .replaceAll(/[,]/g, ".");
        before.push(Number(X));
    });
    for (i = 1; i <= 4; i++) {
        let result = [];
        for (let j = 0; j <= details[i].length; j++) {
            let score;
            if (i == 1) {
                score = ((details[i][j] / before[j]) * 100 - 100).toFixed(2);
            } else {
                score = (
                    (details[i][j] / details[i - 1][j]) * 100 -
                    100
                ).toFixed(2);
            }
            if (!isFinite(score) || isNaN(score)) {
                result.push("-");
            } else {
                result.push(score);
            }
        }
        growth[i] = result;
    }
    for (let q = 1; q <= 4; q++) {
        $("tbody tr").each(function (index) {
            $(this).find("td").eq(q).text(growth[q][index]);
        });
    }

    $(".total-column").addClass("d-none");
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
    for (i = 1; i <= 4; i++) {
        let result = [];
        for (let j = 0; j <= laju[i].length; j++) {
            let score;
            if (i == 1) {
                score = ((laju[i][j] / laju["before"][j]) * 100 - 100).toFixed(
                    2
                );
            } else {
                score = ((laju[i][j] / laju[i - 1][j]) * 100 - 100).toFixed(2);
            }
            if (!isFinite(score) || isNaN(score)) {
                result.push("-");
            } else {
                result.push(score);
            }
        }
        growth[i] = result;
    }
    $(".total-column").addClass("d-none");
    for (let q = 1; q <= 4; q++) {
        $("tbody tr").each(function (index) {
            $(this).find("td").eq(q).text(growth[q][index]);
        });
    }
}
function getSummarise(type) {
    $(".values").each(function () {
        $(this).text(formatRupiah($(this).text()));
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
                formatRupiah(String(sum.toFixed(2)).replaceAll(/[.]/g, ","))
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
                formatRupiah(String(sum.toFixed(2)).replaceAll(/[.]/g, ","))
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
                $(`#categories-${index}-${q}`).text(formatRupiah(que));
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
        for (let q = 1; q <= 4; q++) {
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
        for (let q = 1; q <= 4; q++) {
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
                formatRupiah(String(Nets.toFixed(2)).replaceAll(/[.]/g, ","))
            );
            $(`#sector-13-${q}`).addClass(`text-bold pdrb-total-${q}`);
            sum = sum - sum;
        }
        sum = sum - sum;
        for (let q = 1; q <= 4; q++) {
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