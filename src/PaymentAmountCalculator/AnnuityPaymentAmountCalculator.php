<?php

declare(strict_types = 1);

namespace Kauri\Loan\PaymentAmountCalculator;

use Kauri\Loan\PaymentAmountCalculatorInterface;


class AnnuityPaymentAmountCalculator implements PaymentAmountCalculatorInterface
{
    /**
     * @see http://www.financeformulas.net/Annuity_Payment_Formula.html
     * @param float $presentValue
     * @param float $ratePerPeriod
     * @param float $numberOfPeriods
     * @return float
     */
    public function getPaymentAmount(float $presentValue, float $ratePerPeriod, float $numberOfPeriods): float
    {
        if ($ratePerPeriod > 0) {
            $payment = (($ratePerPeriod / 100) * $presentValue) / (1 - pow(1 + ($ratePerPeriod / 100),
                        -$numberOfPeriods));
        } else {
            $payment = $presentValue / $numberOfPeriods;
        }

        return $payment;
    }
}
