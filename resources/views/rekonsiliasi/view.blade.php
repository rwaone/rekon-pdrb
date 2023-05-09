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
        </style>
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item active">Rekonsiliasi</li>
    </x-slot>

    @livewire('rekonsiliasi')

    <x-slot name="script">
        <!-- Additional JS resources -->
        <script src="{{ url('') }}/plugins/select2/js/select2.full.min.js"></script>
        <script>
            
            $(document).on('focus', '.select2-selection', function(e) {
                $(this).closest(".select2-container").siblings('select:enabled').select2('open');
            })
            
           function calculateSector(sector) {
            let sum = 0;
            $(`.${sector}`).each(function(index){
                sum += $(this).val()>0 ? Number($(this).val()) :0;
            });
            return sum;
           }
            $(document).ready(function() {
			// Your jQuery code goes here
                for (let i = 1; i < 5; i++) {
                    $(`.sector-Q${i}-1`).keyup(function(e) {
                        let jumlah = calculateSector(`sector-Q${i}-1`);
                        $(`#adhk_1_A_Q${i}`).val(jumlah)
                    });

                    $(`.category-Q${i}-1`).keyup(function(e) {
                        let jumlah = calculateSector(`category-Q${i}-1`);
                        $(`#adhk_A_Q${i}`).val(jumlah)
                    });
                    
                    $(`.sector-Q${i}-1`).keypress(function(e) {
                        var charCode = (e.which) ? e.which : event.keyCode
                        if (String.fromCharCode(charCode).match(/[^0-9]/g))    
                        return false;
                    })
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
            });
        </script>
    </x-slot>
</x-dashboard-Layout>
