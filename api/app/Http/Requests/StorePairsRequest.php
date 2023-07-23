<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePairsRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'from' => 'required|string|max:3',
            'to' => 'required|string|max:3',
            'conv' => 'required|string',
        ];
    }
    public function messages()
    {
        return [
            'from.required' => 'The "from" field is required.',
            'from.string' => 'The "from" field must be a string.',
            'from.max' => 'The "from" field must not exceed 3 characters.',
            'to.required' => 'The "to" field is required.',
            'to.string' => 'The "to" field must be a string.',
            'to.max' => 'The "to" field must not exceed 3 characters.',
            'conv.required' => 'The "conv" field is required.',
            'conv.string' => 'The "conv" field must be a string.',
        ];
    }
}
