function getSummarise(type) {
    $('.values').each(function () {
        $(this).text(formatRupiah($(this).text(), 'Rp '))
    })
    if (type === 'lapangan') {
        rowComponent = 55
        let sum = 0
        for (let q = 1; q <= 16; q++) {
            for (let i = 1; i <= 7; i++) {
                let X = $(`#value-${i}-${q}`).text().replaceAll(/[A-Za-z.]/g, '')
                // let X = $(`#value-${i}`).text()
                let Y = X.replaceAll(/[,]/g, '.')
                sum += Y > 0 ? Number(Y) : 0
            }
            $(`#sector-1-${q}`).text(formatRupiah(String(sum.toFixed(2)).replaceAll(/[.]/g, ','), 'Rp '))
            sum = sum - sum
        }
        sum = sum - sum
        for (let q = 1; q <= 16; q++) {
            for (let i = 14; i <= 15; i++) {
                let X = $(`#value-${i}-${q}`).text().replaceAll(/[A-Za-z.]/g, '')
                let Y = X.replaceAll(/[,]/g, '.')
                sum += Y > 0 ? Number(Y) : 0
            }

            $(`#sector-14-${q}`).text(formatRupiah(String(sum.toFixed(2)).replaceAll(/[.]/g, ','), 'Rp '))
            sum = sum - sum
        }
        sum = sum - sum
        for (let q = 1; q <= 16; q++) {
            for (let index of catArray) {
                let jumlah = calculateSector(`categories-${index}-${q}`).toFixed(2)
                let que = String(jumlah).replaceAll(/[.]/g, ',')
                $(`#categories-${index}-${q}`).text(formatRupiah(que, 'Rp '))
                $(`#categories-${index}-${q}`).addClass(`text-bold pdrb-total-${q}`)
            }
        }
        for (let q = 1; q <= 16; q++) {
            let pdrb = calculateSector(`pdrb-total-${q}`).toFixed(2)
            let nonmigas = simpleSum(`#value-10-${q}`) + simpleSum(`#value-15-${q}`)
            $(`#total-${q}`).text(formatRupiah(String(pdrb).replaceAll(/[.]/g, ','), 'Rp '))
            let pdrbNonmigas = (pdrb - nonmigas).toFixed(2)
            $(`#total-nonmigas-${q}`).text(formatRupiah(String(pdrbNonmigas).replaceAll(/[.]/g, ','), 'Rp '))
        }
    } else if (type === 'pengeluaran') {
        rowComponent = 14
        let sum = 0
        for (let q = 1; q <= 16; q++) {
            for (let i = 1; i <= 7; i++) {
                let X = $(`#value-${i}-${q}`).text().replaceAll(/[A-Za-z.]/g, '')
                let Y = X.replaceAll(/[,]/g, '.')
                sum += Y > 0 ? Number(Y) : 0
            }
            $(`#sector-1-${q}`).text(formatRupiah(String(sum.toFixed(2)).replaceAll(/[.]/g, ','), 'Rp '))
            $(`#sector-1-${q}`).addClass(`text-bold pdrb-total-${q}`)
            sum = sum - sum
        }
        sum = sum - sum
        for (let q = 1; q <= 16; q++) {
            for (let i = 10; i <= 11; i++) {
                let X = $(`#value-${i}-${q}`).text().replaceAll(/[A-Za-z.]/g, '')
                let Y = X.replaceAll(/[,]/g, '.')
                sum += Y > 0 ? Number(Y) : 0
            }

            $(`#sector-10-${q}`).text(formatRupiah(String(sum.toFixed(2)).replaceAll(/[.]/g, ','), 'Rp '))
            $(`#sector-10-${q}`).addClass(`text-bold pdrb-total-${q}`)
            sum = sum - sum
        }
        sum = sum - sum
        for (let q = 1; q <= 16; q++) {
            for (let i = 13; i <= 14; i++) {
                let X = $(`#value-${i}-${q}`).text().replaceAll(/[A-Za-z.]/g, '')
                let Y = X.replaceAll(/[,]/g, '.')
                sum += Y > 0 ? Number(Y) : 0
            }

            $(`#sector-13-${q}`).text(formatRupiah(String(sum.toFixed(2)).replaceAll(/[.]/g, ','), 'Rp '))
            $(`#sector-13-${q}`).addClass(`text-bold pdrb-total-${q}`)
            sum = sum - sum
        }
        sum = sum - sum
        for (let q = 1; q <= 16; q++) {
            let pdrb = calculateSector(`pdrb-total-${q}`).toFixed(2)
            $(`#total-${q}`).text(formatRupiah(String(pdrb).replaceAll(/[.]/g, ','), 'Rp '))
        }
    }
}

