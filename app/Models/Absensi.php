<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{   
    protected $table = 'absensis';
    protected $primaryKey = 'id';
    protected $fillable = ['id_karyawan','jam_masuk','jam_keluar','keterangan','pesan','foto','foto_pulang','keterlambatan','created_at','status_ubah'];

    public function karyawan(){
        return $this->hasMany(Karyawan::class, 'id', 'id_karyawan');
    }

    use HasFactory;
}
