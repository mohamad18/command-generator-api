<?php

namespace App\Http\Requests;

use App\Http\Resources\ResponseResource;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SchoolStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // atau cek role user
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:schools,name',
            'address' => 'required|string|max:500',
            // 'email' => 'nullable|email|max:255|unique:schools,email',
            // 'phone' => 'nullable|string|max:20',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama sekolah wajib diisi.',
            'name.unique' => 'Nama sekolah sudah terdaftar.',
            'address.required' => 'Alamat sekolah wajib diisi.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            ResponseResource::error(
                422,
                false,
                'Validation error',
                $validator->errors()
            )
        );
    }
}
