<?php

namespace App\Http\Requests\Promotion;

use App\Enums\PromotionEnum;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Promotion\OrderAmountRangeRule;
use App\Rules\Promotion\ProductAndQuantityRule;

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
        $rules = [
            'name' => 'required',
            'code' => 'required|unique:promotions',
            'startDate' => 'required',
        ];

        $method = $this->only('method')['method'];
        switch ($method) {
            case PromotionEnum::ORDER_AMOUNT_RANGE:
                $rules['method'] = [
                    new OrderAmountRangeRule($this->input('promotion_order_amount_range'))
                ];
                break;
            case PromotionEnum::PRODUCT_AND_QUANTITY:
                $rules['method'] = [
                    new ProductAndQuantityRule($this->only('product_and_quantity', 'object'))
                ];
                break;
        }

        return $rules;
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
