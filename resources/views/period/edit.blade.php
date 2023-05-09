<x-dashboard-Layout>

    <x-slot name="title">
        {{ __('Rekonsiliasi') }}
    </x-slot>

    <x-slot name="head">
        <!-- Additional resources here -->
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/daterangepicker/daterangepicker.css">
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item active">Jadwal</li>
    </x-slot>

    <div class="card">
        <form action="/period/{{ $period->id }}" method="post">
            @csrf
            @method('put')
            <div class="card-header">
                <a href="{{ url()->previous() }}">
                    <button type="button" class="btn btn-warning"> {{ _('< Kembali') }} </button>
                </a>
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label class="col-form-label" for="typeSelect">Jenis PDRB:</label>
                    <select id="typeSelect" class="form-control select2bs4" style="width: 100%;" name="type">
                        <option value="" disabled selected>Pilih Jenis PDRB</option>
                        <option {{ old('type', $period->type) == 'Lapangan Usaha' ? 'selected' : '' }}
                            value='Lapangan Usaha'>Lapangan Usaha</option>
                        <option {{ old('type', $period->type) == 'Pengeluaran' ? 'selected' : '' }} value='Pengeluaran'>
                            Pengeluaran</option>
                    </select>
                    <div class="help-block"></div>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="tahunSelect">Tahun:</label>
                    <select id="tahunSelect" class="form-control select2bs4" style="width: 100%;" name="year">
                        <option value="" disabled selected>Pilih Tahun</option>
                        <option {{ old('type', $period->year) == '2023' ? 'selected' : '' }} value='2023'>2023
                        </option>
                        <option {{ old('type', $period->year) == '2022' ? 'selected' : '' }} value='2022'>2022
                        </option>
                    </select>
                    <div class="help-block"></div>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="quarterSelect">Triwulan:</label>
                    <select id="quarterSelect" class="form-control select2bs4" style="width: 100%;" name="quarter">
                        <option value="" disabled selected>Pilih Triwulan</option>
                        <option {{ old('type', $period->quarter) == '1' ? 'selected' : '' }} value='1'>Triwulan 1
                        </option>
                        <option {{ old('type', $period->quarter) == '2' ? 'selected' : '' }} value='2'>Triwulan 2
                        </option>
                        <option {{ old('type', $period->quarter) == '3' ? 'selected' : '' }} value='3'>Triwulan 3
                        </option>
                        <option {{ old('type', $period->quarter) == '4' ? 'selected' : '' }} value='4'>Triwulan 4
                        </option>
                        <option {{ old('type', $period->quarter) == 'T' ? 'selected' : '' }} value='T'>Tahunan
                        </option>
                        <option {{ old('type', $period->quarter) == 'F' ? 'selected' : '' }} value='F'>Lengkap
                        </option>
                    </select>
                    <div class="help-block"></div>
                </div>

                <div class="form-group">
                    <label for="description-text" class="col-form-label">Keterangan:</label>
                    <input type="text" class="form-control" id="description-text" name="description"
                        value="{{ old('description', $period->description) }}" placeholder="Keterangan Putaran">
                </div>

                <div class="form-group">
                    <label>Jadwal:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control float-right" id="jadwal" name="date_range"
                            value="{{ old('date_range', $period->started_at . ' - ' . $period->ended_at) }}">
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="float-right">
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </div>
        </form>
    </div>

    <x-slot name="script">
        <!-- Additional JS resources -->
        <script src="{{ url('') }}/plugins/select2/js/select2.full.min.js"></script>
        <script src="{{ url('') }}/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="{{ url('') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="{{ url('') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
        <script src="{{ url('') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
        <script src="{{ url('') }}/plugins/moment/moment.min.js"></script>
        <script src="{{ url('') }}/plugins/daterangepicker/daterangepicker.js"></script>
        <script src="{{ url('') }}/plugins/moment/moment.min.js"></script>
        <script>
            $(document).on('focus', '.select2-selection', function(e) {
                $(this).closest(".select2-container").siblings('select:enabled').select2('open');
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

                $("#periodTable").DataTable({
                    "scrollX": true,
                    "ordering": false,
                    "searching": false,
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                })
            });

            //Date range picker
            $('#jadwal').daterangepicker({

                locale: {
                    format: 'YYYY-MM-DD'
                }
            })
            //Date range picker with time picker
            $('#reservationtime').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                locale: {
                    format: 'MM/DD/YYYY hh:mm A'
                }
            })
        </script>
    </x-slot>

</x-dashboard-Layout>
