<?php

namespace App\Rules\Product;

use App\Rules\BaseRule;

class ProductUnitRule extends BaseRule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!is_string($value)) {
            return false;
        }

        if (mb_strlen($value) >= 255 || mb_strlen($value) === 0) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Giá sản phẩm không hợp lệ.';
    }
}
