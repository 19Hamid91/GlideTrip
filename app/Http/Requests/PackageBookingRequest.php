<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PackageBookingRequest extends FormRequest
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
                'quantity' => 'required|integer',
                'start_date' => 'required|date|after:today',
            ];
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            // Validasi untuk update
            return [
                'package_bank_id' => 'required|integer',
            ];
        }

        return [];
    }
}
