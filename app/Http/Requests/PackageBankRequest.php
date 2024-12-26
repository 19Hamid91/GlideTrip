<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PackageBankRequest extends FormRequest
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
                'bank_name' => 'required|string|max:255',
                'bank_account_name' => 'required|string|max:255',
                'bank_account_number' => 'required|string|max:255',
                'logo' => 'required|image|mimes:jpeg,png,jpg',
            ];
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            // Validasi untuk update
            return [
                'bank_name' => 'required|string|max:255',
                'bank_account_name' => 'required|string|max:255',
                'bank_account_number' => 'required|string|max:255',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg',
            ];
        }

        return [];
    }
}
