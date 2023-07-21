<x-dashboard-Layout>
    <x-slot name="title">
        {{ __('Monitoring') }}
    </x-slot>
    <x-slot name="head">
        <!-- Additional resources here -->
        <meta name="csrf-token" content="content">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2/css/select2.min.css">
        <script></script>
        <style type="text/css">
            #monitoring-kuarter thead {
                text-align: center;
            }

            #monitoring-kuarter td {
                padding: 2px;
            }
        </style>
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item active">Rekonsiliasi</li>
    </x-slot>

    <div class="row">
        <div class="col-md-8">
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md">
                            <select class="form-control select2bs4" id="type" name="type">
                                <option value="" selected>-- Pilih Jenis PDRB --</option>
                                <option {{ old('type', $filter['type']) == 'Lapangan Usaha' ? 'selected' : '' }}
                                    value='Lapangan Usaha'>Lapangan Usaha</option>
                                <option value="Pengeluaran">Pengeluaran</option>
                            </select>
                        </div>
                        <div class="col-md">
                            <select class="form-control select2bs4" id="year" name="year">
                                <option value="" selected>-- Pilih Tahun --</option>
                                @if ($years)
                                    @foreach ($years as $year)
                                        <option {{ old('year', $filter['year']) == $year->year ? 'selected' : '' }}
                                            value="{{ $year->year }}">{{ $year->year }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-info col-md-10" id="showData"><i class="bi bi-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <span class="loader d-none"></span>
    <div id="" class="views">
        <h4 class="ml-2">Monitoring Pemasukan Tabel PDRB Lapangan Usaha Tahun</h4>
        <div class="card p-4">
            <h5>Kuarter</h5>
            <div class="card-body p-0">
                <table class="table table-bordered table-striped" id="monitoring-kuarter">
                    <thead>
                        <th>Kabupaten/Kota</th>
                        <th>ADHK</th>
                        <th>ADHB</th>
                    </thead>
                    <tbody>
                        @foreach ($regions as $region)
                            <tr>
                                <td class="pl-2">{{ $region->name }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <x-slot name="script">
        <!-- Additional JS resources -->
        <script src="{{ url('') }}/plugins/select2/js/select2.full.min.js"></script>
        {{-- <script src="{{ asset('js/fenomena.js') }}"</script> --}}
        <script>
            const url_fenomena_year = new URL("{{ route('fenomenaYear') }}")
            const tokens = '{{ csrf_token() }}'
            const url_key = new URL('{{ route('fenomena.getMonitoring') }}')
            $("#type").on("change", function() {
                let pdrb_type = $(this).val();
                if (pdrb_type) {
                    $.ajax({
                        type: "POST",
                        url: url_fenomena_year,
                        data: {
                            type: pdrb_type,
                            _token: tokens,
                        },
                        dataType: "json",

                        success: function(result) {
                            $("#year").empty();
                            $("#year").append(
                                '<option value="">-- Pilih Tahun --</option>'
                            );
                            $.each(result.years, function(key, value) {
                                $("#year").append(
                                    '<option value="' +
                                    value.year +
                                    '">' +
                                    value.year +
                                    "</option>"
                                );
                            });
                        },
                    });
                } else {
                    $("#year").empty();
                    $("#year").append(
                        '<option value="">-- Pilih Tahun --</option>'
                    );
                }
            });

            function fetchData() {
                const types = $('#type').val();
                const years = $('#year').val();
                url_key.searchParams.set("type", types);
                url_key.searchParams.set("year", encodeURIComponent(years));
                return new Promise(function (resolve, reject){
                    $.ajax({
                        type: 'GET',
                        url: url_key.href,
                        dataType: 'json',
                        success: function(data) {
                            resolve(data);
                        }, 
                        error: function(jqXHR, textStatus, errorThrown) {
                            reject(errorThrown);
                        }
                    })
                })
            }

            $('#showData').on('click', async function(e) {
                e.preventDefault();
                try {
                    const data = await fetchData();
                } catch (error) {
                    
                }
                $('.loader').removeClass('d-none');
                setTimeout(() => {
                    $('.views').each(function() {
                        $(this).addClass('d-none');
                    });
                    let showIndex = $('#year').val();
                    $(`#${showIndex}`).removeClass('d-none');
                    $('.loader').addClass('d-none');
                }, 500);
            });

            $('#monitoring-kuarter tbody tr td').each(function() {
                if ($(this).text() === '0') {
                    $(this).html('<i class="bi bi-x-circle-fill" style = "color: red;"></i>');
                    $(this).addClass('text-center')
                }
                if ($(this).text() === '1') {
                    $(this).html('<i class="bi bi-check-circle-fill" style = "color: green;"></i>');
                    $(this).addClass('text-center')
                }
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
