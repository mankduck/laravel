<?php

namespace App\Rules\Promotion;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ProductAndQuantityRule implements ValidationRule
{

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        if ($this->data['product_and_quantity']['quantity'] == 0) {
            $fail('Ban phai nhap so luong toi thieu de huong chiet khau');
        }

        if ($this->data['product_and_quantity']['discountValue'] == 0) {
            $fail('Ban phai nhap gia tri cua chiet khau');
        }

        if (!isset($this->data['object'])) {
            $fail('Ban chua chon doi tuong huong chiet khau');
        }
    }
}
