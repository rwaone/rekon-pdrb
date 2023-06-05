<div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
        <form action="/user" method="post">
            @csrf
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Add New User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label for="name-text" class="col-form-label">Nama:</label>
                        <input type="text" class="form-control" id="name-text" name="name"
                            placeholder="Nama">
                    </div>

                    <div class="form-group">
                        <label for="username-text" class="col-form-label">Username:</label>
                        <input type="text" class="form-control" id="username-text" name="username"
                            placeholder="Username">
                    </div>

                    <div class="form-group">
                        <label for="email-text" class="col-form-label">E-Mail:</label>
                        <input type="text" class="form-control" id="email-text" name="email"
                            placeholder="E-Mail">
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="satkerSelect">Satuan Kerja:</label>
                        <select id="satkerSelect" class="form-control select2bs4" style="width: 100%;"
                            name="satker_id">
                            <option value="" disabled selected>Pilih Satuan Kerja</option>
                            @foreach ($satkers as $satker)
                                <option value='{{$satker->id}}'>{{$satker->name}}</option>
                            @endforeach
                        </select>
                        <div class="help-block"></div>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </div>

        </form>
    </div>
</div>