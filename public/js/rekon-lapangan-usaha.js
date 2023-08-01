 //sum of each value in sector and category
 function calculateSector(sector) {
    let sum = 0;
    // let sector = sector.replaceAll(",","");
    $(`.${sector}`).each(function(index) {
        let X = $(this).val().replaceAll(/[A-Za-z.]/g, '');
        let Y = X.replaceAll(/[,]/g, '.')
        sum += Number(Y);
    });
    return sum;
}

$(document).ready(function () {
    // Your jQuery code goes here
    let cat = JSON.parse($("#my-cat").data('cat'))
    let catArray = cat.split(", ")
    let catB = "1,2,3,4,7,8,9,11"
    let catSpecific = catB.split(",")
    let catLast = catArray.filter(value => !catSpecific.includes(value))
    // console.log(catLast)
    let sum = 0

    //full-form last column sum adhb table
    let tableADHB = $('#adhb-table');
    let tbodyADHB = tableADHB.find('tbody');
    let trADHB = tbodyADHB.find('tr');

    trADHB.on('blur', 'td input', function (e) {
        let $currentRow = $(this).closest('tr')
        let $totalCol = $currentRow.find('td:last')
        let sum = 0
        $currentRow.find('input:not(:hidden):not(:disabled)').each(function () {
            let X = $(this).val().replaceAll(/[A-Za-z.]/g, '')
            let Y = X.replaceAll(/[,]/g, '.')
       
            sum +=  Number(Y) 
        })
        let sumRp = String(sum.toFixed(2)).replaceAll(/[.]/g, ',')
        $totalCol.find('input').val(formatRupiah(sumRp, ''))

        for (let index of catSpecific) {
            let darksum = 0
            let lightsum = 0

            let row = $(`#adhb_${index}_T`).closest('tr')
            let subsection = $(`#adhb_1_${index}_T`).closest('tr')

            row.find('td input:not(#adhb_' + index + '_T):not(#adhb_' + index + '_Y)').each(function () {
                if (!$(this).hasClass(`adhb_${index}_T`)) {
                    let X = $(this).val().replaceAll(/[A-Za-z.]/g, '');
                    let Y = X.replaceAll(/[,]/g, '.');
                    darksum += Number(Y);
                }
            })

            subsection.find('td input:not(#adhb_1_' + index + '_T):not(#adhb_1_' + index + '_Y)').each(function () {
                if (!$(this).hasClass(`adhb_${index}_T`)) {
                    let X = $(this).val().replaceAll(/[A-Za-z.]/g, '');
                    let Y = X.replaceAll(/[,]/g, '.');
                    lightsum += Number(Y);
                }
            })

            let lightsumRp = String(lightsum.toFixed(2)).replaceAll(/[.]/g, ',');
            let darksumRp = String(darksum.toFixed(2)).replaceAll(/[.]/g, ',');
            $(`#adhb_1_${index}_T`).val(formatRupiah(lightsumRp, ''))
            $(`#adhb_${index}_T`).val(formatRupiah(darksumRp, ''))
        }

        let numRows = trADHB.length - 2
        for (let col = 1; col < $('#adhb-table tr:first-child td').length; col++) {
            let sum = 0
            let pdrb = 0
            let nonmigas = 0
            for (let row = 0; row < numRows; row++) {
                let cell = $('#adhb-table tr').eq(row + 1).find('td').eq(col)
                if (cell.hasClass('categories')) {
                    let X = cell.find(`input[id^='adhb']`).val().replaceAll(/[A-Za-z.]/g, '')
                    let Y = X.replaceAll(/[,]/g, '.')
                    sum += Number(Y)
                }
                cell.find('input').each(function () {
                    let inputId = $(this).attr('id');
                    if (inputId && (inputId.includes('adhb_10_4_2_') || inputId.includes('adhb_15_8_3_'))) {
                        let X = $(this).val().replaceAll(/[A-Za-z.]/g, '');
                        let Y = X.replaceAll(/[,]/g, '.');
                        nonmigas += Number(Y);
                    }
                });
            }
            let pdrbs = sum
            let PdrbNonmigas = pdrbs - nonmigas
            let sumPDRB = String(pdrbs.toFixed(2)).replaceAll(/[.]/g, ',')
            let sumPDRBnm = String(PdrbNonmigas.toFixed(2)).replaceAll(/[.]/g, ',')
            let totalnm = $('#adhb-table tr').last().prev().find('td').eq(col)
            let totalCell = $('#adhb-table tr').last().find('td').eq(col)
            totalnm.text(formatRupiah(sumPDRBnm, ''))
            totalCell.text(formatRupiah(sumPDRB, ''))
        }
    });

    //full-form last column sum adhk table
    let tableADHK = $('#adhk-table');
    let tbodyADHK = tableADHK.find('tbody');
    let trADHK = tbodyADHK.find('tr');

    trADHK.on('blur', 'td input', function (e) {
        let $currentRow = $(this).closest('tr')
        let $totalCol = $currentRow.find('td:last')
        let sum = 0
        $currentRow.find('input:not(:hidden):not(:disabled)').each(function () {
            let X = $(this).val().replaceAll(/[A-Za-z.]/g, '')
            let Y = X.replaceAll(/[,]/g, '.')
       
            sum +=  Number(Y) 
        })
        let sumRp = String(sum.toFixed(2)).replaceAll(/[.]/g, ',')
        $totalCol.find('input').val(formatRupiah(sumRp, ''))

        for (let index of catSpecific) {
            let darksum = 0
            let lightsum = 0

            let row = $(`#adhk_${index}_T`).closest('tr')
            let subsection = $(`#adhk_1_${index}_T`).closest('tr')

            row.find('td input:not(#adhk_' + index + '_T):not(#adhk_' + index + '_Y)').each(function () {
                if (!$(this).hasClass(`adhk_${index}_T`)) {
                    let X = $(this).val().replaceAll(/[A-Za-z.]/g, '');
                    let Y = X.replaceAll(/[,]/g, '.');
                    darksum += Number(Y);
                }
            })

            subsection.find('td input:not(#adhk_1_' + index + '_T):not(#adhk_1_' + index + '_Y)').each(function () {
                if (!$(this).hasClass(`adhk_${index}_T`)) {
                    let X = $(this).val().replaceAll(/[A-Za-z.]/g, '');
                    let Y = X.replaceAll(/[,]/g, '.');
                    lightsum += Number(Y);
                }
            })

            let lightsumRp = String(lightsum.toFixed(2)).replaceAll(/[.]/g, ',');
            let darksumRp = String(darksum.toFixed(2)).replaceAll(/[.]/g, ',');
            $(`#adhk_1_${index}_T`).val(formatRupiah(lightsumRp, ''))
            $(`#adhk_${index}_T`).val(formatRupiah(darksumRp, ''))
        }

        let numRows = trADHK.length - 2
        for (let col = 1; col < $('#adhk-table tr:first-child td').length; col++) {
            let sum = 0
            let pdrb = 0
            let nonmigas = 0
            for (let row = 0; row < numRows; row++) {
                let cell = $('#adhk-table tr').eq(row + 1).find('td').eq(col)
                if (cell.hasClass('categories')) {
                    let X = cell.find(`input[id^='adhk']`).val().replaceAll(/[A-Za-z.]/g, '')
                    let Y = X.replaceAll(/[,]/g, '.')
                    sum += Number(Y)
                }
                cell.find('input').each(function () {
                    let inputId = $(this).attr('id');
                    if (inputId && (inputId.includes('adhk_10_4_2_') || inputId.includes('adhk_15_8_3_'))) {
                        let X = $(this).val().replaceAll(/[A-Za-z.]/g, '');
                        let Y = X.replaceAll(/[,]/g, '.');
                        nonmigas += Number(Y);
                    }
                });
            }
            let pdrbs = sum + pdrb
            let PdrbNonmigas = pdrbs - nonmigas
            let sumPDRB = String(pdrbs.toFixed(2)).replaceAll(/[.]/g, ',')
            let sumPDRBnm = String(PdrbNonmigas.toFixed(2)).replaceAll(/[.]/g, ',')
            let totalnm = $('#adhk-table tr').last().prev().find('td').eq(col)
            let totalCell = $('#adhk-table tr').last().find('td').eq(col)
            totalnm.text(formatRupiah(sumPDRBnm, ''))
            totalCell.text(formatRupiah(sumPDRB, ''))
        }
    });


    //single and full, sum for every category and sector
    for (let i = 1; i < 5; i++) {
        //adhb table
        $(`.adhb-sector-Q${i}-1`).keyup(function (e) {
            let jumlah = calculateSector(`adhb-sector-Q${i}-1`).toFixed(2);
            let que = String(jumlah).replaceAll(/[.]/g, ',');
            $(`#adhb_1_1_Q${i}`).val(formatRupiah(que, ''));
        });
        $(`.adhb-sector-Q${i}-8`).keyup(function (e) {
            let jumlah = calculateSector(`adhb-sector-Q${i}-8`).toFixed(2);
            let que = String(jumlah).replaceAll(/[.]/g, ',');
            $(`#adhb_8_3_Q${i}`).val(formatRupiah(que, ''))
        });
        //adhk table
        $(`.adhk-sector-Q${i}-1`).keyup(function (e) {
            let jumlah = calculateSector(`adhk-sector-Q${i}-1`).toFixed(2);
            let que = String(jumlah).replaceAll(/[.]/g, ',');
            $(`#adhk_1_1_Q${i}`).val(formatRupiah(que, ''));
        });
        $(`.adhk-sector-Q${i}-8`).keyup(function (e) {
            let jumlah = calculateSector(`adhk-sector-Q${i}-8`).toFixed(2);
            let que = String(jumlah).replaceAll(/[.]/g, ',');
            $(`#adhk_8_3_Q${i}`).val(formatRupiah(que, ''))
        });

        for (let j = 1; j < 18; j++) {
            //adhb table
            $(`.adhb-category-Q${i}-${j}`).keyup(function (e) {
                let jumlah = calculateSector(`adhb-category-Q${i}-${j}`).toFixed(2);
                let que = String(jumlah).replaceAll(/[.]/g, ',');
                $(`#adhb_${catArray[j - 1]}_Q${i}`).val(formatRupiah(que, ''))
            });
            $(`.adhb-category-${j}`).keyup(function (e) {
                let jumlah = calculateSector(`adhb-category-${j}`).toFixed(2);
                let que = String(jumlah).replaceAll(/[.]/g, ',');
                $(`#adhb_${catArray[j - 1]}`).val(formatRupiah(que, ''))
            });

            //adhk table
            $(`.adhk-category-Q${i}-${j}`).keyup(function (e) {
                let jumlah = calculateSector(`adhk-category-Q${i}-${j}`).toFixed(2);
                let que = String(jumlah).replaceAll(/[.]/g, ',');
                $(`#adhk_${catArray[j - 1]}_Q${i}`).val(formatRupiah(que, ''))
            });
            $(`.adhk-category-${j}`).keyup(function (e) {
                let jumlah = calculateSector(`adhk-category-${j}`).toFixed(2);
                let que = String(jumlah).replaceAll(/[.]/g, ',');
                $(`#adhk_${catArray[j - 1]}`).val(formatRupiah(que, ''))
            });
        }
        for (let j = 1; j < 54; j++) {
            $(`.adhb-sector-Q${i}-${j}`).keyup(function (e) {
                $(this).val(formatRupiah($(this).val(), ''))
                var charCode = (e.which) ? e.which : event.keyCode
                if (String.fromCharCode(charCode).match(/[^0-9.,]/g))
                    return false;
            })
            $(`.adhk-sector-Q${i}-${j}`).keyup(function (e) {
                $(this).val(formatRupiah($(this).val(), ''))
                var charCode = (e.which) ? e.which : event.keyCode
                if (String.fromCharCode(charCode).match(/[^0-9.,]/g))
                    return false;
            })
        }
    }

    $('#adhb-table').on('paste', 'input', function (e) {
        const $this = $(this);
        // let panjang_ndas = $('thead').children().length
        $.each(e.originalEvent.clipboardData.items, function (i, v) {
            if (v.type === 'text/plain') {
                v.getAsString(function (text) {
                    var x = $this.closest('td').index(),
                        y = $this.closest('tr').index() + 1,
                        obj = {};
                    text = text.trim('\r\n');
                    $.each(text.split('\r\n'), function (i2, v2) {
                        $.each(v2.split('\t'), function (i3, v3) {
                            var row = y + i2, col = x + i3;
                            obj['cell-' + row + '-' + col] = v3
                            $this.closest('table').find('tr:eq(' + row + ') td:eq(' + col + ') input:not(:hidden)').val(formatRupiah(v3, ''));
                        });
                    });

                });
            }
        });
        return false;
    });    

    $('#adhk-table').on('paste', 'input', function (e) {
        const $this = $(this);
        // let panjang_ndas = $('thead').children().length
        $.each(e.originalEvent.clipboardData.items, function (i, v) {
            if (v.type === 'text/plain') {
                v.getAsString(function (text) {
                    var x = $this.closest('td').index(),
                        y = $this.closest('tr').index() + 1,
                        obj = {};
                    text = text.trim('\r\n');
                    $.each(text.split('\r\n'), function (i2, v2) {
                        $.each(v2.split('\t'), function (i3, v3) {
                            var row = y + i2, col = x + i3;
                            obj['cell-' + row + '-' + col] = v3
                            $this.closest('table').find('tr:eq(' + row + ') td:eq(' + col + ') input:not(:hidden)').val(formatRupiah(v3, ''));
                        });
                    });

                });
            }
        });
        return false;
    });
})