$(document).ready(function () {

    let price_list = ['adhb', 'adhk']

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
        $('#subsector').val('').change()
    });

    $('#filter-button').click(function () {
        $('.loader').removeClass('d-none');

        $.ajax({
            type: 'POST',
            url: url_get_adjustment.href,
            data: {
                filter: $('#filterForm').serializeArray().reduce(function (obj, item) {
                    obj[item.name] = item.value;
                    return obj;
                }, {}),
                _token: tokens,
            },

            success: function (result) {
                console.log(result);
                sessionStorage.setItem("data", JSON.stringify(result));
                fetchData(1)

                Toast.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Data berhasil ditampilkan.'
                })

                $('.loader').addClass('d-none')
            },
        });
    });

    $("#adjustment-save").click(function () {

        $.ajax({

            type: 'POST',
            url: url_save_adjustment.href,
            data: {
                adjustment: JSON.stringify(dataSave(getQuarter())),
                _token: tokens,
            },

            success: function (result) {
                console.log(result)
                Toast.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Data berhasil disimpan.'
                })

            },
        });
    });

    for (let quarter = 1; quarter <= 4; quarter++) {
        $(`#tab_${quarter}`).click(function () {
            fetchData(quarter)
        })
    }

    function dataSave(quarter) {
        var query = JSON.parse(sessionStorage.getItem("data"));
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

    function fetchData(quarter) {
        var data = JSON.parse(sessionStorage.getItem("data"));
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
        getTotalInisial()
        getTotalBerjalan()
        getQtoQinisial()
        getQtoQberjalan()
        getYonYinisial()
        getYonYberjalan()
        getCtoCinisial()
        getCtoCberjalan()
        getLajuQinisial()
        getLajuQberjalan()
    }

    function getTotalInisial() {
        $.each(price_list, function (index, price_base) {
            let total = 0

            for (let i = 2; i <= 16; i++) {
                total += Number($(`#${price_base}-inisial-${i}`).text().replaceAll('.', '').replaceAll(',', '.'))
            }
            $(`#${price_base}-inisial-total`).text(formatRupiah(String(total.toFixed(2)).replaceAll('.', ','), ''))

            let prov = Number($(`#${price_base}-inisial-1`).text().replaceAll('.', '').replaceAll(',', '.'))

            let selisih = total - prov
            $(`#${price_base}-inisial-selisih`).text(formatRupiah(String(selisih.toFixed(2)).replaceAll('.', ','), ''))

            let diskrepansi = (selisih / prov) * 100
            $(`#${price_base}-inisial-diskrepansi`).text(String(diskrepansi.toFixed(2)).replaceAll('.', ','))

        })
    }

    function getTotalBerjalan() {
        var data = JSON.parse(sessionStorage.getItem("data"));
        let quarter = getQuarter()
        $.each(price_list, function (index, price_base) {
            let total = 0

            for (let i = 2; i <= 16; i++) {
                total += Number(data['current'][i][quarter][price_base])
            }
            $(`#${price_base}-berjalan-total`).text(formatRupiah(String(total.toFixed(2)).replaceAll('.', ','), ''))

            let prov = Number($(`#${price_base}-berjalan-1`).text().replaceAll('.', '').replaceAll(',', '.'))

            let selisih = total - prov
            $(`#${price_base}-berjalan-selisih`).text(formatRupiah(String(selisih.toFixed(2)).replaceAll('.', ','), ''))

            let diskrepansi = (selisih / prov) * 100
            $(`#${price_base}-berjalan-diskrepansi`).text(String(diskrepansi.toFixed(2)).replaceAll('.', ','))

        })
    }

    $.each(price_list, function (index, price_base) {
        for (let indeks = 2; indeks <= 16; indeks++) {
            $(`#${price_base}-adjust-${indeks}`).keyup(function (e) {
                countBerjalan(price_base, indeks)
                getTotalBerjalan()
                getTotalBerjalan()
                getQtoQberjalan()
                getYonYberjalan()
                getCtoCberjalan()
                getLajuQberjalan()
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

    function getQtoQinisial() {
        var data = JSON.parse(sessionStorage.getItem("data"));
        let qtoq = {}
        let quarter = getQuarter()
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
        })
    }

    function getQtoQberjalan() {
        var data = JSON.parse(sessionStorage.getItem("data"));
        let qtoq = {}
        let quarter = getQuarter()
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
            $(`#qtoq-berjalan-${index}`).text(formatRupiah(String(value.toFixed(2)).replaceAll('.', ','), ''))
        })
    }

    function getYonYinisial() {
        var data = JSON.parse(sessionStorage.getItem("data"));
        let yony = {}
        let quarter = getQuarter()
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
        })
    }

    function getYonYberjalan() {
        var data = JSON.parse(sessionStorage.getItem("data"));
        let yony = {}
        let quarter = getQuarter()
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
        })
    }

    function getCtoCinisial() {
        var data = JSON.parse(sessionStorage.getItem("data"));
        let ctoc = {}
        let quarter = getQuarter()
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
        })
    }

    function getCtoCberjalan() {
        var data = JSON.parse(sessionStorage.getItem("data"));
        let ctoc = {}
        let quarter = getQuarter()
        let totalCurrent = 0
        let totalPrevious = 0
        $.each(data['current'], function (index, value) {
            let current = 0
            let previous = 0
            for (q = 1; q <= quarter; q++) {
                let adjust = (q == quarter) ? Number($(`#adhk-adjust-${index}`).val().replaceAll('.', '').replaceAll(',', '.')) : Number(value[q]['adjust_adhk'])
                current += ( Number(value[q]['adhk']) + adjust )
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
        })
    }

    function getLajuQinisial() {
        var data = JSON.parse(sessionStorage.getItem("data"));
        let lajuQ = {}
        let quarter = getQuarter()
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
        })
    }

    function getLajuQberjalan() {
        var data = JSON.parse(sessionStorage.getItem("data"));
        let lajuQ = {}
        let quarter = getQuarter()
        let totalCurrent = 0
        let totalPrevious = 0
        if (quarter == 1) {
            $.each(data['current'], function (index, value) {
                let adjustADHB = Number($(`#adhk-adjust-${index}`).val().replaceAll('.', '').replaceAll(',', '.'))
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
            $(`#lajuQ-berjalan-${index}`).text(formatRupiah(String(value.toFixed(2)).replaceAll('.', ','), ''))
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