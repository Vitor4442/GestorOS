<?php

namespace App\Http\Requests;

use App\ServiceOrderStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateServiceOrderStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, array<int, mixed>> */
    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in(array_column(ServiceOrderStatus::cases(), 'value'))],
            'note' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
