function getSummarise() {
    let sum = 0
    $('.values').each(function () {
        $(this).text(formatRupiah($(this).text(), 'Rp '))
    })
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
}

function simpleSum(atri) {
    let X = $(`${atri}`).text().replaceAll(/[A-Za-z.]/g, '')
    let Y = X.replaceAll(/[,]/g, '.')
    return Number(Y)
}

function distribusi(values, index) {
    let X = simpleSum(values)
    let Y = simpleSum(`#total-${index}`)
    let score = X > 0 ? X / Y * 100 : 0
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
        let score = X > 0 ? X / Y * 100 : 0
        $(this).text(score.toFixed(2))
    })
    let nonmigas = simpleSum('#totalKabkot-nonmigas')
    let Kabkotnonmigas = nonmigas > 0 ? nonmigas / Y * 100 : 0
    $('#totalKabkot-nonmigas').text(Kabkotnonmigas)
    $('totalKabkot-migas').text('100')
}

function getIdx(adhb, adhk) {
    let result = adhb > 0 ? adhb / adhk * 100 : ''
    return result > 0 ? result.toFixed(2) : ''
}

function getAdhb(data) {
    $('#rekon-view tbody td').removeClass(function (index, className) {
        return (className.match(/(^|\s)view-\S+/g) || []).join(' ')
    })
    $('#rekon-view tbody td').addClass('view-adhb')
    for (let q = 1; q <= 16; q++) {
        for (let i = 1; i <= 55; i++) {
            let X = data[`pdrb-${q}`][i - 1]['adhb']
            let Y = String(X).replaceAll(/[.]/g, ',')
            $(`#value-${i}-${q}`).text(Y)
        }
    }
    getSummarise()
    getTotalKabkot()
}

function getAdhk(data) {
    $('#rekon-view tbody td').removeClass(function (index, className) {
        return (className.match(/(^|\s)view-\S+/g) || []).join(' ')
    })
    $('#rekon-view tbody td').addClass('view-adhk')
    for (let q = 1; q <= 16; q++) {
        for (let i = 1; i <= 55; i++) {
            let X = data[`pdrb-${q}`][i - 1]['adhk']
            let Y = String(X).replaceAll(/[.]/g, ',')
            $(`#value-${i}-${q}`).text(Y)
        }
    }
    getSummarise()
    getTotalKabkot()
}

// function getGrowth() {
//     $('tbody td:nth-child(n+2):nth-child(-n+6)').removeClass(function (index, className) {
//         return (className.match(/(^|\s)view-\S+/g) || []).join(' ')
//     })
//     $('tbody td:nth-child(n+2):nth-child(-n+6)').addClass('view-pertumbuhan')
//     let idx_adhk = []
//     let growth = []
//     for (let q = 1; q <= 16; q++) {
//         for (let i = 1; i <= 55; i++) {
//             $(`#value-${i}-${q}`).text(adhk_data[`pdrb-${q}`][i - 1])
//         }
//     }
//     getSummarise()
//     $('tbody td:not(:first-child)').each(function () {
//         let X = $(this).text().replaceAll(/[A-Za-z.]/g, '')
//         let Y = X.replaceAll(/[,]/g, '.')
//         idx_adhk.push(Number(Y))
//     })
//     for (let i = 0; i < idx_adhk.length; i++) {
//         if (i % 5 != 0 && i > 0) {
//             let score = idx_adhk[i - 1] > 0 ? (idx_adhk[i] / idx_adhk[i - 1] * 100 - 100).toFixed(2) : ''
//             growth.push(score)
//         } else {
//             score = '-'
//             growth.push(score)
//         }
//     }
//     $('tbody td:not(:first-child)').each(function (index) {
//         $(this).text(growth[index])
//     })
// }

function getIndex(data) {
    $('#rekon-view tbody td').removeClass(function (index, className) {
        return (className.match(/(^|\s)view-\S+/g) || []).join(' ')
    })
    $('#rekon-view tbody td').addClass('view-indeks')
    let idx_adhb = []
    let idx_adhk = []
    let idx = []
    for (let q = 1; q <= 16; q++) {
        for (let i = 1; i <= 55; i++) {
            let X = data[`pdrb-${q}`][i - 1]['adhb']
            let Y = String(X).replaceAll(/[.]/g, ',')
            $(`#value-${i}-${q}`).text(Y)
        }
    }
    getSummarise()
    $('#rekon-view tbody td').each(function () {
        let X = $(this).text().replaceAll(/[A-Za-z.]/g, '')
        let Y = X.replaceAll(/[,]/g, '.')
        idx_adhb.push(Number(Y))
    })
    for (let q = 1; q <= 16; q++) {
        for (let i = 1; i <= 55; i++) {
            let X = data[`pdrb-${q}`][i - 1]['adhk']
            let Y = String(X).replaceAll(/[.]/g, ',')
            $(`#value-${i}-${q}`).text(Y)
        }
    }
    getSummarise()
    $('#rekon-view tbody td').each(function () {
        let X = $(this).text().replaceAll(/[A-Za-z.]/g, '')
        let Y = X.replaceAll(/[,]/g, '.')
        idx_adhk.push(Number(Y))
    })
    for (let i = 0; i < idx_adhb.length; i++) {
        idx.push(getIdx(idx_adhb[i], idx_adhk[i]))
    }
    $('#rekon-view tbody td').each(function (index) {
        $(this).text(idx[index])
    })
    return (idx)
}

function getAntar(data) {
    getAdhb(data)
    let dividen = []
    $('.sum-of-kabkot').each(function () {
        let X = $(this).text().replaceAll(/[A-Za-z.]/g, '')
        let Y = X.replaceAll(/[,]/g, '.')
        dividen.push(Number(Y))
    })
    // console.log(dividen)
    $('#rekon-view tbody td:not(:first-child)').each(function () {
        let X = $(this).text().replaceAll(/[A-Za-z.]/g, '')
        let Y = X.replaceAll(/[,]/g, '.')
        let rowIndex = $(this).closest('tr').index()
        let colIndex = $(this).closest('td').index()
        if (colIndex === 2){
            $(this).addClass('d-none')
            $('#rekon-view thead th:nth-child(3)').addClass('d-none')
        }
        let score = Y > 0 ? Y / dividen[rowIndex] * 100: 0
        $(this).text(score.toFixed(2))
    })
}

function showOff(){
    $('#rekon-view thead th').removeClass('d-none')
    $('#rekon-view tbody td').removeClass('d-none')
}

// function getLaju(laju) {
//     $('tbody td:nth-child(n+2):nth-child(-n+6)').removeClass(function (index, className) {
//         return (className.match(/(^|\s)view-\S+/g) || []).join(' ')
//     })
//     $('tbody td:nth-child(n+2):nth-child(-n+6)').addClass('view-laju')
//     let growth = []
//     for (let i = 0; i < laju.length; i++) {
//         if (i % 5 != 0 && i > 0) {
//             let score = laju[i - 1] > 0 ? (laju[i] / laju[i - 1] * 100 - 100).toFixed(2) : ''
//             growth.push(score)
//         } else {
//             score = '-'
//             growth.push(score)
//         }
//     }
//     $('tbody td:not(:first-child)').each(function (index) {
//         $(this).text(growth[index])
//     })
// }

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