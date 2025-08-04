<?php

namespace App\Models;

use App\Enums\StatusProgress;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'ktp',
        'nama_pelanggan',
        'alamat',
        'status',
        'latitude',
        'longitude',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
