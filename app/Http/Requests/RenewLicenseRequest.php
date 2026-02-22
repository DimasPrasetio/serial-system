<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RenewLicenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'renew_serial' => ['required', 'string', 'max:255'],
        ];
    }
}
