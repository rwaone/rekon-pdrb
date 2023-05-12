<div>
    <div class="card">
        <form action="/pdrb/rekonsiliasi" method="post" enctype="multipart/form-data">
            @csrf
            <!-- form start -->
            <div class="card-body">

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="type">PDRB:</label>
                    <select id="type" class="form-control col-sm-10 select2bs4" name="type">
                        <option value="">Pilih Jenis PDRB</option>
                        <option {{ old('type', $filter['type']) == 'Lapangan Usaha' ? 'selected' : '' }} value='Lapangan Usaha'>Lapangan Usaha</option>
                        <option {{ old('type', $filter['type']) == 'Pengeluaran' ? 'selected' : '' }} value='Pengeluaran'>Pengeluaran</option>
                    </select>
                    <div class="help-block"></div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="year">Tahun:</label>
                    <select id="year" class="form-control col-sm-10 select2bs4" name="year">
                        <option value="">Pilih Tahun</option>
                        @foreach ($years as $year)
                            <option {{ old('year', $filter['year']) == $year->year ? 'selected' : '' }} value="{{ $year->year }}">{{ $year->year }}</option>
                        @endforeach
                    </select>
                    <div class="help-block"></div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="quarter">Triwulan:</label>
                    <select id="quarter" class="form-control col-sm-10 select2bs4" name="quarter">
                        <option value="">Pilih Triwulan</option>
                        @foreach ($quarters as $quarter)
                            <option {{ old('quarter', $filter['quarter']) == $quarter->quarter ? 'selected' : '' }} value="{{ $quarter->quarter }}">{{ $quarter->quarter }}</option>
                        @endforeach
                        {{-- <option value='1'>Triwulan 1</option>
                    <option value='2'>Triwulan 2</option>
                    <option value='3'>Triwulan 3</option>
                    <option value='4'>Triwulan 4</option> --}}
                    </select>
                    <div class="help-block"></div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="period_id">Periode:</label>
                    <select id="period_id" class="form-control col-sm-10 select2bs4" name="period_id">
                        <option value="">Pilih Periode</option>
                        @foreach ($periods as $period)
                            <option {{ old('period_id', $filter['period_id']) == $period->id ? 'selected' : '' }} value="{{ $period->id }}">{{ $period->description }}</option>
                        @endforeach
                    </select>
                    <div class="help-block"></div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="region_id">Kabupaten/Kota:</label>
                    <select id="region_id" class="form-control col-sm-10 select2bs4" name="region_id">
                        <option value="">Pilih Kabupaten/Kota</option>
                        @foreach ($regions as $region)
                            <option {{ old('region_id',$filter['region_id']) == $region->id ? 'selected' : '' }} value="{{ $region->id }}">{{ $region->name }}</option>
                        @endforeach
                    </select>
                    <div class="help-block"></div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="price_base">Basis Harga:</label>
                    <select class="form-control col-sm-10 select2bs4" name="price_base">
                        <option value="">Pilih Basis Harga</option>
                        <option {{ old('price_base', $filter['price_base']) == 'adhk' ? 'selected' : '' }} value='adhk'>Atas Dasar Harga Konstan</option>
                        <option {{ old('price_base', $filter['price_base']) == 'adhb' ? 'selected' : '' }} value='adhb'>Atas Dasar Harga Berlaku</option>
                    </select>
                    <div class="help-block"></div>
                </div>
                <!-- /.card-body -->
                <button type="submit" class="btn btn-info float-right">Tampilkan</button>
            </div>
        </form>
    </div>
</div>
