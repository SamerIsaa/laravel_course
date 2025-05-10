<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use function App\Http\Requests\Panel\locales;

class BlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'image' => 'required_unless:_method,PUT',
        ];

        foreach (LaravelLocalization::getSupportedLocales() as $key => $language) {
            $rules['title_' . $key] = 'required|string|max:255';
            $rules['content_' . $key] = 'required|string';
        }

        return $rules;
    }
}
