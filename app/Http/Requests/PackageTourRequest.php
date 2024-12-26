<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PackageTourRequest extends FormRequest
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
                'location' => 'required|string|max:255',
                'thumbnail' => 'required|image|mimes:png,jpg,jpeg',
                'category_id' => 'required|integer',
                'price' => 'required|integer',
                'days' => 'required|integer',
                'about' => 'required|string|max:65535',
                'package_photos.*' => 'required|image|mimes:png,jpg,jpeg',
            ];
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            // Validasi untuk update
            dd($this);
            return [
                'name' => 'required|string|max:255',
                'location' => 'required|string|max:255',
                'thumbnail' => 'nullable|image|mimes:png,jpg,jpeg',
                'category_id' => 'required|integer',
                'price' => 'required|integer',
                'days' => 'required|integer',
                'about' => 'required|string|max:65535',
                'package_photos.*' => 'nullable|image|mimes:png,jpg,jpeg',
            ];
        }

        return [];
    }
}
