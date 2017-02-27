<?php

namespace Kauri\Loan\Test;


use Kauri\Loan\InterestAmountCalculator;
use PHPUnit\Framework\TestCase;


class InterestAmountCalculatorTest extends TestCase
{
    /**
     * @dataProvider loadData
     * @param $presentValue
     * @param $currentPeriod
     * @param $yearlyInterestRate
     * @param $expectedInterest
     */
    public function testGetInterestAmount($presentValue, $currentPeriod, $yearlyInterestRate, $expectedInterest)
    {
        $ratePerPeriod = $yearlyInterestRate / 360 * $currentPeriod;

        $calculator = new InterestAmountCalculator();
        $interestAmount = $calculator->getInterestAmount($presentValue, $ratePerPeriod);
        $this->assertEquals($expectedInterest, $interestAmount);
    }

    public function loadData()
    {
        return [
            // Regular annuity
            [100, 30, 360, 30],
            [100, 30, 180, 15],
            // Exact
            [100, 10, 360, 10],
            [100, 29, 180, 14.5]
        ];
    }

}
