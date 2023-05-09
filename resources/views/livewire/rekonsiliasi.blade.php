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
                <label class="col-sm-2 col-form-label" for="pdrb_type">PDRB:</label>
                <select wire:model="selectedPdrb" class="form-control col-sm-10">
                    <option value="">Pilih Jenis PDRB</option>
                    <option value='Lapangan Usaha'>Lapangan Usaha</option>
                    <option value='Pengeluaran'>Pengeluaran</option>
                </select>
                <div class="help-block"></div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="year">Tahun:</label>
                <select wire:model="selectedYear" class="form-control col-sm-10">
                    <option value="" >Pilih Tahun</option>
                    @foreach ($years as $year)
                        <option value="{{ $year->year }}">{{ $year->year }}</option>
                    @endforeach
                </select>
                <div class="help-block"></div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="quarter">Triwulan:</label>
                <select wire:model="selectedQuarter" class="form-control col-sm-10">
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
                <select wire:model="selectedPeriod" class="form-control col-sm-10">
                    <option value="">Pilih Periode</option>
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
                    @foreach ($subsectors as $subsector)
                        @if (
                            ($subsector->code != null && $subsector->code == 'a' && $subsector->sector->code == '1') ||
                                ($subsector->code == null && $subsector->sector->code == '1'))
                            <tr>
                                <td>
                                    <label class="col" style="margin-bottom:0rem;"
                                        for="">{{ $subsector->sector->category->code . '. ' . $subsector->sector->category->name }}</label>
                                </td>
                                <td>
                                    <input disabled type="text"
                                        name="adhk_{{ $subsector->id . '_' . $subsector->sector->id . '_' . $subsector->sector->category->id }}"
                                        id="adhk_{{ $subsector->id . '_' . $subsector->sector->id . '_' . $subsector->sector->category->id }}"
                                        class="form-control" aria-required="true">
                                </td>
                            </tr>
                        @endif
                        @if ($subsector->code != null && $subsector->code == 'a')
                            <tr>
                                <td>
                                    <p class="col ml-4" style="margin-bottom:0rem;" for="">
                                        {{ $subsector->sector->code . '. ' . $subsector->sector->name }}</p>
                                </td>
                                <td>
                                    <input disabled type="text"
                                        name="adhk_{{ $subsector->id . '_' . $subsector->sector->id . '_' . $subsector->sector->category->id }}"
                                        id="adhk_{{ $subsector->id . '_' . $subsector->sector->id . '_' . $subsector->sector->category->id }}"
                                        class="form-control" aria-required="true">
                                </td>
                            </tr>
                        @endif
                        @if ($subsector->code != null)
                            <tr>
                                <td>
                                    <p class="col ml-5" style="margin-bottom:0rem;"
                                        for="{{ $subsector->code }}_{{ $subsector->name }}">
                                        {{ $subsector->code . '. ' . $subsector->name }}</p>
                                </td>
                                <td>
                                    <input type="text"
                                        name="adhk_{{ $subsector->id . '_' . $subsector->sector->id . '_' . $subsector->sector->category->id }}"
                                        id="adhk_{{ $subsector->id . '_' . $subsector->sector->id . '_' . $subsector->sector->category->id }}"
                                        class="form-control" aria-required="true">
                                </td>
                            </tr>
                        @elseif ($subsector->code == null && $subsector->sector->code != null)
                            <tr>
                                <td>
                                    <p class="col ml-4" style="margin-bottom:0rem;"
                                        for="{{ $subsector->sector->code . '_' . $subsector->sector->name }}">
                                        {{ $subsector->sector->code . '. ' . $subsector->sector->name }}</p>
                                </td>
                                <td>
                                    <input type="text"
                                        name="adhk_{{ $subsector->id . '_' . $subsector->sector->id . '_' . $subsector->sector->category->id }}"
                                        id="adhk_{{ $subsector->id . '_' . $subsector->sector->id . '_' . $subsector->sector->category->id }}"
                                        class="form-control" aria-required="true">
                                </td>
                            </tr>
                        @elseif ($subsector->code == null && $subsector->sector->code == null)
                            <tr>
                                <td>
                                    <label class="col" style="margin-bottom:0rem;"
                                        for="{{ $subsector->sector->category->code . '_' . $subsector->name }}">{{ $subsector->sector->category->code . '. ' . $subsector->name }}</label>
                                </td>
                                <td>
                                    <input type="text"
                                        name="adhk_{{ $subsector->id . '_' . $subsector->sector->id . '_' . $subsector->sector->category->id }}"
                                        id="adhk_{{ $subsector->id . '_' . $subsector->sector->id . '_' . $subsector->sector->category->id }}"
                                        class="form-control" aria-required="true">
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
