<x-dashboard-Layout>
    <x-slot name="title">
        {{ __('Fenomena') }}
    </x-slot>
    <x-slot name="head">
        <!-- Additional resources here -->
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
        <script></script>
        <style type="text/css">
        .table td { 
            vertical-align: middle;
            padding: 0.25rem;
        }
        .table tr:nth-child(even) {
            background-color: ; 
        }
        </style>
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item active">Fenomena</li>
    </x-slot>

    <div class="card">
        <!-- form start -->
        <form class="form-horizontal">
            <div class="card-body">

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="region_id">Kabupaten/Kota:</label>
                    <select id="regionSelect" class="form-control col-sm-10 select2bs4" name="region_id">
                        <option value="" disabled selected>Pilih Kabupaten/Kota</option>
                        @foreach ($regions as $region)
                            <option value="{{$region->id}}">{{$region->name}}</option>
                        @endforeach
                    </select>
                    <div class="help-block"></div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="tahun">Tahun:</label>
                    <select id="tahunSelect" class="form-control col-sm-10 select2bs4" name="tahun">
                        <option value="" disabled selected>Pilih Tahun</option>
                        <option value='2023'>2023</option>
                        <option value='2022'>2022</option>
                    </select>
                    <div class="help-block"></div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="pdrb_id">PDRB:</label>
                    <select id="pdrbSelect" class="form-control col-sm-10 select2bs4" name="pdrb_id">
                        <option value="" disabled selected>Pilih Jenis PDRB</option>
                    </select>
                    <div class="help-block"></div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="triwulan_id">Triwulan:</label>
                    <select id="triwulanSelect" class="form-control col-sm-10 select2bs4" name="triwulan_id">
                        <option value="" disabled selected>Pilih Triwulan</option>
                        <option value="1">I</option>
                        <option value="2">II</option>
                        <option value="3">III</option>
                        <option value="4">IV</option>
                    </select>
                    <div class="help-block"></div>
                </div>
                <!-- /.card-body -->
            </div>
        </form>
    </div>

    <div class="card">
        <form class="form-horizontal">
            <div class="card-body p-3">
                <table class="table table-striped table-bordered" id="rekonsiliasi-table">
                    <thead class="text-center" style="background-color: steelblue; color:aliceblue;">
                        <tr>
                            <th>Komponen</th>
                            <th>Fenomena</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($category as $category)
                        <tr>
                            <td>
                                <label class="col" style="margin-bottom:0rem;" for="{{ $category->name }}_{{ $category->code }}">{{ $category->code.". ".$category->name }}</label>
                            </td>
                            <td>
                                <textarea name="adhk_{{ $category->id }}" id="" class="form-control" rows="4" cols="50" aria-required="true"></textarea>
                            </td>
                        </tr>
                            @foreach ($sector as $sect)
                            @if ($sect->category_id == $category->id && $sect->code != NULL)
                                <tr>
                                    <td>
                                        <p class="col ml-4" style="margin-bottom:0rem;" for="{{ $sect->code }}_{{ $sect->name }}">{{ $sect->code.". ".$sect->name }}</p>
                                    </td>
                                    <td>
                                        <textarea name="" id="" class="form-control" rows="4" cols="50" aria-required="true"></textarea>
                                    </td>
                                </tr>
                            @foreach ($subsector as $subsect)
                                @if ($subsect->sector_id == $sect->id && $subsect->code != NULL)
                                    <tr>
                                        <td>
                                            <p class="col ml-5" style="margin-bottom:0rem;" for="{{ $subsect->code }}_{{ $subsect->name }}">{{ $subsect->code.". ".$subsect->name }}</p>
                                        </td>
                                        <td>
                                            <textarea name="" id="" class="form-control" rows="4" cols="50" aria-required="true"></textarea>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            @endif
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex pr-3">
                <div class="ml-auto">
                    <button type="button" class="btn btn-info">Simpan</button>
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
        <script src="{{ url('') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
        <script src="{{ url('') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
        <script src="{{ url('') }}/plugins/jszip/jszip.min.js"></script>
        <script src="{{ url('') }}/plugins/pdfmake/pdfmake.min.js"></script>
        <script src="{{ url('') }}/plugins/pdfmake/vfs_fonts.js"></script>
        <script src="{{ url('') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
        <script src="{{ url('') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
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

                $("#pdrbTable").DataTable({
                    "scrollX": true,
                    "ordering": false,
                    "searching": true,
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    "buttons": ["copy", "csv", "excel", "pdf"]
                }).buttons().container().appendTo('#pdrbTable_wrapper .col-md-6:eq(0)');
            });
        </script>
    </x-slot>
</x-dashboard-Layout>
