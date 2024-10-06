<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserStoreRequest extends FormRequest
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
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['email'],
            'phone_number' => ['required'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'roles' => ['required', 'array'],
            'roles.*' => ['required', 'exists:roles,id'],
            'user_avatar' => ['image', 'mimes:jpeg,png,jpg', 'max:8192'],
        ];
        if ($this->getMethod() == 'PUT') {
            $rules['phone_number'][] = 'unique:users,phone_number,' . $this->route('user')->id;
            $rules['email'][] = 'unique:users,email,' . $this->route('user')->id;
        } elseif ($this->getMethod() == 'POST') {
            $rules['phone_number'][] = 'unique:users,phone_number';
            $rules['email'][] = 'unique:users,email';
        }
        return $rules;
    }
}
