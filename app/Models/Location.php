<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class Location extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'latitude', 'longitude'];

    public function user()
{
    return $this->belongsTo(User::class);
}

}
