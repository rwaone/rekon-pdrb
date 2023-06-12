    <form id="fullForm" method="post"  class="form-horizontal">
        <div class="card-body p-3">
            <table class="table table-bordered" id="rekonsiliasi-table">
                <thead class="text-center" style="background-color: #09c140; color:aliceblue;">
                    <tr>
                        <th style="width: 200px">Komponen</th>
                        <th>Triwulan I</th>
                        <th>Triwulan II</th>
                        <th>Triwulan III</th>
                        <th>Triwulan IV</th>
                        <th>Tahunan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subsectors as $subsector)
                        @if (
                            ($subsector->code != null && $subsector->code == 'a' && $subsector->sector->code == '1' && $subsector->sector->category->type == 'Lapangan Usaha') ||
                                ($subsector->code == null && $subsector->sector->code == '1' && $subsector->sector->category->type == 'Lapangan Usaha'))
                            <tr>
                                <td>
                                    <label class="col" style="margin-bottom:0rem;"
                                        for="">{{ $subsector->sector->category->code . '. ' . $subsector->sector->category->name }}</label>
                                </td>
                                <td class="categories">
                                    <input disabled type="text"
                                        name="value_1_{{ $subsector->id }}"
                                        id="adhk_{{ $subsector->sector->category->code . '_Q1' }}"
                                        class="form-control text-right" aria-required="true">
                                </td>
                                <td class="categories">
                                    <input disabled type="text"
                                        name="value_2_{{ $subsector->id }}"
                                        id="adhk_{{ $subsector->sector->category->code . '_Q2' }}"
                                        class="form-control text-right" aria-required="true">
                                </td>
                                <td class="categories">
                                    <input disabled type="text"
                                        name="value_3_{{ $subsector->id }}"
                                        id="adhk_{{ $subsector->sector->category->code . '_Q3' }}"
                                        class="form-control text-right" aria-required="true">
                                </td>
                                <td class="categories">
                                    <input disabled type="text"
                                        name="value_4_{{ $subsector->id }}"
                                        id="adhk_{{ $subsector->sector->category->code . '_Q4' }}"
                                        class="form-control text-right" aria-required="true">
                                </td>
                                <td class="categories">
                                    <input disabled type="text"
                                        name="value_Y_{{ $subsector->id }}"
                                        id="adhk_{{ $subsector->sector->category->code . '_Y' }}"
                                        class="form-control text-right" aria-required="true">
                                </td>
                            </tr>
                        @endif
                        @if ($subsector->code != null && $subsector->code == 'a' && $subsector->sector->category->type == 'Lapangan Usaha')
                            <tr>
                                <td>
                                    <p class="col ml-4" style="margin-bottom:0rem;" for="">
                                        {{ $subsector->sector->code . '. ' . $subsector->sector->name }}</p>
                                </td>
                                <td>
                                    <input disabled type="text"
                                        name="value_1_{{ $subsector->id }}"
                                        id="adhk_{{ $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q1' }}"
                                        class="form-control text-right {{ 'category-Q1-' . $subsector->sector->category->code }}"
                                        aria-required="true">
                                </td>
                                <td>
                                    <input disabled type="text"
                                        name="value_2_{{ $subsector->id }}"
                                        id="adhk_{{ $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q2' }}"
                                        class="form-control text-right {{ 'category-Q2-' . $subsector->sector->category->code }}"
                                        aria-required="true">
                                </td>
                                <td>
                                    <input disabled type="text"
                                        name="value_3_{{ $subsector->id }}"
                                        id="adhk_{{ $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q3' }}"
                                        class="form-control text-right {{ 'category-Q3-' . $subsector->sector->category->code }}"
                                        aria-required="true">
                                </td>
                                <td>
                                    <input disabled type="text"
                                        name="value_4_{{ $subsector->id }}"
                                        id="adhk_{{ $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q4' }}"
                                        class="form-control text-right {{ 'category-Q4-' . $subsector->sector->category->code }}"
                                        aria-required="true">
                                </td>
                                <td>
                                    <input disabled type="text"
                                        name="value_Y_{{ $subsector->id }}"
                                        id="adhk_{{ $subsector->sector->code . '_' . $subsector->sector->category->code . '_Y' }}"
                                        class="form-control text-right {{ 'category-Y-' . $subsector->sector->category->code }}"
                                        aria-required="true">
                                </td>
                            </tr>
                        @endif
                        @if ($subsector->code != null && $subsector->sector->category->type == 'Lapangan Usaha')
                            <tr>
                                <td>
                                    <p class="col ml-5 mr-4" style="margin-bottom:0rem;"
                                        for="{{ $subsector->code }}_{{ $subsector->name }}">
                                        {{ $subsector->code . '. ' . $subsector->name }}</p>
                                </td>
                                <td>
                                    <input type="hidden" name="id_1_{{ $subsector->id }}">
                                    <input type="text"
                                        name="value_1_{{ $subsector->id }}"
                                        id="adhk_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q1' }}"
                                        class="form-control text-right {{ 'sector-Q1-' . $subsector->sector_id }} {{ 'category-Q1-' . $subsector->sector->category_id }} "
                                        aria-required="true" tabindex="{{ $subsector->id }}">
                                </td>
                                <td>
                                    <input type="hidden" name="id_2_{{ $subsector->id }}">
                                    <input type="text"
                                        name="value_2_{{ $subsector->id }}"
                                        id="adhk_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q2' }}"
                                        class="form-control text-right {{ 'sector-Q2-' . $subsector->sector_id }} {{ 'category-Q2-' . $subsector->sector->category_id }}"
                                        aria-required="true" tabindex="{{ $subsector->id + 55 }}">
                                </td>
                                <td>
                                    <input type="hidden" name="id_3_{{ $subsector->id }}">
                                    <input type="text"
                                        name="value_3_{{ $subsector->id }}"
                                        id="adhk_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q3' }}"
                                        class="form-control text-right {{ 'sector-Q3-' . $subsector->sector_id }} {{ 'category-Q3-' . $subsector->sector->category_id }}"
                                        aria-required="true" tabindex="{{ $subsector->id + 110 }}">
                                </td>
                                <td>
                                    <input type="hidden" name="id_4_{{ $subsector->id }}">
                                    <input type="text"
                                        name="value_4_{{ $subsector->id }}"
                                        id="adhk_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q4' }}"
                                        class="form-control text-right {{ 'sector-Q4-' . $subsector->sector_id }} {{ 'category-Q4-' . $subsector->sector->category_id }}"
                                        aria-required="true" tabindex="{{ $subsector->id + 165 }}">
                                </td>
                                <td>
                                    <input type="hidden" name="id_Y_{{ $subsector->id }}">
                                    <input disabled type="text"
                                        name="value_Y_{{ $subsector->id }}"
                                        id="adhk_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code . '_Y' }}"
                                        class="form-control text-right {{ 'sector-Y-' . $subsector->sector_id }} {{ 'category-Y-' . $subsector->sector->category_id }}"
                                        aria-required="true" tabindex="{{ $subsector->id + 220 }}">
                                </td>
                            </tr>
                        @elseif ($subsector->code == null && $subsector->sector->code != null && $subsector->sector->category->type == 'Lapangan Usaha')
                            <tr>
                                <td>
                                    <p class="col ml-4 mr-4" style="margin-bottom:0rem;"
                                        for="{{ $subsector->sector->code . '_' . $subsector->sector->name }}">
                                        {{ $subsector->sector->code . '. ' . $subsector->sector->name }}</p>
                                </td>
                                <td>
                                    <input type="hidden" name="id_1_{{ $subsector->id }}">
                                    <input type="text"
                                        name="value_1_{{ $subsector->id }}"
                                        id="adhk_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q1' }}"
                                        class="form-control text-right {{ 'sector-Q1-' . $subsector->sector_id }} {{ 'category-Q1-' . $subsector->sector->category_id }}"
                                        aria-required="true" tabindex="{{ $subsector->id }}">
                                </td>
                                <td>
                                    <input type="hidden" name="id_2_{{ $subsector->id }}">
                                    <input type="text"
                                        name="value_2_{{ $subsector->id }}"
                                        id="adhk_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q2' }}"
                                        class="form-control text-right {{ 'sector-Q2-' . $subsector->sector_id }} {{ 'category-Q2-' . $subsector->sector->category_id }}"
                                        aria-required="true" tabindex="{{ $subsector->id + 55 }}">
                                </td>
                                <td>
                                    <input type="hidden" name="id_3_{{ $subsector->id }}">
                                    <input type="text"
                                        name="value_3_{{ $subsector->id }}"
                                        id="adhk_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q3' }}"
                                        class="form-control text-right {{ 'sector-Q3-' . $subsector->sector_id }} {{ 'category-Q3-' . $subsector->sector->category_id }}"
                                        aria-required="true" tabindex="{{ $subsector->id + 110 }}">
                                </td>
                                <td>
                                    <input type="hidden" name="id_4_{{ $subsector->id }}">
                                    <input type="text"
                                        name="value_4_{{ $subsector->id }}"
                                        id="adhk_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q4' }}"
                                        class="form-control text-right {{ 'sector-Q4-' . $subsector->sector_id }} {{ 'category-Q4-' . $subsector->sector->category_id }}"
                                        aria-required="true" tabindex="{{ $subsector->id + 165 }}">
                                </td>
                                <td>
                                    <input type="hidden" name="id_Y_{{ $subsector->id }}">
                                    <input disabled type="text"
                                        name="value_Y_{{ $subsector->id }}"
                                        id="adhk_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code . '_Y' }}"
                                        class="form-control text-right {{ 'sector-Y-' . $subsector->sector_id }} {{ 'category-Y-' . $subsector->sector->category_id }}"
                                        aria-required="true" tabindex="{{ $subsector->id + 220 }}">
                                </td>
                            </tr>
                        @elseif ($subsector->code == null && $subsector->sector->code == null && $subsector->sector->category->type == 'Lapangan Usaha')
                            <tr>
                                <td>
                                    <label class="col" style="margin-bottom:0rem;"
                                        for="{{ $subsector->sector->category->code . '_' . $subsector->name }}">{{ $subsector->sector->category->code . '. ' . $subsector->name }}</label>
                                </td>
                                <td>
                                    <input type="hidden" name="id_1_{{ $subsector->id }}">
                                    <input type="text"
                                        name="value_1_{{ $subsector->id }}"
                                        id="adhk_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q1' }}"
                                        class="form-control text-right {{ 'sector-Q1-' . $subsector->sector_id }} {{ 'category-Q1-' . $subsector->sector->category_id }}"
                                        aria-required="true" tabindex="{{ $subsector->id }}">
                                </td>
                                <td>
                                    <input type="hidden" name="id_2_{{ $subsector->id }}">
                                    <input type="text"
                                        name="value_2_{{ $subsector->id }}"
                                        id="adhk_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q2' }}"
                                        class="form-control text-right {{ 'sector-Q2-' . $subsector->sector_id }} {{ 'category-Q2-' . $subsector->sector->category_id }}"
                                        aria-required="true" tabindex="{{ $subsector->id + 55 }}">
                                </td>
                                <td>
                                    <input type="hidden" name="id_3_{{ $subsector->id }}">
                                    <input type="text"
                                        name="value_3_{{ $subsector->id }}"
                                        id="adhk_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q3' }}"
                                        class="form-control text-right {{ 'sector-Q3-' . $subsector->sector_id }} {{ 'category-Q3-' . $subsector->sector->category_id }}"
                                        aria-required="true" tabindex="{{ $subsector->id + 110 }}">
                                </td>
                                <td>
                                    <input type="hidden" name="id_4_{{ $subsector->id }}">
                                    <input type="text"
                                        name="value_4_{{ $subsector->id }}"
                                        id="adhk_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q4' }}"
                                        class="form-control text-right {{ 'sector-Q4-' . $subsector->sector_id }} {{ 'category-Q4-' . $subsector->sector->category_id }}"
                                        aria-required="true" tabindex="{{ $subsector->id + 165 }}">
                                </td>
                                <td>
                                    <input type="hidden" name="id_Y_{{ $subsector->id }}">
                                    <input disabled type="text"
                                        name="value_Y_{{ $subsector->id }}"
                                        id="adhk_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code . '_Y' }}"
                                        class="form-control text-right {{ 'sector-Y-' . $subsector->sector->id }} {{ 'category-Y-' . $subsector->sector->category_id }}"
                                        aria-required="true" tabindex="{{ $subsector->id + 220 }}">
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    <tr class="PDRB-footer text-center"
                        style="background-color: #09c140; color:aliceblue; font-weight: bold;">
                        <td>
                            <p class="col mt-1 mb-1" style="margin-bottom:0rem;"> Produk Domestik Regional Bruto
                                (PDRB) Nonmigas </p>
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
                    <tr class="PDRB-footer text-center"
                        style="background-color: #09c140; color:aliceblue; font-weight: bold;">
                        <td>
                            <p class="col mt-1 mb-1" style="margin-bottom:0rem;"> Produk Domestik Regional Bruto
                                (PDRB) </p>
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
                <button id="fullFormSave" type="button" class="btn btn-info">Simpan</button>
            </div>
        </div>
    </form>
