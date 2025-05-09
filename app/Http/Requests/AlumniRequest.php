<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlumniRequest extends FormRequest
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
            'study_program'        => ['required', 'string'],
            'graduation_date'      => ['required', 'date'],
            'nim'                  => ['required', 'string', 'max:10'],
            'full_name'            => ['required', 'string'],
            'phone'                => ['nullable', 'string'],
            'email'                => ['nullable', 'email'],
            'start_work_date'      => ['nullable', 'date'],
            'start_work_now_date'  => ['nullable', 'date'],
            'study_start_year'     => ['required', 'digits:4'],
            'company_id'           => ['nullable', 'integer', 'exists:companies,id'],
            'profession_id'        => ['nullable', 'integer', 'exists:professions,id'],
            'superior_id'          => ['nullable', 'integer', 'exists:superiors,id'],
        ];
    }
}
