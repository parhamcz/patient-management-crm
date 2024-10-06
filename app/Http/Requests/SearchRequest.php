<?php

namespace App\Http\Requests;

use App\Enums\GenderEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SearchRequest extends FormRequest
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
        foreach (GenderEnum::cases() as $case){
            $genders[] = $case->value;
        }
        return [
            'patient' => ['array'],
            'patient.entry' => ['string','nullable'],
            'patient.gender' => [Rule::in($genders),'nullable'],
            'patient.age' => ['array'],
            'patient.age.start' => ['int','nullable'],
            'patient.age.end' => ['int','nullable'],
            'file' => ['array'],
            'file.special_case' => ['bool'],'nullable',
            'file.diseases' => ['array','nullable'],
            'file.diseases.*' => ['exists:diseases,id', 'int','nullable'],
            'file.hospitals' => ['array'],
            'file.hospitals.*' => ['exists:hospitals,id', 'int','nullable'],
            'file.congresses' => ['array'],
            'file.congresses.*' => ['exists:congresses,id', 'int','nullable'],
        ];
    }
}
