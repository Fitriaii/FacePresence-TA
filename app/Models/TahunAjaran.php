<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $table = 'tahun_ajaran';
    protected $fillable = [
        'tahun_ajaran',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
    ];

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'tahun_ajaran_id', 'id');
    }
    public function siswa_kelas()
    {
        return $this->hasMany(Siswa_Kelas::class, 'tahun_ajaran_id', 'id');
    }
}
