<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScanProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'serialized_scan' => 'required|string',
        ];
    }
}
