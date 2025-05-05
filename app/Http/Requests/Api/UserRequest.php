<?php

namespace App\Http\Requests\Api;

use App\Rules\YoutubeRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'video_url' => ['required', 'url' , new YoutubeRule()]
        ];
    }


    public function attributes()
    {
        return [
            'name' => 'الاسم',
            'email' => 'البريد الالكتروني',
            'password' => 'كلمة المرور'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'code' => 422,
            'message' => $validator->errors()->first(),
            'data' => [
                'errors' => $validator->errors()
            ],
        ]));
    }
}
