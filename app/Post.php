<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    //名前, 回数, 重量, 時間
    protected $fillable = [
        'title',
        'amount',
        'time_hour',
        'time_minute',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
