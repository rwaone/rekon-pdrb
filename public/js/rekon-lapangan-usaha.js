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
    let table = $('#rekonsiliasi-table');
    let tbody = table.find('tbody');
    let tr = tbody.find('tr');

    tr.on('blur', 'td input', function (e) {
        let $currentRow = $(this).closest('tr')
        let $lastCol = $currentRow.find('td:last')
        let sum = 0
        $currentRow.find('td:not(:last-child) input:not(:hidden)').each(function () {
            let X = $(this).val().replaceAll(/[A-Za-z.]/g, '')
            let Y = X.replaceAll(/[,]/g, '.')
            sum += Y > 0 ? Number(Y) : 0
        })
        let sumRp = String(sum.toFixed(2)).replaceAll(/[.]/g, ',')
        $lastCol.find('input').val(formatRupiah(sumRp, 'Rp '))

        for (let index of catSpecific) {
            let darksum = 0
            let lightsum = 0

            let row = $(`#adhk_${index}_Y`).closest('tr')
            let subsection = $(`#adhk_1_${index}_Y`).closest('tr')

            row.find('td input:not(#adhk_' + index + '_Y)').each(function () {
                if (!$(this).hasClass(`adhk_${index}_Y`)) {
                    let X = $(this).val().replaceAll(/[A-Za-z.]/g, '');
                    let Y = X.replaceAll(/[,]/g, '.');
                    darksum += Y > 0 ? Number(Y) : 0;
                }
            })

            subsection.find('td input:not(#adhk_1_' + index + '_Y)').each(function () {
                if (!$(this).hasClass(`adhk_${index}_Y`)) {
                    let X = $(this).val().replaceAll(/[A-Za-z.]/g, '');
                    let Y = X.replaceAll(/[,]/g, '.');
                    lightsum += Y > 0 ? Number(Y) : 0;
                }
            })

            let lightsumRp = String(lightsum.toFixed(2)).replaceAll(/[.]/g, ',');
            let darksumRp = String(darksum.toFixed(2)).replaceAll(/[.]/g, ',');
            $(`#adhk_1_${index}_Y`).val(formatRupiah(lightsumRp, 'Rp '))
            $(`#adhk_${index}_Y`).val(formatRupiah(darksumRp, 'Rp '))
        }

        let numRows = tr.length - 2
        for (let col = 1; col < $('#rekonsiliasi-table tr:first-child td').length; col++) {
            let sum = 0
            let pdrb = 0
            let nonmigas = 0
            for (let row = 0; row < numRows; row++) {
                let cell = $('#rekonsiliasi-table tr').eq(row + 1).find('td').eq(col)
                if (cell.hasClass('categories')) {
                    let X = cell.find('input').val().replaceAll(/[A-Za-z.]/g, '')
                    let Y = X.replaceAll(/[,]/g, '.')
                    sum += Y > 0 ? Number(Y) : 0
                }
                for (let index of catLast) {
                    if (cell.find(`input[id^='adhk___${index}_']`).length > 0) {
                        let X = cell.find(`input[id^='adhk___${index}_']`).val().replaceAll(
                            /[A-Za-z.]/g, '')
                        let Y = X.replaceAll(/[,]/g, '.')
                        pdrb += Y > 0 ? Number(Y) : 0
                    }
                }
                cell.find('input').each(function () {
                    let inputId = $(this).attr('id');
                    if (inputId && (inputId.includes('adhk__1_B_') || inputId.includes('adhk_b_1_C_'))) {
                        let X = $(this).val().replaceAll(/[A-Za-z.]/g, '');
                        let Y = X.replaceAll(/[,]/g, '.');
                        nonmigas += Y > 0 ? Number(Y) : 0;
                    }
                });
            }
            let pdrbs = sum + pdrb
            let PdrbNonmigas = pdrbs - nonmigas
            let sumPDRB = String(pdrbs.toFixed(2)).replaceAll(/[.]/g, ',')
            let sumPDRBnm = String(PdrbNonmigas.toFixed(2)).replaceAll(/[.]/g, ',')
            let totalnm = $('#rekonsiliasi-table tr').last().prev().find('td').eq(col)
            let totalCell = $('#rekonsiliasi-table tr').last().find('td').eq(col)
            totalnm.text(formatRupiah(sumPDRBnm, 'Rp '))
            totalCell.text(formatRupiah(sumPDRB, 'Rp '))
        }
    });
    //

    //Single-Form Sum Last Column
    let tableSingle = $('#rekonsiliasi-table-single')
    let tbodySingle = tableSingle.find('tbody')
    let trSingle = tbodySingle.find('tr')

    trSingle.on('blur', 'td input', function (e) {
        let numRows = trSingle.length - 2
        let sum = 0
        let pdrb = 0
        let nonmigas = 0
        for (let row = 0; row < numRows; row++) {
            let cell = $('#rekonsiliasi-table-single tr').eq(row + 1).find('td').eq(1)
            if (cell.hasClass('categories')) {
                let X = cell.find('input').val().replaceAll(/[A-Za-z.]/g, '')
                let Y = X.replaceAll(/[,]/g, '.')
                sum += Y > 0 ? Number(Y) : 0
            }
            for (let index of catLast) {
                if (cell.find(`input[id^='adhk___${index}']`).length > 0) {
                    let X = cell.find(`input[id^='adhk___${index}']`).val().replaceAll(
                        /[A-Za-z.]/g, '')
                    let Y = X.replaceAll(/[,]/g, '.')
                    pdrb += Y > 0 ? Number(Y) : 0
                }
            }
            if (cell.find('input').attr('id').includes('adhk__1_B') || cell.find('input').attr(
                'id').includes('adhk_b_1_C')) {
                let X = cell.find('input').val().replaceAll(/[A-Za-z.]/g, '')
                let Y = X.replaceAll(/[,]/g, '.')
                nonmigas += Y > 0 ? Number(Y) : 0
            }
        }
        let pdrbs = sum + pdrb
        let PdrbNonmigas = pdrbs - nonmigas
        let sumPDRB = String(pdrbs.toFixed(2)).replaceAll(/[.]/g, ',')
        let sumPDRBnm = String(PdrbNonmigas.toFixed(2)).replaceAll(/[.]/g, ',')
        let totalnm = $('#rekonsiliasi-table-single tr').last().prev().find('td').eq(1)
        let totalCell = $('#rekonsiliasi-table-single tr').last().find('td').eq(1)
        totalnm.text(formatRupiah(sumPDRBnm, 'Rp '))
        totalCell.text(formatRupiah(sumPDRB, 'Rp '))
    })
    //

    //single and full, sum for every category and sector
    for (let i = 1; i < 5; i++) {
        $(`.sector-Q${i}-1`).keyup(function (e) {
            let jumlah = calculateSector(`sector-Q${i}-1`).toFixed(2);
            let que = String(jumlah).replaceAll(/[.]/g, ',');
            $(`#adhk_1_A_Q${i}`).val(formatRupiah(que, 'Rp '));
        });
        $(`.sector-Q${i}-8`).keyup(function (e) {
            let jumlah = calculateSector(`sector-Q${i}-8`).toFixed(2);
            let que = String(jumlah).replaceAll(/[.]/g, ',');
            $(`#adhk_1_C_Q${i}`).val(formatRupiah(que, 'Rp '))
        });
        for (let j = 1; j < 18; j++) {
            $(`.category-Q${i}-${j}`).keyup(function (e) {
                let jumlah = calculateSector(`category-Q${i}-${j}`).toFixed(2);
                let que = String(jumlah).replaceAll(/[.]/g, ',');
                $(`#adhk_${catArray[j - 1]}_Q${i}`).val(formatRupiah(que, 'Rp '))
            });
            $(`.category-${j}`).keyup(function (e) {
                let jumlah = calculateSector(`category-${j}`).toFixed(2);
                let que = String(jumlah).replaceAll(/[.]/g, ',');
                $(`#adhk_${catArray[j - 1]}`).val(formatRupiah(que, 'Rp '))
            });
        }
        for (let j = 1; j < 54; j++) {
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

    $('.sector-1').keyup(function (e) {
        let jumlah = calculateSector('sector-1').toFixed(2);
        let que = String(jumlah).replaceAll(/[.]/g, ',');
        $('#adhk_1_A').val(formatRupiah(que, 'Rp '));
    })

    $('.sector-8').keyup(function (e) {
        let jumlah = calculateSector('sector-8').toFixed(2);
        let que = String(jumlah).replaceAll(/[.]/g, ',');
        $('#adhk_1_C').val(formatRupiah(que, 'Rp '));
    })

    $('#rekonsiliasi-table').on('paste', 'input', function (e) {
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
                            $this.closest('table').find('tr:eq(' + row + ') td:eq(' + col + ') input').val(formatRupiah(v3, 'Rp '));
                        });
                    });

                });
            }
        });
        return false;
    });

    $('#rekonsiliasi-table-single').on('paste', 'input', function (e) {
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