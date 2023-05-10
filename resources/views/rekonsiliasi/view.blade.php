<x-dashboard-Layout>
    <x-slot name="title">
        {{ __('Rekonsiliasi') }}
    </x-slot>
    <x-slot name="head">
        <!-- Additional resources here -->
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2/css/select2.min.css">
        <script></script>
        <style type="text/css">
            .table td {
                vertical-align: middle;
                padding: 0.25rem;
            }

            .table tr:nth-child(even) {
                background-color: ;
            }

            #rekonsiliasi-table td {
                word-wrap:break-word;
            }

            #rekonsiliasi-table td:not(:first-child) {
                text-align: right;
            }
        </style>
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item active">Rekonsiliasi</li>
    </x-slot>
    <div id = "my-cat" data-cat = "{{ json_encode($cat) }}"></div>
    @livewire('rekonsiliasi')

    <x-slot name="script">
        <!-- Additional JS resources -->
        <script src="{{ url('') }}/plugins/select2/js/select2.full.min.js"></script>
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
    </x-slot>
</x-dashboard-Layout>
