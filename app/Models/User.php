<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Role;

class User extends Authenticatable
{
    use Notifiable;

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

    // 在 belongsToMany 的第二個參數： 關聯表
    // 在 belongsToMany 的第三個參數： 永遠放「當前模型」的外鍵（這裡是 user_id）。
    // 第四個參數： 永遠放「另一個模型」的外鍵（這裡是 role_id）
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    // public function hasPermission($permission)
    // {
    //     // 取得使用者的所有角色
    //     $roles = $this->role;
    //     foreach ($roles as $role) {
    //         // 取得角色的所有權限
    //         $permissions = $role->permission;
    //         foreach ($permissions as $perm) {
    //             if ($perm->name === $permission) {
    //                 return true;
    //             }
    //         }
    //     }
    //     return false;
    // }
}
