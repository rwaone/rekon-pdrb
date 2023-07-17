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

    <div class="row">
        <div class="col-md-3">

            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        {{-- <img class="profile-user-img img-fluid img-circle"
                            src="{{ asset('storage/' . $user->pegawai->foto) }}" alt="User profile picture"> --}}
                            <img class="profile-user-img img-fluid img-circle"
                                src="{{ url('') }}/dist/img/user2-160x160.jpg" alt="User profile picture">
                            
                    </div>
                    <h3 class="profile-username text-center"> {{$user->name}} </h3>
                    <p class="text-muted text-center">{{ $user->role }}</p>
                    <ul class="list-group list-group-unbordered mb-3">
                        {{-- <li class="list-group-item">
                            <b>Jenis Akun</b> <a class="float-right">{{auth()->user()->role}}</a>
                        </li> --}}
                        {{-- <li class="list-group-item">
                            <b>Following</b> <a class="float-right">543</a>
                        </li>
                        <li class="list-group-item">
                            <b>Friends</b> <a class="float-right">13,287</a>
                        </li> --}}
                    </ul>
                    {{-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> --}}
                </div>

            </div>


            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">About Me</h3>
                </div>

                <div class="card-body">
                    <strong><i class="fas fa-circle mr-1"></i> Username</strong>
                    <p class="text-muted">
                        {{ $user->username }}
                    </p>
                    <hr>
                    <strong><i class="fas fa-circle mr-1"></i> Email</strong>
                    <p class="text-muted">
                        {{ $user->email }}
                    </p>
                    <hr>
                    <strong><i class="fas fa-circle mr-1"></i>Satuan Kerja</strong>
                    <p class="text-muted">
                        {{ $user->satker->name }}
                    </p>
                    <hr>
                </div>

            </div>

        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#settings"
                                data-toggle="tab">Settings</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">

                        <div class="active tab-pane" id="settings">
                            <form class="form-horizontal" action="/password" method="post">
                                @csrf
                                @method('put')

                                @if (session()->has('error'))
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert"aria-hidden="true">&times;</button>
                                        <strong>{{ session('error') }}</strong>
                                    </div>
                                @endif

                                @if (session()->has('success'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert"aria-hidden="true">&times;</button>
                                        <strong>{{ session('success') }}</strong>
                                    </div>
                                @endif

                                <div class="form-group row">
                                    <label for="old_password" class="col-sm-2 col-form-label">Password Lama</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="old_password"
                                            placeholder="Password Lama" name="old_password" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password" class="col-sm-2 col-form-label">Password Baru</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control  @error('password') is-invalid @enderror" id="password"
                                            placeholder="Password Baru" name="password" required>
                                            @error('password')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password_confirmation" class="col-sm-2 col-form-label">Konfirmasi
                                        Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation"
                                            placeholder="Konfirmasi Password" name="password_confirmation" required>
                                            @error('password_confirmation')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>
            </div>

        </div>

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
