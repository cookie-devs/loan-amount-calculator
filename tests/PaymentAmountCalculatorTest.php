<?php

namespace Kauri\Loan\Test;


use Kauri\Loan\PaymentAmountCalculator;
use PHPUnit\Framework\TestCase;

class PaymentAmountCalculatorTest extends TestCase
{
    /**
     * @dataProvider loanData
     * @param $amountOfPrincipal
     * @param $totalPeriod
     * @param $currentPeriod
     * @param $yearlyInterestRate
     * @param $expected
     */
    public function testGetPaymentAmount(
        $amountOfPrincipal,
        $totalPeriod,
        $currentPeriod,
        $yearlyInterestRate,
        $expected
    ) {
        $presentValue = $amountOfPrincipal;
        $ratePerPeriod = $yearlyInterestRate / 360 * $currentPeriod;
        $numberOfPeriods = $totalPeriod / $currentPeriod;

        $calculator = new PaymentAmountCalculator();
        $paymentAmount = $calculator->getPaymentAmount($presentValue, $ratePerPeriod, $numberOfPeriods);
        $this->assertEquals($expected, round($paymentAmount, 2));
    }

    /**
     * @return array
     */
    public function loanData()
    {
        return [
            // Exact
            [900, 90, 60, 0, 600],
            [900, 90, 30, 0, 300],
            [900, 90, 60, 360, 1067.42],
            [900, 90, 30, 360, 495.56],
            // Regular, 30 day month, 360 days a year
            [5630, 1800, 30, 9, 116.87], // 60 payments, monthly, 360 days a year
            [1000, 60, 30, 0, 500], // 2 payments, monthly, 360 days a year
        ];
    }
}
