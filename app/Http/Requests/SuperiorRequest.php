<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuperiorRequest extends FormRequest
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
           
            'full_name' => ['required', 'string'],
            'position'=> ['required', 'string'],
            'phone' => ['required', 'string'],
            'email' => ['required', 'email'],
            'company_id' => ['nullable', 'exists:companies,id'],
        ];
    }
}
