<?php

namespace App\Http\Requests;

use App\Enums\GenderEnum;
use App\Rules\PhoneNumberRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PatientStoreRequest extends FormRequest
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
        $genders = [];
        foreach (GenderEnum::cases() as $case) {
            $genders[] = $case->value;
        }
        return [
            'name' => ['nullable'],
            'national_id' => ['nullable', 'digits:10'],
            'gender' => ['nullable', Rule::in($genders)],
            'education_degree' => ['nullable'],
            'marital_status' => ['nullable'],
            'children_count' => ['nullable'],
            'occupation' => ['nullable'],
            'first_visit_at' => ['nullable'],
            'address' => ['nullable'],
            'phone_number' => ['nullable', new PhoneNumberRule()],
            'birthdate' => ['nullable', 'date', 'date_format:Y-m-d'],
            'patient_avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:8192'],
        ];
    }
}
