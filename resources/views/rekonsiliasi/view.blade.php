<x-dashboard-Layout>

    <x-slot name="title">
        {{ __('Rekonsiliasi') }}
    </x-slot>
    <x-slot name="head">
        <!-- Additional resources here -->
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="{{ url('') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
        <script nonce="326d0a6f-467a-4c36-84e6-ac3d7ab6c268">
            (function(w, d) {
                ! function(bv, bw, bx, by) {
                    bv[bx] = bv[bx] || {};
                    bv[bx].executed = [];
                    bv.zaraz = {
                        deferred: [],
                        listeners: []
                    };
                    bv.zaraz.q = [];
                    bv.zaraz._f = function(bz) {
                        return function() {
                            var bA = Array.prototype.slice.call(arguments);
                            bv.zaraz.q.push({
                                m: bz,
                                a: bA
                            })
                        }
                    };
                    for (const bB of ["track", "set", "debug"]) bv.zaraz[bB] = bv.zaraz._f(bB);
                    bv.zaraz.init = () => {
                        var bC = bw.getElementsByTagName(by)[0],
                            bD = bw.createElement(by),
                            bE = bw.getElementsByTagName("title")[0];
                        bE && (bv[bx].t = bw.getElementsByTagName("title")[0].text);
                        bv[bx].x = Math.random();
                        bv[bx].w = bv.screen.width;
                        bv[bx].h = bv.screen.height;
                        bv[bx].j = bv.innerHeight;
                        bv[bx].e = bv.innerWidth;
                        bv[bx].l = bv.location.href;
                        bv[bx].r = bw.referrer;
                        bv[bx].k = bv.screen.colorDepth;
                        bv[bx].n = bw.characterSet;
                        bv[bx].o = (new Date).getTimezoneOffset();
                        if (bv.dataLayer)
                            for (const bI of Object.entries(Object.entries(dataLayer).reduce(((bJ, bK) => ({
                                    ...bJ[1],
                                    ...bK[1]
                                }))))) zaraz.set(bI[0], bI[1], {
                                scope: "page"
                            });
                        bv[bx].q = [];
                        for (; bv.zaraz.q.length;) {
                            const bL = bv.zaraz.q.shift();
                            bv[bx].q.push(bL)
                        }
                        bD.defer = !0;
                        for (const bM of [localStorage, sessionStorage]) Object.keys(bM || {}).filter((bO => bO
                            .startsWith("_zaraz_"))).forEach((bN => {
                            try {
                                bv[bx]["z_" + bN.slice(7)] = JSON.parse(bM.getItem(bN))
                            } catch {
                                bv[bx]["z_" + bN.slice(7)] = bM.getItem(bN)
                            }
                        }));
                        bD.referrerPolicy = "origin";
                        bD.src = "/cdn-cgi/zaraz/s.js?z=" + btoa(encodeURIComponent(JSON.stringify(bv[bx])));
                        bC.parentNode.insertBefore(bD, bC)
                    };
                    ["complete", "interactive"].includes(bw.readyState) ? zaraz.init() : bv.addEventListener(
                        "DOMContentLoaded", zaraz.init)
                }(w, d, "zarazData", "script");
            })(window, document);
        </script>
        <style type="text/css">
            .table td {
                vertical-align: middle;
                padding: 0.25rem;
            }

            .table tr:nth-child(even) {
                background-color: ;
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
        <script src="{{ url('') }}/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="{{ url('') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="{{ url('') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
        <script src="{{ url('') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
        <script src="{{ url('') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
        <script src="{{ url('') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
        <script src="{{ url('') }}/plugins/jszip/jszip.min.js"></script>
        <script src="{{ url('') }}/plugins/pdfmake/pdfmake.min.js"></script>
        <script src="{{ url('') }}/plugins/pdfmake/vfs_fonts.js"></script>
        <script src="{{ url('') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
        <script src="{{ url('') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
        <script>
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
