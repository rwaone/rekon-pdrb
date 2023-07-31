<div class="card-header">
    <div class="card-tools">
        <button id="copy-adhb" type="button" class="btn btn-warning">
            <i class="fas fa-copy"></i> Salin Data
        </button>
    </div>
</div>
<form id="adhbForm" method="post" class="form-horizontal">
    <div class="card-body p-3">
        <table class="table table-bordered table-responsive" id="adhb-table">
            <thead class="text-center" style="background-color: #09c140; color:aliceblue;">
                <tr>
                    <th>Komponen</th>
                    <th>Triwulan I</th>
                    <th>Triwulan II</th>
                    <th>Triwulan III</th>
                    <th>Triwulan IV</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subsectors as $subsector)
                    @if (
                        ($subsector->code != null &&
                            $subsector->code == 'a' &&
                            $subsector->sector->code == '1' &&
                            $subsector->sector->category->type == 'Lapangan Usaha') ||
                            ($subsector->code == null &&
                                $subsector->sector->code == '1' &&
                                $subsector->sector->category->type == 'Lapangan Usaha'))
                        <tr>
                            <td class="desc-col">
                                <label class="col" style="margin-bottom:0rem;"
                                    for="">{{ $subsector->sector->category->code . '. ' . $subsector->sector->category->name }}</label>
                            </td>
                            <td class="categories">
                                <input disabled type="text"
                                    id="adhb_{{ $subsector->sector->category->id . '_Q1' }}"
                                    class="form-control text-right" aria-required="true">
                            </td>
                            <td class="categories">
                                <input disabled type="text"
                                    id="adhb_{{ $subsector->sector->category->id . '_Q2' }}"
                                    class="form-control text-right" aria-required="true">
                            </td>
                            <td class="categories">
                                <input disabled type="text"
                                    id="adhb_{{ $subsector->sector->category->id . '_Q3' }}"
                                    class="form-control text-right" aria-required="true">
                            </td>
                            <td class="categories">
                                <input disabled type="text"
                                    id="adhb_{{ $subsector->sector->category->id . '_Q4' }}"
                                    class="form-control text-right" aria-required="true">
                            </td>
                            <td class="categories">
                                <input disabled type="text" id="adhb_{{ $subsector->sector->category->id . '_T' }}"
                                    class="form-control text-right" aria-required="true">
                            </td>

                        </tr>
                    @endif
                    @if ($subsector->code != null && $subsector->code == 'a' && $subsector->sector->category->type == 'Lapangan Usaha')
                        <tr>
                            <td class="desc-col">
                                <p class="col ml-4" style="margin-bottom:0rem;" for="">
                                    {{ $subsector->sector->code . '. ' . $subsector->sector->name }}</p>
                            </td>
                            <td>
                                <input disabled type="text"
                                    id="adhb_{{ $subsector->sector->id . '_' . $subsector->sector->category->id . '_Q1' }}"
                                    class="form-control text-right {{ 'adhb-category-Q1-' . $subsector->sector->category->code }}"
                                    aria-required="true">
                            </td>
                            <td>
                                <input disabled type="text"
                                    id="adhb_{{ $subsector->sector->id . '_' . $subsector->sector->category->id . '_Q2' }}"
                                    class="form-control text-right {{ 'adhb-category-Q2-' . $subsector->sector->category->code }}"
                                    aria-required="true">
                            </td>
                            <td>
                                <input disabled type="text"
                                    id="adhb_{{ $subsector->sector->id . '_' . $subsector->sector->category->id . '_Q3' }}"
                                    class="form-control text-right {{ 'adhb-category-Q3-' . $subsector->sector->category->code }}"
                                    aria-required="true">
                            </td>
                            <td>
                                <input disabled type="text"
                                    id="adhb_{{ $subsector->sector->id . '_' . $subsector->sector->category->id . '_Q4' }}"
                                    class="form-control text-right {{ 'adhb-category-Q4-' . $subsector->sector->category->code }}"
                                    aria-required="true">
                            </td>
                            <td>
                                <input disabled type="text" name="adhb_sum_{{ $subsector->id }}"
                                    id="adhb_{{ $subsector->sector->id . '_' . $subsector->sector->category->id . '_T' }}"
                                    class="form-control text-right {{ 'adhb-category-T-' . $subsector->sector->category->code }}"
                                    aria-required="true">
                            </td>
                        </tr>
                    @endif
                    @if ($subsector->code != null && $subsector->sector->category->type == 'Lapangan Usaha')
                        <tr>
                            <td class="desc-col">
                                <p class="col ml-5 mr-4" style="margin-bottom:0rem;"
                                    for="{{ $subsector->code }}_{{ $subsector->name }}">
                                    {{ $subsector->code . '. ' . $subsector->name }}</p>
                            </td>
                            <td>
                                <input type="hidden" name="id_1_{{ $subsector->id }}">
                                <input type="text" name="adhb_value_1_{{ $subsector->id }}"
                                    id="adhb_{{ $subsector->id . '_' . $subsector->sector->id . '_' . $subsector->sector->category->id . '_Q1' }}"
                                    class="form-control text-right {{  'adhb-sector-Q1-' . $subsector->sector_id }} {{ 'adhb-category-Q1-' . $subsector->sector->category_id }} "
                                    aria-required="true" tabindex="{{ $subsector->id }}">
                            </td>
                            <td>
                                <input type="hidden" name="id_2_{{ $subsector->id }}">
                                <input type="text" name="adhb_value_2_{{ $subsector->id }}"
                                    id="adhb_{{ $subsector->id . '_' . $subsector->sector->id . '_' . $subsector->sector->category->id . '_Q2' }}"
                                    class="form-control text-right {{  'adhb-sector-Q2-' . $subsector->sector_id }} {{ 'adhb-category-Q2-' . $subsector->sector->category_id }}"
                                    aria-required="true" tabindex="{{ $subsector->id + 55 }}">
                            </td>
                            <td>
                                <input type="hidden" name="id_3_{{ $subsector->id }}">
                                <input type="text" name="adhb_value_3_{{ $subsector->id }}"
                                    id="adhb_{{ $subsector->id . '_' . $subsector->sector->id . '_' . $subsector->sector->category->id . '_Q3' }}"
                                    class="form-control text-right {{  'adhb-sector-Q3-' . $subsector->sector_id }} {{ 'adhb-category-Q3-' . $subsector->sector->category_id }}"
                                    aria-required="true" tabindex="{{ $subsector->id + 110 }}">
                            </td>
                            <td>
                                <input type="hidden" name="id_4_{{ $subsector->id }}">
                                <input type="text" name="adhb_value_4_{{ $subsector->id }}"
                                    id="adhb_{{ $subsector->id . '_' . $subsector->sector->id . '_' . $subsector->sector->category->id . '_Q4' }}"
                                    class="form-control text-right {{  'adhb-sector-Q4-' . $subsector->sector_id }} {{ 'adhb-category-Q4-' . $subsector->sector->category_id }}"
                                    aria-required="true" tabindex="{{ $subsector->id + 165 }}">
                            </td>
                            <td>
                                <input disabled type="text" name="adhb_sum_{{ $subsector->id }}"
                                    id="adhb_{{ $subsector->id . '_' . $subsector->sector->id . '_' . $subsector->sector->category->id . '_T' }}"
                                    class="form-control text-right {{  'adhb-sector-T-' . $subsector->sector_id }} {{ 'adhb-category-T-' . $subsector->sector->category_id }}"
                                    aria-required="true" tabindex="{{ $subsector->id + 220 }}">
                            </td>
                        </tr>
                    @elseif (
                        $subsector->code == null &&
                            $subsector->sector->code != null &&
                            $subsector->sector->category->type == 'Lapangan Usaha')
                        <tr>
                            <td class="desc-col">
                                <p class="col ml-4 mr-4" style="margin-bottom:0rem;"
                                    for="{{ $subsector->sector->code . '_' . $subsector->sector->name }}">
                                    {{ $subsector->sector->code . '. ' . $subsector->sector->name }}</p>
                            </td>
                            <td>
                                <input type="hidden" name="id_1_{{ $subsector->id }}">
                                <input type="text" name="adhb_value_1_{{ $subsector->id }}"
                                    id="adhb_{{ $subsector->id . '_' . $subsector->sector->id . '_' . $subsector->sector->category->id . '_Q1' }}"
                                    class="form-control text-right {{  'adhb-sector-Q1-' . $subsector->sector_id }} {{ 'adhb-category-Q1-' . $subsector->sector->category_id }}"
                                    aria-required="true" tabindex="{{ $subsector->id }}">
                            </td>
                            <td>
                                <input type="hidden" name="id_2_{{ $subsector->id }}">
                                <input type="text" name="adhb_value_2_{{ $subsector->id }}"
                                    id="adhb_{{ $subsector->id . '_' . $subsector->sector->id . '_' . $subsector->sector->category->id . '_Q2' }}"
                                    class="form-control text-right {{  'adhb-sector-Q2-' . $subsector->sector_id }} {{ 'adhb-category-Q2-' . $subsector->sector->category_id }}"
                                    aria-required="true" tabindex="{{ $subsector->id + 55 }}">
                            </td>
                            <td>
                                <input type="hidden" name="id_3_{{ $subsector->id }}">
                                <input type="text" name="adhb_value_3_{{ $subsector->id }}"
                                    id="adhb_{{ $subsector->id . '_' . $subsector->sector->id . '_' . $subsector->sector->category->id . '_Q3' }}"
                                    class="form-control text-right {{  'adhb-sector-Q3-' . $subsector->sector_id }} {{ 'adhb-category-Q3-' . $subsector->sector->category_id }}"
                                    aria-required="true" tabindex="{{ $subsector->id + 110 }}">
                            </td>
                            <td>
                                <input type="hidden" name="id_4_{{ $subsector->id }}">
                                <input type="text" name="adhb_value_4_{{ $subsector->id }}"
                                    id="adhb_{{ $subsector->id . '_' . $subsector->sector->id . '_' . $subsector->sector->category->id . '_Q4' }}"
                                    class="form-control text-right {{  'adhb-sector-Q4-' . $subsector->sector_id }} {{ 'adhb-category-Q4-' . $subsector->sector->category_id }}"
                                    aria-required="true" tabindex="{{ $subsector->id + 165 }}">
                            </td>
                            <td>
                                <input disabled type="text" name="adhb_sum_{{ $subsector->id }}"
                                    id="adhb_{{ $subsector->id . '_' . $subsector->sector->id . '_' . $subsector->sector->category->id . '_T' }}"
                                    class="form-control text-right {{  'adhb-sector-T-' . $subsector->sector_id }} {{ 'adhb-category-T-' . $subsector->sector->category_id }}"
                                    aria-required="true" tabindex="{{ $subsector->id + 220 }}">
                            </td>
                        </tr>
                    @elseif (
                        $subsector->code == null &&
                            $subsector->sector->code == null &&
                            $subsector->sector->category->type == 'Lapangan Usaha')
                        <tr>
                            <td class="desc-col">
                                <label class="col" style="margin-bottom:0rem;"
                                    for="{{ $subsector->sector->category->code . '_' . $subsector->name }}">{{ $subsector->sector->category->code . '. ' . $subsector->name }}</label>
                            </td>
                            <td class="categories">
                                <input type="hidden" name="id_1_{{ $subsector->id }}">
                                <input type="text" name="adhb_value_1_{{ $subsector->id }}"
                                    id="adhb_{{ $subsector->id . '_' . $subsector->sector->id . '_' . $subsector->sector->category->id . '_Q1' }}"
                                    class="form-control text-right {{  'adhb-sector-Q1-' . $subsector->sector_id }} {{ 'adhb-category-Q1-' . $subsector->sector->category_id }}"
                                    aria-required="true" tabindex="{{ $subsector->id }}">
                            </td>
                            <td class="categories">
                                <input type="hidden" name="id_2_{{ $subsector->id }}">
                                <input type="text" name="adhb_value_2_{{ $subsector->id }}"
                                    id="adhb_{{ $subsector->id . '_' . $subsector->sector->id . '_' . $subsector->sector->category->id . '_Q2' }}"
                                    class="form-control text-right {{  'adhb-sector-Q2-' . $subsector->sector_id }} {{ 'adhb-category-Q2-' . $subsector->sector->category_id }}"
                                    aria-required="true" tabindex="{{ $subsector->id + 55 }}">
                            </td>
                            <td class="categories">
                                <input type="hidden" name="id_3_{{ $subsector->id }}">
                                <input type="text" name="adhb_value_3_{{ $subsector->id }}"
                                    id="adhb_{{ $subsector->id . '_' . $subsector->sector->id . '_' . $subsector->sector->category->id . '_Q3' }}"
                                    class="form-control text-right {{  'adhb-sector-Q3-' . $subsector->sector_id }} {{ 'adhb-category-Q3-' . $subsector->sector->category_id }}"
                                    aria-required="true" tabindex="{{ $subsector->id + 110 }}">
                            </td>
                            <td class="categories">
                                <input type="hidden" name="id_4_{{ $subsector->id }}">
                                <input type="text" name="adhb_value_4_{{ $subsector->id }}"
                                    id="adhb_{{ $subsector->id . '_' . $subsector->sector->id . '_' . $subsector->sector->category->id . '_Q4' }}"
                                    class="form-control text-right {{  'adhb-sector-Q4-' . $subsector->sector_id }} {{ 'adhb-category-Q4-' . $subsector->sector->category_id }}"
                                    aria-required="true" tabindex="{{ $subsector->id + 165 }}">
                            </td>
                            <td class="categories">
                                <input disabled type="text" name="adhb_sum_{{ $subsector->id }}"
                                    id="adhb_{{ $subsector->id . '_' . $subsector->sector->id . '_' . $subsector->sector->category->id . '_T' }}"
                                    class="form-control text-right {{  'adhb-sector-T-' . $subsector->sector->id }} {{ 'adhb-category-T-' . $subsector->sector->category_id }}"
                                    aria-required="true" tabindex="{{ $subsector->id + 220 }}">
                            </td>
                        </tr>
                    @endif
                @endforeach
                <tr class="PDRB-footer text-center"
                    style="background-color: #09c140; color:aliceblue; font-weight: bold;">
                    <td class="desc-col">
                        <p class="col mt-1 mb-1" style="margin-bottom:0rem;"> Produk Domestik Regional Bruto
                            (PDRB) Nonmigas </p>
                    </td>
                    <td id="adhb_total-nonmigas-Q1" class="total-cell">
                    </td>
                    <td id="adhb_total-nonmigas-Q2" class="total-cell">
                    </td>
                    <td id="adhb_total-nonmigas-Q3" class="total-cell">
                    </td>
                    <td id="adhb_total-nonmigas-Q4" class="total-cell">
                    </td>
                    <td id="adhb_total-nonmigas-T" class="total-cell">
                    </td>
                </tr>
                <tr class="PDRB-footer text-center"
                    style="background-color: #09c140; color:aliceblue; font-weight: bold;">
                    <td class="desc-col">
                        <p class="col mt-1 mb-1" style="margin-bottom:0rem;"> Produk Domestik Regional Bruto
                            (PDRB) </p>
                    </td>
                    <td id="adhb_total-Q1" class="total-cell">
                    </td>
                    <td id="adhb_total-Q2" class="total-cell">
                    </td>
                    <td id="adhb_total-Q3" class="total-cell">
                    </td>
                    <td id="adhb_total-Q4" class="total-cell">
                    </td>
                    <td id="adhb_total-T" class="total-cell">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="card-footer d-flex pr-3">
        
    </div>
</form>
