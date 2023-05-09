

<div class="card">
    <!-- form start -->
    <form class="form-horizontal">
        <div class="card-body">

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="year">Tahun:</label>
                <select id="tahunSelect" class="form-control col-sm-10 select2bs4" name="year">
                    <option value="" disabled selected>Pilih Tahun</option>
                    <option value='2023'>2023</option>
                    <option value='2022'>2022</option>
                </select>
                <div class="help-block"></div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="quarter">Triwulan:</label>
                <select id="tahunSelect" class="form-control col-sm-10 select2bs4" name="quarter">
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
                <select id="typeSelect" class="form-control col-sm-10 select2bs4" name="pdrb_type">
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
                    @foreach ($categories as $category)
                        <tr>
                            <td>
                                <label class="col" style="margin-bottom:0rem;"
                                    for="{{ $category->name }}_{{ $category->code }}">{{ $category->code . '. ' . $category->name }}</label>
                            </td>
                            <td>
                                <input type="text" name="" id="" class="form-control"
                                    aria-required="true">
                            </td>
                        </tr>
                        @foreach ($sectors as $sector)
                            @if ($sector->category_id == $category->id && $sector->code != null)
                                <tr>
                                    <td>
                                        <p class="col ml-4" style="margin-bottom:0rem;"
                                            for="{{ $sector->code }}_{{ $sector->name }}">
                                            {{ $sector->code . '. ' . $sector->name }}</p>
                                    </td>
                                    <td>
                                        <input type="text" name="" id="" class="form-control"
                                            aria-required="true">
                                    </td>
                                </tr>
                                @foreach ($subsectors as $subsector)
                                    @if ($subsector->sector_id == $sector->id && $subsector->code != null)
                                        <tr>
                                            <td>
                                                <p class="col ml-5" style="margin-bottom:0rem;"
                                                    for="{{ $subsector->code }}_{{ $subsector->name }}">
                                                    {{ $subsector->code . '. ' . $subsector->name }}</p>
                                            </td>
                                            <td>
                                                <input type="text" name="" id=""
                                                    class="form-control" aria-required="true">
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    @endforeach
                </tbody>
            </table>
            {{-- @foreach ($category as $category)
                <label class="col" for="{{ $category->name }}_{{ $category->code }}">{{ $category->code.". ".$category->name }}</label>
                @foreach ($sector as $sect)
                @if ($sect->category_id == $category->id && $sect->code != null)
                    <p class="col ml-4" for="{{ $sect->code }}_{{ $sect->name }}">{{ $sect->code.". ".$sect->name }}</p>
                @foreach ($subsector as $subsect)
                    @if ($subsect->sector_id == $sect->id && $subsect->code != null)
                            <p class="col ml-5" for="{{ $subsect->code }}_{{ $subsect->name }}">{{ $subsect->code.". ".$subsect->name }}</p>
                    @endif
                @endforeach
                @endif
                @endforeach
            @endforeach --}}
        </div>
        <div class="card-footer d-flex pr-3">
            <div class="ml-auto">
                <button type="button" class="btn btn-info">Simpan</button>
            </div>
        </div>
    </form>
</div>