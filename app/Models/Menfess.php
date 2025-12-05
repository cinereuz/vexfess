<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menfess extends Model
{
    use HasFactory;

    // Pastikan user_id masuk sini
    protected $fillable = ['user_id', 'recipient', 'message', 'tag', 'status', 'likes'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likesData()
    {
        return $this->hasMany(MenfessLike::class);
    }
}