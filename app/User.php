<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function Posts(){
        return $this->hasMany(Post::class);
    }

    public function friends(){
        return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')
                    ->wherePivot('status', 'accepted')
                    ->withTimestamps();
    }
    public function friendRequests(){
        return $this->belongsToMany(User::class, 'friendships','friend_id', 'user_id')
                    ->wherePivot('pending')
                    ->withTimestamps();
    }
}
