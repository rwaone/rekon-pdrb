<x-dashboard-Layout>

    <x-slot name="title">
        {{ __('Jadwal Rekonsiliasi') }}
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

        <div class="card-header">
            <div class="card-tools">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-lg">
                    <i class="fas fa-plus"></i> Add
                </button>
            </div>
        </div>

        <div class="card-body">
            <table id="periodTable" class="table table-sorted table-search">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">PDRB</th>
                        <th class="text-center">Tahun</th>
                        <th class="text-center">Triwulan</th>
                        <th class="text-center">Periode</th>
                        <th class="text-center">Tanggal Mulai</th>
                        <th class="text-center">Tanggal Selesai</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                    <tr>
                        <td class="text-center"></td>
                        <td class="text-center search-header"><input type="text" class="search-input form-control"></td>
                        <td class="text-center search-header"><input type="text" class="search-input form-control"></td>
                        <td class="text-center search-header"><input type="text" class="search-input form-control"></td>
                        <td class="text-center search-header"><input type="text" class="search-input form-control"></td>
                        <td class="text-center search-header"><input type="text" class="search-input form-control"></td>
                        <td class="text-center search-header"><input type="text" class="search-input form-control"></td>
                        <td class="text-center search-header"><input type="text" class="search-input form-control"></td>
                        <td class="text-center search-header"><input type="text" class="search-input form-control"></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($periods as $period)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $period->type }}</td>
                            <td class="text-center">{{ $period->year }}</td>
                            <td class="text-center">
                                @switch($period->quarter)
                                    @case('T')
                                        Tahunan
                                    @break

                                    @case('F')
                                        Lengkap
                                    @break

                                    @default
                                        Triwulan {{ $period->quarter }}
                                @endswitch
                            </td>
                            <td class="text-center">{{ $period->description }}</td>
                            <td class="text-center">{{ $period->started_at }}</td>
                            <td class="text-center">{{ $period->ended_at }}</td>
                            <td class="text-center">
                                @switch($period->status)
                                    @case('Aktif')
                                        <span class="badge bg-warning"> {{ $period->status }} </span>
                                    @break

                                    @case('Selesai')
                                        <span class="badge bg-success"> {{ $period->status }} </span>
                                    @break

                                    @case('Final')
                                        <span class="badge bg-primary"> {{ $period->status }} </span>
                                    @break

                                    @default
                                @endswitch
                            </td>
                            <td class="project-actions text-center">
                                <a class="btn btn-info btn-sm" href="/period/{{ $period->id }}/edit">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                    Edit
                                </a>
                                <a onclick="deleteConfirm('/period/{{ $period->id }}')" class="btn btn-danger btn-sm"
                                    href="#">
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
        <div class="row d-flex justify-content-end align-items-center">
            <div class="mb-3 mx-3 ml-auto">Menampilkan <span id="showPage"></span> dari <span id="showTotal"></span>
            </div>
            <div class="form-group"> <!--		Show Numbers Of Rows 		-->
                <select class  ="form-control" name="state" id="maxRows">
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                </select>
            </div>
            <div class="pagination-container">
                <nav>
                    <ul class="pagination">
                        <li data-page="prev">
                            <span>
                                < <span class="sr-only">(current)
                            </span></span>
                        </li>
                        <!--	Here the JS Function Will Add the Rows -->
                        <li data-page="next" id="prev">
                            <span> > <span class="sr-only">(current)</span></span>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="modal fade" id="modal-lg">
            <div class="modal-dialog modal-lg">
                <form id="periodForm" action="/period" method="post">
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
                                    @foreach ($years as $year)
                                        <option value='{{ $year }}'>{{ $year }}</option>
                                    @endforeach
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
                                    <!-- <option value='Y'>Tahunan</option> -->
                                </select>
                                <div class="help-block"></div>
                            </div>
                            {{-- 
                            <div class="form-group">
                                <label for="description-text" class="col-form-label">Keterangan:</label>
                                <input type="text" class="form-control" id="description-text" name="description"
                                    placeholder="Keterangan Putaran">
                            </div> --}}

                            <div class="form-group">
                                <label for="description-text" class="col-form-label">Keterangan Putaran:</label>
                                <div class="input-group mb-3">
                                    {{-- <div class="input-group-prepend">
                                        <span class="input-group-text">Putaran ke-</span>
                                    </div> --}}
                                    <input type="text" class="form-control" id="description-text"
                                        name="description" placeholder="Keterangan Putaran">
                                </div>
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
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                            <button id="periodSubmit" type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="deleteModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Konfirmasi</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda Benar-Benar Ingin Menghapusnya?</p>
                    </div>
                    <form action="" method="post" id="btn-delete">
                        <div class="modal-footer justify-content-between">
                            @method('delete')
                            @csrf
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
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
            <script>
                getPagination("#periodTable", 10);
                function deleteConfirm(url) {
                    $('#btn-delete').attr('action', url);
                    $('#deleteModal').modal();
                }

                $(function() {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });

                    var notif = "{{ Session::get('notif') }}";

                    if (notif != '') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: notif
                        })
                    } else if (notif == '2') {
                        Toast.fire({
                            icon: 'danger',
                            title: 'Gagal',
                            text: notif
                        })
                    }
                });

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

                    // $("#periodTable").DataTable({
                    //     "scrollX": true,
                    //     "ordering": false,
                    //     "searching": false,
                    //     "responsive": true,
                    //     "lengthChange": false,
                    //     "autoWidth": false,
                    // })
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
