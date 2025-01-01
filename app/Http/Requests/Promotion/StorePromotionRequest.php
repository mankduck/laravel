<?php

namespace App\Http\Requests\Promotion;

use Illuminate\Foundation\Http\FormRequest;

class StorePromotionRequest extends FormRequest
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
            'code' => 'required|unique:promotions',
            'startDate' => 'required',

        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => 'Bạn chưa nhập vào tên khuyến mãi.',
            'code.required' => 'Bạn chưa nhập vào mã khuyến mãi',
            'code.unique' => 'Mã khuyến mãi đã tồn tại',
            'startDate.required' => 'Bạn chưa chọn ngày bắt đầu'
        ];
    }
}
