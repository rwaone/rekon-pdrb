<x-dashboard-Layout>

    <x-slot name="title">
        {{ __('Rekonsiliasi') }}
    </x-slot>

    <x-slot name="head">
        <!-- Additional resources here -->
        <link rel="stylesheet" href="../../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
        <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
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
    </x-slot>

    <x-slot name="breadcrumb">
        <li class="breadcrumb-item active">Jadwal</li>
    </x-slot>

    <div class="card">

        <div class="card-header">
            <div class="card-tools">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-lg">
                    <i class="fas fa-plus"></i> Add
                </button>
            </div>
        </div>

        <div class="card-body">
            <table id="periodTable" class="table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>PDRB</th>
                        <th>Tahun</th>
                        <th>Triwulan</th>
                        <th>Periode</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($periods as $period)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $period->type }}</td>
                            <td>{{ $period->year }}</td>
                            <td>{{ $period->quarter }}</td>
                            <td>{{ $period->description }}</td>
                            <td>{{ $period->year }}</td>
                            <td>{{ $period->started_at }}</td>
                            <td>{{ $period->ended_at }}</td>
                            <td>{{ $period->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="modal fade" id="modal-lg">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Large Modal</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>One fine body&hellip;</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success">Save</button>
                    </div>
                </div>

            </div>
        </div>

        <x-slot name="script">
            <!-- Additional JS resources -->
            <script src="../../plugins/select2/js/select2.full.min.js"></script>
            <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
            <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
            <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
            <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
            <script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
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

                    $("#periodTable").DataTable({
                        "scrollX": true,
                        "ordering": false,
                        "searching": false,
                        "responsive": true,
                        "lengthChange": false,
                        "autoWidth": false,
                    })
                });
            </script>
        </x-slot>

</x-dashboard-Layout>
