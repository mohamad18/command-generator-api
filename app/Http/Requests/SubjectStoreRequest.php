<?php

namespace App\Http\Requests;

use App\Http\Resources\ResponseResource;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class SubjectStoreRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            // definisikan validasi di sini
            'school_id' => 'required|exists:school,id',
            'school_id' => 'required|integer',
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('subjects', 'name')->ignore($this->subject), // ignore the current subject if updating, matches the name parameter ex: {subject}
            ],
            'description' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'school_id.required' => 'ID Sekolah wajib diisi.',
            'school_id.exists' => 'ID Sekolah tidak ditemukan.',
            'school_id.integer' => 'ID Sekolah harus berupa angka.',
            'name.required' => 'Nama Subject wajib diisi.',
            'name.unique' => 'Nama Subject sudah terdaftar.',
            'description.string' => 'Deskripsi harus berupa teks.',
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
