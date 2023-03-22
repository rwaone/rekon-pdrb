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
        <li class="breadcrumb-item active">Rekonsiliasi</li>
    </x-slot>

    <div class="card">
        <!-- form start -->
        <form class="form-horizontal">
            <div class="card-body">

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="region_id">Kabupaten/Kota:</label>
                    <select id="regionSelect" class="form-control col-sm-10 select2bs4" name="region_id">
                        <option value="" disabled selected>Pilih Kabupaten/Kota</option>
                        @foreach ($regions as $region)
                            <option value="{{$region->id}}">{{$region->name}}</option>
                        @endforeach
                    </select>
                    <div class="help-block"></div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="tahun">Tahun:</label>
                    <select id="tahunSelect" class="form-control col-sm-10 select2bs4" name="tahun">
                        <option value="" disabled selected>Pilih Tahun</option>
                        <option value='2023'>2023</option>
                        <option value='2022'>2022</option>
                    </select>
                    <div class="help-block"></div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="pdrb_id">PDRB:</label>
                    <select id="pdrbSelect" class="form-control col-sm-10 select2bs4" name="pdrb_id">
                        <option value="" disabled selected>Pilih Jenis PDRB</option>
                    </select>
                    <div class="help-block"></div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="period_id">Periode:</label>
                    <select id="periodSelect" class="form-control col-sm-10 select2bs4" name="period_id">
                        <option value="" disabled selected>Pilih Periode</option>
                    </select>
                    <div class="help-block"></div>
                </div>
                <!-- /.card-body -->
            </div>
        </form>
    </div>

    <div class="card">

        <div class="card-body">
            <table id="pdrbTable" class="table">
                <thead>
                    <tr>
                        <th>Rendering engine</th>
                        <th>Browser</th>
                        <th>Platform(s)</th>
                        <th>Engine version</th>
                        <th>CSS grade</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Tasman</td>
                        <td>Internet Explorer 4.5</td>
                        <td>Mac OS 8-9</td>
                        <td>-</td>
                        <td>X</td>
                    </tr>
                    <tr>
                        <td>Tasman</td>
                        <td>Internet Explorer 5.1</td>
                        <td>Mac OS 7.6-9</td>
                        <td>1</td>
                        <td>C</td>
                    </tr>
                    <tr>
                        <td>Tasman</td>
                        <td>Internet Explorer 5.2</td>
                        <td>Mac OS 8-X</td>
                        <td>1</td>
                        <td>C</td>
                    </tr>
                    <tr>
                        <td>Misc</td>
                        <td>NetFront 3.1</td>
                        <td>Embedded devices</td>
                        <td>-</td>
                        <td>C</td>
                    </tr>
                    <tr>
                        <td>Misc</td>
                        <td>NetFront 3.4</td>
                        <td>Embedded devices</td>
                        <td>-</td>
                        <td>A</td>
                    </tr>
                    <tr>
                        <td>Misc</td>
                        <td>Dillo 0.8</td>
                        <td>Embedded devices</td>
                        <td>-</td>
                        <td>X</td>
                    </tr>
                    <tr>
                        <td>Misc</td>
                        <td>Links</td>
                        <td>Text only</td>
                        <td>-</td>
                        <td>X</td>
                    </tr>
                    <tr>
                        <td>Misc</td>
                        <td>Lynx</td>
                        <td>Text only</td>
                        <td>-</td>
                        <td>X</td>
                    </tr>
                    <tr>
                        <td>Misc</td>
                        <td>IE Mobile</td>
                        <td>Windows Mobile 6</td>
                        <td>-</td>
                        <td>C</td>
                    </tr>
                    <tr>
                        <td>Misc</td>
                        <td>PSP browser</td>
                        <td>PSP</td>
                        <td>-</td>
                        <td>C</td>
                    </tr>
                    <tr>
                        <td>Other browsers</td>
                        <td>All others</td>
                        <td>-</td>
                        <td>-</td>
                        <td>U</td>
                    </tr>
                </tbody>
            </table>
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
        <script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
        <script src="../../plugins/jszip/jszip.min.js"></script>
        <script src="../../plugins/pdfmake/pdfmake.min.js"></script>
        <script src="../../plugins/pdfmake/vfs_fonts.js"></script>
        <script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
        <script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
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
