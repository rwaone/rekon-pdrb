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
        <form action="/user/{{ $user->id }}" method="post">
            @csrf
            @method('put')
            
            <div class="card-header">
                <a href="{{ url('user') }}">
                    <button type="button" class="btn btn-warning"> {{ _('< Kembali') }} </button>
                </a>
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label for="name-text" class="col-form-label">Nama:</label>
                    <input type="text" class="form-control" id="name-text" name="name"
                        placeholder="Nama" value="{{ old('name', $user->name) }}">
                </div>

                <div class="form-group">
                    <label for="username-text" class="col-form-label">Username:</label>
                    <input type="text" class="form-control" id="username-text" name="username"
                        placeholder="Username" value="{{ old('username', $user->username) }}">
                </div>

                <div class="form-group">
                    <label for="email-text" class="col-form-label">E-Mail:</label>
                    <input type="text" class="form-control" id="email-text" name="email"
                        placeholder="E-Mail" value="{{ old('email', $user->email) }}">
                </div>
                
                <div class="form-group">
                    <label class="col-form-label" for="roleSelect">Role:</label>
                    <select id="roleSelect" class="form-control select2bs4" style="width: 100%;"
                        name="role">
                        <option value="" disabled selected>Pilih Role</option>
                        <option {{ old('role', $user->role) == 'admin' ? 'selected' : '' }} value="admin">admin</option>
                        <option {{ old('role', $user->role) == 'user' ? 'selected' : '' }} value="user">user</option>
                    </select>
                    <div class="help-block"></div>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="satkerSelect">Satuan Kerja:</label>
                    <select id="satkerSelect" class="form-control select2bs4" style="width: 100%;"
                        name="satker_id">
                        <option value="" disabled selected>Pilih Satuan Kerja</option>
                        @foreach ($satkers as $satker)
                            <option {{ old('type', $user->satker_id) == $satker->id ? 'selected' : '' }}  value='{{$satker->id}}'>{{$satker->name}}</option>
                        @endforeach
                    </select>
                    <div class="help-block"></div>
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
