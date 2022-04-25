<div class="modal fade" id="modalTambahJabatan">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Jabatan</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
        </button>
      </div>
      <form action="{{ url('/jabatan/tambah') }}" method="POST" id="jabatanCreateForm">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="jabatan" class="col-form-label">Jabatan</label>
            <input type="text" name="jabatan" id="jabatan" class="form-control">
            <span class="text-danger error-text jabatan_error" role="alert"></span>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-outline-info btn-xs" id="jabatanCreateButton">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>