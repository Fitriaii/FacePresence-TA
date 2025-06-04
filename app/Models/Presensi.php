<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $table = 'presensi';
    protected $fillable = [
        'siswa_kelas_id',
        'jadwal_id',
        'waktu_presensi',
        'status',
        'catatan',
    ];

    public function siswa_kelas()
    {
        return $this->belongsTo(Siswa_Kelas::class, 'siswa_kelas_id', 'id')->withDefault();
    }
    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_id', 'id')->withDefault();
    }
}