function simpleSum(atri) {
    let X = $(`${atri}`).text().replaceAll(/[A-Za-z.]/g, '')
    let Y = X.replaceAll(/[,]/g, '.')
    return Number(Y)
}

function distribusi(values, index) {
    let X = simpleSum(values)
    let Y = simpleSum(`#total-${index}`)
    let score = Y > 0 ? X / Y * 100 : 0
    return score > 0 ? score.toFixed(2) : 0
}

function getDist() {
    for (let q = 1; q <= 16; q++) {
        $(`.view-distribusi-${q}`).each(function () {
            let id = '#' + $(this).attr('id')
            let y = distribusi(id, q)
            $(this).text(y)
        })
        $(`#total-nonmigas-${q}`).text(distribusi(`#total-nonmigas-${q}`, q))
        $(`#total-${q}`).text(distribusi(`#total-${q}`, q))
    }
    $('.view-distribusi-totalKabkot').each(function () {
        let id = '#' + $(this).attr('id')
        let X = simpleSum(id)
        let Y = simpleSum('#totalKabkot-migas')
        let score = Y > 0 ? X / Y * 100 : 0
        $(this).text(score.toFixed(2))
    })
    let Y = simpleSum('#totalKabkot-migas')
    let nonmigas = simpleSum('#totalKabkot-nonmigas')
    let Kabkotnonmigas = nonmigas > 0 ? nonmigas / Y * 100 : 0
    $('#totalKabkot-nonmigas').text(Kabkotnonmigas)
    $('totalKabkot-migas').text('100')
    selisih('percentage')
}

function getIdx(adhb, adhk) {
    let result = adhb > 0 ? adhb / adhk * 100 : ''
    return result > 0 ? result.toFixed(2) : ''
}

