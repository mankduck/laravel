<?php

namespace App\Http\Requests\Promotion;

use App\Enums\PromotionEnum;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Promotion\OrderAmountRangeRule;
use App\Rules\Promotion\ProductAndQuantityRule;

class UpdatePromotionRequest extends FormRequest
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
            'name' => 'required|unique:promotions,name,' . $this->id . '',
            'code' => 'required|unique:promotions,code,' . $this->id . '',
            'startDate' => 'required',
        ];

        $method = $this->input('method');
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
            default:
                $rules['method'] = 'required';
                break;
        }

        return $rules;
    }


    public function messages(): array
    {

        $method = $this->input('method');

        $messages = [
            'name.required' => 'Bạn chưa nhập vào tên khuyến mãi.',
            'code.required' => 'Bạn chưa nhập vào mã khuyến mãi',
            'code.unique' => 'Mã khuyến mãi đã tồn tại',
            'startDate.required' => 'Bạn chưa chọn ngày bắt đầu'
        ];

        if ($method === null) {
            $messages['method.required'] = 'Ban chua chon hinh thuc khuyen mai';
        }

        return $messages;
    }
}
