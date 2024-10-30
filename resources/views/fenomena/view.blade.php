<x-dashboard-Layout>
    <x-slot name="title">
        {{ __('Fenomena') }}
    </x-slot>
    <x-slot name="head">
        <!-- Additional resources here -->
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
        <script></script>
        <style type="text/css">
            .table td {
                vertical-align: middle;
                padding: 0.25rem;
            }

            #btn-back-to-top {
                position: fixed;
                bottom: 20px;
                right: 20px;
                display: none;
                border-radius: 100%
            }
        </style>
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item active">Fenomena</li>
    </x-slot>

    @include('fenomena.filter')
    <span class="loader d-none"></span>

    <div id="fenomenaFormContainer" class="card">
        @include('fenomena.single-form')
    </div>


    <!-- Back to top button -->
    <button type="button" class="btn btn-light btn-floating btn-lg" id="btn-back-to-top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <x-slot name="script">
        <!-- Additional JS resources -->
        <script src="{{ url('') }}/plugins/select2/js/select2.full.min.js"></script>
        <script src="{{ url('') }}/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="{{ asset('js/fenomena.js') }}"></script>
        <script>
            //Get the button
            let mybutton = document.getElementById("btn-back-to-top");
            let url_key = window.location.pathname
            let thisType
            thisType = url_key.split('/')[1];
            const tokens = '{{ csrf_token() }}'
            const fetchYear = '{{ route("fetchYear") }}'
            const getFenomena = '{{ route("getFenomena") }}'
            const saveFenomena = '{{ route("saveFenomena") }}'

            $(document).on('focus', '.select2-selection', function(e) {
                $(this).closest(".select2-container").siblings('select:enabled').select2('open');
            })

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
