

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
                <select id="quarterSelect" class="form-control col-sm-10 select2bs4" name="quarter">
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
            <table class="table table-bordered" id="rekonsiliasi-table">
                <thead class="text-center" style="background-color: steelblue; color:aliceblue;">
                    <tr>
                        <th>Komponen</th>
                        <th>Triwulan I</th>
                        <th>Triwulan II</th>
                        <th>Triwulan III</th>
                        <th>Triwulan IV</th>
                        <th>Tahunan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subsectors as $subsect)
                    @if (($subsect->code != NULL && $subsect->code == "a" && $subsect->sector->code == "1") || ($subsect->code == NULL && $subsect->sector->code == "1"))
                        <tr>
                            <td>
                                <label class="col" style="margin-bottom:0rem;" for="">{{ $subsect->sector->category->code.". ".$subsect->sector->category->name }}</label>
                            </td>
                            <td class="categories">
                                <input disabled type="text" name="adhk_{{ $subsect->sector->category->code."_Q1" }}" id="adhk_{{ $subsect->sector->category->code."_Q1" }}" class="form-control text-right" aria-required="true">
                            </td>
                            <td class="categories">
                                <input disabled type="text" name="adhk_{{ $subsect->sector->category->code."_Q2" }}" id="adhk_{{ $subsect->sector->category->code."_Q2" }}" class="form-control text-right" aria-required="true">
                            </td>
                            <td class="categories">
                                <input disabled type="text" name="adhk_{{ $subsect->sector->category->code."_Q3" }}" id="adhk_{{ $subsect->sector->category->code."_Q3" }}" class="form-control text-right" aria-required="true">
                            </td>
                            <td class="categories">
                                <input disabled type="text" name="adhk_{{ $subsect->sector->category->code."_Q4" }}" id="adhk_{{ $subsect->sector->category->code."_Q4" }}" class="form-control text-right" aria-required="true">
                            </td>
                            <td class="categories">
                                <input disabled type="text" name="adhk_{{ $subsect->sector->category->code."_Y" }}" id="adhk_{{ $subsect->sector->category->code."_Y" }}" class="form-control text-right" aria-required="true">
                            </td>
                        </tr>
                    @endif
                    @if ($subsect->code != NULL && $subsect->code == "a")
                        <tr>
                            <td>
                                <p class="col ml-4" style="margin-bottom:0rem;" for="">{{ $subsect->sector->code.". ".$subsect->sector->name }}</p>
                            </td>
                            <td>
                                <input disabled type="text" name="adhk_{{ $subsect->sector->code."_".$subsect->sector->category->code."_Q1" }}" id="adhk_{{ $subsect->sector->code."_".$subsect->sector->category->code."_Q1" }}" class="form-control text-right {{ "category-Q1-".$subsect->sector->category->code }}" aria-required="true">
                            </td>
                            <td>
                                <input disabled type="text" name="adhk_{{ $subsect->sector->code."_".$subsect->sector->category->code."_Q2" }}" id="adhk_{{ $subsect->sector->code."_".$subsect->sector->category->code."_Q2" }}" class="form-control text-right {{ "category-Q2-".$subsect->sector->category->code }}" aria-required="true">
                            </td>
                            <td>
                                <input disabled type="text" name="adhk_{{ $subsect->sector->code."_".$subsect->sector->category->code."_Q3" }}" id="adhk_{{ $subsect->sector->code."_".$subsect->sector->category->code."_Q3" }}" class="form-control text-right {{ "category-Q3-".$subsect->sector->category->code }}" aria-required="true">
                            </td>
                            <td>
                                <input disabled type="text" name="adhk_{{ $subsect->sector->code."_".$subsect->sector->category->code."_Q4" }}" id="adhk_{{ $subsect->sector->code."_".$subsect->sector->category->code."_Q4" }}" class="form-control text-right {{ "category-Q4-".$subsect->sector->category->code }}" aria-required="true">
                            </td>
                            <td>
                                <input disabled type="text" name="adhk_{{ $subsect->sector->code."_".$subsect->sector->category->code."_Y" }}" id="adhk_{{ $subsect->sector->code."_".$subsect->sector->category->code."_Y" }}" class="form-control text-right {{ "category-Y-".$subsect->sector->category->code }}" aria-required="true">
                            </td>
                        </tr>
                    @endif
                    @if ($subsect->code != NULL)
                        <tr>
                            <td>
                                <p class="col ml-5 mr-4" style="margin-bottom:0rem;" 
                                    for="{{ $subsect->code }}_{{ $subsect->name }}">{{ $subsect->code.". ".$subsect->name }}</p>
                            </td>
                            <td>
                                <input type="text" name="adhk_{{ $subsect->code."_".$subsect->sector->code."_".$subsect->sector->category->code."_Q1" }}" id="adhk_{{ $subsect->code."_".$subsect->sector->code."_".$subsect->sector->category->code."_Q1" }}" class="form-control text-right {{ "sector-Q1-".$subsect->sector_id }} {{ "category-Q1-".$subsect->sector->category_id }} " aria-required="true" tabindex="{{ $subsect->id }}">
                            </td>
                            <td>
                                <input type="text" name="adhk_{{ $subsect->code."_".$subsect->sector->code."_".$subsect->sector->category->code."_Q2" }}" id="adhk_{{ $subsect->code."_".$subsect->sector->code."_".$subsect->sector->category->code."_Q2" }}" class="form-control text-right {{ "sector-Q2-".$subsect->sector_id }} {{ "category-Q2-".$subsect->sector->category_id }}" aria-required="true" tabindex="{{ $subsect->id+55 }}">
                            </td>
                            <td>
                                <input type="text" name="adhk_{{ $subsect->code."_".$subsect->sector->code."_".$subsect->sector->category->code."_Q3" }}" id="adhk_{{ $subsect->code."_".$subsect->sector->code."_".$subsect->sector->category->code."_Q3" }}" class="form-control text-right {{ "sector-Q3-".$subsect->sector_id }} {{ "category-Q3-".$subsect->sector->category_id }}" aria-required="true" tabindex="{{ $subsect->id+110 }}">
                            </td>
                            <td>
                                <input type="text" name="adhk_{{ $subsect->code."_".$subsect->sector->code."_".$subsect->sector->category->code."_Q4" }}" id="adhk_{{ $subsect->code."_".$subsect->sector->code."_".$subsect->sector->category->code."_Q4" }}" class="form-control text-right {{ "sector-Q4-".$subsect->sector_id }} {{ "category-Q4-".$subsect->sector->category_id }}" aria-required="true" tabindex="{{ $subsect->id+165 }}">
                            </td>
                            <td>
                                <input disabled type="text" name="adhk_{{ $subsect->code."_".$subsect->sector->code."_".$subsect->sector->category->code."_Y" }}" id="adhk_{{ $subsect->code."_".$subsect->sector->code."_".$subsect->sector->category->code."_Y" }}" class="form-control text-right {{ "sector-Y-".$subsect->sector_id }} {{ "category-Y-".$subsect->sector->category_id }}" aria-required="true" tabindex="{{ $subsect->id+220 }}">
                            </td>
                        </tr>    
                    @elseif ($subsect->code == NULL && $subsect->sector->code != NULL)
                        <tr>
                            <td>
                                <p class="col ml-4 mr-4" style="margin-bottom:0rem;" 
                                    for="{{ $subsect->sector->code."_".$subsect->sector->name }}">{{ $subsect->sector->code.". ".$subsect->sector->name }}</p>
                            </td>
                            <td>
                                <input type="text" name="adhk_{{ $subsect->code."_".$subsect->sector->code."_".$subsect->sector->category->code."_Q1" }}" id="adhk_{{ $subsect->code."_".$subsect->sector->code."_".$subsect->sector->category->code."_Q1" }}" class="form-control text-right {{ "sector-Q1-".$subsect->sector_id }} {{ "category-Q1-".$subsect->sector->category_id }}" aria-required="true" tabindex="{{ $subsect->id }}">
                            </td>
                            <td>
                                <input type="text" name="adhk_{{ $subsect->code."_".$subsect->sector->code."_".$subsect->sector->category->code."_Q2" }}" id="adhk_{{ $subsect->code."_".$subsect->sector->code."_".$subsect->sector->category->code."_Q2" }}" class="form-control text-right {{ "sector-Q2-".$subsect->sector_id }} {{ "category-Q2-".$subsect->sector->category_id }}" aria-required="true" tabindex="{{ $subsect->id+55 }}">
                            </td>
                            <td>
                                <input type="text" name="adhk_{{ $subsect->code."_".$subsect->sector->code."_".$subsect->sector->category->code."_Q3" }}" id="adhk_{{ $subsect->code."_".$subsect->sector->code."_".$subsect->sector->category->code."_Q3" }}" class="form-control text-right {{ "sector-Q3-".$subsect->sector_id }} {{ "category-Q3-".$subsect->sector->category_id }}" aria-required="true" tabindex="{{ $subsect->id+110 }}">
                            </td>
                            <td>
                                <input type="text" name="adhk_{{ $subsect->code."_".$subsect->sector->code."_".$subsect->sector->category->code."_Q4" }}" id="adhk_{{ $subsect->code."_".$subsect->sector->code."_".$subsect->sector->category->code."_Q4" }}" class="form-control text-right {{ "sector-Q4-".$subsect->sector_id }} {{ "category-Q4-".$subsect->sector->category_id }}" aria-required="true" tabindex="{{ $subsect->id+165 }}">
                            </td>
                            <td>
                                <input disabled type="text" name="adhk_{{ $subsect->code."_".$subsect->sector->code."_".$subsect->sector->category->code."_Y" }}" id="adhk_{{ $subsect->code."_".$subsect->sector->code."_".$subsect->sector->category->code."_Y" }}" class="form-control text-right {{ "sector-Y-".$subsect->sector_id }} {{ "category-Y-".$subsect->sector->category_id }}" aria-required="true" tabindex="{{ $subsect->id+220 }}">
                            </td>
                        </tr>
                    @elseif ($subsect->code == NULL && $subsect->sector->code == NULL)
                        <tr>
                            <td>
                                <label class="col" style="margin-bottom:0rem;" for="{{ $subsect->sector->category->code."_".$subsect->name }}">{{ $subsect->sector->category->code.". ".$subsect->name }}</label>
                            </td>
                            <td>
                                <input type="text" name="adhk_{{ $subsect->code."_".$subsect->sector->code."_".$subsect->sector->category->code."_Q1" }}" id="adhk_{{ $subsect->code."_".$subsect->sector->code."_".$subsect->sector->category->code."_Q1" }}" class="form-control text-right {{ "sector-Q1-".$subsect->sector_id }} {{ "category-Q1-".$subsect->sector->category_id }}" aria-required="true" tabindex="{{ $subsect->id }}">
                            </td>
                            <td>
                                <input type="text" name="adhk_{{ $subsect->code."_".$subsect->sector->code."_".$subsect->sector->category->code."_Q2" }}" id="adhk_{{ $subsect->code."_".$subsect->sector->code."_".$subsect->sector->category->code."_Q2" }}" class="form-control text-right {{ "sector-Q2-".$subsect->sector_id }} {{ "category-Q2-".$subsect->sector->category_id }}" aria-required="true" tabindex="{{ $subsect->id+55 }}">
                            </td>
                            <td>
                                <input type="text" name="adhk_{{ $subsect->code."_".$subsect->sector->code."_".$subsect->sector->category->code."_Q3" }}" id="adhk_{{ $subsect->code."_".$subsect->sector->code."_".$subsect->sector->category->code."_Q3" }}" class="form-control text-right {{ "sector-Q3-".$subsect->sector_id }} {{ "category-Q3-".$subsect->sector->category_id }}" aria-required="true" tabindex="{{ $subsect->id+110 }}">
                            </td>
                            <td>
                                <input type="text" name="adhk_{{ $subsect->code."_".$subsect->sector->code."_".$subsect->sector->category->code."_Q4" }}" id="adhk_{{ $subsect->code."_".$subsect->sector->code."_".$subsect->sector->category->code."_Q4" }}" class="form-control text-right {{ "sector-Q4-".$subsect->sector_id }} {{ "category-Q4-".$subsect->sector->category_id }}" aria-required="true" tabindex="{{ $subsect->id+165 }}">
                            </td>
                            <td>
                                <input disabled type="text" name="adhk_{{ $subsect->code."_".$subsect->sector->code."_".$subsect->sector->category->code."_Y" }}" id="adhk_{{ $subsect->code."_".$subsect->sector->code."_".$subsect->sector->category->code."_Y" }}" class="form-control text-right {{ "sector-Y-".$subsect->sector->id }} {{ "category-Y-".$subsect->sector->category_id }}" aria-required="true" tabindex="{{ $subsect->id+220 }}">
                            </td>
                        </tr>
                    @endif
                    @endforeach
                    <tr class = "PDRB-footer text-center" style="background-color: steelblue; color:aliceblue; font-weight: bold;">
                        <td>
                            <p class="col mt-1 mb-1" style="margin-bottom:0rem;"> Produk Domestik Regional Bruto (PDRB) Nonmigas </p>
                        </td>
                        <td>
                            <p class="col mt-1 mb-1" id="total-nonmigas-Q1" style="margin-bottom:0rem;"></p>
                        </td>
                        <td>
                            <p class="col mt-1 mb-1" id="total-nonmigas-Q2" style="margin-bottom:0rem;"></p>
                        </td>
                        <td>
                            <p class="col mt-1 mb-1" id="total-nonmigas-Q3" style="margin-bottom:0rem;"></p>
                        </td>
                        <td>
                            <p class="col mt-1 mb-1" id="total-nonmigas-Q4" style="margin-bottom:0rem;"></p>
                        </td>
                        <td>
                            <p class="col mt-1 mb-1" id="total-nonmigas-Y" style="margin-bottom:0rem;"></p>
                        </td>
                    </tr>
                    <tr class = "PDRB-footer text-center" style="background-color: steelblue; color:aliceblue; font-weight: bold;">
                        <td>
                            <p class="col mt-1 mb-1" style="margin-bottom:0rem;"> Produk Domestik Regional Bruto (PDRB) </p>
                        </td>
                        <td>
                            <p class="col mt-1 mb-1" id="total-Q1" style="margin-bottom:0rem;"></p>
                        </td>
                        <td>
                            <p class="col mt-1 mb-1" id="total-Q2" style="margin-bottom:0rem;"></p>
                        </td>
                        <td>
                            <p class="col mt-1 mb-1" id="total-Q3" style="margin-bottom:0rem;"></p>
                        </td>
                        <td>
                            <p class="col mt-1 mb-1" id="total-Q4" style="margin-bottom:0rem;"></p>
                        </td>
                        <td>
                            <p class="col mt-1 mb-1" id="total-Y" style="margin-bottom:0rem;"></p>
                        </td>
                    </tr>
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