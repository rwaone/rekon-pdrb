    <form action="/pdrb" method="post" class="form-horizontal" id="singleForm">
        <div class="card-body p-3">
            <table class="table table-striped table-bordered" id="rekonsiliasi-table-single-pengeluaran">
                <thead class="text-center" style="background-color: #09c140; color:aliceblue;">
                    <tr>
                        <th>Komponen</th>
                        <th>Nilai</th>
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
                                <td class = "sectors">
                                    <input disabled type="text"
                                        name="{{ $subsector->sector->code . '_' . $subsector->sector->category->code }}"
                                        id="adhk_{{ $subsector->sector->code . '_' . $subsector->sector->category->code }}"
                                        class="form-control text-right {{ 'category-' . $subsector->sector->category->code }}"
                                        aria-required="true">
                                </td>
                            </tr>
                        @endif
                        @if ($subsector->code != null && $subsector->sector->category->type == 'Pengeluaran')
                            <tr>
                                <td>
                                    <p class="col ml-5" style="margin-bottom:0rem;"
                                        for="{{ $subsector->code }}_{{ $subsector->name }}">
                                        {{ $subsector->code . '. ' . $subsector->name }}</p>
                                </td>
                                <input type="hidden" name="id_{{ $subsector->id }}">
                                <input type="hidden" name="subsector_{{ $subsector->id }}"
                                    value="{{ $subsector->id }}">
                                <td>
                                    <input type="text" name="value_{{ $subsector->id }}"
                                        id="adhk_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code }}"
                                        class="form-control text-right {{ 'sector-' . $subsector->sector_id }} {{ 'category-' . $subsector->sector->category_id }}"
                                        aria-required="true">
                                </td>
                            </tr>
                        @elseif ($subsector->code == null && $subsector->sector->code != null && $subsector->sector->category->type == 'Pengeluaran')
                            <tr>
                                <td class = "sectors">
                                    <p class="col ml-4" style="margin-bottom:0rem;"
                                        for="{{ $subsector->sector->code . '_' . $subsector->sector->name }}">
                                        {{ $subsector->sector->code . '. ' . $subsector->sector->name }}</p>
                                </td>
                                <input type="hidden" name="id_{{ $subsector->id }}">
                                <input type="hidden" name="subsector_{{ $subsector->id }}"
                                    value="{{ $subsector->id }}">
                                <td>
                                    <input type="text" name="value_{{ $subsector->id }}"
                                        id="adhk_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code }}"
                                        class="form-control text-right {{ 'sector-' . $subsector->sector_id }} {{ 'category-' . $subsector->sector->category_id }}"
                                        aria-required="true">
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    <tr class="PDRB-footer text-center"
                        style="background-color: #09c140; color:aliceblue; font-weight: bold;">
                        <td>
                            <p class="col mt-1 mb-1" style="margin-bottom:0rem;"> Produk Domestik Regional Bruto (PDRB)
                            </p>
                        </td>
                        <td>
                            <p class="col mt-1 mb-1" id="total" style="margin-bottom:0rem;"></p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer d-flex pr-3">
            <div class="ml-auto">
                <button id="singleFormSave" type="button" class="btn btn-success">Simpan</button>
            </div>
        </div>
    </form>