function getReady() {
    let headers = [];
    $("#rekon-view thead tr th").each(function () {
        headers.push($(this).text());
    });
    let contents = [];
    $("#rekon-view tbody tr").each(function (index) {
        let data = {};
        $(this)
            .find("td")
            .each(function (indeX) {
                let value = $(this).text();
                data[headers[indeX]] = value;
            });
        contents.push(data);
    });
    let komponens = [];
    $("#komponen tbody tr").each(function (index) {
        let data = {};
        $(this)
            .find("td")
            .each(function (indeX) {
                let value = $(this).text();
                data["Komponen"] = value;
            });
        komponens.push(data);
    });

    contents.forEach(function (row, index) {
        row.Komponen = row.Komponen.trim();
    });

    if (komponens.length > 0) {
        komponens.forEach(function (row, index) {
            row.Komponen = row.Komponen.trim();
        });

        let merged = [];
        for (let i = 0; i < komponens.length; i++) {
            let mergeds = { ...komponens[i], ...contents[i] };
            merged.push(mergeds);
        }
        return merged;
    } else {
        return contents;
    }
}

function convertToCSV(jsonData) {
    const separator = ";"; // CSV separator character
    const keys = Object.keys(jsonData[0]); // Get the keys from the first object

    // Build the header row
    const header = keys.join(separator);

    // Build the data rows
    const rows = jsonData.map((item) => {
        return keys
            .map((key) => {
                const value = item[key];
                return value ? `"${value}"` : ""; // Add double quotes around values
            })
            .join(separator);
    });

    // Combine header and data rows
    return `${header}\n${rows.join("\n")}`;
}
function downloadCSV(csvData, filename) {
    const csvFile = new Blob([csvData], { type: "text/csv" });
    const downloadLink = document.createElement("a");
    downloadLink.href = URL.createObjectURL(csvFile);
    downloadLink.download = filename;
    downloadLink.click();
}

