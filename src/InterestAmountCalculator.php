<?php

declare(strict_types = 1);

namespace Kauri\Loan;


class InterestAmountCalculator implements InterestAmountCalculatorInterface
{
    /**
     * Calculate interest amount for present value based on interest rate
     * @param float $presentValue
     * @param float $interestRate
     * @return float
     */
    public function getInterestAmount(float $presentValue, float $interestRate): float
    {
        $interestAmount = ($presentValue * ($interestRate / 100));
        return $interestAmount;
    }

    /**
     * @param float $interestRate Yearly interest rate (based on 360 days)
     * @param float $periodLength Period length in days
     * @return float
     */
    public function getPeriodInterestRate(float $interestRate, float $periodLength): float
    {
        $periodRate = $interestRate / 360 * $periodLength;
        return (float) $periodRate;
    }
}
