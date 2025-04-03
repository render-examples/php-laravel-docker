<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    public $table = 'messages';
    protected $fillable = ['id', 'user_id', 'chat_id','text'];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getTimeAttribute(): string {   //accessor=>   Message::….->append(“time”)をeloquantで実行可能
        return date(
            "d M Y, H:i:s",
            strtotime($this->attributes['created_at']) //created_atコラムから日付をより見やすいtimeというaccessorを作成している
        );
    }
}
