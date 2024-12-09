<?php

namespace App\Http\Requests;

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
        if ($this->isMethod('post')) {
            return [
                'name' => 'required|string|max:255',
                'password' => 'required|string|min:6',
                'email' => 'required|email|unique:users',
                'ip' => 'required|ip',
                'comment' => 'nullable|string',
            ];
        }
        else if ($this->isMethod('put')) {
            return [
                'name' => 'string|max:255',
                'password' => 'string|min:6',
                'email' => 'email|unique:users',
                'ip' => 'ip',
                'comment' => 'string',
            ];
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'Поле name является обязательным',
            'name.string' => 'Поле name обязано быть строкой',
            'name.max' => 'У поля name может быть 255 символов максимум',

            'password.required' => 'Поле password является обязательным',
            'password.string' => 'Поле password обязано быть строкой',
            'password.min' => 'Введите, как минимум, 6 символов для password',

            'email.required' => 'Поле email является обязательным',
            'email.email' => 'Введите корректный email',
            'email.unique' => 'Данный email уже зарегистрирован',

            'ip.required' => 'Поле ip является обязательным',
            'ip.ip' => 'Введите корректный ip',

            'comment.string' => 'Поле comment обязано быть строкой'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}
