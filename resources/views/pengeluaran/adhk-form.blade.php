<div class="card-header">
    <div class="card-tools">
        <button id="copy-adhk" type="button" class="btn btn-warning">
            <i class="fas fa-copy"></i> Salin Data
        </button>
    </div>
</div>

<form id="adhkForm" method="post"  class="form-horizontal">
    <div class="card-body p-3">
        <table class="table table-bordered" id="adhk-table">
            <thead class="text-center" style="background-color: #09c140; color:aliceblue;">
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
                @foreach ($subsectors as $subsector)
                    @if ($subsector->code != null && $subsector->code == 'a' && $subsector->sector->category->type == 'Pengeluaran')
                        <tr>
                            <td>
                                <p class="col ml-4" style="margin-bottom:0rem;" for="">
                                    {{ $subsector->sector->code . '. ' . $subsector->sector->name }}</p>
                            </td>
                            <td class="sectors">
                                <input disabled type="text"
                                    
                                    id="adhk_{{ $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q1' }}"
                                    class="form-control text-right {{ 'adhk-category-Q1-' . $subsector->sector->category->code }}"
                                    aria-required="true">
                            </td>
                            <td class="sectors">
                                <input disabled type="text"
                                    
                                    id="adhk_{{ $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q2' }}"
                                    class="form-control text-right {{ 'adhk-category-Q2-' . $subsector->sector->category->code }}"
                                    aria-required="true">
                            </td>
                            <td class="sectors">
                                <input disabled type="text"
                                    
                                    id="adhk_{{ $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q3' }}"
                                    class="form-control text-right {{ 'adhk-category-Q3-' . $subsector->sector->category->code }}"
                                    aria-required="true">
                            </td>
                            <td class="sectors">
                                <input disabled type="text"
                                    
                                    id="adhk_{{ $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q4' }}"
                                    class="form-control text-right {{ 'adhk-category-Q4-' . $subsector->sector->category->code }}"
                                    aria-required="true">
                            </td>
                            <td class="sectors">
                                <input disabled type="text"
                                    
                                    id="adhk_{{ $subsector->sector->code . '_' . $subsector->sector->category->code . '_Y' }}"
                                    class="form-control text-right {{ 'adhk-category-Y-' . $subsector->sector->category->code }}"
                                    aria-required="true">
                            </td>
                        </tr>
                    @endif
                    @if ($subsector->code != null && $subsector->sector->category->type == 'Pengeluaran')
                        <tr>
                            <td>
                                <p class="col ml-5 mr-4" style="margin-bottom:0rem;"
                                    for="{{ $subsector->code }}_{{ $subsector->name }}">
                                    {{ $subsector->code . '. ' . $subsector->name }}</p>
                            </td>
                            <td>
                                <input type="hidden" name="id_1_{{ $subsector->id }}">
                                <input type="text"
                                    name="adhk_value_1_{{ $subsector->id }}"
                                    id="adhk_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q1' }}"
                                    class="form-control text-right {{ 'adhk-sector-Q1-' . $subsector->sector_id }} {{ 'adhk-category-Q1-' . $subsector->sector->category_id }} "
                                    aria-required="true" tabindex="{{ $subsector->id }}">
                            </td>
                            <td>
                                <input type="hidden" name="id_2_{{ $subsector->id }}">
                                <input type="text"
                                    name="adhk_value_2_{{ $subsector->id }}"
                                    id="adhk_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q2' }}"
                                    class="form-control text-right {{ 'adhk-sector-Q2-' . $subsector->sector_id }} {{ 'adhk-category-Q2-' . $subsector->sector->category_id }}"
                                    aria-required="true" tabindex="{{ $subsector->id + 55 }}">
                            </td>
                            <td>
                                <input type="hidden" name="id_3_{{ $subsector->id }}">
                                <input type="text"
                                    name="adhk_value_3_{{ $subsector->id }}"
                                    id="adhk_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q3' }}"
                                    class="form-control text-right {{ 'adhk-sector-Q3-' . $subsector->sector_id }} {{ 'adhk-category-Q3-' . $subsector->sector->category_id }}"
                                    aria-required="true" tabindex="{{ $subsector->id + 110 }}">
                            </td>
                            <td>
                                <input type="hidden" name="id_4_{{ $subsector->id }}">
                                <input type="text"
                                    name="adhk_value_4_{{ $subsector->id }}"
                                    id="adhk_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q4' }}"
                                    class="form-control text-right {{ 'adhk-sector-Q4-' . $subsector->sector_id }} {{ 'adhk-category-Q4-' . $subsector->sector->category_id }}"
                                    aria-required="true" tabindex="{{ $subsector->id + 165 }}">
                            </td>
                            <td>
                                <input type="hidden" name="id_Y_{{ $subsector->id }}">
                                <input disabled type="text"
                                    name="adhk_value_Y_{{ $subsector->id }}"
                                    id="adhk_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code . '_Y' }}"
                                    class="form-control text-right {{ 'adhk-sector-Y-' . $subsector->sector_id }} {{ 'adhk-category-Y-' . $subsector->sector->category_id }}"
                                    aria-required="true" tabindex="{{ $subsector->id + 220 }}">
                            </td>
                        </tr>
                    @elseif ($subsector->code == null && $subsector->sector->code != null && $subsector->sector->category->type == 'Pengeluaran')
                        <tr>
                            <td>
                                <p class="col ml-4 mr-4" style="margin-bottom:0rem;"
                                    for="{{ $subsector->sector->code . '_' . $subsector->sector->name }}">
                                    {{ $subsector->sector->code . '. ' . $subsector->sector->name }}</p>
                            </td>
                            <td class ="sectors">
                                <input type="hidden" name="id_1_{{ $subsector->id }}">
                                <input type="text"
                                    name="adhk_value_1_{{ $subsector->id }}"
                                    id="adhk_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q1' }}"
                                    class="form-control text-right {{ 'adhk-sector-Q1-' . $subsector->sector_id }} {{ 'adhk-category-Q1-' . $subsector->sector->category_id }}"
                                    aria-required="true" tabindex="{{ $subsector->id }}">
                            </td>
                            <td class ="sectors">
                                <input type="hidden" name="id_2_{{ $subsector->id }}">
                                <input type="text"
                                    name="adhk_value_2_{{ $subsector->id }}"
                                    id="adhk_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q2' }}"
                                    class="form-control text-right {{ 'adhk-sector-Q2-' . $subsector->sector_id }} {{ 'adhk-category-Q2-' . $subsector->sector->category_id }}"
                                    aria-required="true" tabindex="{{ $subsector->id + 55 }}">
                            </td>
                            <td class ="sectors">
                                <input type="hidden" name="id_3_{{ $subsector->id }}">
                                <input type="text"
                                    name="adhk_value_3_{{ $subsector->id }}"
                                    id="adhk_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q3' }}"
                                    class="form-control text-right {{ 'adhk-sector-Q3-' . $subsector->sector_id }} {{ 'adhk-category-Q3-' . $subsector->sector->category_id }}"
                                    aria-required="true" tabindex="{{ $subsector->id + 110 }}">
                            </td>
                            <td class ="sectors">
                                <input type="hidden" name="id_4_{{ $subsector->id }}">
                                <input type="text"
                                    name="adhk_value_4_{{ $subsector->id }}"
                                    id="adhk_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q4' }}"
                                    class="form-control text-right {{ 'adhk-sector-Q4-' . $subsector->sector_id }} {{ 'adhk-category-Q4-' . $subsector->sector->category_id }}"
                                    aria-required="true" tabindex="{{ $subsector->id + 165 }}">
                            </td>
                            <td class ="sectors">
                                <input type="hidden" name="id_Y_{{ $subsector->id }}">
                                <input disabled type="text"
                                    name="adhk_value_Y_{{ $subsector->id }}"
                                    id="adhk_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code . '_Y' }}"
                                    class="form-control text-right {{ 'adhk-sector-Y-' . $subsector->sector_id }} {{ 'adhk-category-Y-' . $subsector->sector->category_id }} sectors"
                                    aria-required="true" tabindex="{{ $subsector->id + 220 }}">
                            </td>
                        </tr>
                    @endif
                @endforeach
                <tr class="PDRB-footer text-center"
                    style="background-color: #09c140; color:aliceblue; font-weight: bold;">
                    <td>
                        <p class="col mt-1 mb-1" style="margin-bottom:0rem;"> Produk Domestik Regional Bruto
                            (PDRB) </p>
                    </td>
                    <td id="adhk_total-Q1" class="total-cell">
                    </td>
                    <td id="adhk_total-Q2" class="total-cell">
                    </td>
                    <td id="adhk_total-Q3" class="total-cell">
                    </td>
                    <td id="adhk_total-Q4" class="total-cell">
                    </td>
                    <td id="adhk_total-Y" class="total-cell">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</form>
