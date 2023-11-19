$(document).ready(function () {

    let price_list = ['adhb', 'adhk']

    function changeBackgroundColor(element, value) {
        element.removeClass('uptrend downtrend')
        if (value > 0) {
            element.addClass('uptrend')
        } else if (value < 0) {
            element.addClass('downtrend')
        }
    }

    //change input value into formated accounting input
    $('input[type="text"]').keyup(function (e) {
        $(this).val(formatRupiah($(this).val(), ''))
        var charCode = (e.which) ? e.which : event.keyCode
        if (String.fromCharCode(charCode).match(/[^0-9.,]/g))
            return false;
    })

    $('#type').on('change', function () {
        var pdrb_type = this.value
        $("#year").html('')
        $('#region_id').val('').change()

        $.ajax({
            type: 'POST',
            url: url_fetch_year.href,
            data: {
                type: pdrb_type,
                _token: tokens,
            },
            dataType: 'json',

            success: function (result) {
                $('#year').html('<option value=""> Pilih Tahun </option>');
                $.each(result.years, function (key, value) {
                    $('#year').append('<option value="' + value.year + '">' +
                        value.year + '</option>');
                });
                $.each(result.years, function (key, value) {
                    $('#year-copy').append('<option value="' + value.year +
                        '">' +
                        value.year + '</option>');
                });
                $('#quarter').append(
                    '<option value="" disabled selected> Pilih Triwulan </option>');
                $('#period').append(
                    '<option value="" selected> Pilih Periode </option>');
            },
        })
    });

    $('#year').on('change', function () {
        var pdrb_type = $('#type').val()
        var pdrb_year = this.value
        $("#quarter").html('')
        $('#region_id').val('').change()


        $.ajax({
            type: 'POST',
            url: url_fetch_quarter.href,
            data: {
                type: pdrb_type,
                year: pdrb_year,
                _token: tokens,
            },
            dataType: 'json',

            success: function (result) {
                $('#quarter').html(
                    '<option value="" selected> Pilih Triwulan </option>');
                $.each(result.quarters, function (key, value) {
                    var description = (value.quarter == 'Y') ? 'Tahunan' :
                        'Triwulan ' + value.quarter;
                    $('#quarter').append('<option value="' + value.quarter +
                        '">' + description + '</option>');
                });
                $('#period').append(
                    '<option value="" selected> Pilih Periode </option>');
            },
        })
    });

    $('#quarter').on('change', function () {
        var pdrb_type = $('#type').val()
        var pdrb_year = $('#year').val()
        var pdrb_quarter = this.value
        $("#period").html('')
        $('#region_id').val('').change()


        $.ajax({
            type: 'POST',
            url: url_fetch_period.href,
            data: {
                type: pdrb_type,
                year: pdrb_year,
                quarter: pdrb_quarter,
                _token: tokens,
            },
            dataType: 'json',

            success: function (result) {
                $('#period').html('<option value="" selected> Pilih Periode </option>');
                $.each(result.periods, function (key, value) {
                    $('#period').append('<option value="' + value.id + '">' +
                        value.description + ' (' + value.status + ')' +
                        '</option>');
                });
            },
        })
    });

    $('#period').change(function () {
        if ($('#period').text().includes('Aktif')) {
            $('#adjustment-save').prop('disabled', false)
        } else {
            $('#adjustment-save').prop('disabled', true)
        }
    });

    $('#filter-button').click(function () {
        if (validateFilter()) {
            sessionStorage.setItem("filterData", JSON.stringify(filterData()))
            fetchData()
        } else {
            Toast.fire({
                icon: 'warning',
                title: 'Gagal',
                text: 'Isian filter tidak boleh kosong'
            })
        }
    });

    function filterData() {
        let filter = {}

        filter['type'] = $(`#type`).val()
        filter['year'] = $(`#year`).val()
        filter['quarter'] = $(`#quarter`).val()
        filter['period_id'] = $(`#period`).val()
        filter['subsector'] = $(`#subsector`).val()

        return filter
    }

    function validateFilter() {

        if ($(`#type`).val() == '') {
            return false
        } else if ($(`#year`).val() == '') {
            return false
        } else if ($(`#quarter`).val() == '') {
            return false
        } else if ($(`#period`).val() == '') {
            return false
        } else if ($(`#subsector`).val() == '') {
            return false
        }

        return true

    }


    $("#adjustment-save").click(function () {
        $('.loader').removeClass('d-none');

        $.ajax({

            type: 'POST',
            url: url_save_adjustment.href,
            data: {
                adjustment: JSON.stringify(dataSave(getQuarter())),
                _token: tokens,
            },

            success: function (result) {
                Toast.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Data berhasil disimpan.'
                })
                $('.loader').addClass('d-none')
                fetchData()

            },
        });
    });

    for (let quarter = 1; quarter <= 4; quarter++) {
        $(`#tab_${quarter}`).click(function () {
            printData(quarter)
        })
    }

    function dataSave(quarter) {
        var query = JSON.parse(sessionStorage.getItem("adjustmentData"));
        let data = {}
        for (let region = 2; region <= 16; region++) {
            let array = {}
            array['pdrb_id'] = query['current'][region][quarter]['id']
            array['adhb'] = Number($(`#adhb-adjust-${region}`).val().replaceAll('.', '').replaceAll(',', '.'))
            array['adhk'] = Number($(`#adhk-adjust-${region}`).val().replaceAll('.', '').replaceAll(',', '.'))
            data[region] = array
        }
        return data
    }

    function fetchData() {
        $('.loader').removeClass('d-none');
        $.ajax({
            type: 'POST',
            url: url_get_adjustment.href,
            data: {
                filter: sessionStorage.getItem("filterData"),
                _token: tokens,
            },

            success: function (result) {

                console.log(result)

                sessionStorage.setItem("adjustmentData", JSON.stringify(result.data));

                printData(1)

                $.each(result.messages, function (index, message) {
                    window.showToastr(message['type'], message['text'])
                })

                $('.loader').addClass('d-none')
            },
        });
    }

    function printData(quarter) {
        var data = JSON.parse(sessionStorage.getItem("adjustmentData"))
        $.each(data['current'], function (index, data) {
            $(`#adhb-inisial-${index}`).text(formatRupiah(data[quarter]['adhb'].replaceAll('.', ','), ''))
            $(`#adhk-inisial-${index}`).text(formatRupiah(data[quarter]['adhk'].replaceAll('.', ','), ''))
            $(`#adhb-berjalan-${index}`).text(formatRupiah(data[quarter]['adhb'].replaceAll('.', ','), ''))
            $(`#adhk-berjalan-${index}`).text(formatRupiah(data[quarter]['adhk'].replaceAll('.', ','), ''))
            $(`#adhb-adjust-${index}`).val(formatRupiah(data[quarter]['adjust_adhb'].replaceAll('.', ','), ''))
            $(`#adhk-adjust-${index}`).val(formatRupiah(data[quarter]['adjust_adhk'].replaceAll('.', ','), ''))
        })
        $('.tab-item').removeClass('active')
        $(`#tab_${quarter}`).addClass('active')

        for (let indeks = 2; indeks <= 16; indeks++) {
            countBerjalan('adhb', indeks)
            countBerjalan('adhk', indeks)
        }

        getTotalInisial(quarter, data)
        getTotalBerjalan(quarter, data)
        getQtoQinisial(quarter, data)
        getQtoQberjalan(quarter, data)
        getYonYinisial(quarter, data)
        getYonYberjalan(quarter, data)
        getCtoCinisial(quarter, data)
        getCtoCberjalan(quarter, data)
        getLajuQinisial(quarter, data)
        getLajuQberjalan(quarter, data)
        getKontribusiInisial(quarter, data)
        getKontribusiBerjalan(quarter, data)
    }

    function getTotalInisial(quarter, data) {
        $.each(price_list, function (index, price_base) {
            let total = 0

            for (let i = 2; i <= 16; i++) {
                total += Number(data['current'][i][quarter][price_base])
            }
            $(`#${price_base}-inisial-total`).text(formatRupiah(String(total.toFixed(2)).replaceAll('.', ','), ''))

            let prov = Number(data['current'][1][quarter][price_base])

            let selisih = total - prov
            $(`#${price_base}-inisial-selisih`).text(formatRupiah(String(selisih.toFixed(2)).replaceAll('.', ','), ''))

            let diskrepansi = (selisih / prov) * 100
            $(`#${price_base}-inisial-diskrepansi`).text(String(diskrepansi.toFixed(2)).replaceAll('.', ','))

        })
    }

    function getTotalBerjalan(quarter, data) {
        $.each(price_list, function (index, price_base) {
            let total = 0

            for (let i = 2; i <= 16; i++) {
                let adjust = Number($(`#${price_base}-adjust-${i}`).val().replaceAll('.', '').replaceAll(',', '.'))
                total += Number(data['current'][i][quarter][price_base]) + adjust
            }
            $(`#${price_base}-berjalan-total`).text(formatRupiah(String(total.toFixed(2)).replaceAll('.', ','), ''))

            let prov = Number(data['current'][1][quarter][price_base])

            let selisih = total - prov
            $(`#${price_base}-berjalan-selisih`).text(formatRupiah(String(selisih.toFixed(2)).replaceAll('.', ','), ''))

            let diskrepansi = (selisih / prov) * 100
            $(`#${price_base}-berjalan-diskrepansi`).text(String(diskrepansi.toFixed(2)).replaceAll('.', ','))

        })
    }

    $.each(price_list, function (index, price_base) {
        for (let indeks = 2; indeks <= 16; indeks++) {
            $(`#${price_base}-adjust-${indeks}`).keyup(function (e) {
                var data = JSON.parse(sessionStorage.getItem("adjustmentData"));
                let quarter = getQuarter()
                countBerjalan(price_base, indeks)
                getTotalBerjalan(quarter, data)
                getTotalBerjalan(quarter, data)
                getQtoQberjalan(quarter, data)
                getYonYberjalan(quarter, data)
                getCtoCberjalan(quarter, data)
                getLajuQberjalan(quarter, data)
                getKontribusiBerjalan(quarter, data)
            })
        }
    })

    function getQuarter() {
        quarter = $(`.nav-link.tab-item.active`).data('value')
        return quarter
    }

    function countBerjalan(price_base, indeks) {
        let adjust = Number($(`#${price_base}-adjust-${indeks}`).val().replaceAll('.', '').replaceAll(',', '.'))
        let inisial = Number($(`#${price_base}-inisial-${indeks}`).text().replaceAll('.', '').replaceAll(',', '.'))
        let value = adjust + inisial
        $(`#${price_base}-berjalan-${indeks}`).text(formatRupiah(String(value.toFixed(2)).replaceAll('.', ','), ''))
    }

    function getQtoQinisial(quarter, data) {
        let qtoq = {}
        let totalCurrent = 0
        let totalPrevious = 0
        if (quarter == 1) {
            $.each(data['current'], function (index, value) {
                let current = Number(value[quarter]['adhk'])
                let previous = Number(data['previous'][index][4]['adhk'])
                let result = (current - previous) / previous * 100
                qtoq[index] = result

                if (index != 1) {
                    totalCurrent += Number(current)
                    totalPrevious += Number(previous)
                }
            })
        } else {
            $.each(data['current'], function (index, value) {
                let current = Number(value[quarter]['adhk'])
                let previous = Number(value[quarter - 1]['adhk'])
                let result = (current - previous) / previous * 100
                qtoq[index] = result

                if (index != 1) {
                    totalCurrent += Number(current)
                    totalPrevious += Number(previous)
                }
            })
        }

        qtoq['total'] = (totalCurrent - totalPrevious) / totalPrevious * 100

        $.each(qtoq, function (index, value) {
            $(`#qtoq-inisial-${index}`).text(formatRupiah(String(value.toFixed(2)).replaceAll('.', ','), ''))
            changeBackgroundColor($(`#qtoq-inisial-${index}`), value)
        })
    }

    function getQtoQberjalan(quarter, data) {
        let qtoq = {}
        let totalCurrent = 0
        let totalPrevious = 0
        if (quarter == 1) {
            $.each(data['current'], function (index, value) {
                let adjust = Number($(`#adhk-adjust-${index}`).val().replaceAll('.', '').replaceAll(',', '.'))
                let current = Number(value[quarter]['adhk']) + adjust
                let previous = Number(data['previous'][index][4]['adhk'])
                let result = (current - previous) / previous * 100
                qtoq[index] = result

                if (index != 1) {
                    totalCurrent += Number(current)
                    totalPrevious += Number(previous)
                }
            })
        } else {
            $.each(data['current'], function (index, value) {
                let adjust = Number($(`#adhk-adjust-${index}`).val().replaceAll('.', '').replaceAll(',', '.'))
                let current = Number(value[quarter]['adhk']) + adjust
                let previous = Number(value[quarter - 1]['adhk']) + Number(value[quarter - 1]['adjust_adhk'])
                let result = (current - previous) / previous * 100
                qtoq[index] = result

                if (index != 1) {
                    totalCurrent += Number(current)
                    totalPrevious += Number(previous)
                }
            })
        }

        qtoq['total'] = (totalCurrent - totalPrevious) / totalPrevious * 100

        $.each(qtoq, function (index, value) {
            $(`#qtoq-berjalan-${index}`).text(formatRupiah(String(value.toFixed(2)).replaceAll('.', ','), ''))
            changeBackgroundColor($(`#qtoq-berjalan-${index}`), value)
        })
    }

    function getYonYinisial(quarter, data) {
        let yony = {}
        let totalCurrent = 0
        let totalPrevious = 0
        $.each(data['current'], function (index, value) {
            let current = Number(value[quarter]['adhk'])
            let previous = Number(data['previous'][index][quarter]['adhk'])
            let result = (current - previous) / previous * 100
            yony[index] = result

            if (index != 1) {
                totalCurrent += Number(current)
                totalPrevious += Number(previous)
            }
        })

        yony['total'] = (totalCurrent - totalPrevious) / totalPrevious * 100

        $.each(yony, function (index, value) {
            $(`#yony-inisial-${index}`).text(formatRupiah(String(value.toFixed(2)).replaceAll('.', ','), ''))
            changeBackgroundColor($(`#yony-inisial-${index}`), value)
        })
    }

    function getYonYberjalan(quarter, data) {
        let yony = {}
        let totalCurrent = 0
        let totalPrevious = 0
        $.each(data['current'], function (index, value) {
            let adjust = Number($(`#adhk-adjust-${index}`).val().replaceAll('.', '').replaceAll(',', '.'))
            let current = Number(value[quarter]['adhk']) + adjust
            let previous = Number(data['previous'][index][quarter]['adhk'])
            let result = (current - previous) / previous * 100
            yony[index] = result

            if (index != 1) {
                totalCurrent += Number(current)
                totalPrevious += Number(previous)
            }
        })

        yony['total'] = (totalCurrent - totalPrevious) / totalPrevious * 100

        $.each(yony, function (index, value) {
            $(`#yony-berjalan-${index}`).text(formatRupiah(String(value.toFixed(2)).replaceAll('.', ','), ''))
            changeBackgroundColor($(`#yony-berjalan-${index}`), value)
        })
    }

    function getCtoCinisial(quarter, data) {
        let ctoc = {}
        let totalCurrent = 0
        let totalPrevious = 0
        $.each(data['current'], function (index, value) {
            let current = 0
            let previous = 0
            for (q = 1; q <= quarter; q++) {
                current += Number(value[q]['adhk'])
                previous += Number(data['previous'][index][q]['adhk'])
            }
            let result = (current - previous) / previous * 100
            ctoc[index] = result

            if (index != 1) {
                totalCurrent += Number(current)
                totalPrevious += Number(previous)
            }
        })

        ctoc['total'] = (totalCurrent - totalPrevious) / totalPrevious * 100

        $.each(ctoc, function (index, value) {
            $(`#ctoc-inisial-${index}`).text(formatRupiah(String(value.toFixed(2)).replaceAll('.', ','), ''))
            changeBackgroundColor($(`#ctoc-inisial-${index}`), value)
        })
    }

    function getCtoCberjalan(quarter, data) {
        let ctoc = {}
        let totalCurrent = 0
        let totalPrevious = 0
        $.each(data['current'], function (index, value) {
            let current = 0
            let previous = 0
            for (q = 1; q <= quarter; q++) {
                let adjust = (q == quarter) ? Number($(`#adhk-adjust-${index}`).val().replaceAll('.', '').replaceAll(',', '.')) : Number(value[q]['adjust_adhk'])
                current += (Number(value[q]['adhk']) + adjust)
                previous += Number(data['previous'][index][q]['adhk'])
            }
            let result = (current - previous) / previous * 100
            ctoc[index] = result

            if (index != 1) {
                totalCurrent += Number(current)
                totalPrevious += Number(previous)
            }
        })

        ctoc['total'] = (totalCurrent - totalPrevious) / totalPrevious * 100

        $.each(ctoc, function (index, value) {
            $(`#ctoc-berjalan-${index}`).text(formatRupiah(String(value.toFixed(2)).replaceAll('.', ','), ''))
            changeBackgroundColor($(`#ctoc-berjalan-${index}`), value)
        })
    }

    function getLajuQinisial(quarter, data) {
        let lajuQ = {}
        let totalCurrent = 0
        let totalPrevious = 0
        if (quarter == 1) {
            $.each(data['current'], function (index, value) {
                let currentADHB = Number(value[quarter]['adhb'])
                let currentADHK = Number(value[quarter]['adhk'])

                let previousADHB = Number(data['previous'][index][4]['adhb'])
                let previousADHK = Number(data['previous'][index][4]['adhk'])

                let current = currentADHB / currentADHK
                let previous = previousADHB / previousADHK

                let result = (current - previous) / previous * 100
                lajuQ[index] = result

                if (index != 1) {
                    totalCurrent += Number(current)
                    totalPrevious += Number(previous)
                }
            })
        } else {
            $.each(data['current'], function (index, value) {
                let currentADHB = Number(value[quarter]['adhb'])
                let currentADHK = Number(value[quarter]['adhk'])

                let previousADHB = Number(value[quarter - 1]['adhb'])
                let previousADHK = Number(value[quarter - 1]['adhk'])

                let current = currentADHB / currentADHK
                let previous = previousADHB / previousADHK

                let result = (current - previous) / previous * 100
                lajuQ[index] = result

                if (index != 1) {
                    totalCurrent += Number(current)
                    totalPrevious += Number(previous)
                }
            })
        }

        lajuQ['total'] = (totalCurrent - totalPrevious) / totalPrevious * 100

        $.each(lajuQ, function (index, value) {
            $(`#lajuQ-inisial-${index}`).text(formatRupiah(String(value.toFixed(2)).replaceAll('.', ','), ''))
            changeBackgroundColor($(`#lajuQ-inisial-${index}`), value)
        })
    }

    function getLajuQberjalan(quarter, data) {
        let lajuQ = {}
        let totalCurrent = 0
        let totalPrevious = 0
        if (quarter == 1) {
            $.each(data['current'], function (index, value) {
                let adjustADHB = Number($(`#adhb-adjust-${index}`).val().replaceAll('.', '').replaceAll(',', '.'))
                let adjustADHK = Number($(`#adhk-adjust-${index}`).val().replaceAll('.', '').replaceAll(',', '.'))

                let currentADHB = Number(value[quarter]['adhb']) + adjustADHB
                let currentADHK = Number(value[quarter]['adhk']) + adjustADHK

                let previousADHB = Number(data['previous'][index][4]['adhb'])
                let previousADHK = Number(data['previous'][index][4]['adhk'])

                let current = currentADHB / currentADHK
                let previous = previousADHB / previousADHK

                let result = (current - previous) / previous * 100
                lajuQ[index] = result

                if (index != 1) {
                    totalCurrent += Number(current)
                    totalPrevious += Number(previous)
                }
            })
        } else {
            $.each(data['current'], function (index, value) {

                let adjustADHB = Number($(`#adhb-adjust-${index}`).val().replaceAll('.', '').replaceAll(',', '.'))
                let adjustADHK = Number($(`#adhk-adjust-${index}`).val().replaceAll('.', '').replaceAll(',', '.'))

                let currentADHB = Number(value[quarter]['adhb']) + adjustADHB
                let currentADHK = Number(value[quarter]['adhk']) + adjustADHK

                let previousADHB = Number(value[quarter - 1]['adhb'])
                let previousADHK = Number(value[quarter - 1]['adhk'])

                let current = currentADHB / currentADHK
                let previous = previousADHB / previousADHK

                let result = (current - previous) / previous * 100
                lajuQ[index] = result

                if (index != 1) {
                    totalCurrent += Number(current)
                    totalPrevious += Number(previous)
                }
            })
        }

        lajuQ['total'] = (totalCurrent - totalPrevious) / totalPrevious * 100

        $.each(lajuQ, function (index, value) {
            $(`#lajuQ-berjalan-${index}`).text(formatRupiah(String(value.toFixed(2)).replaceAll('.', ','), ''))
            changeBackgroundColor($(`#lajuQ-berjalan-${index}`), value)
        })
    }

    function getKontribusiBerjalan(quarter, data) {
        let x = {}
        let kontribusi = {}
        let total = 0

        for (let i = 2; i <= 16; i++) {
            let adjust = Number($(`#adhb-adjust-${i}`).val().replaceAll('.', '').replaceAll(',', '.'))
            x[i] = Number(data['current'][i][quarter]['adhb']) + adjust
            total += x[i]
        }

        x['total'] = total

        $.each(x, function (index, value) {

            let result = value / total * 100
            kontribusi[index] = result
        })

        $.each(kontribusi, function (index, value) {
            $(`#kontribusi-berjalan-${index}`).text(formatRupiah(String(value.toFixed(2)).replaceAll('.', ','), ''))
        })
    }

    function getKontribusiInisial(quarter, data) {
        let x = {}
        let kontribusi = {}
        let total = 0

        for (let i = 2; i <= 16; i++) {
            x[i] = Number(data['current'][i][quarter]['adhb'])
            total += x[i]
        }

        x['total'] = total

        $.each(x, function (index, value) {

            let result = value / total * 100
            kontribusi[index] = result
        })

        $.each(kontribusi, function (index, value) {
            $(`#kontribusi-inisial-${index}`).text(formatRupiah(String(value.toFixed(2)).replaceAll('.', ','), ''))
        })
    }

    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function () {
        scrollFunction();
    };

    function scrollFunction() {
        if (
            document.body.scrollTop > 20 ||
            document.documentElement.scrollTop > 20
        ) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    }
    // When the user clicks on the button, scroll to the top of the document
    mybutton.addEventListener("click", backToTop);

    function backToTop() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }
});