function diskrepansi() {
    $('#rekon-view tbody td:first-child').each(function () {
        let X = Number($(this).closest('tr').find('td:nth-child(3)').text().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
        let Y = Number($(this).closest('tr').find('td:nth-child(2)').text().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
        let score = X > 0 ? (Y - X) / X * 100 : 0
        $(this).addClass('text-right')
        if ((score > 5) || (score < -5)) {
            $(this).css('background-color', '#DB3131')
            $(this).css('color', 'aliceblue')
        } else if ((score > 1 && score < 6) || (score < -1 && score > -6)) {
            $(this).css('background-color', '#E6ED18')
            $(this).css('color', 'black')
        }
        $(this).text(score.toFixed(2))
    })
    $('#head-purpose').text('Cek Diskrepansi')
}

function selisih(type) {
    $('#rekon-view tbody td:first-child').each(function () {
        if (type === 'percentage') {
            let X = Number($(this).closest('tr').find('td:nth-child(3)').text())
            let Y = Number($(this).closest('tr').find('td:nth-child(2)').text())
            let score = Y - X
            $(this).text(score.toFixed(2))
        } else {
            let X = Number($(this).closest('tr').find('td:nth-child(3)').text().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
            let Y = Number($(this).closest('tr').find('td:nth-child(2)').text().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
            let score = Y - X
            $(this).text(score.toFixed(2))
        }
        $(this).addClass('text-right')
        $(this).css('background-color', '')
        $(this).css('color', '')
    })
    $('#head-purpose').text('Selisih')
}

function getAdhb(data, type) {
    if (type === 'lapangan') {
        rowComponent = 55
    } else if (type === 'pengeluaran') {
        rowComponent = 14
    }
    $('#rekon-view tbody td:not(:first-child)').removeClass(function (index, className) {
        return (className.match(/(^|\s)view-\S+/g) || []).join(' ')
    })
    $('#rekon-view tbody td:not(:first-child)').addClass('view-adhb')
    for (let q = 1; q <= 16; q++) {
        for (let i = 1; i <= rowComponent; i++) {
            let X = data[`pdrb-${q}`][i - 1]['adhb']
            let Y = String(X).replaceAll(/[.]/g, ',')
            $(`#value-${i}-${q}`).text(Y)
        }
    }
    getSummarise(type)
    getTotalKabkot()
    diskrepansi()
}

function getAdhk(data, type) {
    if (type === 'lapangan') {
        rowComponent = 55
    } else if (type === 'pengeluaran') {
        rowComponent = 14
    }
    $('#rekon-view tbody td:not(:first-child)').removeClass(function (index, className) {
        return (className.match(/(^|\s)view-\S+/g) || []).join(' ')
    })
    $('#rekon-view tbody td:not(:first-child)').addClass('view-adhk')
    for (let q = 1; q <= 16; q++) {
        for (let i = 1; i <= rowComponent; i++) {
            let X = data[`pdrb-${q}`][i - 1]['adhk']
            let Y = String(X).replaceAll(/[.]/g, ',')
            $(`#value-${i}-${q}`).text(Y)
        }
    }
    getSummarise(type)
    getTotalKabkot()
    diskrepansi()
}

function getGrowth(data, before, type) {
    if (type === 'lapangan') {
        rowComponent = 55
    } else if (type === 'pengeluaran') {
        rowComponent = 14
    }
    $('tbody td:nth-child(n+2):nth-child(-n+6)').removeClass(function (index, className) {
        return (className.match(/(^|\s)view-\S+/g) || []).join(' ')
    })
    $('tbody td:nth-child(n+2):nth-child(-n+6)').addClass('view-pertumbuhan')
    let adhk_now = []
    let adhk_before = []
    let growth = []
    for (let q = 1; q <= 16; q++) {
        for (let i = 1; i <= rowComponent; i++) {
            let X = data[`pdrb-${q}`][i - 1]['adhb']
            let Y = String(X).replaceAll(/[.]/g, ',')
            $(`#value-${i}-${q}`).text(Y)
        }
    }
    getSummarise(type)
    getTotalKabkot()
    $('#rekon-view tbody td:not(:first-child)').each(function () {
        let X = $(this).text().replaceAll(/[A-Za-z.]/g, '')
        let Y = X.replaceAll(/[,]/g, '.')
        adhk_now.push(Number(Y))
    })
    for (let q = 1; q <= 16; q++) {
        for (let i = 1; i <= rowComponent; i++) {
            let X = before[`pdrb-${q}`][i - 1]['adhb']
            let Y = String(X).replaceAll(/[.]/g, ',')
            $(`#value-${i}-${q}`).text(Y)
        }
    }
    getSummarise(type)
    getTotalKabkot()
    $('#rekon-view tbody td:not(:first-child)').each(function () {
        let X = $(this).text().replaceAll(/[A-Za-z.]/g, '')
        let Y = X.replaceAll(/[,]/g, '.')
        adhk_before.push(Number(Y))
    })

    for (let i = 0; i < adhk_now.length; i++) {
        let score = adhk_before[i] > 0 ? (adhk_now[i] / adhk_before[i] * 100 - 100).toFixed(2) : ''
        growth.push(score)
    }
    $('#rekon-view tbody td:not(:first-child)').each(function (index) {
        $(this).text(growth[index])
    })
    selisih('percentage')
}

function getIndex(data, type) {
    if (type === 'lapangan') {
        rowComponent = 55
    } else if (type === 'pengeluaran') {
        rowComponent = 14
    }
    $('#rekon-view tbody td:not(:first-child)').removeClass(function (index, className) {
        return (className.match(/(^|\s)view-\S+/g) || []).join(' ')
    })
    $('#rekon-view tbody td:not(:first-child)').addClass('view-indeks')
    let idx_adhb = []
    let idx_adhk = []
    let idx = []
    for (let q = 1; q <= 16; q++) {
        for (let i = 1; i <= rowComponent; i++) {
            let X = data[`pdrb-${q}`][i - 1]['adhb']
            let Y = String(X).replaceAll(/[.]/g, ',')
            $(`#value-${i}-${q}`).text(Y)
        }
    }
    getSummarise(type)
    getTotalKabkot()
    $('#rekon-view tbody td:not(:first-child)').each(function () {
        let X = $(this).text().replaceAll(/[A-Za-z.]/g, '')
        let Y = X.replaceAll(/[,]/g, '.')
        idx_adhb.push(Number(Y))
    })
    for (let q = 1; q <= 16; q++) {
        for (let i = 1; i <= rowComponent; i++) {
            let X = data[`pdrb-${q}`][i - 1]['adhk']
            let Y = String(X).replaceAll(/[.]/g, ',')
            $(`#value-${i}-${q}`).text(Y)
        }
    }
    getSummarise(type)
    getTotalKabkot()
    $('#rekon-view tbody td:not(:first-child)').each(function () {
        let X = $(this).text().replaceAll(/[A-Za-z.]/g, '')
        let Y = X.replaceAll(/[,]/g, '.')
        idx_adhk.push(Number(Y))
    })
    for (let i = 0; i < idx_adhb.length; i++) {
        idx.push(getIdx(idx_adhb[i], idx_adhk[i]))
    }
    $('#rekon-view tbody td:not(:first-child)').each(function (index) {
        $(this).text(idx[index])
    })
    selisih('percentage')
    return (idx)
}

function getAntar(data, type) {
    getAdhb(data, type)
    let dividen = []
    $('.sum-of-kabkot').each(function () {
        let X = $(this).text().replaceAll(/[A-Za-z.]/g, '')
        let Y = X.replaceAll(/[,]/g, '.')
        dividen.push(Number(Y))
    })
    // console.log(dividen)
    $('#rekon-view tbody td:first-child').each(function () {
        $(this).addClass('d-none')
        $('#rekon-view thead th:first-child').addClass('d-none')
    })
    $('#rekon-view tbody td:not(:first-child)').each(function () {
        let X = $(this).text().replaceAll(/[A-Za-z.]/g, '')
        let Y = X.replaceAll(/[,]/g, '.')
        let rowIndex = $(this).closest('tr').index()
        let colIndex = $(this).closest('td').index()
        if (colIndex === 2) {
            $(this).addClass('d-none')
            $('#rekon-view thead th:nth-child(3)').addClass('d-none')
        }
        let score = Y > 0 ? Y / dividen[rowIndex] * 100 : 0
        $(this).text(score.toFixed(2))
    })
}

function showOff() {
    $('#rekon-view thead th').removeClass('d-none')
    $('#rekon-view tbody td').removeClass('d-none')
}

function getLaju(first, before) {
    $('#rekon-view tbody td:not(:first-child)').removeClass(function (index, className) {
        return (className.match(/(^|\s)view-\S+/g) || []).join(' ')
    })
    $('#rekon-view tbody td:not(:first-child)').addClass('view-laju')
    let growth = []
    for (let i = 0; i < first.length; i++) {
        let score = before[i] > 0 ? (first[i] / before[i] * 100 - 100).toFixed(2) : ''
        growth.push(score)
    }
    $('#rekon-view tbody td:not(:first-child)').each(function (index) {
        $(this).text(growth[index])
    })
    selisih('percentage')
}

function getTotalKabkot() {
    $('#rekon-view').each(function () {
        let table = $(this)
        let numRows = table.find('tr').length
        let numCols = table.find('tr:first-child td').length
        for (let row = 1; row <= numRows; row++) {
            let sum = 0
            for (let col = 4; col <= numCols; col++) {
                let cellValue = table.find('tr:nth-child(' + row + ') td:nth-child(' + col + ')').text()
                let X = cellValue.replaceAll(/[A-Za-z.]/g, '')
                let Y = X.replaceAll(/[,]/g, '.')
                if (!isNaN(Number(Y))) {
                    sum += Number(Y)
                }
            }
            table.find('tr:nth-child(' + row + ') td:nth-child(2)').text(formatRupiah(String(sum.toFixed(2)).replaceAll(/[.]/g, ','), 'Rp '))
        }
    });
}