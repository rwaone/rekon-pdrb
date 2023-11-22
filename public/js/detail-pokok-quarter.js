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

function showOff() {
    $("#rekon-view thead th").removeClass("d-none");
    $("#rekon-view tbody td").removeClass("d-none");
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
    // console.log(type);
    // console.log(data);
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

function getGrowthQ(data, befores, type) {
    const rowComponent = type === "lapangan-usaha" ? 55 : 14;
    $("tbody td:nth-child(n+2):nth-child(-n+6)").removeClass(function (
        index,
        className
    ) {
        return (className.match(/(^|\s)view-\S+/g) || []).join(" ");
    });
    $("tbody td:nth-child(n+2):nth-child(-n+6)").addClass("view-pertumbuhan");

    const details = [];
    const growth = [];
    const before = [];

    const getCells = (columnIndex) => {
        const cells = [];
        $("tbody tr").each(function () {
            const value = $(this).find("td").eq(columnIndex).text();
            cells.push(
                Number(
                    value.replaceAll(/[A-Za-z.]/g, "").replaceAll(/[,]/g, ".")
                )
            );
        });
        return cells;
    };

    for (let q = 1; q <= 4; q++) {
        for (let i = 1; i <= rowComponent; i++) {
            $(`#value-${i}-${q}`).text(data["pdrb-" + q][i - 1]["adhk"]);
        }
    }
    getSummarise(types);

    for (let i = 1; i <= 4; i++) {
        details[i] = getCells(i);
    }
    let status;
    status = 2;
    if (befores === "kosong") {
        status = 1;
    }
    if (status === 2) {
        $("tbody td:nth-child(2)").each(function () {
            for (let i = 1; i <= rowComponent; i++) {
                $(`#value-${i}-1`).text(befores["pdrb-4"][i - 1]["adhk"]);
            }
        });
        getSummarise(types);
        $("tbody td:nth-child(2)").each(function () {
            const X = $(this)
                .text()
                .replaceAll(/[A-Za-z.]/g, "")
                .replaceAll(/[,]/g, ".");
            before.push(Number(X));
        });
    }

    for (let i = 1; i <= 4; i++) {
        const result = details[i].map((value, j) => {
            let score;
            if (i === 1) {
                if (status === 2) {
                    score = ((value / before[j]) * 100 - 100).toFixed(2);
                } else {
                    score = "-";
                }
            } else {
                score = ((value / details[i - 1][j]) * 100 - 100).toFixed(2);
            }
            return !isFinite(score) || isNaN(score) ? "-" : score;
        });
        growth[i] = result;
    }

    for (let q = 1; q <= 4; q++) {
        $("tbody tr").each(function (index) {
            $(this).find("td").eq(q).text(growth[q][index]);
        });
    }

    $(".total-column").addClass("d-none");
    if (befores === "kosong") {
        alert("Data Tahun Lalu Belum Final");
    }
}

function getGrowthY(data, befores, type) {
    const rowComponent = type === "lapangan-usaha" ? 55 : 14;
    $("tbody td:nth-child(n+2):nth-child(-n+6)").removeClass(function (
        index,
        className
    ) {
        return (className.match(/(^|\s)view-\S+/g) || []).join(" ");
    });
    $("tbody td:nth-child(n+2):nth-child(-n+6)").addClass("view-pertumbuhan");

    const details = [];
    const growth = [];
    const before = [];

    const getCells = (columnIndex) => {
        const cells = [];
        $("tbody tr").each(function () {
            const value = $(this).find("td").eq(columnIndex).text();
            cells.push(
                Number(
                    value.replaceAll(/[A-Za-z.]/g, "").replaceAll(/[,]/g, ".")
                )
            );
        });
        return cells;
    };

    for (let q = 1; q <= 4; q++) {
        for (let i = 1; i <= rowComponent; i++) {
            $(`#value-${i}-${q}`).text(
                formatRupiah(data["pdrb-" + q][i - 1]["adhk"].replace(".", ","))
            );
        }
    }
    getSummarise(types);

    for (let i = 1; i <= 4; i++) {
        details[i] = getCells(i);
    }

    let status;
    status = 2;
    if (befores === "kosong") {
        status = 1;
    }

    if (status === 2) {
        for (let q = 1; q <= 4; q++) {
            for (let i = 1; i <= rowComponent; i++) {
                $(`#value-${i}-${q}`).text(
                    formatRupiah(
                        befores["pdrb-" + q][i - 1]["adhk"].replace(".", ",")
                    )
                );
            }
        }
        getSummarise(types);

        for (let i = 1; i <= 4; i++) {
            before[i] = getCells(i);
        }
    }

    for (var i = 1; i <= 4; i++) {
        let result = [];
        for (let j = 0; j <= details[i].length; j++) {
            let score = ((details[i][j] / before[i][j]) * 100 - 100).toFixed(2);

            result[j] = !isFinite(score) || isNaN(score) ? "-" : score;
        }
        growth[i] = result;
    }

    for (let q = 1; q <= 4; q++) {
        $("tbody tr").each(function (index) {
            $(this).find("td").eq(q).text(growth[q][index]);
        });
    }

    $(".total-column").addClass("d-none");
    if (befores === "kosong") {
        alert("Data Tahun Lalu Belum Final");
    }
}

function getGrowthC(data, befores, type) {
    const rowComponent = type === "lapangan-usaha" ? 55 : 14;
    $("tbody td:nth-child(n+2):nth-child(-n+6)").removeClass(function (
        index,
        className
    ) {
        return (className.match(/(^|\s)view-\S+/g) || []).join(" ");
    });
    $("tbody td:nth-child(n+2):nth-child(-n+6)").addClass("view-pertumbuhan");

    const details = [];
    const growth = [];
    const before = [];

    const getCells = (columnIndex) => {
        const cells = [];
        $("tbody tr").each(function () {
            const value = $(this).find("td").eq(columnIndex).text();
            cells.push(
                Number(
                    value.replaceAll(/[A-Za-z.]/g, "").replaceAll(/[,]/g, ".")
                )
            );
        });
        return cells;
    };

    for (let q = 1; q <= 4; q++) {
        for (let i = 1; i <= rowComponent; i++) {
            $(`#value-${i}-${q}`).text(
                formatRupiah(data["pdrb-" + q][i - 1]["adhk"].replace(".", ","))
            );
        }
    }
    getSummarise(types);

    for (let i = 1; i <= 4; i++) {
        details[i] = getCells(i);
    }

    let status;
    status = 2;
    if (befores === "kosong") {
        status = 1;
    }

    if (status === 2) {
        for (let q = 1; q <= 4; q++) {
            for (let i = 1; i <= rowComponent; i++) {
                $(`#value-${i}-${q}`).text(
                    formatRupiah(
                        befores["pdrb-" + q][i - 1]["adhk"].replace(".", ",")
                    )
                );
            }
        }
        getSummarise(types);

        for (let i = 1; i <= 4; i++) {
            before[i] = getCells(i);
        }
    }

    for (var i = 1; i <= 4; i++) {
        let result = [];
        for (let j = 0; j < details[i].length; j++) {
            let score = 0;
            let sumValue = 0;
            let sumBefore = 0;

            for (let length = 1; length <= i; length++) {
                sumValue += details[length][j];
                sumBefore += before[length][j];
            }
            score = ((sumValue / sumBefore) * 100 - 100).toFixed(2);

            result[j] = !isFinite(score) || isNaN(score) ? "-" : score;
        }
        growth[i] = result;
    }

    for (let q = 1; q <= 4; q++) {
        $("tbody tr").each(function (index) {
            $(this).find("td").eq(q).text(growth[q][index]);
        });
    }

    $(".total-column").addClass("d-none");
    if (befores === "kosong") {
        alert("Data Tahun Lalu Belum Final");
    }
}

function getSOGQ(data, befores, type) {
    const rowComponent = type === "lapangan-usaha" ? 55 : 14;
    $("tbody td:nth-child(n+2):nth-child(-n+6)").removeClass(function (
        index,
        className
    ) {
        return (className.match(/(^|\s)view-\S+/g) || []).join(" ");
    });
    $("tbody td:nth-child(n+2):nth-child(-n+6)").addClass("view-pertumbuhan");

    const current = [];
    const growth = [];
    const previous = [];

    const getCells = (columnIndex) => {
        const cells = [];
        $("tbody tr").each(function () {
            const value = $(this).find("td").eq(columnIndex).text();
            cells.push(
                Number(
                    value.replaceAll(/[A-Za-z.]/g, "").replaceAll(/[,]/g, ".")
                )
            );
        });
        return cells;
    };

    for (let q = 1; q <= 4; q++) {
        for (let i = 1; i <= rowComponent; i++) {
            $(`#value-${i}-${q}`).text(
                formatRupiah(data["pdrb-" + q][i - 1]["adhk"].replace(".", ","))
            );
        }
    }
    getSummarise(types);

    for (let i = 1; i <= 4; i++) {
        current[i] = getCells(i);
    }

    let status;
    status = 2;
    if (befores === "kosong") {
        status = 1;
    }

    if (status === 2) {
        for (let q = 1; q <= 4; q++) {
            for (let i = 1; i <= rowComponent; i++) {
                $(`#value-${i}-${q}`).text(
                    formatRupiah(
                        befores["pdrb-" + q][i - 1]["adhk"].replace(".", ",")
                    )
                );
            }
        }
        getSummarise(types);

        for (let i = 1; i <= 4; i++) {
            previous[i] = getCells(i);
        }
    }

    for (var i = 1; i <= 4; i++) {
        let result = [];
        let previous_total;
        if (i == 1) {
            previous_total = previous[4][previous[i].length - 1];
        } else {
            previous_total = current[i - 1][current[i].length - 1];
        }
        for (let j = 0; j < current[i].length; j++) {
            let sog;
            if (i == 1) {
                sog = (
                    (100 * (current[i][j] - previous[4][j])) /
                    previous_total
                ).toFixed(2);
            } else {
                sog = (
                    (100 * (current[i][j] - current[i - 1][j])) /
                    previous_total
                ).toFixed(2);
            }
            result[j] = !isFinite(sog) || isNaN(sog) ? "-" : sog;
        }
        growth[i] = result;
    }

    for (let q = 1; q <= 4; q++) {
        $("tbody tr").each(function (index) {
            $(this).find("td").eq(q).text(growth[q][index]);
        });
    }

    $(".total-column").addClass("d-none");
    if (befores === "kosong") {
        alert("Data Tahun Lalu Belum Final");
    }
}

function getSOGY(data, befores, type) {
    const rowComponent = type === "lapangan-usaha" ? 55 : 14;
    $("tbody td:nth-child(n+2):nth-child(-n+6)").removeClass(function (
        index,
        className
    ) {
        return (className.match(/(^|\s)view-\S+/g) || []).join(" ");
    });
    $("tbody td:nth-child(n+2):nth-child(-n+6)").addClass("view-pertumbuhan");

    const current = [];
    const growth = [];
    const previous = [];

    const getCells = (columnIndex) => {
        const cells = [];
        $("tbody tr").each(function () {
            const value = $(this).find("td").eq(columnIndex).text();
            cells.push(
                Number(
                    value.replaceAll(/[A-Za-z.]/g, "").replaceAll(/[,]/g, ".")
                )
            );
        });
        return cells;
    };

    for (let q = 1; q <= 4; q++) {
        for (let i = 1; i <= rowComponent; i++) {
            $(`#value-${i}-${q}`).text(
                formatRupiah(data["pdrb-" + q][i - 1]["adhk"].replace(".", ","))
            );
        }
    }
    getSummarise(types);

    for (let i = 1; i <= 4; i++) {
        current[i] = getCells(i);
    }

    let status;
    status = 2;
    if (befores === "kosong") {
        status = 1;
    }

    if (status === 2) {
        for (let q = 1; q <= 4; q++) {
            for (let i = 1; i <= rowComponent; i++) {
                $(`#value-${i}-${q}`).text(
                    formatRupiah(
                        befores["pdrb-" + q][i - 1]["adhk"].replace(".", ",")
                    )
                );
            }
        }
        getSummarise(types);

        for (let i = 1; i <= 4; i++) {
            previous[i] = getCells(i);
        }
    }

    for (var i = 1; i <= 4; i++) {
        let result = [];
        let previous_total = previous[i][previous[i].length - 1];
        for (let j = 0; j < current[i].length; j++) {
            let sog = (
                (100 * (current[i][j] - previous[i][j])) /
                previous_total
            ).toFixed(2);

            result[j] = !isFinite(sog) || isNaN(sog) ? "-" : sog;
        }
        growth[i] = result;
    }

    for (let q = 1; q <= 4; q++) {
        $("tbody tr").each(function (index) {
            $(this).find("td").eq(q).text(growth[q][index]);
        });
    }

    $(".total-column").addClass("d-none");
    if (befores === "kosong") {
        alert("Data Tahun Lalu Belum Final");
    }
}

function getIndex(data, befores, type) {
    const rowComponent = type === "lapangan-usaha" ? 55 : 14;
    $("tbody td:nth-child(n+2):nth-child(-n+6)").removeClass(function (
        index,
        className
    ) {
        return (className.match(/(^|\s)view-\S+/g) || []).join(" ");
    });
    $("tbody td:nth-child(n+2):nth-child(-n+6)").addClass("view-indeks");

    const current_adhb = [];
    const current_adhk = [];
    const prev_adhb = [];
    const prev_adhk = [];
    const idx = [];
    const prev_idx = [];

    const getCells = (columnIndex) => {
        const cells = [];
        $("tbody tr").each(function () {
            const value = $(this).find("td").eq(columnIndex).text();
            cells.push(
                Number(
                    value.replaceAll(/[A-Za-z.]/g, "").replaceAll(/[,]/g, ".")
                )
            );
        });
        return cells;
    };

    for (let q = 1; q <= 4; q++) {
        for (let i = 1; i <= rowComponent; i++) {
            $(`#value-${i}-${q}`).text(data[`pdrb-` + q][i - 1]["adhb"]);
        }
    }
    getSummarise(types);
    getTotal();
    for (let i = 1; i <= 5; i++) {
        current_adhb[i] = getCells(i);
    }
    for (let q = 1; q <= 4; q++) {
        for (let i = 1; i <= rowComponent; i++) {
            $(`#value-${i}-${q}`).text(data[`pdrb-` + q][i - 1]["adhk"]);
        }
    }
    getSummarise(types);
    getTotal();
    for (let i = 1; i <= 5; i++) {
        current_adhk[i] = getCells(i);
    }
    for (let i = 1; i <= 5; i++) {
        const result = current_adhb[i].map((value, j) => {
            const score = getIdx(value, current_adhk[i][j]);
            return !isFinite(score) || isNaN(score) ? "-" : score;
        });
        idx[i] = result;
    }
    if (!(befores === "kosong")) {
        for (let q = 1; q <= 4; q++) {
            for (let i = 1; i <= rowComponent; i++) {
                $(`#value-${i}-${q}`).text(befores[`pdrb-` + q][i - 1]["adhb"]);
            }
        }
        getSummarise(types);
        getTotal();
        for (let i = 1; i <= 5; i++) {
            prev_adhb[i] = getCells(i);
        }
        for (let q = 1; q <= 4; q++) {
            for (let i = 1; i <= rowComponent; i++) {
                $(`#value-${i}-${q}`).text(befores[`pdrb-` + q][i - 1]["adhk"]);
            }
        }
        getSummarise(types);
        getTotal();
        for (let i = 1; i <= 5; i++) {
            prev_adhk[i] = getCells(i);
        }
        for (let i = 1; i <= 5; i++) {
            const result = prev_adhb[i].map((value, j) => {
                const score = getIdx(value, prev_adhk[i][j]);
                return !isFinite(score) || isNaN(score) ? "-" : score;
            });
            prev_idx[i] = result;
        }
    } else {
        prev_idx = "kosong";
    }

    for (let q = 1; q <= 4; q++) {
        $("tbody tr").each(function (index) {
            $(this).find("td").eq(q).text(idx[q][index]);
        });
    }
    $("tbody tr").each(function (index) {
        $(this).find("td").eq(5).text(idx[5][index]);
    });

    return [idx, prev_idx];
}

function getLajuQ(idx) {
    $("tbody td:nth-child(n+2):nth-child(-n+6)").removeClass(function (
        index,
        className
    ) {
        return (className.match(/(^|\s)view-\S+/g) || []).join(" ");
    });
    $("tbody td:nth-child(n+2):nth-child(-n+6)").addClass("view-laju");
    const growth = [];
    const current = idx[0];
    const previous = idx[1];
    for (let i = 1; i <= 4; i++) {
        const result = current[i].map((value, j) => {
            let score;
            if (i === 1) {
                score = ((value / previous[4][j]) * 100 - 100).toFixed(2);
            } else {
                score = ((value / current[i - 1][j]) * 100 - 100).toFixed(2);
            }
            return !isFinite(score) || isNaN(score) ? "-" : score;
        });
        growth[i] = result;
    }

    $(".total-column").addClass("d-none");
    if (previous === "kosong") {
        alert("Data Tahun Lalu Belum Final");
    }
    for (let q = 1; q <= 4; q++) {
        $("tbody tr").each(function (index) {
            $(this).find("td").eq(q).text(growth[q][index]);
        });
    }
}

function getLajuY(idx) {
    $("tbody td:nth-child(n+2):nth-child(-n+6)").removeClass(function (
        index,
        className
    ) {
        return (className.match(/(^|\s)view-\S+/g) || []).join(" ");
    });
    $("tbody td:nth-child(n+2):nth-child(-n+6)").addClass("view-laju");
    const growth = [];
    const current = idx[0];
    const previous = idx[1];
    for (let i = 1; i <= 4; i++) {
        const result = current[i].map((value, j) => {
            let score = ((value / previous[i][j]) * 100 - 100).toFixed(2);
            return !isFinite(score) || isNaN(score) ? "-" : score;
        });
        growth[i] = result;
    }

    $(".total-column").addClass("d-none");
    if (previous === "kosong") {
        alert("Data Tahun Lalu Belum Final");
    }
    for (let q = 1; q <= 4; q++) {
        $("tbody tr").each(function (index) {
            $(this).find("td").eq(q).text(growth[q][index]);
        });
    }
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
                    formatRupiah(String(sum.toFixed(2)).replaceAll(/[.]/g, ","))
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

function fetchData() {
    return new Promise(function (resolve, reject) {
        $.ajax({
            type: "GET",
            url: getUrl.href,
            dataType: "json",
            success: function (data) {
                console.log(data)
                resolve(data);
                // console.log(data);
                sessionStorage.setItem("data", JSON.stringify(data.data));
                sessionStorage.setItem("before", JSON.stringify(data.before));
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
    toFixedView();
});

//change
$(document).ready(function () {
    let tbody = $("#rekon-view").find("tbody");
    var datas = JSON.parse(sessionStorage.getItem("data"));
    var befores = JSON.parse(sessionStorage.getItem("before"));
    $("#select-cat").on("change", function (e) {
        e.preventDefault();
        let checkVal = $(this).val();
        console.log(checkVal);
        switch (checkVal) {
            case "nav-adhb":
                resetMenu("nav-adhb");
                e.preventDefault();
                $(".loader").removeClass("d-none");
                // console.log(datas, befores)
                setTimeout(function () {
                    getAdhb(datas, types);
                    showOff();
                    toFixedView();
                    $(".loader").addClass("d-none");
                }, 500);
                break;
            case "nav-adhk":
                resetMenu("nav-adhk");
                e.preventDefault();
                $(".loader").removeClass("d-none");
                // console.log(datas, befores)
                setTimeout(function () {
                    getAdhk(datas, types);
                    showOff();
                    toFixedView();
                    $(".loader").addClass("d-none");
                }, 500);
                break;
            case "nav-distribusi":
                resetMenu("nav-distribusi");
                e.preventDefault();
                $(".loader").removeClass("d-none");
                // console.log(datas, befores)
                setTimeout(function () {
                    getAdhb(datas, types);
                    $("tbody td:nth-child(n+2):nth-child(-n+6)").removeClass(
                        function (index, className) {
                            return (
                                className.match(/(^|\s)view-\S+/g) || []
                            ).join(" ");
                        }
                    );
                    for (let q = 1; q <= 5; q++) {
                        for (let i = 0; i <= 55; i++) {
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
                    tbody.find(".total-column").each(function () {
                        $(this).addClass("view-distribusi-total");
                    });
                    getDist();

                    showOff();
                    $(".loader").addClass("d-none");
                }, 500);
                break;
            case "nav-qtoq":
                resetMenu("nav-qtoq");
                e.preventDefault();
                $(".loader").removeClass("d-none");
                // console.log(datas, befores)
                setTimeout(function () {
                    getGrowthQ(datas, befores, types);
                    $(".loader").addClass("d-none");
                }, 500);
                break;
            case "nav-ytoy":
                resetMenu("nav-ytoy");
                e.preventDefault();
                $(".loader").removeClass("d-none");
                // console.log(datas, befores)
                setTimeout(function () {
                    getGrowthY(datas, befores, types);
                    $(".loader").addClass("d-none");
                }, 500);
                break;
            case "nav-ctoc":
                resetMenu("nav-ctoc");
                e.preventDefault();
                $(".loader").removeClass("d-none");
                // console.log(datas, befores)
                setTimeout(function () {
                    getGrowthC(datas, befores, types);
                    $(".loader").addClass("d-none");
                }, 500);
                break;
            case "nav-indeks":
                resetMenu("nav-indeks");
                e.preventDefault();
                $(".loader").removeClass("d-none");
                // console.log(datas, befores)
                setTimeout(function () {
                    getIndex(datas, befores, types);
                    showOff();
                    $(".loader").addClass("d-none");
                }, 500);
                break;
            case "nav-lajuQ":
                resetMenu("nav-lajuQ");
                e.preventDefault();
                $(".loader").removeClass("d-none");
                // console.log(datas, befores)
                setTimeout(function () {
                    let idx = getIndex(datas, befores, types);
                    getLajuQ(idx);
                    $(".loader").addClass("d-none");
                }, 500);
                break;
            case "nav-lajuY":
                resetMenu("nav-lajuY");
                e.preventDefault();
                $(".loader").removeClass("d-none");
                // console.log(datas, befores)
                setTimeout(function () {
                    let idx = getIndex(datas, befores, types);
                    getLajuY(idx);
                    $(".loader").addClass("d-none");
                }, 500);
                break;
            case "nav-sogQ":
                resetMenu("nav-sogQ");
                e.preventDefault();
                $(".loader").removeClass("d-none");
                // console.log(datas, befores)
                setTimeout(function () {
                    getSOGQ(datas, befores, types);
                    $(".loader").addClass("d-none");
                }, 500);
                break;
            case "nav-sogY":
                resetMenu("nav-sogY");
                e.preventDefault();
                $(".loader").removeClass("d-none");
                // console.log(datas, befores)
                setTimeout(function () {
                    getSOGY(datas, befores, types);
                    $(".loader").addClass("d-none");
                }, 500);
                break;
            default:
                break;
        }
    });

    // $("#nav-adhb").on("click", function (e) {
    //     resetMenu("nav-adhb");
    //     e.preventDefault();
    //     $(".loader").removeClass("d-none");
    //     setTimeout(function () {
    //         getAdhb(datas, types);
    //         showOff();
    //         toFixedView();
    //         $(".loader").addClass("d-none");
    //     }, 500);
    // });

    // $("#nav-adhk").on("click", function (e) {
    //     resetMenu("nav-adhk");
    //     e.preventDefault();
    //     $(".loader").removeClass("d-none");
    //     setTimeout(function () {
    //         getAdhk(datas, types);
    //         showOff();
    //         toFixedView();
    //         $(".loader").addClass("d-none");
    //     }, 500);
    // });

    // $("#nav-distribusi").on("click", function (e) {
    //     resetMenu("nav-distribusi");
    //     e.preventDefault();
    //     $(".loader").removeClass("d-none");
    //     setTimeout(function () {
    //         getAdhb(datas, types);
    //         $("tbody td:nth-child(n+2):nth-child(-n+6)").removeClass(function (
    //             index,
    //             className
    //         ) {
    //             return (className.match(/(^|\s)view-\S+/g) || []).join(" ");
    //         });
    //         for (let q = 1; q <= 5; q++) {
    //             for (let i = 0; i <= 55; i++) {
    //                 $(`#value-${i}-${q}`).addClass(`view-distribusi-${q}`);
    //                 $(`#sector-${i}-${q}`).addClass(`view-distribusi-${q}`);
    //             }
    //             for (let index of catArray) {
    //                 $(`#categories-${index}-${q}`).addClass(
    //                     `view-distribusi-${q}`
    //                 );
    //             }
    //         }
    //         tbody.find(".total-column").each(function () {
    //             $(this).addClass("view-distribusi-total");
    //         });
    //         getDist();

    //         showOff();
    //         $(".loader").addClass("d-none");
    //     }, 500);
    // });

    // //belum tau gimana
    // $("#nav-qtoq").on("click", function (e) {
    //     resetMenu("nav-qtoq");
    //     e.preventDefault();
    //     $(".loader").removeClass("d-none");
    //     setTimeout(function () {
    //         getGrowthQ(datas, befores, types);
    //         $(".loader").addClass("d-none");
    //     }, 500);
    // });

    // $("#nav-ytoy").on("click", function (e) {
    //     resetMenu("nav-ytoy");
    //     e.preventDefault();
    //     $(".loader").removeClass("d-none");
    //     setTimeout(function () {
    //         getGrowthY(datas, befores, types);
    //         $(".loader").addClass("d-none");
    //     }, 500);
    // });

    // $("#nav-ctoc").on("click", function (e) {
    //     resetMenu("nav-ctoc");
    //     e.preventDefault();
    //     $(".loader").removeClass("d-none");
    //     setTimeout(function () {
    //         getGrowthC(datas, befores, types);
    //         $(".loader").addClass("d-none");
    //     }, 500);
    // });

    // //indeks implisit adhb/adhk
    // $("#nav-indeks").on("click", function (e) {
    //     resetMenu("nav-indeks");
    //     e.preventDefault();
    //     $(".loader").removeClass("d-none");
    //     setTimeout(function () {
    //         getIndex(datas, befores, types);
    //         showOff();
    //         $(".loader").addClass("d-none");
    //     }, 500);
    // });

    // //laju index
    // $("#nav-lajuQ").on("click", function (e) {
    //     resetMenu("nav-lajuQ");
    //     e.preventDefault();
    //     $(".loader").removeClass("d-none");
    //     setTimeout(function () {
    //         let idx = getIndex(datas, befores, types);
    //         getLajuQ(idx);
    //         $(".loader").addClass("d-none");
    //     }, 500);
    // });

    // $("#nav-lajuY").on("click", function (e) {
    //     resetMenu("nav-lajuY");
    //     e.preventDefault();
    //     $(".loader").removeClass("d-none");
    //     setTimeout(function () {
    //         let idx = getIndex(datas, befores, types);
    //         getLajuY(idx);
    //         $(".loader").addClass("d-none");
    //     }, 500);
    // });

    // $("#nav-sogQ").on("click", function (e) {
    //     resetMenu("nav-sogQ");
    //     e.preventDefault();
    //     $(".loader").removeClass("d-none");
    //     setTimeout(function () {
    //         getSOGQ(datas, befores, types);
    //         $(".loader").addClass("d-none");
    //     }, 500);
    // });

    // $("#nav-sogY").on("click", function (e) {
    //     resetMenu("nav-sogY");
    //     e.preventDefault();
    //     $(".loader").removeClass("d-none");
    //     setTimeout(function () {
    //         getSOGY(datas, befores, types);
    //         $(".loader").addClass("d-none");
    //     }, 500);
    // });

    function resetMenu(menu) {
        $(".tab-item").removeClass("active");
        $("#" + menu).addClass("active");
    }
});