function fetchDownload() {
    const period_id = $("#period").val();
    url_key.searchParams.set("period_id", encodeURIComponent(period_id));
    url_key.searchParams.set("type", encodeURIComponent("show"));
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

function fetchDownloadYear() {
    const period_id = $("#period").val();
    url_key.searchParams.set("period_id", encodeURIComponent(period_id));
    url_key.searchParams.set("type", encodeURIComponent("year"));
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

function fetchDownloadCumulative() {
    const period_id = $("#period").val();
    url_key.searchParams.set("period_id", encodeURIComponent(period_id));
    url_key.searchParams.set("type", encodeURIComponent("cumulative"));
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

async function downloadExcel() {
    // Your JSON data
    let list = [];
    try {
        const data = await fetchDownload();
        //adhb
        getAdhb(data.data, "lapangan");
        list["adhb_json"] = getReady();
        //adhk
        getAdhk(data.data, "lapangan");
        list["adhk_json"] = getReady();
        //struktur-dalam
        getAdhb(data.data, "lapangan");
        $("#rekon-view tbody td").removeClass(function (index, className) {
            return (className.match(/(^|\s)view-\S+/g) || []).join(" ");
        });
        for (let q = 1; q <= 16; q++) {
            for (let i = 0; i <= rowComponent; i++) {
                $(`#value-${i}-${q}`).addClass(`view-distribusi-${q}`);
                $(`#sector-${i}-${q}`).addClass(`view-distribusi-${q}`);
            }
            for (let index of catArray) {
                $(`#categories-${index}-${q}`).addClass(`view-distribusi-${q}`);
            }
        }
        $("#rekon-view tbody td:nth-child(2)").each(function () {
            $(this).addClass(`view-distribusi-totalKabkot`);
        });
        getDist();
        list["sdalam_json"] = getReady();
        //struktur-antar
        getAntar(data.data, "lapangan");
        list["santar_json"] = getReady();
        //indeks-implisit
        getIndex(data.data, "lapangan");
        list["index_json"] = getReady();

        //growth-qtoq
        if (data.before === null || data.before.length === 0) {
            alert("Data kuarter sebelumnya tidak ada");
        } else {
            getGrowth(data.data, data.before, "lapangan");
            list["growthQ_json"] = getReady();
            //laju-qtoq
            let firstQ = getIndex(data.data, "lapangan");
            let beforeQ = getIndex(data.before, "lapangan");
            getLaju(firstQ, beforeQ);
            list["lajuQ_json"] = getReady();
        }

        const dataYear = await fetchDownloadYear();

        //growth-ytoy
        if (dataYear.before === null || dataYear.before.length === 0) {
            alert("Data tahun lalu tidak ada");
        } else {
            getGrowth(dataYear.data, dataYear.before, "lapangan");
            list["growthY_json"] = getReady();
            //laju-ytoy
            let firstY = getIndex(dataYear.data, "lapangan");
            let beforeY = getIndex(dataYear.before, "lapangan");
            getLaju(firstY, beforeY);
            list["lajuY_json"] = getReady();
        }

        const dataCumulative = await fetchDownloadCumulative();

        //growth-CtoC
        if (
            dataCumulative.before === null ||
            dataCumulative.before.length === 0
        ) {
            alert("Data tahun lalu tidak ada");
        } else {
            getGrowth(dataCumulative.data, dataCumulative.before, "lapangan");
            list["growthC_json"] = getReady();
            //laju-ytoy
            let firstC = getIndex(dataCumulative.data, "lapangan");
            let beforeC = getIndex(dataCumulative.before, "lapangan");
            getLaju(firstC, beforeC);
            list["lajuC_json"] = getReady();
        }
        showOff();
        getStored("lapangan");
        $(".nav-item").removeClass("active");
        $("#nav-adhb").addClass("active");

        var workbook = XLSX.utils.book_new();
        for (let key in list) {
            if (list.hasOwnProperty(key)) {
                let value = list[key];
                var worksheet = XLSX.utils.json_to_sheet(value);
                XLSX.utils.book_append_sheet(workbook, worksheet, key);
            }
        }

        // Convert the workbook to a binary Excel file
        var excelFile = XLSX.write(workbook, { type: "binary" });

        // Convert the binary Excel file to a Blob
        var blob = new Blob([s2ab(excelFile)], {
            type: "application/octet-stream",
        });

        // Create a download link
        var a = document.createElement("a");
        var url = URL.createObjectURL(blob);
        a.href = url;
        const types = $("#select2-type-container").html();
        const years = $("#select2-year-container").html();
        const quarters = $("#select2-quarter-container").html();
        const periods = $("#select2-period-container").html();
        a.download =
            types + "-" + years + "-" + quarters + "-" + periods + ".xlsx";

        // Append the link to the document and trigger the download
        document.body.appendChild(a);
        a.click();

        // Clean up
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    } catch (e) {
        alert("An error occurred: " + e.message);
    }
}

function downloadKonserda() {
    let list = [];
    var datas = JSON.parse(localStorage.getItem("data"));
    try {
        getAdhb(datas);
        list["ADHB"] = getReady();
        getAdhk(datas);
        list["ADHK"] = getReady();
        let tbody = $('#rekon-view').find('tbody')
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
                $(`#categories-${index}-${q}`).addClass(`view-distribusi-${q}`);
            }
        }
        tbody.find(".total-column").each(function () {
            $(this).addClass("view-distribusi-total");
        });
        getDist();
        list["DISTRIBUSI"] = getReady();
        getGrowth(datas);
        list["GROWTH"] = getReady();
        let laju = getIndex(datas);
        list["INDEX"] = getReady();
        getLaju(laju);
        list["LAJU"] = getReady();
        getAdhb(datas);

        var workbook = XLSX.utils.book_new();
        for (let key in list) {
            if (list.hasOwnProperty(key)) {
                let value = list[key];
                var worksheet = XLSX.utils.json_to_sheet(value);
                XLSX.utils.book_append_sheet(workbook, worksheet, key);
            }
        }
        // Convert the workbook to a binary Excel file
        var excelFile = XLSX.write(workbook, { type: "binary" });

        // Convert the binary Excel file to a Blob
        var blob = new Blob([s2ab(excelFile)], {
            type: "application/octet-stream",
        });

        // Create a download link
        var a = document.createElement("a");
        var url = URL.createObjectURL(blob);
        a.href = url;
        a.download ="downloaded-data.xlsx";

        // Append the link to the document and trigger the download
        document.body.appendChild(a);
        a.click();

        // Clean up
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    } catch (e) {
        alert("Error: " + e.message);
    }
}

// Utility function to convert string to ArrayBuffer
function s2ab(s) {
    var buf = new ArrayBuffer(s.length);
    var view = new Uint8Array(buf);
    for (var i = 0; i < s.length; i++) {
        view[i] = s.charCodeAt(i) & 0xff;
    }
    return buf;
}
