<div class="modal fade" id="modalUbahJabatan">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ubah Jabatan</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
        </button>
      </div>
      <form action="" method="POST" id="jabatanEditForm">
        @csrf
        @method('patch')
        <div class="modal-body">
          <div class="form-group">
            <label for="edit-jabatan" class="col-form-label">Jabatan</label>
            <div id="editJabatan">
              <input type="text" name="jabatan" id="edit-jabatan" class="form-control">
            </div>
            <span class="text-danger error-text jabatan_error" role="alert"></span>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-outline-info btn-xs" id="jabatanUpdateButton">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>