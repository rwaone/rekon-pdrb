<x-dashboard-Layout>

    <x-slot name="title">
        {{ __('Pengguna') }}
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
        <li class="breadcrumb-item active">Pengguna</li>
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
                        <th class="text-center">Nama</th>
                        <th class="text-center">Username</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Role</th>
                        <th class="text-center">Satker</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $user->name }}</td>
                            <td class="text-center">{{ $user->username }}</td>
                            <td class="text-center">{{ $user->email }}</td>
                            <td class="text-center">
                                @switch($user->role)
                                    @case('admin')
                                        <span class="badge bg-primary"> {{ $user->role }} </span>
                                    @break

                                    @case('user')
                                        <span class="badge bg-success"> {{ $user->role }} </span>
                                    @break

                                    @default
                                @endswitch
                            </td>
                            <td class="text-center">{{ $user->satker->name }}</td>
                            <td class="project-actions text-center">
                                <a class="btn btn-primary btn-sm" href="#">
                                    <i class="fas fa-eye"></i>
                                    View
                                </a>
                                <a class="btn btn-info btn-sm" href="/user/{{ $user->id }}/edit">
                                    <i class="fas fa-pencil-alt"></i>
                                    Edit
                                </a>
                                <a class="btn btn-warning btn-sm" href="#">
                                    <i class="fas fa-key"></i>
                                    Reset
                                </a>
                                <a onclick="deleteConfirm('/user/{{ $user->id }}')" class="btn btn-danger btn-sm"
                                    href="#">
                                    <i class="fas fa-trash"></i>
                                    Delete
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

        @include('user.create-modal')

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
            <script src="{{ url('') }}/plugins/moment/moment.min.js"></script>
            <script>
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
