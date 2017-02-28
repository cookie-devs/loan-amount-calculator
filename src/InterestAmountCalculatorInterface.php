<?php

declare(strict_types = 1);

namespace Kauri\Loan;


interface InterestAmountCalculatorInterface
{
    /**
     * @param float $presentValue
     * @param float $ratePerPeriod
     * @return float
     */
    public function getInterestAmount(float $presentValue, float $ratePerPeriod): float;
}
