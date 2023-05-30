<div>
    <div class="card">
        <form action="rekonsiliasi" method="post" enctype="multipart/form-data" id="filterForm">
            <!-- form start -->
            <div class="card-body">

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="type">PDRB:</label>
                    <select id="type" class="form-control col-sm-9 select2bs4" name="type" required>
                        <option value="" selected>Pilih Jenis PDRB</option>
                        <option value='Lapangan Usaha'>Lapangan Usaha</option>
                        <option value='Pengeluaran'>Pengeluaran</option>
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
                    </select>
                    <div class="help-block"></div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="period_id">Periode:</label>
                    <select id="period" class="form-control col-sm-9 select2bs4" name="period_id" required>
                        <option value="">Pilih Putaran</option>
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

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="price_base">Basis Harga:</label>
                    <select class="form-control col-sm-9 select2bs4" name="price_base" id="price_base" required>
                        <option value="">Pilih Basis Harga</option>
                        <option value='adhk'>Atas Dasar Harga Konstan</option>
                        <option value='adhb'>Atas Dasar Harga Berlaku</option>
                    </select>
                    <div class="help-block"></div>
                </div>
                <!-- /.card-body -->
                {{-- <button id="filterSubmit" type="button" class="btn btn-info float-right">Tampilkan</button> --}}
            </div>
        </form>
    </div>
</div>
