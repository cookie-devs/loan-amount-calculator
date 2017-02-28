<?php

declare(strict_types = 1);

namespace Kauri\Loan;


interface PaymentAmountCalculatorInterface
{
    /**
     * @param float $presentValue
     * @param float $ratePerPeriod
     * @param float $numberOfPeriods
     * @return float
     */
    public function getPaymentAmount(float $presentValue, float $ratePerPeriod, float $numberOfPeriods): float;
}
