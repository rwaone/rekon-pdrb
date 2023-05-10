<div>
    <div class="card">

        <!-- form start -->
        <div class="card-body">
            {{-- 
            <div class="form-group">
                <label for="description-text" class="col-form-label">Keterangan:</label>
                <input wire:model="message" type="text" class="form-control" placeholder="Keterangan Putaran">
            </div>

            {{ $message }} --}}

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="pdrb_type">PDRB:</label>
                <select wire:model="selectedPdrb" class="form-control col-sm-10">
                    <option value="">Pilih Jenis PDRB</option>
                    <option value='Lapangan Usaha'>Lapangan Usaha</option>
                    <option value='Pengeluaran'>Pengeluaran</option>
                </select>
                <div class="help-block"></div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="year">Tahun:</label>
                <select wire:model="selectedYear" class="form-control col-sm-10">
                    <option value="">Pilih Tahun</option>
                    @foreach ($years as $year)
                        <option value="{{ $year->year }}">{{ $year->year }}</option>
                    @endforeach
                </select>
                <div class="help-block"></div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="quarter">Triwulan:</label>
                <select wire:model="selectedQuarter" class="form-control col-sm-10">
                    <option value="">Pilih Triwulan</option>
                    @foreach ($quarters as $quarter)
                        <option value="{{ $quarter->quarter }}">{{ $quarter->quarter }}</option>
                    @endforeach
                    {{-- <option value='1'>Triwulan 1</option>
                    <option value='2'>Triwulan 2</option>
                    <option value='3'>Triwulan 3</option>
                    <option value='4'>Triwulan 4</option> --}}
                </select>
                <div class="help-block"></div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="period_id">Periode:</label>
                <select wire:model="selectedPeriod" class="form-control col-sm-10">
                    <option value="">Pilih Periode</option>
                    @foreach ($periods as $period)
                        <option value="{{ $period->id }}">{{ $period->description }}</option>
                    @endforeach
                </select>
                <div class="help-block"></div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="region_id">Kabupaten/Kota:</label>
                <select wire:model="region_id" id="regionSelect" class="form-control col-sm-10" name="region_id">
                    <option value="">Pilih Kabupaten/Kota</option>
                    @foreach ($regions as $region)
                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                    @endforeach
                </select>
                <div class="help-block"></div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="price_base">Basis Harga:</label>
                <select wire:model="price_base" class="form-control col-sm-10" name="price_base">
                    <option value="">Pilih Basis Harga</option>
                    <option value='adhk'>Atas Dasar Harga Konstan</option>
                    <option value='adhb'>Atas Dasar Harga Berlaku</option>
                </select>
                <div class="help-block"></div>
            </div>
            <!-- /.card-body -->
            {{$showFormComponent}}
            <button wire:click="showForm" class="btn btn-info float-right">Tampilkan</button>
        </div>
    </div>

    @if ($showFormComponent == 'showFull')
        <div>
            @include('livewire.full-form')
        </div>
    @endif

    @if ($showFormComponent == 'showSingle')
        <div>
            @include('livewire.single-form')
        </div>
    @endif

    <script>
            
        $(document).on('focus', '.select2-selection', function(e) {
            $(this).closest(".select2-container").siblings('select:enabled').select2('open');
        })
        
        function inputToCurrency(num){
            const val = num.replaceAll(",","");
            const return_ = Number(val).toLocaleString('en-US');
            console.log(return_);
            return val.toLocaleString('en-US');
        }

        function calculateSector(sector) {
            let sum = 0;
            // let sector = sector.replaceAll(",","");
            $(`.${sector}`).each(function(index){
                let X = $(this).val().replaceAll(/[A-Za-z.]/g,'');
                let Y = X.replaceAll(/[,]/g, '.')
                sum += Y > 0 ? Number(Y) :0;
            });
            return sum;
        }
        
        function calculateRow(row) {
            let sum = 0;

        }

        function formatRupiah(angka, prefix)
        {
            var number_string = String(angka).replace(/[^,\d]/g, '').toString(),
                split    = number_string.split(','),
                sisa     = split[0].length % 3,
                rupiah     = split[0].substr(0, sisa),
                ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
                
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            
            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

                  

        $(document).ready(function() {
        // Your jQuery code goes here
            // let cat = JSON.parse($("#my-cat").data('cat'))
            // let catArray = cat.split(", ")
            let cat = "A,B,C,D,G,H,I,K"
            let catArray = cat.split(",")
            let sum = 0

            let table = $('#rekonsiliasi-table');
            let tbody = table.find('tbody');
            let tr = tbody.find('tr');

            tr.on('blur', 'td input', function(e) {
                let sum = 0;
                let $currentRow = $(this).closest('tr');
                let $lastCol = $currentRow.find('td:last');
                $currentRow.find('td:not(:last-child) input').each(function () {
                    let X = $(this).val().replaceAll(/[A-Za-z.]/g,'');
                    let Y = X.replaceAll(/[,]/g, '.');
                    sum += Y > 0 ? Number(Y) : 0;
                });
                let sumRp = String(sum).replaceAll(/[.]/g, ',');
                $lastCol.find('input').val(formatRupiah(sumRp, 'Rp '));

                for (let index of catArray) {
                    let darksum = 0
                    let lightsum = 0

                    let row = $(`#adhk_${index}_Y`).closest('tr')
                    let subsection = $(`#adhk_1_${index}_Y`).closest('tr')
                    
                    row.find('td input:not(#adhk_'+index+'_Y)').each(function (){
                        if (!$(this).hasClass(`adhk_${index}_Y`)) {
                            let X = $(this).val().replaceAll(/[A-Za-z.]/g,'');
                            let Y = X.replaceAll(/[,]/g, '.');
                            darksum += Y > 0 ? Number(Y) : 0;
                        }
                    })

                    subsection.find('td input:not(#adhk_1_'+index+'_Y)').each(function (){
                        if (!$(this).hasClass(`adhk_${index}_Y`)) {
                            let X = $(this).val().replaceAll(/[A-Za-z.]/g,'');
                            let Y = X.replaceAll(/[,]/g, '.');
                            lightsum += Y > 0 ? Number(Y) : 0;
                        }
                    })
                    
                    let lightsumRp = String(darksum).replaceAll(/[.]/g, ','); 
                    let darksumRp = String(darksum).replaceAll(/[.]/g, ',');
                    $(`#adhk_1_${index}_Y`).val(formatRupiah(lightsumRp, 'Rp '))
                    $(`#adhk_${index}_Y`).val(formatRupiah(darksumRp, 'Rp '))
                }   

            });
            
            for (let i = 1; i < 5; i++) {
                $(`.sector-Q${i}-1`).keyup(function(e) {
                    // $(this).val(inputToCurrency(e.currentTarget.value));
                    let jumlah = calculateSector(`sector-Q${i}-1`);
                    let que = String(jumlah).replaceAll(/[.]/g, ',');
                    $(`#adhk_1_A_Q${i}`).val(formatRupiah(que, 'Rp '));
                });
                $(`.sector-Q${i}-8`).keyup(function(e) {
                    let jumlah = calculateSector(`sector-Q${i}-8`);
                    let que = String(jumlah).replaceAll(/[.]/g, ',');
                    $(`#adhk_1_C_Q${i}`).val(formatRupiah(que, 'Rp '))
                });
                for (let j = 1; j < 18; j++) {
                    $(`.category-Q${i}-${j}`).keyup(function(e) {
                        let jumlah = calculateSector(`category-Q${i}-${j}`);
                        let que = String(jumlah).replaceAll(/[.]/g, ',');
                        $(`#adhk_${catArray[j-1]}_Q${i}`).val(formatRupiah(que, 'Rp '))
                    });
                }
                for (let j = 1; j < 49; j++) {
                    $(`.sector-Q${i}-${j}`).keyup(function(e) {
                        $(this).val(formatRupiah($(this).val(), 'Rp '))
                        var charCode = (e.which) ? e.which : event.keyCode
                        if (String.fromCharCode(charCode).match(/[^0-9.,]/g))    
                        return false;
                    })
                }
            }
        });

        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            $("#pdrbTable").DataTable({
                "scrollX": true,
                "ordering": false,
                "searching": true,
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf"]
            }).buttons().container().appendTo('#pdrbTable_wrapper .col-md-6:eq(0)');
        });
    </script>
</div>
