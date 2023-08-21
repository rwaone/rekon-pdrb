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
    let price_list = ['adhb', 'adhk']
    $.each(price_list, function (index, price_base) {
        //full-form last column sum
        let table = $('#' + price_base + '-table');
        let tbody = table.find('tbody');
        let tr = tbody.find('tr');
        tr.on('blur', 'td input', function (e) {
            let rows = tr.length - 1
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

            let numRows = tr.length - 1
            for (let col = 1; col < $('#' + price_base + '-table tr:first-child td').length; col++) {
                let sum = 0
                for (let row = 0; row < numRows; row++) {
                    let cell = $('#' + price_base + '-table tr').eq(row + 1).find('td').eq(col)
                    if (cell.hasClass('sectors')) {
                        let X = cell.find(`input[id^='` + price_base + `']`).val().replaceAll(/[A-Za-z.]/g, '')
                        let Y = X.replaceAll(/[,]/g, '.')
                        sum += Number(Y)
                    }
                }
                let pdrbs = sum.toFixed(9)
                let sumPDRB = String(pdrbs).replaceAll(/[.]/g, ',')
                let totalCell = $('#' + price_base + '-table tr').last().find('td').eq(col)
                totalCell.text(formatRupiah(sumPDRB, ''))
            }
        });

        //single and full, sum for every category and sector
        for (let i = 1; i <= 4; i++) {
            $(`.` + price_base + `-sector-Q${i}-49`).keyup(function (e) {
                let jumlah = calculateSector(price_base + `-sector-Q${i}-49`).toFixed(9);
                let que = String(jumlah).replaceAll(/[.]/g, ',');
                $(`#` + price_base + `_1_X_Q${i}`).val(formatRupiah(que, '` + price_base + `'));
            });
            $(`.` + price_base + `-sector-Q${i}-52`).keyup(function (e) {
                let jumlah = calculateSector(price_base + `-sector-Q${i}-52`).toFixed(9);
                let que = String(jumlah).replaceAll(/[.]/g, ',');
                $(`#` + price_base + `_4_X_Q${i}`).val(formatRupiah(que, '` + price_base + `'))
            });
            $(`.` + price_base + `-sector-Q${i}-54`).keyup(function (e) {
                let X = $(`#` + price_base + `_a_6_X_Q${i}`).val().replaceAll(/[A-Za-z.]/g, '')
                let I = $(`#` + price_base + `_b_6_X_Q${i}`).val().replaceAll(/[A-Za-z.]/g, '')
                let XM = X.replaceAll(/[,]/g, '.')
                let IM = I.replaceAll(/[,]/g, '.')
                let sumXI = Number(XM) - Number(IM)
                let valueXI = String(sumXI.toFixed(9)).replaceAll(/[.]/g, ',')
                $(`#` + price_base + `_6_X_Q${i}`).val(formatRupiah(valueXI, ''))
            });

            for (let j = 49; j <= 54; j++) {
                $(`.` + price_base + `-sector-Q${i}-${j}`).keyup(function (e) {
                    $(this).val(formatRupiah($(this).val(), '` + price_base + `'))
                    var charCode = (e.which) ? e.which : event.keyCode
                    if (String.fromCharCode(charCode).match(/[^0-9.,]/g))
                        return false;
                })
                $(`.` + price_base + `-sector-${j}`).keyup(function (e) {
                    $(this).val(formatRupiah($(this).val(), '` + price_base + `'))
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
                                $this.closest('table').find('tr:eq(' + row + ') td:eq(' + col + ') input:not(:hidden)').val(formatRupiah(v3, '` + price_base + `'));
                            });
                        });

                    });
                }
            });
            return false;
        });
    })
})