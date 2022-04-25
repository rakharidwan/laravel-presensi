<table>
    <tr>
      <th>No</th>
      <th>Entitas</th>
      <th>Nama</th>
      <th>Jabatan</th>
      <th>Tanggal</th>
      <th>Jam Masuk</th>
      <th>Jam Keluar</th>
      <th>Keterangan</th>
      <th>Keterlambatan</th>
      <th>Pesan</th>
    </tr>
    @foreach ($absensi as $a)
    <tr>
        <td>{{ $loop->iteration }}</td>
        @foreach($a->karyawan as $karyawan)
          <td>{{ $karyawan->entitas }}</td>
          <td>{{ $karyawan->nama }}</td>
          <td>{{ $karyawan->jabatan->jabatan }}</td>
          <td>{{ date('d/m/Y', strtotime($a->created_at)); }}</td>
          @endforeach
          <td>{{ $a->jam_masuk }}</td>
          <td>{{ $a->jam_keluar }}</td>
          <td>{{ $a->keterangan }}</td>
          <td>{{ $a->keterlambatan }} Menit</td>
          <td>{{ $a->pesan }}</td>
    </tr>
    @endforeach
</table>