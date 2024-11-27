<div class="card-body p-3">
    <table class="table table-bordered" id="release-table">
        <thead class="text-center" style="background-color: #09c140; color:aliceblue;">
            <tr>
                <th>Klasifikasi</th>
                <th>Triwulan I</th>
                <th>Triwulan II</th>
                <th>Triwulan III</th>
                <th>Triwulan IV</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($classifications as $classification)
                <tr>
                    <td class="desc-col">
                        <p class="col mt-1 mb-1" style="margin-bottom:0rem;"> {{ $classification->code . '. ' . $classification->name }} </p>
                    </td> 
                    <td id="{{'adhb-' . $classification->code . '-Q1'}}"></td>
                    <td id="{{'adhb-' . $classification->code . '-Q2'}}"></td>
                    <td id="{{'adhb-' . $classification->code . '-Q3'}}"></td>
                    <td id="{{'adhb-' . $classification->code . '-Q4'}}"></td>
                    <td id="{{'adhb-' . $classification->code . '-Y'}}"></td>
                </tr>
            @endforeach
            <tr class="PDRB-footer text-center" style="background-color: #09c140; color:aliceblue; font-weight: bold;">
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
