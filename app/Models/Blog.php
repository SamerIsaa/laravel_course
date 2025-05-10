<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Blog extends Model
{
    use Translatable;

    protected $fillable = ['image' , 'is_published'];
    public $translatedAttributes = ['title', 'content'];

    public $translationModel = BlogTranslation::class;




    public function createTranslation(Request $request)
    {
        foreach (LaravelLocalization::getSupportedLocales() as $key => $language) {
            foreach ($this->translatedAttributes as $attribute) {
                if ($request->get($attribute . '_' . $key) != null && !empty($request->$attribute . $key)) {
                    $this->{$attribute . ':' . $key} = $request->get($attribute . '_' . $key);
                }
            }
            $this->save();
        }
        return $this;
    }

}
