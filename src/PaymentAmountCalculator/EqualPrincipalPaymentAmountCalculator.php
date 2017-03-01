<?php

declare(strict_types = 1);

namespace Kauri\Loan\PaymentAmountCalculator;

use Kauri\Loan\PaymentAmountCalculatorInterface;

class EqualPrincipalPaymentAmountCalculator implements PaymentAmountCalculatorInterface
{
    /**
     * @param float $presentValue
     * @param float $ratePerPeriod
     * @param float $numberOfPeriods
     * @return float
     */
    public function getPaymentAmount(float $presentValue, float $ratePerPeriod, float $numberOfPeriods): float
    {
        $principal = $presentValue / $numberOfPeriods;

        if ($ratePerPeriod > 0) {
            $payment = $principal + $presentValue * ($ratePerPeriod / 100);
        } else {
            $payment = $principal;
        }

        return $payment;
    }
}
