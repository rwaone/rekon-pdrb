<div class="card">
    <form action="/pdrb" method="post" class="form-horizontal" id="singleForm">
        @csrf
        <div class="card-body p-3">
            <table class="table table-striped table-bordered" id="rekonsiliasi-table-single">
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
                                <td class="categories">
                                    <input disabled type="text" name="{{ $subsector->sector->category->code }}"
                                        id="adhk_{{ $subsector->sector->category->code }}" class="form-control"
                                        aria-required="true">
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
                                        name="{{ $subsector->sector->code . '_' . $subsector->sector->category->code }}"
                                        id="adhk_{{ $subsector->sector->code . '_' . $subsector->sector->category->code }}"
                                        class="form-control {{ 'category-' . $subsector->sector->category->code }}"
                                        aria-required="true">
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
                                        name="{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code }}"
                                        id="adhk_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code }}"
                                        class="form-control {{ 'sector-' . $subsector->sector_id }} {{ 'category-' . $subsector->sector->category_id }}"
                                        aria-required="true">
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
                                        name="{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code }}"
                                        id="adhk_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code }}"
                                        class="form-control {{ 'sector-' . $subsector->sector_id }} {{ 'category-' . $subsector->sector->category_id }}"
                                        aria-required="true">
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
                                        name="{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code }}"
                                        id="adhk_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code }}"
                                        class="form-control {{ 'sector-' . $subsector->sector_id }} {{ 'category-' . $subsector->sector->category_id }}"
                                        aria-required="true">
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    <tr class="PDRB-footer text-center"
                        style="background-color: steelblue; color:aliceblue; font-weight: bold;">
                        <td>
                            <p class="col mt-1 mb-1" style="margin-bottom:0rem;"> Produk Domestik Regional Bruto (PDRB)
                                Nonmigas </p>
                        </td>
                        <td>
                            <p class="col mt-1 mb-1" id="total-nonmigas" style="margin-bottom:0rem;"></p>
                        </td>
                        </td>
                    </tr>
                    <tr class="PDRB-footer text-center"
                        style="background-color: steelblue; color:aliceblue; font-weight: bold;">
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
</div>
