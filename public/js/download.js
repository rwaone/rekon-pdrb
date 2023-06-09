function getReady() {
    let headers = []
    $('#rekon-view thead tr th').each(function () {
        headers.push($(this).text())
    })
    let contents = []
    $('#rekon-view tbody tr').each(function (index) {
        let data = {}
        $(this).find('td').each(function (indeX) {
            let value = $(this).text()
            data[headers[indeX]] = value
        })
        contents.push(data)
    })
    let komponens = []
    $('#komponen tbody tr').each(function (index) {
        let data = {}
        $(this).find('td').each(function (indeX) {
            let value = $(this).text()
            data['Komponen'] = value
        })
        komponens.push(data)
    })
    komponens.forEach(function (row, index) {
        row.Komponen = row.Komponen.trim()
    })
    let merged = []
    for (let i = 0; i < komponens.length; i++) {
        let mergeds = { ...komponens[i], ...contents[i] }
        merged.push(mergeds)
    }
    return merged
}

function convertToCSV(jsonData) {
    const separator = ';'; // CSV separator character
    const keys = Object.keys(jsonData[0]); // Get the keys from the first object

    // Build the header row
    const header = keys.join(separator);

    // Build the data rows
    const rows = jsonData.map(item => {
        return keys.map(key => {
            const value = item[key];
            return value ? `"${value}"` : ''; // Add double quotes around values
        }).join(separator);
    });

    // Combine header and data rows
    return `${header}\n${rows.join('\n')}`;
}
function downloadCSV(csvData, filename) {
    const csvFile = new Blob([csvData], { type: 'text/csv' });
    const downloadLink = document.createElement('a');
    downloadLink.href = URL.createObjectURL(csvFile);
    downloadLink.download = filename;
    downloadLink.click();
}

