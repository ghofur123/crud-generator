<form class="form-input-create" name="form-create" method="post">
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Create</h1>

        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body modal-form-create">
        <div class="alert alert-warning" role="alert" style="display: none;"></div>
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="id" id="id-form-edit" hidden>
            <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama">
        </div>
        <div class="mb-3">
            <label for="nisn" class="form-label">Nisn</label>
            <input type="text" name="nisn" class="form-control" id="nisn" placeholder="Nisn">
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" name="alamat" class="form-control" id="alamat" placeholder="Alamat">
        </div>
    </div>
    <div class="modal-footer">
        <div class="button-loader-class" style="display:none;">
            <div class="spinner-border spinner-border-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>Loading...
        </div>
        <button type="submit" class="btn btn-primary button-submit-class">Simpan</button>
        <button type="button" class="btn btn-info">Clear</button>
    </div>
</form>