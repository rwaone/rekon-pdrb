{{-- @foreach ($monitoring_quarter as $year => $quarters) --}}
<div id="" class="views">
    <h4 class="ml-2 text-bold">Monitoring Pemasukan Tabel PDRB Pengeluaran, <span>Tahun {{ $year_now }} - Triwulan
            {{ $quarter_now }} - {{ $description }}</span></h4>
    {{-- @foreach ($quarters as $quarter => $regions) --}}

    <table class="table table-bordered" id="monitoring-kuarter">
        <thead class="bg-info">
            <th>Kabupaten/Kota</th>
            <th>Status</th>
            {{-- <th>Submit</th> --}}
        </thead>
        <tbody class="bg-white">
            {{-- @foreach ($regions as $region => $item)
                            <tr>
                                <td class = "pl-2">{{ $region }}</td>
                                <td>{{ $item['entry'] }}</td>
                                <td>{{ $item['submit'] }}</td>
                            </tr>
                        @endforeach --}}
            @foreach ($datasets as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td class="text-center"><span class="status">{{ $item['status'] }}</span></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- @endforeach --}}
</div>
{{-- @endforeach --}}
