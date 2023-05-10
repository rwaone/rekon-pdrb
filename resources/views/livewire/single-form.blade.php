<div class="card">
    <form class="form-horizontal">
        <div class="card-body p-3">
            <table class="table table-striped table-bordered" id="rekonsiliasi-table">
                <thead class="text-center" style="background-color: steelblue; color:aliceblue;">
                    <tr>
                        <th>Komponen</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subsectors as $subsector)
                        @if (
                            ($subsector->code != null && $subsector->code == 'a' && $subsector->sector->code == '1') ||
                                ($subsector->code == null && $subsector->sector->code == '1'))
                            <tr>
                                <td>
                                    <label class="col" style="margin-bottom:0rem;"
                                        for="">{{ $subsector->sector->category->code . '. ' . $subsector->sector->category->name }}</label>
                                </td>
                                <td>
                                    <input disabled type="text"
                                        name="adhk_{{ $subsector->id . '_' . $subsector->sector->id . '_' . $subsector->sector->category->id }}"
                                        id="adhk_{{ $subsector->id . '_' . $subsector->sector->id . '_' . $subsector->sector->category->id }}"
                                        class="form-control" aria-required="true">
                                </td>
                            </tr>
                        @endif
                        @if ($subsector->code != null && $subsector->code == 'a')
                            <tr>
                                <td>
                                    <p class="col ml-4" style="margin-bottom:0rem;" for="">
                                        {{ $subsector->sector->code . '. ' . $subsector->sector->name }}</p>
                                </td>
                                <td>
                                    <input disabled type="text"
                                        name="adhk_{{ $subsector->id . '_' . $subsector->sector->id . '_' . $subsector->sector->category->id }}"
                                        id="adhk_{{ $subsector->id . '_' . $subsector->sector->id . '_' . $subsector->sector->category->id }}"
                                        class="form-control" aria-required="true">
                                </td>
                            </tr>
                        @endif
                        @if ($subsector->code != null)
                            <tr>
                                <td>
                                    <p class="col ml-5" style="margin-bottom:0rem;"
                                        for="{{ $subsector->code }}_{{ $subsector->name }}">
                                        {{ $subsector->code . '. ' . $subsector->name }}</p>
                                </td>
                                <td>
                                    <input type="text"
                                        name="adhk_{{ $subsector->id . '_' . $subsector->sector->id . '_' . $subsector->sector->category->id }}"
                                        id="adhk_{{ $subsector->id . '_' . $subsector->sector->id . '_' . $subsector->sector->category->id }}"
                                        class="form-control" aria-required="true">
                                </td>
                            </tr>
                        @elseif ($subsector->code == null && $subsector->sector->code != null)
                            <tr>
                                <td>
                                    <p class="col ml-4" style="margin-bottom:0rem;"
                                        for="{{ $subsector->sector->code . '_' . $subsector->sector->name }}">
                                        {{ $subsector->sector->code . '. ' . $subsector->sector->name }}</p>
                                </td>
                                <td>
                                    <input type="text"
                                        name="adhk_{{ $subsector->id . '_' . $subsector->sector->id . '_' . $subsector->sector->category->id }}"
                                        id="adhk_{{ $subsector->id . '_' . $subsector->sector->id . '_' . $subsector->sector->category->id }}"
                                        class="form-control" aria-required="true">
                                </td>
                            </tr>
                        @elseif ($subsector->code == null && $subsector->sector->code == null)
                            <tr>
                                <td>
                                    <label class="col" style="margin-bottom:0rem;"
                                        for="{{ $subsector->sector->category->code . '_' . $subsector->name }}">{{ $subsector->sector->category->code . '. ' . $subsector->name }}</label>
                                </td>
                                <td>
                                    <input type="text"
                                        name="adhk_{{ $subsector->id . '_' . $subsector->sector->id . '_' . $subsector->sector->category->id }}"
                                        id="adhk_{{ $subsector->id . '_' . $subsector->sector->id . '_' . $subsector->sector->category->id }}"
                                        class="form-control" aria-required="true">
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer d-flex pr-3">
            <div class="ml-auto">
                <button type="button" class="btn btn-success">Simpan</button>
            </div>
        </div>
    </form>
</div>