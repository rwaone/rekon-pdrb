<div>
    <div class="card">
        <form action="/pdrb/rekonsiliasi" action="post">
            @csrf
            <!-- form start -->
            <div class="card-body">
                {{-- 
            <div class="form-group">
                <label for="description-text" class="col-form-label">Keterangan:</label>
                <input wire:model="message" type="text" class="form-control" placeholder="Keterangan Putaran">
            </div>

            {{ $message }} --}}

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="pdrb_type">PDRB:</label>
                    <select wire:model="selectedPdrb" class="form-control col-sm-10" name="type">
                        <option value="">Pilih Jenis PDRB</option>
                        <option value='Lapangan Usaha'>Lapangan Usaha</option>
                        <option value='Pengeluaran'>Pengeluaran</option>
                    </select>
                    <div class="help-block"></div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="year">Tahun:</label>
                    <select wire:model="selectedYear" class="form-control col-sm-10" name="year">
                        <option value="">Pilih Tahun</option>
                        @foreach ($years as $year)
                            <option value="{{ $year->year }}">{{ $year->year }}</option>
                        @endforeach
                    </select>
                    <div class="help-block"></div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="quarter">Triwulan:</label>
                    <select wire:model="selectedQuarter" class="form-control col-sm-10" name="quarter">
                        <option value="">Pilih Triwulan</option>
                        @foreach ($quarters as $quarter)
                            <option value="{{ $quarter->quarter }}">{{ $quarter->quarter }}</option>
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
                    <select wire:model="selectedPeriod" class="form-control col-sm-10" name="period_id">
                        <option value="">Pilih Periode</option>
                        @foreach ($periods as $period)
                            <option value="{{ $period->id }}">{{ $period->description }}</option>
                        @endforeach
                    </select>
                    <div class="help-block"></div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="region_id">Kabupaten/Kota:</label>
                    <select wire:model="region_id" id="regionSelect" class="form-control col-sm-10" name="region_id">
                        <option value="">Pilih Kabupaten/Kota</option>
                        @foreach ($regions as $region)
                            <option value="{{ $region->id }}">{{ $region->name }}</option>
                        @endforeach
                    </select>
                    <div class="help-block"></div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="price_base">Basis Harga:</label>
                    <select wire:model="price_base" class="form-control col-sm-10" name="price_base">
                        <option value="">Pilih Basis Harga</option>
                        <option value='adhk'>Atas Dasar Harga Konstan</option>
                        <option value='adhb'>Atas Dasar Harga Berlaku</option>
                    </select>
                    <div class="help-block"></div>
                </div>
                <!-- /.card-body -->
                <button type="submit" class="btn btn-info float-right">Tampilkan</button>
            </div>
        </form>
    </div>
</div>
