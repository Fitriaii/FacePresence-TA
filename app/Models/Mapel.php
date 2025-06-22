<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $table = 'mapel';
    protected $fillable = [
        'guru_id',
        'nama_mapel',
        'kode_mapel',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id', 'id')->withDefault();
    }
}
