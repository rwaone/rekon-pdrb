{{-- <div class="card-header">
    <div class="card-tools">
    </div>
</div> --}}
<div class="card-body p-3">
    <table class="table table-bordered" id="rekon-table">
        <thead class="text-center" style="background-color: #09c140; color:aliceblue;">
            <tr>
                <th>Komponen</th>
                <th style="width: 10%">Triwulan I</th>
                <th style="width: 10%">Triwulan II</th>
                <th style="width: 10%">Triwulan III</th>
                <th style="width: 10%">Triwulan IV</th>
                <th style="width: 10%">Total</th>
            </tr>
        </thead>
        <tbody class="text-center">
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
                        <td class="categories" id="value_{{ $subsector->sector->category->code . '_Q1' }}">
                        </td>
                        <td class="categories" id="value_{{ $subsector->sector->category->code . '_Q2' }}">
                        </td>
                        <td class="categories" id="value_{{ $subsector->sector->category->code . '_Q3' }}">
                        </td>
                        <td class="categories" id="value_{{ $subsector->sector->category->code . '_Q4' }}">
                        </td>
                        <td class="categories" id="value_{{ $subsector->sector->category->code . '_T' }}">
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
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
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
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
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
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
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
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                    </tr>
                @endif
            @endforeach
            <tr class="PDRB-footer text-center" style="background-color: #09c140; color:aliceblue; font-weight: bold;">
                <td class="desc-col">
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
                    <p class="col mt-1 mb-1" id="total-nonmigas-T" style="margin-bottom:0rem;"></p>
                </td>
            </tr>
            <tr class="PDRB-footer text-center" style="background-color: #09c140; color:aliceblue; font-weight: bold;">
                <td class="desc-col">
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
                    <p class="col mt-1 mb-1" id="total-T" style="margin-bottom:0rem;"></p>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="card-footer d-flex pr-3">

</div>
