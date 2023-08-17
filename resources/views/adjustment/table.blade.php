<div class="card-body p-3">
    <table class="table table-bordered table-responsive" id="adjust-table">
        <thead class="text-center" style="background-color: #09c140; color:aliceblue;">
            <tr>
                <th class="first" rowspan="2" style="min-width: 300px">Wilayah</th>
                <th colspan="3">ADHB</th>
                <th colspan="3">ADHK</th>
                <th colspan="2">Q-to-Q</th>
                <th colspan="2">Y-on-Y</th>
                <th colspan="2">C-to-C</th>
                <th colspan="2">Laju Imp Q-to-Q</th>
                <th colspan="2">SOG Y-on-Y Thd Total</th>
                <th colspan="2">Kontribusi Thd Total</th>
            </tr>
            <tr>
                <th style="min-width: 100px">Inisial</th>
                <th style="min-width: 100px">Adjustment</th>
                <th style="min-width: 100px">Berjalan</th>
                <th style="min-width: 100px">Inisial</th>
                <th style="min-width: 100px">Adjustment</th>
                <th style="min-width: 100px">Berjalan</th>
                <th style="min-width: 100px">Inisial</th>
                <th style="min-width: 100px">Berjalan</th>
                <th style="min-width: 100px">Inisial</th>
                <th style="min-width: 100px">Berjalan</th>
                <th style="min-width: 100px">Inisial</th>
                <th style="min-width: 100px">Berjalan</th>
                <th style="min-width: 100px">Inisial</th>
                <th style="min-width: 100px">Berjalan</th>
                <th style="min-width: 100px">Inisial</th>
                <th style="min-width: 100px">Berjalan</th>
                <th style="min-width: 100px">Inisial</th>
                <th style="min-width: 100px">Berjalan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($regions as $region)
                @if ($region->id == 1)
                    <tr>
                        <td class="first"><b>{{ $region->name }}</b></td>
                        <td class="adhb-inisial"></td>
                        <td class="adhb-adjust"></td>
                        <td class="adhb-berjalan"></td>
                        <td class="adhk-inisial"></td>
                        <td class="adhk-adjust"></td>
                        <td class="adhk-berjalan"></td>
                        <td class="qtoq-inisial"></td>
                        <td class="qtoq-berjalan"></td>
                        <td class="yony-inisial"></td>
                        <td class="yony-berjalan"></td>
                        <td class="ctoc-inisial"></td>
                        <td class="ctoc-berjalan"></td>
                        <td class="lajuQ-inisial"></td>
                        <td class="lajuQ-berjalan"></td>
                        <td class="sogY-inisial"></td>
                        <td class="sogY-berjalan"></td>
                        <td class="kontribusi-inisial"></td>
                        <td class="kontribusi-berjalan"></td>
                    </tr>
                    <tr>
                        <td class="first"><b>Total Kab/Kota</b></td>
                        <td class="adhb-inisial"></td>
                        <td class="adhb-adjust"></td>
                        <td class="adhb-berjalan"></td>
                        <td class="adhk-inisial"></td>
                        <td class="adhk-adjust"></td>
                        <td class="adhk-berjalan"></td>
                        <td class="qtoq-inisial"></td>
                        <td class="qtoq-berjalan"></td>
                        <td class="yony-inisial"></td>
                        <td class="yony-berjalan"></td>
                        <td class="ctoc-inisial"></td>
                        <td class="ctoc-berjalan"></td>
                        <td class="lajuQ-inisial"></td>
                        <td class="lajuQ-berjalan"></td>
                        <td class="sogY-inisial"></td>
                        <td class="sogY-berjalan"></td>
                        <td class="kontribusi-inisial"></td>
                        <td class="kontribusi-berjalan"></td>
                    </tr>
                    <tr>
                        <td class="first"><b>Selisih Prov dan Total Kab/Kota</b></td>
                        <td class="adhb-inisial"></td>
                        <td class="adhb-adjust"></td>
                        <td class="adhb-berjalan"></td>
                        <td class="adhk-inisial"></td>
                        <td class="adhk-adjust"></td>
                        <td class="adhk-berjalan"></td>
                        <td class="qtoq-inisial"></td>
                        <td class="qtoq-berjalan"></td>
                        <td class="yony-inisial"></td>
                        <td class="yony-berjalan"></td>
                        <td class="ctoc-inisial"></td>
                        <td class="ctoc-berjalan"></td>
                        <td class="lajuQ-inisial"></td>
                        <td class="lajuQ-berjalan"></td>
                        <td class="sogY-inisial"></td>
                        <td class="sogY-berjalan"></td>
                        <td class="kontribusi-inisial"></td>
                        <td class="kontribusi-berjalan"></td>
                    </tr>
                    <tr>
                        <td class="first"><b>% Diskrepansi</b></td>
                        <td class="adhb-inisial"></td>
                        <td class="adhb-adjust"></td>
                        <td class="adhb-berjalan"></td>
                        <td class="adhk-inisial"></td>
                        <td class="adhk-adjust"></td>
                        <td class="adhk-berjalan"></td>
                        <td class="qtoq-inisial"></td>
                        <td class="qtoq-berjalan"></td>
                        <td class="yony-inisial"></td>
                        <td class="yony-berjalan"></td>
                        <td class="ctoc-inisial"></td>
                        <td class="ctoc-berjalan"></td>
                        <td class="lajuQ-inisial"></td>
                        <td class="lajuQ-berjalan"></td>
                        <td class="sogY-inisial"></td>
                        <td class="sogY-berjalan"></td>
                        <td class="kontribusi-inisial"></td>
                        <td class="kontribusi-berjalan"></td>
                    </tr>
                @else
                    <tr>
                        <td class="first">{{ $loop->iteration - 1 . '. ' . $region->name }}</td>
                        <td class="adhb-inisial"></td>
                        <td class="adhb-adjust"><input type="text" class="form-control text-right" name="adhb-adjust" aria-required="true"></td>
                        <td class="adhk-inisial"></td>
                        <td class="adhb-berjalan"></td>
                        <td class="adhk-adjust"><input type="text" class="form-control text-right" name="adhk-adjust" aria-required="true"></td>
                        <td class="adhk-berjalan"></td>
                        <td class="qtoq-inisial"></td>
                        <td class="qtoq-berjalan"></td>
                        <td class="yony-inisial"></td>
                        <td class="yony-berjalan"></td>
                        <td class="ctoc-inisial"></td>
                        <td class="ctoc-berjalan"></td>
                        <td class="lajuQ-inisial"></td>
                        <td class="lajuQ-berjalan"></td>
                        <td class="sogY-inisial"></td>
                        <td class="sogY-berjalan"></td>
                        <td class="kontribusi-inisial"></td>
                        <td class="kontribusi-berjalan"></td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>
