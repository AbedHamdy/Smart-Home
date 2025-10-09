<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterTechnicianRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'experience_years' => 'required|integer|min:0|max:80',
            'category_id' => 'required|integer|exists:categories,id',
            'skills' => 'nullable|string|max:2000',
            'experience' => 'nullable|string|max:3000',
            'cv_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'notes' => 'nullable|string|max:2000',
        ];
    }
}
