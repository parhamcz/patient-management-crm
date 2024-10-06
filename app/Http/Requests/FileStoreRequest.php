<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileStoreRequest extends FormRequest
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
            "visit_date" => ['required', 'date'],
            "patient_accompany" => ['string'],
            "case_number" => ['string'],
            "medical_history" => ['string'],
            "before_operation" => ['string'],
            "during_operation" => ['string'],
            "after_operation" => ['string'],
            "disease_comparison" => ['string'],
            "special_case" => ['boolean'],
            "patient_id" => [ 'integer', 'exists:patients,id'],
            "hospitals" => [ 'array'],
            "hospitals.*" => [ 'exists:hospitals,id'],
            "congresses" => ['array'],
            "congresses.*" => ['exists:congresses,id'],
            "doctors" => [ 'array'],
            "doctors.*" => [ 'exists:users,id'],
            "diseases" => [ 'array'],
            "diseases.*" => [ 'exists:diseases,id'],
        ];
    }
}
