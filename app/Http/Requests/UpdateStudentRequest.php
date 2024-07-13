<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:students,email,' . $this->student->id],
            'kelas_id' => ['required', 'exists:kelas,id'],
            'section_id' => ['required', 'exists:sections,id']
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Student name',
            'email' => 'Student email',
            'kelas_id' => 'Kelas',
            'section_id' => 'Section'
        ];
    }
}
