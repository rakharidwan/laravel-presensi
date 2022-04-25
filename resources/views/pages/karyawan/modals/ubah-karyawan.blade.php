<div class="modal fade" id="modalUbahKaryawan">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ubah Karyawan</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
        </button>
      </div>
      <form action="" method="POST" id="karyawanUpdateForm" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="edit-nik" class="col-form-label">NIK</label>
                <input type="text" name="nik" id="edit-nik" class="form-control" maxlength="15">
                <span class="text-danger error-text nik_error" role="alert"></span>
              </div>
              <div class="form-group">
                <label for="edit-nama" class="col-form-label">Nama</label>
                <input type="text" name="nama" id="edit-nama" class="form-control">
                <span class="text-danger error-text nama_error" role="alert"></span>
              </div>
              <div class="form-group">
                <label for="edit-no-hp" class="col-form-label">No. HP</label>
                <input type="text" name="nomor_hp" id="edit-no-hp" class="form-control" maxlength="15">
                <span class="text-danger error-text nomor_hp_error" role="alert"></span>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="edit-jabatan" class="col-form-label">Jabatan</label>
                <select class="form-control" name="jabatan" id="edit-jabatan">
                  <option>Pilih Jabatan</option>
                  @forelse ($jabatan as $jabatan)
                    <option value="{{ $jabatan->id }}">{{ $jabatan->jabatan }}</option>
                  @empty
                    <option value="">Data Jabatan Tidak Ada</option>
                  @endforelse
                </select>
                <span class="text-danger error-text jabatan_error" role="alert"></span>
              </div>
              <div class="form-group">
                <label for="edit-entitas" class="col-form-label">Entitas</label>
                <input type="text" name="entitas" id="edit-entitas" class="form-control">
                <span class="text-danger error-text entitas_error" role="alert"></span>
              </div>
              <div class="form-group">
                <label for="edit-foto" class="col-form-label">Foto</label>
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" id="edit-foto" name="foto" class="custom-file-input">
                    <label class="custom-file-label">Pilih Foto</label>
                  </div>
                </div>
                <span class="text-danger error-text foto_error" role="alert"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-outline-info btn-xs" id="karyawanUpdateButton">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>