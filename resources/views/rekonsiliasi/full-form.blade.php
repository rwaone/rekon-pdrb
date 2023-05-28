    <form id="fullForm" method="post"  class="form-horizontal">
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
                        @if (
                            ($subsect->code != null && $subsect->code == 'a' && $subsect->sector->code == '1') ||
                                ($subsect->code == null && $subsect->sector->code == '1'))
                            <tr>
                                <td>
                                    <label class="col" style="margin-bottom:0rem;"
                                        for="">{{ $subsect->sector->category->code . '. ' . $subsect->sector->category->name }}</label>
                                </td>
                                <td class="categories">
                                    <input disabled type="text"
                                        name="value_1_{{ $subsect->id }}"
                                        id="adhk_{{ $subsect->sector->category->code . '_Q1' }}"
                                        class="form-control text-right" aria-required="true">
                                </td>
                                <td class="categories">
                                    <input disabled type="text"
                                        name="value_2_{{ $subsect->id }}"
                                        id="adhk_{{ $subsect->sector->category->code . '_Q2' }}"
                                        class="form-control text-right" aria-required="true">
                                </td>
                                <td class="categories">
                                    <input disabled type="text"
                                        name="value_3_{{ $subsect->id }}"
                                        id="adhk_{{ $subsect->sector->category->code . '_Q3' }}"
                                        class="form-control text-right" aria-required="true">
                                </td>
                                <td class="categories">
                                    <input disabled type="text"
                                        name="value_4_{{ $subsect->id }}"
                                        id="adhk_{{ $subsect->sector->category->code . '_Q4' }}"
                                        class="form-control text-right" aria-required="true">
                                </td>
                                <td class="categories">
                                    <input disabled type="text"
                                        name="value_Y_{{ $subsect->id }}"
                                        id="adhk_{{ $subsect->sector->category->code . '_Y' }}"
                                        class="form-control text-right" aria-required="true">
                                </td>
                            </tr>
                        @endif
                        @if ($subsect->code != null && $subsect->code == 'a')
                            <tr>
                                <td>
                                    <p class="col ml-4" style="margin-bottom:0rem;" for="">
                                        {{ $subsect->sector->code . '. ' . $subsect->sector->name }}</p>
                                </td>
                                <td>
                                    <input disabled type="text"
                                        name="value_1_{{ $subsect->id }}"
                                        id="adhk_{{ $subsect->sector->code . '_' . $subsect->sector->category->code . '_Q1' }}"
                                        class="form-control text-right {{ 'category-Q1-' . $subsect->sector->category->code }}"
                                        aria-required="true">
                                </td>
                                <td>
                                    <input disabled type="text"
                                        name="value_2_{{ $subsect->id }}"
                                        id="adhk_{{ $subsect->sector->code . '_' . $subsect->sector->category->code . '_Q2' }}"
                                        class="form-control text-right {{ 'category-Q2-' . $subsect->sector->category->code }}"
                                        aria-required="true">
                                </td>
                                <td>
                                    <input disabled type="text"
                                        name="value_3_{{ $subsect->id }}"
                                        id="adhk_{{ $subsect->sector->code . '_' . $subsect->sector->category->code . '_Q3' }}"
                                        class="form-control text-right {{ 'category-Q3-' . $subsect->sector->category->code }}"
                                        aria-required="true">
                                </td>
                                <td>
                                    <input disabled type="text"
                                        name="value_4_{{ $subsect->id }}"
                                        id="adhk_{{ $subsect->sector->code . '_' . $subsect->sector->category->code . '_Q4' }}"
                                        class="form-control text-right {{ 'category-Q4-' . $subsect->sector->category->code }}"
                                        aria-required="true">
                                </td>
                                <td>
                                    <input disabled type="text"
                                        name="value_Y_{{ $subsect->id }}"
                                        id="adhk_{{ $subsect->sector->code . '_' . $subsect->sector->category->code . '_Y' }}"
                                        class="form-control text-right {{ 'category-Y-' . $subsect->sector->category->code }}"
                                        aria-required="true">
                                </td>
                            </tr>
                        @endif
                        @if ($subsect->code != null)
                            <tr>
                                <td>
                                    <p class="col ml-5 mr-4" style="margin-bottom:0rem;"
                                        for="{{ $subsect->code }}_{{ $subsect->name }}">
                                        {{ $subsect->code . '. ' . $subsect->name }}</p>
                                </td>
                                <td>
                                    <input type="hidden" name="id_{{ $subsect->id . '_Q1' }}">
                                    <input type="text"
                                        name="value_1_{{ $subsect->id }}"
                                        id="adhk_{{ $subsect->code . '_' . $subsect->sector->code . '_' . $subsect->sector->category->code . '_Q1' }}"
                                        class="form-control text-right {{ 'sector-Q1-' . $subsect->sector_id }} {{ 'category-Q1-' . $subsect->sector->category_id }} "
                                        aria-required="true" tabindex="{{ $subsect->id }}">
                                </td>
                                <td>
                                    <input type="hidden" name="id_{{ $subsect->id . '_Q2' }}">
                                    <input type="text"
                                        name="value_2_{{ $subsect->id }}"
                                        id="adhk_{{ $subsect->code . '_' . $subsect->sector->code . '_' . $subsect->sector->category->code . '_Q2' }}"
                                        class="form-control text-right {{ 'sector-Q2-' . $subsect->sector_id }} {{ 'category-Q2-' . $subsect->sector->category_id }}"
                                        aria-required="true" tabindex="{{ $subsect->id + 55 }}">
                                </td>
                                <td>
                                    <input type="hidden" name="id_{{ $subsect->id . '_Q3' }}">
                                    <input type="text"
                                        name="value_3_{{ $subsect->id }}"
                                        id="adhk_{{ $subsect->code . '_' . $subsect->sector->code . '_' . $subsect->sector->category->code . '_Q3' }}"
                                        class="form-control text-right {{ 'sector-Q3-' . $subsect->sector_id }} {{ 'category-Q3-' . $subsect->sector->category_id }}"
                                        aria-required="true" tabindex="{{ $subsect->id + 110 }}">
                                </td>
                                <td>
                                    <input type="hidden" name="id_{{ $subsect->id . '_Q4' }}">
                                    <input type="text"
                                        name="value_4_{{ $subsect->id }}"
                                        id="adhk_{{ $subsect->code . '_' . $subsect->sector->code . '_' . $subsect->sector->category->code . '_Q4' }}"
                                        class="form-control text-right {{ 'sector-Q4-' . $subsect->sector_id }} {{ 'category-Q4-' . $subsect->sector->category_id }}"
                                        aria-required="true" tabindex="{{ $subsect->id + 165 }}">
                                </td>
                                <td>
                                    <input type="hidden" name="id_{{ $subsect->id . '_Y' }}">
                                    <input disabled type="text"
                                        name="value_Y_{{ $subsect->id }}"
                                        id="adhk_{{ $subsect->code . '_' . $subsect->sector->code . '_' . $subsect->sector->category->code . '_Y' }}"
                                        class="form-control text-right {{ 'sector-Y-' . $subsect->sector_id }} {{ 'category-Y-' . $subsect->sector->category_id }}"
                                        aria-required="true" tabindex="{{ $subsect->id + 220 }}">
                                </td>
                            </tr>
                        @elseif ($subsect->code == null && $subsect->sector->code != null)
                            <tr>
                                <td>
                                    <p class="col ml-4 mr-4" style="margin-bottom:0rem;"
                                        for="{{ $subsect->sector->code . '_' . $subsect->sector->name }}">
                                        {{ $subsect->sector->code . '. ' . $subsect->sector->name }}</p>
                                </td>
                                <td>
                                    <input type="hidden" name="id_{{ $subsect->id . '_Q1' }}">
                                    <input type="text"
                                        name="value_1_{{ $subsect->id }}"
                                        id="adhk_{{ $subsect->code . '_' . $subsect->sector->code . '_' . $subsect->sector->category->code . '_Q1' }}"
                                        class="form-control text-right {{ 'sector-Q1-' . $subsect->sector_id }} {{ 'category-Q1-' . $subsect->sector->category_id }}"
                                        aria-required="true" tabindex="{{ $subsect->id }}">
                                </td>
                                <td>
                                    <input type="hidden" name="id_{{ $subsect->id . '_Q2' }}">
                                    <input type="text"
                                        name="value_2_{{ $subsect->id }}"
                                        id="adhk_{{ $subsect->code . '_' . $subsect->sector->code . '_' . $subsect->sector->category->code . '_Q2' }}"
                                        class="form-control text-right {{ 'sector-Q2-' . $subsect->sector_id }} {{ 'category-Q2-' . $subsect->sector->category_id }}"
                                        aria-required="true" tabindex="{{ $subsect->id + 55 }}">
                                </td>
                                <td>
                                    <input type="hidden" name="id_{{ $subsect->id . '_Q3' }}">
                                    <input type="text"
                                        name="value_3_{{ $subsect->id }}"
                                        id="adhk_{{ $subsect->code . '_' . $subsect->sector->code . '_' . $subsect->sector->category->code . '_Q3' }}"
                                        class="form-control text-right {{ 'sector-Q3-' . $subsect->sector_id }} {{ 'category-Q3-' . $subsect->sector->category_id }}"
                                        aria-required="true" tabindex="{{ $subsect->id + 110 }}">
                                </td>
                                <td>
                                    <input type="hidden" name="id_{{ $subsect->id . '_Q4' }}">
                                    <input type="text"
                                        name="value_4_{{ $subsect->id }}"
                                        id="adhk_{{ $subsect->code . '_' . $subsect->sector->code . '_' . $subsect->sector->category->code . '_Q4' }}"
                                        class="form-control text-right {{ 'sector-Q4-' . $subsect->sector_id }} {{ 'category-Q4-' . $subsect->sector->category_id }}"
                                        aria-required="true" tabindex="{{ $subsect->id + 165 }}">
                                </td>
                                <td>
                                    <input type="hidden" name="id_{{ $subsect->id . '_Y' }}">
                                    <input disabled type="text"
                                        name="value_Y_{{ $subsect->id }}"
                                        id="adhk_{{ $subsect->code . '_' . $subsect->sector->code . '_' . $subsect->sector->category->code . '_Y' }}"
                                        class="form-control text-right {{ 'sector-Y-' . $subsect->sector_id }} {{ 'category-Y-' . $subsect->sector->category_id }}"
                                        aria-required="true" tabindex="{{ $subsect->id + 220 }}">
                                </td>
                            </tr>
                        @elseif ($subsect->code == null && $subsect->sector->code == null)
                            <tr>
                                <td>
                                    <label class="col" style="margin-bottom:0rem;"
                                        for="{{ $subsect->sector->category->code . '_' . $subsect->name }}">{{ $subsect->sector->category->code . '. ' . $subsect->name }}</label>
                                </td>
                                <td>
                                    <input type="hidden" name="id_{{ $subsect->id . '_Q1' }}">
                                    <input type="text"
                                        name="value_1_{{ $subsect->id }}"
                                        id="adhk_{{ $subsect->code . '_' . $subsect->sector->code . '_' . $subsect->sector->category->code . '_Q1' }}"
                                        class="form-control text-right {{ 'sector-Q1-' . $subsect->sector_id }} {{ 'category-Q1-' . $subsect->sector->category_id }}"
                                        aria-required="true" tabindex="{{ $subsect->id }}">
                                </td>
                                <td>
                                    <input type="hidden" name="id_{{ $subsect->id . '_Q2' }}">
                                    <input type="text"
                                        name="value_2_{{ $subsect->id }}"
                                        id="adhk_{{ $subsect->code . '_' . $subsect->sector->code . '_' . $subsect->sector->category->code . '_Q2' }}"
                                        class="form-control text-right {{ 'sector-Q2-' . $subsect->sector_id }} {{ 'category-Q2-' . $subsect->sector->category_id }}"
                                        aria-required="true" tabindex="{{ $subsect->id + 55 }}">
                                </td>
                                <td>
                                    <input type="hidden" name="id_{{ $subsect->id . '_Q3' }}">
                                    <input type="text"
                                        name="value_3_{{ $subsect->id }}"
                                        id="adhk_{{ $subsect->code . '_' . $subsect->sector->code . '_' . $subsect->sector->category->code . '_Q3' }}"
                                        class="form-control text-right {{ 'sector-Q3-' . $subsect->sector_id }} {{ 'category-Q3-' . $subsect->sector->category_id }}"
                                        aria-required="true" tabindex="{{ $subsect->id + 110 }}">
                                </td>
                                <td>
                                    <input type="hidden" name="id_{{ $subsect->id . '_Q4' }}">
                                    <input type="text"
                                        name="value_4_{{ $subsect->id }}"
                                        id="adhk_{{ $subsect->code . '_' . $subsect->sector->code . '_' . $subsect->sector->category->code . '_Q4' }}"
                                        class="form-control text-right {{ 'sector-Q4-' . $subsect->sector_id }} {{ 'category-Q4-' . $subsect->sector->category_id }}"
                                        aria-required="true" tabindex="{{ $subsect->id + 165 }}">
                                </td>
                                <td>
                                    <input type="hidden" name="id_{{ $subsect->id . '_Y' }}">
                                    <input disabled type="text"
                                        name="value_Y_{{ $subsect->id }}"
                                        id="adhk_{{ $subsect->code . '_' . $subsect->sector->code . '_' . $subsect->sector->category->code . '_Y' }}"
                                        class="form-control text-right {{ 'sector-Y-' . $subsect->sector->id }} {{ 'category-Y-' . $subsect->sector->category_id }}"
                                        aria-required="true" tabindex="{{ $subsect->id + 220 }}">
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    <tr class="PDRB-footer text-center"
                        style="background-color: steelblue; color:aliceblue; font-weight: bold;">
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
                        style="background-color: steelblue; color:aliceblue; font-weight: bold;">
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
