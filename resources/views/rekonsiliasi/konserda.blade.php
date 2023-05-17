<x-dashboard-Layout>
    <x-slot name="title">
        {{ __('Konserda') }}
    </x-slot>
    <x-slot name="head">
        <!-- Additional resources here -->
        <meta name="csrf-token" content="content">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2/css/select2.min.css">
        <script></script>
        <style type="text/css">
            .table td {
                vertical-align: middle;
                padding: 0.25rem;
            }

            #rekon-view td {
                word-wrap: break-word;
            }

            #rekon-view .values {
                text-align: right;
            }

            #rekon-view .PDRB-footer td p {
                text-align: center !important;
            }

            #rekon-view tr:not(:last-child):not(:nth-last-child(2)) td:not(:first-child) {
                text-align: right;
            }
        </style>
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item active">Konserda</li>
        <div id="my-cat" data-cat="{{ json_encode($cat) }}"></div>
    </x-slot>
        <div class="card mb-3 p-0">
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-md-3">
                            <select class="form-control select2bs4" id="tahun" name="tahun">
                                <option value="" disabled selected>-- Pilih Tahun Konserda --</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control select2bs4" id="tahunpdrb" name="tahunpdrb">
                                <option value="" disabled selected>-- Pilih Tahun PDRB --</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control select2bs4" id="putaran" name="putaran">
                                <option value="" disabled selected>-- Pilih Putaran --</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-info col" id="showData">Tampilkan Data</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <table class="table table-bordered" id="rekon-view">
                    <thead class="text-center" style="background-color: steelblue; color:aliceblue;">
                        <tr>
                            <th>Komponen</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subsectors as $index => $item)
                            @if (($item->code != NULL && $item->code == "a" && $item->sector->code == "1") || ($item->code == NULL && $item->sector->code == "1"))
                                <tr>
                                    <td>
                                        <label class="col" style="margin-bottom:0rem;"
                                            for="">{{ $item->sector->category->code . '. ' . $item->sector->category->name }}</label>
                                    </td>
                                    <td id="categories-{{ $index+1 }}" class="categories values"></td>
                                </tr>
                            @endif
                            @if ($item->code != null && $item->code == 'a')
                            <tr>
                                <td>
                                    <p class="col ml-4" style="margin-bottom:0rem;" for="">
                                        {{ $item->sector->code . '. ' . $item->sector->name }}</p>
                                </td>
                                <td id="sector-{{ $index+1 }}" class="values"></td>
                            </tr>
                        @endif
                        @if ($item->code != null)
                            <tr>
                                <td>
                                    <p class="col ml-5" style="margin-bottom:0rem;"
                                        for="{{ $item->code }}_{{ $item->name }}">
                                        {{ $item->code . '. ' . $item->name }}</p>
                                </td>
                                <td id="{{ "value-".$item->id }}" class ="values">{{ $pdrb[$index]->adhk }}</td>
                            </tr>
                        @elseif ($item->code == null && $item->sector->code != null)
                            <tr>
                                <td>
                                    <p class="col ml-4" style="margin-bottom:0rem;"
                                        for="{{ $item->sector->code . '_' . $item->sector->name }}">
                                        {{ $item->sector->code . '. ' . $item->sector->name }}</p>
                                </td>
                                <td id="{{ "value-".$item->id }}" class ="values">{{ $pdrb[$index]->adhk }}</td>
                            </tr>
                        @elseif ($item->code == null && $item->sector->code == null)
                            <tr>
                                <td>
                                    <label class="col" style="margin-bottom:0rem;"
                                        for="{{ $item->sector->category->code . '_' . $item->name }}">{{ $item->sector->category->code . '. ' . $item->name }}</label>
                                </td>
                                <td id="{{ "value-".$item->id }}" class = "values">{{ $pdrb[$index]->adhk }}</td>
                            </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    <x-slot name="script">
        <!-- Additional JS resources -->
        <script src="{{ url('') }}/plugins/select2/js/select2.full.min.js"></script>
        <script>
            $(document).on('focus', '.select2-selection', function(e) {
                $(this).closest(".select2-container").siblings('select:enabled').select2('open');
            })
           

            //sum of each value in sector and category
            function calculateSector(sector) {
                let sum = 0;
                // let sector = sector.replaceAll(",","");
                $(`.${sector}`).each(function(index) {
                    let X = $(this).val().replaceAll(/[A-Za-z.]/g, '');
                    let Y = X.replaceAll(/[,]/g, '.')
                    sum += Y > 0 ? Number(Y) : 0;
                });
                return sum;
            }
            //

            //change the value of inputed number to Rupiah 
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
            //



            $(document).ready(function() {
                // Your jQuery code goes here
                // 
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
            })
                $(document).on('select2:open', () => {
                    document.querySelector('.select2-search__field').focus();
            });

            $(function() {
                //Initialize Select2 Elements
                $('.select2').select2()

                //Initialize Select2 Elements
                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                })
            });
        </script>
    </x-slot>
</x-dashboard-Layout>
