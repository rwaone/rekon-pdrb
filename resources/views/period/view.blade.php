<x-dashboard-Layout>

    <x-slot name="title">
        {{ __('Rekonsiliasi') }}
    </x-slot>

    <x-slot name="head">
        <!-- Additional resources here -->
        <link rel="stylesheet" href="../../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
        <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
        <link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item active">Jadwal</li>
    </x-slot>

    <div class="card">

        <div class="card-header">
            <div class="card-tools">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-lg">
                    <i class="fas fa-plus"></i> Add
                </button>
            </div>
        </div>

        <div class="card-body">
            <table id="periodTable" class="table">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">PDRB</th>
                        <th class="text-center">Tahun</th>
                        <th class="text-center">Triwulan</th>
                        <th class="text-center">Keterangan</th>
                        <th class="text-center">Tanggal Mulai</th>
                        <th class="text-center">Tanggal Selesai</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($periods as $period)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $period->year }}</td>
                            <td class="text-center">{{ $period->type }}</td>
                            <td class="text-center">{{ $period->quarter }}</td>
                            <td class="text-center">{{ $period->description }}</td>
                            <td class="text-center">{{ $period->started_at }}</td>
                            <td class="text-center">{{ $period->ended_at }}</td>
                            <td class="text-center">{{ $period->status }}</td>
                            <td class="project-actions text-right">
                                <a class="btn btn-primary btn-sm" href="#">
                                    <i class="fas fa-folder">
                                    </i>
                                    View
                                </a>
                                <a class="btn btn-info btn-sm" href="#">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                    Edit
                                </a>
                                <a class="btn btn-danger btn-sm" href="#">
                                    <i class="fas fa-trash">
                                    </i>
                                    Delete
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="modal fade" id="modal-lg">
            <div class="modal-dialog modal-lg">
                <form action="/period" method="post">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add New Period</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <label class="col-form-label" for="typeSelect">Jenis PDRB:</label>
                                <select id="typeSelect" class="form-control select2bs4" style="width: 100%;"
                                    name="type">
                                    <option value="" disabled selected>Pilih Jenis PDRB</option>
                                    <option value='Lapangan Usaha'>Lapangan Usaha</option>
                                    <option value='Pengeluaran'>Pengeluaran</option>
                                </select>
                                <div class="help-block"></div>
                            </div>

                            <div class="form-group">
                                <label class="col-form-label" for="tahunSelect">Tahun:</label>
                                <select id="tahunSelect" class="form-control select2bs4" style="width: 100%;"
                                    name="year">
                                    <option value="" disabled selected>Pilih Tahun</option>
                                    <option value='2023'>2023</option>
                                    <option value='2022'>2022</option>
                                </select>
                                <div class="help-block"></div>
                            </div>

                            <div class="form-group">
                                <label class="col-form-label" for="quarterSelect">Triwulan:</label>
                                <select id="quarterSelect" class="form-control select2bs4" style="width: 100%;"
                                    name="quarter">
                                    <option value="" disabled selected>Pilih Triwulan</option>
                                    <option value='1'>Triwulan 1</option>
                                    <option value='2'>Triwulan 2</option>
                                    <option value='3'>Triwulan 3</option>
                                    <option value='4'>Triwulan 4</option>
                                </select>
                                <div class="help-block"></div>
                            </div>

                            <div class="form-group">
                                <label for="description-text" class="col-form-label">Keterangan:</label>
                                <input type="text" class="form-control" id="description-text" name="description"
                                    placeholder="Keterangan Putaran">
                            </div>

                            <div class="form-group">
                                <label>Jadwal:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control float-right" id="jadwal"
                                        name="date_range">
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <x-slot name="script">
            <!-- Additional JS resources -->
            <script src="../../plugins/select2/js/select2.full.min.js"></script>
            <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
            <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
            <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
            <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
            <script src="../../plugins/moment/moment.min.js"></script>
            <script src="../../plugins/daterangepicker/daterangepicker.js"></script>
            <script src="../../plugins/moment/moment.min.js"></script>
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
