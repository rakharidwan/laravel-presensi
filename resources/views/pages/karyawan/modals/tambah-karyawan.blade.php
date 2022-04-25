<div class="modal fade" id="modalTambahKaryawan">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Karyawan</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
        </button>
      </div>
      <form action="{{ url('/karyawan/tambah') }}" method="POST" id="karyawanCreateForm" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="nik" class="col-form-label">NIK</label>
                <input type="text" name="nik" id="nik" class="form-control" maxlength="15">
                <span class="text-danger error-text nik_error" role="alert"></span>
              </div>
              <div class="form-group">
                <label for="nama" class="col-form-label">Nama</label>
                <input type="text" name="nama" id="nama" class="form-control">
                <span class="text-danger error-text nama_error" role="alert"></span>
              </div>
              <div class="form-group">
                <label for="no-hp" class="col-form-label">No. HP</label>
                <input type="text" name="nomor_hp" id="no-hp" class="form-control" maxlength="15">
                <span class="text-danger error-text nomor_hp_error" role="alert"></span>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="jabatan" class="col-form-label">Jabatan</label>
                <select class="form-control" name="jabatan" id="jabatan">
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
                <label for="entitas" class="col-form-label">Entitas</label>
                <input type="text" name="entitas" id="entitas" class="form-control">
                <span class="text-danger error-text entitas_error" role="alert"></span>
              </div>
              <div class="form-group">
                <label for="foto" class="col-form-label">Foto</label>
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" id="foto" name="foto" class="custom-file-input">
                    <label class="custom-file-label">Pilih Foto</label>
                  </div>
                </div>
                <span class="text-danger error-text foto_error" role="alert"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-outline-info btn-xs" id="karyawanCreateButton">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>