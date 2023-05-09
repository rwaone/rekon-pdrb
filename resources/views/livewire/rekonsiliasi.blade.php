

<div class="card">

    <!-- form start -->
    <form action="" method="post" class="form-horizontal">
        @csrf
        <div class="card-body">
{{-- 
            <div class="form-group">
                <label for="description-text" class="col-form-label">Keterangan:</label>
                <input wire:model="message" type="text" class="form-control" placeholder="Keterangan Putaran">
            </div>

            {{ $message }} --}}

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="year">Tahun:</label>
                <select wire:model="selectedYear" class="form-control col-sm-10">
                    <option value="" disabled selected>Pilih Tahun</option>
                    <option value='2023'>2023</option>
                    <option value='2022'>2022</option>
                </select>
                <div class="help-block">{{ $selectedYear }}</div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="quarter">Triwulan:</label>
                <select id="quarterSelect" class="form-control col-sm-10" name="quarter">
                    <option value="" disabled selected>Pilih Triwulan</option>
                    <option value='1'>Triwulan 1</option>
                    <option value='2'>Triwulan 2</option>
                    <option value='3'>Triwulan 3</option>
                    <option value='4'>Triwulan 4</option>
                </select>
                <div class="help-block"></div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="pdrb_type">PDRB:</label>
                <select id="typeSelect" class="form-control col-sm-10" name="pdrb_type">
                    <option value="" disabled selected>Pilih Jenis PDRB</option>
                    <option value='Lapangan Usaha'>Lapangan Usaha</option>
                    <option value='Pengeluaran'>Pengeluaran</option>
                </select>
                <div class="help-block"></div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="period_id">Periode:</label>
                <select id="periodSelect" class="form-control col-sm-10 select2bs4" name="period_id">
                    <option value="" disabled selected>Pilih Periode</option>
                    @foreach ($periods as $period)
                        <option value="{{ $period->id }}">{{ $period->description }}</option>
                    @endforeach
                </select>
                <div class="help-block"></div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="region_id">Kabupaten/Kota:</label>
                <select id="regionSelect" class="form-control col-sm-10 select2bs4" name="region_id">
                    <option value="" disabled selected>Pilih Kabupaten/Kota</option>
                    @foreach ($regions as $region)
                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                    @endforeach
                </select>
                <div class="help-block"></div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="price_base">Basis Harga:</label>
                <select id="priceSelect" class="form-control col-sm-10 select2bs4" name="price_base">
                    <option value="" disabled selected>Pilih Basis Harga</option>
                    <option value='adhk'>Atas Dasar Harga Konstan</option>
                    <option value='adhb'>Atas Dasar Harga Berlaku</option>
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
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach ($subsectors as $subsect)
                            @if (($subsect->code != NULL && $subsect->code == "a" && $subsect->sector->code == "1") || ($subsect->code == NULL && $subsect->sector->code == "1"))
                                <tr>
                                    <td>
                                        <label class="col" style="margin-bottom:0rem;" for="">{{ $subsect->sector->category->code.". ".$subsect->sector->category->name }}</label>
                                    </td>
                                    <td>
                                        <input disabled type="text" name="adhk_{{ $subsect->id."_".$subsect->sector->id."_".$subsect->sector->category->id }}" id="adhk_{{ $subsect->id."_".$subsect->sector->id."_".$subsect->sector->category->id }}" class="form-control" aria-required="true">
                                    </td>
                                </tr>
                            @endif
                            @if ($subsect->code != NULL && $subsect->code == "a")
                                <tr>
                                    <td>
                                        <p class="col ml-4" style="margin-bottom:0rem;" for="">{{ $subsect->sector->code.". ".$subsect->sector->name }}</p>
                                    </td>
                                    <td>
                                        <input disabled type="text" name="adhk_{{ $subsect->id."_".$subsect->sector->id."_".$subsect->sector->category->id }}" id="adhk_{{ $subsect->id."_".$subsect->sector->id."_".$subsect->sector->category->id }}" class="form-control" aria-required="true">
                                    </td>
                                </tr>
                            @endif
                            @if ($subsect->code != NULL)
                                <tr>
                                    <td>
                                        <p class="col ml-5" style="margin-bottom:0rem;" 
                                            for="{{ $subsect->code }}_{{ $subsect->name }}">{{ $subsect->code.". ".$subsect->name }}</p>
                                    </td>
                                    <td>
                                        <input type="text" name="adhk_{{ $subsect->id."_".$subsect->sector->id."_".$subsect->sector->category->id }}" id="adhk_{{ $subsect->id."_".$subsect->sector->id."_".$subsect->sector->category->id }}" class="form-control" aria-required="true">
                                    </td>
                                </tr>    
                            @elseif ($subsect->code == NULL && $subsect->sector->code != NULL)
                                <tr>
                                    <td>
                                        <p class="col ml-4" style="margin-bottom:0rem;" 
                                            for="{{ $subsect->sector->code."_".$subsect->sector->name }}">{{ $subsect->sector->code.". ".$subsect->sector->name }}</p>
                                    </td>
                                    <td>
                                        <input type="text" name="adhk_{{ $subsect->id."_".$subsect->sector->id."_".$subsect->sector->category->id }}" id="adhk_{{ $subsect->id."_".$subsect->sector->id."_".$subsect->sector->category->id }}" class="form-control" aria-required="true">
                                    </td>
                                </tr>
                            @elseif ($subsect->code == NULL && $subsect->sector->code == NULL)
                                <tr>
                                    <td>
                                        <label class="col" style="margin-bottom:0rem;" for="{{ $subsect->sector->category->code."_".$subsect->name }}">{{ $subsect->sector->category->code.". ".$subsect->name }}</label>
                                    </td>
                                    <td>
                                        <input type="text" name="adhk_{{ $subsect->id."_".$subsect->sector->id."_".$subsect->sector->category->id }}" id="adhk_{{ $subsect->id."_".$subsect->sector->id."_".$subsect->sector->category->id }}" class="form-control" aria-required="true">
                                    </td>
                                </tr>
                            @endif
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