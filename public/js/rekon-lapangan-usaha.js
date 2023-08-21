//sum of each value in sector and category
function calculateSector(sector) {
    let sum = 0;
    // let sector = sector.replaceAll(",","");
    $(`.${sector}`).each(function (index) {
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

    let price_list = ['adhb', 'adhk']
    $.each(price_list, function (index, price_base) {
        let table = $('#' + price_base + '-table');
        let tbody = table.find('tbody');
        let tr = tbody.find('tr');
        let rows = tr.length - 2

        tr.on('blur', 'td input', function (e) {
            for (let row = 0; row < rows; row++) {
                let rowSum = 0
                for (let col = 1; col < $('#' + price_base + '-table tr:first-child td').length; col++) {
                    if (col != 5) {
                        let cell = $('#' + price_base + '-table tr').eq(row + 1).find('td').eq(col)
                        let value = Number(cell.find(`input[id^='` + price_base + `']`).val().replaceAll(/[A-Za-z.]/g, '').replaceAll(/[,]/g, '.'))
                        if (price_base == 'adhb') {
                        }
                        rowSum += value
                    } else {
                        let cell = $('#' + price_base + '-table tr').eq(row + 1).find('td').eq(col)
                        let sumText = String(rowSum.toFixed(9)).replaceAll(/[.]/g, ',')
                        cell.find(`input[id^='` + price_base + `']`).val(formatRupiah(sumText, ''))
                    }
                }
            }

            let numRows = tr.length - 2
            for (let col = 1; col < $('#' + price_base + '-table tr:first-child td').length; col++) {
                let sum = 0
                let pdrb = 0
                let nonmigas = 0
                for (let row = 0; row < numRows; row++) {
                    let cell = $('#' + price_base + '-table tr').eq(row + 1).find('td').eq(col)
                    if (cell.hasClass('categories')) {
                        let X = cell.find(`input[id^='${price_base}']`).val().replaceAll(/[A-Za-z.]/g, '')
                        let Y = X.replaceAll(/[,]/g, '.')
                        sum += Number(Y)
                    }
                    cell.find('input').each(function () {
                        let inputId = $(this).attr('id');
                        if (inputId && (inputId.includes(price_base + '_10_4_2_') || inputId.includes(price_base + '_15_8_3_'))) {
                            let X = $(this).val().replaceAll(/[A-Za-z.]/g, '');
                            let Y = X.replaceAll(/[,]/g, '.');
                            nonmigas += Number(Y);
                        }
                    });
                }
                let pdrbs = sum + pdrb
                let PdrbNonmigas = pdrbs - nonmigas
                let sumPDRB = String(pdrbs.toFixed(9)).replaceAll(/[.]/g, ',')
                let sumPDRBnm = String(PdrbNonmigas.toFixed(9)).replaceAll(/[.]/g, ',')
                let totalnm = $('#' + price_base + '-table tr').last().prev().find('td').eq(col)
                let totalCell = $('#' + price_base + '-table tr').last().find('td').eq(col)
                totalnm.text(formatRupiah(sumPDRBnm, ''))
                totalCell.text(formatRupiah(sumPDRB, ''))
            }
        })

        //single and full, sum for every category and sector
        for (let i = 1; i < 5; i++) {
            //adhb table
            $(`.` + price_base + `-sector-Q${i}-1`).keyup(function (e) {
                let jumlah = calculateSector(price_base + `-sector-Q${i}-1`).toFixed(9);
                let que = String(jumlah).replaceAll(/[.]/g, ',');
                $(`#` + price_base + `_1_1_Q${i}`).val(formatRupiah(que, ''));
            });
            $(`.` + price_base + `-sector-Q${i}-8`).keyup(function (e) {
                let jumlah = calculateSector(price_base + `-sector-Q${i}-8`).toFixed(9);
                let que = String(jumlah).replaceAll(/[.]/g, ',');
                $(`#` + price_base + `_8_3_Q${i}`).val(formatRupiah(que, ''))
            });

            for (let j = 1; j < 18; j++) {
                //adhb table
                $(`.` + price_base + `-category-Q${i}-${j}`).keyup(function (e) {
                    let jumlah = calculateSector(price_base + `-category-Q${i}-${j}`).toFixed(9);
                    let que = String(jumlah).replaceAll(/[.]/g, ',');
                    $(`#` + price_base + `_${catArray[j - 1]}_Q${i}`).val(formatRupiah(que, ''))
                });
                $(`.` + price_base + `-category-${j}`).keyup(function (e) {
                    let jumlah = calculateSector(price_base + `-category-${j}`).toFixed(9);
                    let que = String(jumlah).replaceAll(/[.]/g, ',');
                    $(`#` + price_base + `_${catArray[j - 1]}`).val(formatRupiah(que, ''))
                });

            }
            //change input value into formated accounting input
            for (let j = 1; j < 54; j++) {
                $(`.` + price_base + `-sector-Q${i}-${j}`).keyup(function (e) {
                    $(this).val(formatRupiah($(this).val(), ''))
                    var charCode = (e.which) ? e.which : event.keyCode
                    if (String.fromCharCode(charCode).match(/[^0-9.,]/g))
                        return false;
                })
            }
        }

        $('#' + price_base + '-table').on('paste', 'input', function (e) {
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
})