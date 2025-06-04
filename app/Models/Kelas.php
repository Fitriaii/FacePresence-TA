<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $table = 'kelas';
    protected $fillable = [
        'nama_kelas',
        'jenis_kelas',
        'tingkatan_siswa',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id', 'id')->withDefault();
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'kelas_id', 'id');
    }

    public function siswa_kelas()
    {
        return $this->hasMany(Siswa_Kelas::class, 'kelas_id', 'id');
    }
}
