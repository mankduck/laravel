<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
            'name' => 'required',
            'country' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'payment-method' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Bạn chưa nhập tên.',
            'country.required' => 'Bạn chưa nhập thành phố.',
            'address.required' => 'Bạn chưa nhập địa chỉ.',
            'phone.required' => 'Bạn chưa nhập số điện thoại.',
            'email.required' => 'Bạn chưa nhập email.',
            'payment-method.required' => 'Bạn chưa chọn phương thức thanh toán.',
        ];
    }
}
