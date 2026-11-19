<?php

namespace App\Http\Requests;

use App\ServiceOrderPriority;
use App\ServiceOrderStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreServiceOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, array<int, mixed>> */
    public function rules(): array
    {
        return [
            'customer_id' => ['required', 'integer', 'exists:customers,id'],
            'assigned_to' => ['nullable', 'integer', 'exists:users,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'status' => ['required', Rule::in(array_column(ServiceOrderStatus::cases(), 'value'))],
            'priority' => ['required', Rule::in(array_column(ServiceOrderPriority::cases(), 'value'))],
            'scheduled_at' => ['nullable', 'date'],
            'estimated_cost' => ['nullable', 'numeric', 'min:0', 'max:99999999.99'],
            'final_cost' => ['nullable', 'numeric', 'min:0', 'max:99999999.99'],
        ];
    }
}
