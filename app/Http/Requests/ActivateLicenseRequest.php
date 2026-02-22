<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActivateLicenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'serial' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'device' => ['required', 'array'],
            'device.fingerprint_hash' => ['required', 'string', 'max:255'],
            'device.label' => ['required', 'string', 'max:255'],
            'device.platform' => ['required', 'string', 'max:50'],
        ];
    }
}
