// import { formatRupiah } from './pdrb.js'

function formatRupiah(angka, prefix) {
    var number_string = String(angka).replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}

//change
$(document).ready(function() {
    let tbody = $('#rekon-view').find('tbody')
    $('#nav-distribusi').on('click', function(){
        $('tbody td:nth-child(2)').removeClass(function(index, className) {
            return (className.match(/(^|\s)view-\S+/g) || []).join(' ')
        })
        getFilter()
        $('tbody tr:not(:last-child):not(:nth-last-child(2)) td:nth-child(2)').addClass('view-distribusi')
        getDist()
    })

    $('#nav-adhb').on('click', function(){
        $('tbody td:nth-child(2)').removeClass(function(index, className) {
            return (className.match(/(^|\s)view-\S+/g) || []).join(' ')
        })
        $('tbody td:nth-child(2)').addClass('view-adhb')
        getFilter()
    })

    $('#nav-adhk').on('click', function(){
        $('tbody td:nth-child(2)').removeClass(function(index, className) {
            return (className.match(/(^|\s)view-\S+/g) || []).join(' ')
        })
        $('tbody td:nth-child(2)').addClass('view-adhk')
        getFilter()
        const period_id = $('#period').val()
        $.ajax({
            type: 'GET',
            url: '/getData/' + period_id,
            dataType: 'json',
            success: function (data) {
                for (let i = 0; i < data.length; i++) {
                    $(`#value-${i+1}`).text(data[i].adhk)
                }
                getSummarise()
            }  
        })
    })
    
    //belum tau gimana
    // $('#nav-pertumbuhan').on('click', function(){
    //     $('tbody td:nth-child(2)').removeClass(function(index, className) {
    //         return (className.match(/(^|\s)view-\S+/g) || []).join(' ')
    //     })
    //     $('tbody td:nth-child(2)').addClass('view-pertumbuhan')
    // })

    //indeks implisit adhb/adhk
    $('#nav-indeks').on('click', function(){
        $('tbody td:nth-child(2)').removeClass(function(index, className) {
            return (className.match(/(^|\s)view-\S+/g) || []).join(' ')
        })
        $('tbody td:nth-child(2)').addClass('view-indeks')
        const period_id = $('#period').val()
        $.ajax({
            type: 'GET',
            url: '/getData/' + period_id,
            dataType: 'json',
            success: function (data) {
                for (let i = 0; i < data.length; i++) {
                    $(`#value-${i+1}`).text(data[i].adhb)
                }
                getSummarise()
                let adhb = []
                $('tbody td:not(:first-child)').each(function() {
                    let X = $(this).text().replaceAll(/[A-Za-z.]/g,'')
                    let Y = X.replaceAll(/[,]/g, '.')
                    adhb.push(Number(Y))
                })
                for (let i = 0; i < data.length; i++) {
                    $(`#value-${i+1}`).text(data[i].adhk)
                }
                getSummarise()
                let adhk = []
                $('tbody td:not(:first-child)').each(function() {
                    let X = $(this).text().replaceAll(/[A-Za-z.]/g,'')
                    let Y = X.replaceAll(/[,]/g, '.')
                    adhk.push(Number(Y))
                })
                let idx = []
                for (let i = 0; i < adhb.length; i++){
                    idx.push(getIdx(adhb[i], adhk[i]))
                }
                $('tbody td:not(:first-child)').each(function(index) {
                    $(this).text(idx[index])
                })
            }  
        })
    })
})

//get localized storage data
$(document).ready(function(){
    getFilter()
})
function simpleSum(atri) {
    let X = $(`${atri}`).text().replaceAll(/[A-Za-z.]/g,'')
    let Y = X.replaceAll(/[,]/g, '.')
    return Number(Y)
}

function distribusi(values){
    let X = simpleSum(values)
    let Y = simpleSum('#total')
    let score = X > 0 ? X/Y * 100 : 0 
    return score > 0 ? score.toFixed(2) : 0
}

function getDist(){
    $('.view-distribusi').each(function(){
        let id = '#' + $(this).attr('id')
        let y = distribusi(id)
        $(this).text(y)
    })
    $('#total-nonmigas').text(distribusi('#total-nonmigas'))
    $('#total').text(distribusi('#total'))
}

function getIdx(adhb, adhk) {
    let result = adhb > 0 ? adhb/adhk * 100 : ''
    return result > 0 ? result.toFixed(2) : ''
}
function getFilter() {
    const dataStored = localStorage.getItem('dataStored')
    if (dataStored){
        let data = JSON.parse(dataStored)
        for (let i = 0; i < data.length; i++) {
                $(`#value-${i+1}`).text(data[i].adhb)
            }
        getSummarise()
        $('#view-body').removeClass('d-none')
    }
}
//summarise
function getSummarise(){
    let sum = 0
    $('.values').each(function () {
        $(this).text(formatRupiah($(this).text(), 'Rp '))
    })
    for (let i = 1; i <= 7; i++) {
        let X = $(`#value-${i}`).text().replaceAll(/[A-Za-z.]/g,'')
        // let X = $(`#value-${i}`).text()
        let Y = X.replaceAll(/[,]/g, '.')
        sum += Y > 0 ? Number(Y) : 0
    }
    $('#sector-1').text(formatRupiah(String(sum).replaceAll(/[.]/g, ','), 'Rp '))
    sum = sum - sum
    for (let i = 14; i <= 15; i++) {
        let X = $(`#value-${i}`).text().replaceAll(/[A-Za-z.]/g,'')
        let Y = X.replaceAll(/[,]/g, '.')
        sum += Y > 0 ? Number(Y) : 0
    }
    $('#sector-14').text(formatRupiah(String(sum).replaceAll(/[.]/g, ','), 'Rp '))
    sum = sum - sum
    for (let index of catArray){    
        let jumlah = calculateSector(`categories-${index}`)
        let que = String(jumlah).replaceAll(/[.]/g, ',')
        $(`#categories-${index}`).text(formatRupiah(que, 'Rp '))
        $(`#categories-${index}`).addClass('text-bold pdrb-total')
    }
    let pdrb = calculateSector('pdrb-total')
    let nonmigas = simpleSum('#value-10') + simpleSum('#value-15')
    $('#total').text(formatRupiah(String(pdrb), 'Rp '))
    
    let pdrbNonmigas = pdrb - nonmigas
    $('#total-nonmigas').text(formatRupiah(String(pdrbNonmigas), 'Rp '))
}

//get the data
$(document).ready(function() {
    $('#showData').click(function(e){
        e.preventDefault()
        const period_id = $('#period').val()
        $.ajax({
            beforeSend: function(){
              $('.loader').removeClass('d-none')  
            },
            complete: function() {
                setTimeout(function() {
                    $('.loader').addClass('d-none')
                    $('#view-body').removeClass('d-none')
                }, 1000)
            },
            type: 'GET',
            url: '/getData/' + period_id,
            dataType: 'json',
            success: function (data) {
                for (let i = 0; i < data.length; i++) {
                    $(`#value-${i+1}`).text(data[i].adhb)
                }
                getSummarise()
                localStorage.setItem('dataStored', JSON.stringify(data))
            }  
        })
    })

    $('#refresh').click(function(){
        $('#view-body').addClass('d-none')
        localStorage.clear()
    })
})