<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{   
    protected $table = 'jabatans';
    protected $primaryKey = 'id';
    protected $fillable = ['jabatan'];

    public function karyawan(){
        return $this->hasOne(Karyawan::class);
    }

    use HasFactory;
}
