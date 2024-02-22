<div class="card-body p-3">
    <table class="table table-bordered" id="rekon-table">
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
                        <td class="sectors" id="value_{{ $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q1' }}">
                        </td>
                        <td class="sectors" id="value_{{ $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q2' }}">
                        </td>
                        <td class="sectors" id="value_{{ $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q3' }}">
                        </td>
                        <td class="sectors" id="value_{{ $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q4' }}">
                        </td>
                        <td class="sectors" id="value_{{ $subsector->sector->code . '_' . $subsector->sector->category->code . '_Y' }}">
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
                        <td  id="value_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q1' }}">
                        </td>
                        <td id="value_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q2' }}">
                        </td>
                        <td id="value_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q3' }}">
                        </td>
                        <td id="value_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q4' }}">
                        </td>
                        <td id="value_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code . '_Y' }}">
                        </td>
                    </tr>
                @elseif ($subsector->code == null && $subsector->sector->code != null && $subsector->sector->category->type == 'Pengeluaran')
                    <tr>
                        <td>
                            <p class="col ml-4 mr-4" style="margin-bottom:0rem;"
                                for="{{ $subsector->sector->code . '_' . $subsector->sector->name }}">
                                {{ $subsector->sector->code . '. ' . $subsector->sector->name }}</p>
                        </td>
                        <td class="sectors" id="value_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q1' }}">
                        </td>
                        <td class="sectors" id="value_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q2' }}">
                        </td>
                        <td class="sectors" id="value_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q3' }}">
                        </td>
                        <td class="sectors" id="value_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code . '_Q4' }}">
                        </td>
                        <td class="sectors" id="value_{{ $subsector->code . '_' . $subsector->sector->code . '_' . $subsector->sector->category->code . '_Y' }}">
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
                <td id="value_total-Q1" class="total-cell">
                </td>
                <td id="value_total-Q2" class="total-cell">
                </td>
                <td id="value_total-Q3" class="total-cell">
                </td>
                <td id="value_total-Q4" class="total-cell">
                </td>
                <td id="value_total-Y" class="total-cell">
                </td>
            </tr>
        </tbody>
    </table>
</div>
