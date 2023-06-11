<div>
    <div class="card">
        <form action="rekonsiliasi" method="post" enctype="multipart/form-data" id="filterForm">
            <!-- form start -->
            <div class="card-body">

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="type">PDRB:</label>
                    <select id="type" class="form-control col-sm-9 select2bs4" name="type" required>
                        <option value="" selected>Pilih Jenis PDRB</option>
                        <option value='{{ $type }}'>{{ $type }}</option>
                    </select>
                    <div class="help-block"></div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="year">Tahun:</label>
                    <select id="year" class="form-control col-sm-9 select2bs4" name="year" required>
                        <option value="">Pilih Tahun</option>
                    </select>
                    <div class="help-block"></div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="quarter">Triwulan:</label>
                    <select id="quarter" class="form-control col-sm-9 select2bs4" name="quarter" required>
                        <option value="">Pilih Triwulan</option>
                        <option value='1'>Triwulan 1</option>
                        <option value='2'>Triwulan 2</option>
                        <option value='3'>Triwulan 3</option>
                        <option value='4'>Triwulan 4</option>
                        <option value='T'>Tahunan</option>
                    </select>
                    <div class="help-block"></div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="region_id">Kabupaten/Kota:</label>
                    <select id="region_id" class="form-control col-sm-9 select2bs4" name="region_id" required>
                        <option value="">Pilih Kabupaten/Kota</option>
                        @foreach ($regions as $region)
                            <option value="{{ $region->id }}">{{ $region->name }}</option>
                        @endforeach
                    </select>
                    <div class="help-block"></div>
                </div>
                <!-- /.card-body -->
                {{-- <button id="filterSubmit" type="button" class="btn btn-info float-right">Tampilkan</button> --}}
            </div>
        </form>
    </div>
</div>
