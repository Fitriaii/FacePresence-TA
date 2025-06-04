<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Guru extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory, HasRoles;

    protected $table = 'guru';
    protected $fillable = [
        'nama_guru',
        'nip',
        'no_hp',
        'alamat',
        'jenis_kelamin',
        'status_keaktifan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault();
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'id', 'id');
    }
}
