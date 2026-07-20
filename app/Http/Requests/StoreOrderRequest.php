<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
        'products.*.product_id' => 'required|exists:products,id',
        'products.*.quantities' => 'required|integer|min:1',
        ];
    }

    public function attributes(): array
    {
        $attributes = [];

        foreach ($this->input('products', []) as $index => $product) {
            $row = $index + 1;
            $attributes["products.$index.product_id"] = __('validation.attributes.product_row', ['row' => $row]);
            $attributes["products.$index.quantities"] = __('validation.attributes.quantity_row', ['row' => $row]);
        }

        return $attributes;
    }
}
