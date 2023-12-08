<?php

namespace TDD;

class Receipt
{
    public function total(array $items = [], $coupun)
    {
        $sum = array_sum($items);
        if (!is_null($coupun)) {

            if ($coupun > 1.00) {
                throw new \BadMethodCallException("Must be lower than 1.00 or equal");
            }

            return $sum - ($sum * $coupun);
        }
        return $sum;
    }

    public function tax($amount, $tax)
    {
        return ($amount * $tax);
    }

    public function postTaxTotal($valores, $tax, $coupun)
    {
        $subtotal = $this->total($valores, $coupun);
        return $subtotal + $this->tax($subtotal, $tax);
    }

    public function currencyAmt($input)
    {
        return round($input, 2);
    }
}
