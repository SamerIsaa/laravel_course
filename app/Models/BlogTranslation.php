<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class BlogTranslation extends Model
{

    protected $fillable = ['title', 'content'];

    public $timestamps = false;


}
