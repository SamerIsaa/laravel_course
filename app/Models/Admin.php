<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
     ];

    protected $table = 'admins';
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
//        'password',
//        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // single user has many posts

    public function posts()
    {
        // any hasMany must return Collect of many item's or collect of 1 item
        // [post1] , or [post1, p2,p3]
        return $this->hasMany(Post::class, 'user_id', 'id');
    }


    // user has one address

    public function address()
    {
        // return single object
        return $this->hasOne(Address::class, 'user_id', 'id');
    }

    // relation to comments model

    public function comments()
    {
        return $this->hasManyThrough(Comment::class, Post::class, 'user_id', 'post_id');
    }


    // user has many materials (belongsToMany())

    public function materials()
    {
        return $this->belongsToMany(Material::class, 'users_materials', 'user_id', 'material_id');
    }

}
