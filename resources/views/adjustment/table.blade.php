<div class="card-header d-flex p-0">
    <ul class="nav nav-pills float-left p-2">
        <li class="nav-item"><a class="nav-link tab-item" data-value="1" id="tab_1" type="button">Triwulan 1</a></li>
        <li class="nav-item"><a class="nav-link tab-item" data-value="2" id="tab_2" type="button">Triwulan 2</a></li>
        <li class="nav-item"><a class="nav-link tab-item" data-value="3" id="tab_3" type="button">Triwulan 3</a></li>
        <li class="nav-item"><a class="nav-link tab-item" data-value="4" id="tab_4" type="button">Triwulan 4</a></li>
        <li class="nav-item"><a class="nav-link tab-item" data-value="5" id="tab_5" type="button">Tahunan</a></li>
    </ul>
</div>
<div class="card-body p-3">
    <form action="adjustForm" method="post">
        <table class="table table-bordered table-responsive" id="adjust-table">
            <thead class="text-center" style="background-color: #09b5c1; color:aliceblue;">
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
                    <th style="min-width: 120px">Adjustment</th>
                    <th style="min-width: 100px">Berjalan</th>
                    <th style="min-width: 100px">Inisial</th>
                    <th style="min-width: 120px">Adjustment</th>
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
                            <td class="text-right adhb-inisial" id="adhb-inisial-{{ $region->id }}"></td>
                            <td class="text-right adhb-adjust"><input id="adhb-adjust-{{ $region->id }}" type="text"
                                class="form-control text-right" name="adhb-adjust-{{ $region->id }}"
                                aria-required="true" disabled></td>
                            <td class="text-right adhb-berjalan" id="adhb-berjalan-{{ $region->id }}"></td>
                            <td class="text-right adhk-inisial" id="adhk-inisial-{{ $region->id }}"></td>
                            <td class="text-right adhk-adjust"><input id="adhk-adjust-{{ $region->id }}" type="text"
                                class="form-control text-right" name="adhk-adjust-{{ $region->id }}"
                                aria-required="true" disabled></td>
                            <td class="text-right adhk-berjalan" id="adhk-berjalan-{{ $region->id }}"></td>
                            <td class="text-right qtoq-inisial" id="qtoq-inisial-{{ $region->id }}"></td>
                            <td class="text-right qtoq-berjalan" id="qtoq-berjalan-{{ $region->id }}"></td>
                            <td class="text-right yony-inisial" id="yony-inisial-{{ $region->id }}"></td>
                            <td class="text-right yony-berjalan" id="yony-berjalan-{{ $region->id }}"></td>
                            <td class="text-right ctoc-inisial" id="ctoc-inisial-{{ $region->id }}"></td>
                            <td class="text-right ctoc-berjalan" id="ctoc-berjalan-{{ $region->id }}"></td>
                            <td class="text-right lajuQ-inisial" id="lajuQ-inisial-{{ $region->id }}"></td>
                            <td class="text-right lajuQ-berjalan" id="lajuQ-berjalan-{{ $region->id }}"></td>
                            <td class="text-right sogY-inisial" id="sogY-inisial-{{ $region->id }}"></td>
                            <td class="text-right sogY-berjalan" id="sogY-berjalan-{{ $region->id }}"></td>
                            <td class="text-right kontribusi-inisial" id="kontribusi-inisial-{{ $region->id }}"></td>
                            <td class="text-right kontribusi-berjalan" id="kontribusi-berjalan-{{ $region->id }}"></td>
                        </tr>
                        <tr>
                            <td class="first"><b>Total Kab/Kota</b></td>
                            <td class="text-right adhb-inisial" id="adhb-inisial-total"></td>
                            <td class="text-right adhb-adjust"></td>
                            <td class="text-right adhb-berjalan" id="adhb-berjalan-total"></td>
                            <td class="text-right adhk-inisial" id="adhk-inisial-total"></td>
                            <td class="text-right adhk-adjust"></td>
                            <td class="text-right adhk-berjalan" id="adhk-berjalan-total"></td>
                            <td class="text-right qtoq-inisial" id="qtoq-inisial-total"></td>
                            <td class="text-right qtoq-berjalan" id="qtoq-berjalan-total"></td>
                            <td class="text-right yony-inisial" id="yony-inisial-total"></td>
                            <td class="text-right yony-berjalan" id="yony-berjalan-total"></td>
                            <td class="text-right ctoc-inisial" id="ctoc-inisial-total"></td>
                            <td class="text-right ctoc-berjalan" id="ctoc-berjalan-total"></td>
                            <td class="text-right lajuQ-inisial" id="lajuQ-inisial-total"></td>
                            <td class="text-right lajuQ-berjalan" id="lajuQ-berjalan-total"></td>
                            <td class="text-right sogY-inisial" id="sogY-inisial-total"></td>
                            <td class="text-right sogY-berjalan" id="sogY-berjalan-total"></td>
                            <td class="text-right kontribusi-inisial" id="kontribusi-inisial-total"></td>
                            <td class="text-right kontribusi-berjalan" id="kontribusi-berjalan-total"></td>
                        </tr>
                        <tr>
                            <td class="first"><b>Selisih Prov dan Total Kab/Kota</b></td>
                            <td class="text-right adhb-inisial" id="adhb-inisial-selisih"></td>
                            <td class="text-right adhb-adjust"></td>
                            <td class="text-right adhb-berjalan" id="adhb-berjalan-selisih"></td>
                            <td class="text-right adhk-inisial" id="adhk-inisial-selisih"></td>
                            <td class="text-right adhk-adjust"></td>
                            <td class="text-right adhk-berjalan" id="adhk-berjalan-selisih"></td>
                            <td class="text-right qtoq-inisial"></td>
                            <td class="text-right qtoq-berjalan"></td>
                            <td class="text-right yony-inisial"></td>
                            <td class="text-right yony-berjalan"></td>
                            <td class="text-right ctoc-inisial"></td>
                            <td class="text-right ctoc-berjalan"></td>
                            <td class="text-right lajuQ-inisial"></td>
                            <td class="text-right lajuQ-berjalan"></td>
                            <td class="text-right sogY-inisial"></td>
                            <td class="text-right sogY-berjalan"></td>
                            <td class="text-right kontribusi-inisial"></td>
                            <td class="text-right kontribusi-berjalan"></td>
                        </tr>
                        <tr>
                            <td class="first"><b>% Diskrepansi</b></td>
                            <td class="text-right adhb-inisial" id="adhb-inisial-diskrepansi"></td>
                            <td class="text-right adhb-adjust"></td>
                            <td class="text-right adhb-berjalan" id="adhb-berjalan-diskrepansi"></td>
                            <td class="text-right adhk-inisial" id="adhk-inisial-diskrepansi"></td>
                            <td class="text-right adhk-adjust"></td>
                            <td class="text-right adhk-berjalan" id="adhk-berjalan-diskrepansi"></td>
                            <td class="text-right qtoq-inisial"></td>
                            <td class="text-right qtoq-berjalan"></td>
                            <td class="text-right yony-inisial"></td>
                            <td class="text-right yony-berjalan"></td>
                            <td class="text-right ctoc-inisial"></td>
                            <td class="text-right ctoc-berjalan"></td>
                            <td class="text-right lajuQ-inisial"></td>
                            <td class="text-right lajuQ-berjalan"></td>
                            <td class="text-right sogY-inisial"></td>
                            <td class="text-right sogY-berjalan"></td>
                            <td class="text-right kontribusi-inisial"></td>
                            <td class="text-right kontribusi-berjalan"></td>
                        </tr>
                    @else
                        <tr>
                            <td class="first">{{ $loop->iteration - 1 . '. ' . $region->name }}</td>
                            <td class="text-right adhb-inisial" id="adhb-inisial-{{ $region->id }}"></td>

                            <td class="adhb-adjust"><input id="adhb-adjust-{{ $region->id }}" type="text"
                                    class="form-control text-right" name="adhb-adjust-{{ $region->id }}"
                                    aria-required="true" ></td>

                            <td class="text-right adhb-berjalan" id="adhb-berjalan-{{ $region->id }}"></td>
                            <td class="text-right adhk-inisial" id="adhk-inisial-{{ $region->id }}"></td>

                            <td class="adhk-adjust"><input id="adhk-adjust-{{ $region->id }}" type="text"
                                    class="form-control text-right" name="adhk-adjust-{{ $region->id }}"
                                    aria-required="true" ></td>
                                    
                            <td class="text-right adhk-berjalan" id="adhk-berjalan-{{ $region->id }}"></td>
                            <td class="text-right qtoq-inisial" id="qtoq-inisial-{{ $region->id }}"></td>
                            <td class="text-right qtoq-berjalan" id="qtoq-berjalan-{{ $region->id }}"></td>
                            <td class="text-right yony-inisial" id="yony-inisial-{{ $region->id }}"></td>
                            <td class="text-right yony-berjalan" id="yony-berjalan-{{ $region->id }}"></td>
                            <td class="text-right ctoc-inisial" id="ctoc-inisial-{{ $region->id }}"></td>
                            <td class="text-right ctoc-berjalan" id="ctoc-berjalan-{{ $region->id }}"></td>
                            <td class="text-right lajuQ-inisial" id="lajuQ-inisial-{{ $region->id }}"></td>
                            <td class="text-right lajuQ-berjalan" id="lajuQ-berjalan-{{ $region->id }}"></td>
                            <td class="text-right sogY-inisial" id="sogY-inisial-{{ $region->id }}"></td>
                            <td class="text-right sogY-berjalan" id="sogY-berjalan-{{ $region->id }}"></td>
                            <td class="text-right kontribusi-inisial" id="kontribusi-inisial-{{ $region->id }}"></td>
                            <td class="text-right kontribusi-berjalan" id="kontribusi-berjalan-{{ $region->id }}"></td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </form>
</div>
