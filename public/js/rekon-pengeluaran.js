$(document).ready(function () {
    // Your jQuery code goes here
    let cat = JSON.parse($("#my-cat").data('cat'))
    let catArray = cat.split(", ")
    let catB = "A,B,C,D,G,H,I,K"
    let catSpecific = catB.split(",")
    let catLast = catArray.filter(value => !catSpecific.includes(value))
    // console.log(catLast)
    let sum = 0

    //full-form last column sum
    let table = $('#rekonsiliasi-table-pengeluaran');
    let tbody = table.find('tbody');
    let tr = tbody.find('tr');

    tr.on('blur', 'td input', function (e) {
        let $currentRow = $(this).closest('tr')
        let $lastCol = $currentRow.find('td:last')
        let sum = 0
        $currentRow.find('td:not(:last-child) input:not(:hidden)').each(function () {
            let X = $(this).val().replaceAll(/[A-Za-z.]/g, '')
            let Y = X.replaceAll(/[,]/g, '.')
            sum += Number(Y)
        })
        let sumRp = String(sum.toFixed(2)).replaceAll(/[.]/g, ',')
        $lastCol.find('input').val(formatRupiah(sumRp, 'Rp '))

        for (let i = 1; i <= 6; i++) {
            let sum = 0
            let subsection = $(`#adhk_${i}_X_Y`).closest('tr')

            subsection.find('td input').each(function () {
                if (!$(this).hasClass('category-Y-X')) {
                    let X = $(this).val().replaceAll(/[A-Za-z.]/g, '')
                    let Y = X.replaceAll(/[,]/g, '.')
                    sum += Number(Y)
                }
            })
            let sumSection = String(sum.toFixed(2)).replaceAll(/[.]/g, ',')
            $(`#adhk_${i}_X_Y`).val(formatRupiah(sumSection, 'Rp '))
        }

        let numRows = tr.length - 2
        for (let col = 1; col < $('#rekonsiliasi-table-pengeluaran tr:first-child td').length; col++) {
            let sum = 0
            for (let row = 0; row < numRows; row++) {
                let cell = $('#rekonsiliasi-table-pengeluaran tr').eq(row + 1).find('td').eq(col)
                if (cell.hasClass('sectors')) {
                    let X = cell.find('input:not(:hidden)').val().replaceAll(/[A-Za-z.]/g, '')
                    let Y = X.replaceAll(/[,]/g, '.')
                    sum += Number(Y)
                }
            }
            let pdrbs = sum.toFixed(2)
            let sumPDRB = String(pdrbs).replaceAll(/[.]/g, ',')
            let totalCell = $('#rekonsiliasi-table-pengeluaran tr').last().find('td').eq(col)
            totalCell.text(formatRupiah(sumPDRB, 'Rp '))
        }
    });
    //

    //Single-Form Sum Last Column
    let tableSingle = $('#rekonsiliasi-table-single-pengeluaran')
    let tbodySingle = tableSingle.find('tbody')
    let trSingle = tbodySingle.find('tr')

    trSingle.on('blur', 'td input', function (e) {
        let numRows = trSingle.length - 2
        let sum = 0
        for (let row = 0; row < numRows; row++) {
            let cell = $('#rekonsiliasi-table-single-pengeluaran tr').eq(row + 1).find('td').eq(1)
            if (cell.hasClass('sectors')) {
                let X = cell.find('input:not(:hidden)').val().replaceAll(/[A-Za-z.]/g, '')
                let Y = X.replaceAll(/[,]/g, '.')
                sum += Number(Y)
            }
        }
        let sumPDRB = String(sum.toFixed(2)).replaceAll(/[.]/g, ',')
        let totalCell = $('#rekonsiliasi-table-single-pengeluaran tr').last().find('td').eq(1)
        totalCell.text(formatRupiah(sumPDRB, 'Rp '))
    })
    //

    //single and full, sum for every category and sector
    for (let i = 1; i <= 4; i++) {
        $(`.sector-Q${i}-49`).keyup(function (e) {
            let jumlah = calculateSector(`sector-Q${i}-49`).toFixed(2);
            let que = String(jumlah).replaceAll(/[.]/g, ',');
            $(`#adhk_1_X_Q${i}`).val(formatRupiah(que, 'Rp '));
        });
        $(`.sector-Q${i}-52`).keyup(function (e) {
            let jumlah = calculateSector(`sector-Q${i}-52`).toFixed(2);
            let que = String(jumlah).replaceAll(/[.]/g, ',');
            $(`#adhk_4_X_Q${i}`).val(formatRupiah(que, 'Rp '))
        });
        $(`.sector-Q${i}-54`).keyup(function (e) {
            let jumlah = calculateSector(`sector-Q${i}-54`).toFixed(2);
            let que = String(jumlah).replaceAll(/[.]/g, ',');
            $(`#adhk_6_X_Q${i}`).val(formatRupiah(que, 'Rp '))
        });

        for (let j = 49; j <= 54; j++) {
            $(`.sector-Q${i}-${j}`).keyup(function (e) {
                $(this).val(formatRupiah($(this).val(), 'Rp '))
                var charCode = (e.which) ? e.which : event.keyCode
                if (String.fromCharCode(charCode).match(/[^0-9.,]/g))
                    return false;
            })
            $(`.sector-${j}`).keyup(function (e) {
                $(this).val(formatRupiah($(this).val(), 'Rp '))
                var charCode = (e.which) ? e.which : event.keyCode
                if (String.fromCharCode(charCode).match(/[^0-9.,]/g))
                    return false;
            })
        }
    }

    $('.sector-49').keyup(function (e) {
        let jumlah = calculateSector('sector-49').toFixed(2);
        let que = String(jumlah).replaceAll(/[.]/g, ',');
        $('#adhk_1_X').val(formatRupiah(que, 'Rp '));
    })

    $('.sector-52').keyup(function (e) {
        let jumlah = calculateSector('sector-52').toFixed(2);
        let que = String(jumlah).replaceAll(/[.]/g, ',');
        $('#adhk_4_X').val(formatRupiah(que, 'Rp '));
    })

    $('.sector-54').keyup(function (e) {
        let jumlah = calculateSector('sector-54').toFixed(2);
        let que = String(jumlah).replaceAll(/[.]/g, ',');
        $('#adhk_6_X').val(formatRupiah(que, 'Rp '));
    })

    $('#rekonsiliasi-table-pengeluaran').on('paste', 'input', function (e) {
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
                            $this.closest('table').find('tr:eq(' + row + ') td:eq(' + col + ') input:not(:hidden)').val(formatRupiah(v3, 'Rp '));
                        });
                    });

                });
            }
        });
        return false;
    });

    $('#rekonsiliasi-table-single-pengeluaran').on('paste', 'input', function (e) {
        const $this = $(this);
        // let panjang_ndas = $('thead').children().length
        $.each(e.originalEvent.clipboardData.items, function (i, v) {
            if (v.type === 'text/plain') {
                v.getAsString(function (text) {
                    var x = $this.closest('td').index() - 2,
                        y = $this.closest('tr').index() + 1,
                        obj = {};
                    text = text.trim('\r\n');
                    $.each(text.split('\r\n'), function (i2, v2) {
                        $.each(v2.split('\t'), function (i3, v3) {
                            var row = y + i2, col = x + i3;
                            obj['cell-' + row + '-' + col] = v3
                            $this.closest('table').find('tr:eq(' + row + ') td:eq(' + col + ') input').val(formatRupiah(v3, 'Rp '));
                        });
                    });

                });
            }
        });
        return false;
    });
})