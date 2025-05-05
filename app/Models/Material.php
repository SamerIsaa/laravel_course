<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = ['name'];


    // material has many users
    public function users()
    {
        return $this->belongsToMany(User::class, 'users_materials', 'material_id', 'user_id');
    }
}
