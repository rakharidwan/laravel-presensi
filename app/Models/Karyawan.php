<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{       
    protected $table = 'karyawans';
    protected $primaryKey = 'id';
    protected $fillable = ['id_jabatan','nama','nik','entitas','nomor_hp','foto'];

    public function jabatan(){
        return $this->belongsTo(Jabatan::class,'id_jabatan');
    }

    public function absensi(){
        return $this->belongsTo(Absensi::class);
    }

    use HasFactory;
}
