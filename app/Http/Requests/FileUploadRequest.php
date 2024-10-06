<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileUploadRequest extends FormRequest
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
        //TODO add most common mimeTypes.
        return [
            'upload' => [
                'required',
                "mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4,video/webm,video/ogg,image/jpeg,image/jpg,image/png,image/bmp,application/pdf,audio/mpeg,audio/wav,audio/aac,audio/x-aac,audio/wav,audio/mp3",
                'max:16384'],
        ];
    }
}
