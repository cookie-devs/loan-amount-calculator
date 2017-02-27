<?php

declare(strict_types = 1);

namespace Kauri\Loan;


class InterestAmountCalculator implements InterestAmountCalculatorInterface
{
    /**
     * @param float $presentValue
     * @param float $ratePerPeriod
     * @return float
     */
    public function getInterestAmount(float $presentValue, float $ratePerPeriod) : float
    {
        $interestAmount = ($presentValue * ($ratePerPeriod / 100));
        return $interestAmount;
    }

}