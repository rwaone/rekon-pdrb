<form class="form-horizontal" id="fenomenaSingleForm">
    <div class="card-body p-3 table-responsive">
        <table class="table table-striped table-bordered" id="rekonsiliasi-table-single">
            <thead class="text-center" style="background-color: #09c140; color:aliceblue;">
                <tr>
                    <th>Komponen</th>
                    <th>Fenomena</th>
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
                                <textarea name="{{ $subsector->sector->category->id }}"
                                    id="fenomena_{{ $subsector->sector->category->id }}" class="form-control" rows="4" cols="50" 
                                    aria-required="true"></textarea>
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
                                <textarea type="text"
                                    name="{{ $subsector->sector->code . '_' . $subsector->sector->category->code }}"
                                    id="fenomena_{{ $subsector->sector->category->id . '_'  . $subsector->sector->id}}"
                                    class="form-control" rows="4" cols="50"  aria-required="true"></textarea>
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
                            <input type="hidden" name="id_{{ $subsector->id }}">
                            <input type="hidden" name="subsector_{{ $subsector->id }}"
                                value="{{ $subsector->id }}">
                            <td>
                                <textarea name="value_{{ $subsector->id }}"
                                    id="adhk_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code }}"
                                    class="form-control" rows="4" cols="50"
                                    aria-required="true"></textarea>
                            </td>
                        </tr>
                    @elseif ($subsector->code == null && $subsector->sector->code != null)
                        <tr>
                            <td>
                                <p class="col ml-4" style="margin-bottom:0rem;"
                                    for="{{ $subsector->sector->code . '_' . $subsector->sector->name }}">
                                    {{ $subsector->sector->code . '. ' . $subsector->sector->name }}</p>
                            </td>
                            <input type="hidden" name="id_{{ $subsector->id }}">
                            <input type="hidden" name="subsector_{{ $subsector->id }}"
                                value="{{ $subsector->id }}">
                            <td>
                                <textarea name="value_{{ $subsector->id }}"
                                    id="adhk_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code }}"
                                    class="form-control" rows="4" cols="50" 
                                    aria-required="true"></textarea>
                            </td>
                        </tr>
                    @elseif ($subsector->code == null && $subsector->sector->code == null)
                        <tr>
                            <td>
                                <label class="col" style="margin-bottom:0rem;"
                                    for="{{ $subsector->sector->category->code . '_' . $subsector->name }}">{{ $subsector->sector->category->code . '. ' . $subsector->name }}</label>
                            </td>
                            <input type="hidden" name="id_{{ $subsector->id }}">
                            <input type="hidden" name="subsector_{{ $subsector->id }}"
                                value="{{ $subsector->id }}">
                            <td>
                                <textarea type="text" name="value_{{ $subsector->id }}"
                                    id="adhk_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code }}"
                                    class="form-control" rows="4" cols="50"
                                    aria-required="true"></textarea>
                            </td>
                        </tr>
                    @endif
                @endforeach
                <tr class="PDRB-footer text-center"
                    style="background-color: #09c140; color:aliceblue; font-weight: bold;">
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