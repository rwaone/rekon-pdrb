<div>
    <div class="card">
        <form method="post" enctype="multipart/form-data" id="filterForm">
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
                    <label class="col-sm-2 col-form-label" for="year">Periode Tahun:</label>
                    <select id="year" class="form-control col-sm-9 select2bs4" name="year" required>
                        <option value="">Pilih Tahun</option>
                    </select>
                    <div class="help-block"></div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="quarter">Periode Triwulan:</label>
                    <select id="quarter" class="form-control col-sm-9 select2bs4" name="quarter" required>
                        <option value="">Pilih Triwulan</option>
                    </select>
                    <div class="help-block"></div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="period_id">Periode Putaran:</label>
                    <select id="period" class="form-control col-sm-9 select2bs4" name="period_id" required>
                        <option value="">Pilih Periode Revisi</option>
                    </select>
                    <div class="help-block"></div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="subsector"> {{$type == 'Pengeluaran' ? 'Komponen' : 'Lapangan Usaha'}}:</label>
                    <select id="subsector" class="form-control col-sm-9 select2bs4" name="subsector" required>
                        <option value="">Pilih {{$type == 'Pengeluaran' ? 'Komponen' : 'Lapangan Usaha'}}</option>                        
                        @foreach ($subsectors as $subsector)
                            <option value="{{ $subsector->id }}">{{$loop->iteration . '. ' . $subsector->name }}</option>
                        @endforeach
                    </select>
                    <div class="help-block"></div>
                </div>

                <button id="filter-button" type="button" class="btn btn-success float-right">Tampilkan</button>

            </div>
        </form>
    </div>
</div>
