<x-dashboard-Layout>

    <x-slot name="title">
        {{ __('Dashboard') }}
    </x-slot>

    <x-slot name="head">
        <!-- Additional resources here -->
        <link rel="stylesheet" href="../../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
        <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item active">Rekonsiliasi</li>
    </x-slot>

    <div class="card">
        <!-- form start -->
        <form class="form-horizontal">
            <div class="card-body">

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="satker_id">Satuan Kerja:</label>
                    <select id="satkerSelect" class="form-control col-sm-10 select2bs4" name="satker_id" required>
                        <option value="" disabled selected>Pilih Satker</option>
                    </select>
                    <div class="help-block"></div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="tahun">Tahun:</label>
                    <select id="tahunSelect" class="form-control col-sm-10 select2bs4" name="tahun" required>
                        <option value="" disabled selected>Pilih Tahun</option>
                        <option value='2023'>2023</option>
                        <option value='2022'>2022</option>
                    </select>
                    <div class="help-block"></div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="pdrb_id">PDRB:</label>
                    <select id="pdrbSelect" class="form-control col-sm-10 select2bs4" name="pdrb_id" required>
                        <option value="" disabled selected>Pilih Jenis PDRB</option>
                    </select>
                    <div class="help-block"></div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="period_id">Periode:</label>
                    <select id="periodSelect" class="form-control col-sm-10 select2bs4" name="period_id" required>
                        <option value="" disabled selected>Pilih Periode</option>
                    </select>
                    <div class="help-block"></div>
                </div>
                <!-- /.card-body -->
            </div>
        </form>
    </div>

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Rekonsiliasi</h3>
        </div>
        <div class="card-body">
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            Footer
        </div>
        <!-- /.card-footer-->
    </div>
    <!-- /.card -->

    <x-slot name="script">
        <!-- Additional JS resources -->
        <script src="../../plugins/select2/js/select2.full.min.js"></script>
        <script>
            $(document).on('focus', '.select2-selection', function (e) {
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
            });
        </script>
    </x-slot>

</x-dashboard-Layout>
