<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        if ($this->isMethod('post')) {
            // Validasi untuk store
            return [
                'name' => 'required|string|max:255',
                'icon' => 'required|image|mimes:jpeg,png,jpg',
            ];
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            // Validasi untuk update
            return [
                'name' => 'required|string|max:255',
                'icon' => 'nullable|image|mimes:jpeg,png,jpg',
            ];
        }

        return [];
    }
}
