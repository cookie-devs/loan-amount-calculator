<?php

declare(strict_types = 1);

namespace Kauri\Loan;


interface InterestAmountCalculatorInterface
{
    /**
     * @param float $presentValue
     * @param float $interestRate
     * @return float
     */
    public function getInterestAmount(float $presentValue, float $interestRate): float;

    /**
     * @param float $interestRate
     * @param float $periodLength
     * @return float
     */
    public function getPeriodInterestRate(float $interestRate, float $periodLength): float;
}
