<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $table = 'siswa';
    protected $fillable = [
        'nama_siswa',
        'nis',
        'no_hp',
        'alamat',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'foto_siswa' => 'array',
    ];

    public function siswa_kelas()
    {
        return $this->hasMany(Siswa_Kelas::class, 'siswa_id');
    }
}
