<?php

namespace Kauri\Loan\Test;


use Kauri\Loan\PaymentAmountCalculator\AnnuityPaymentAmountCalculator;
use Kauri\Loan\PaymentAmountCalculator\EqualPrincipalPaymentAmountCalculator;
use PHPUnit\Framework\TestCase;

class PaymentAmountCalculatorTest extends TestCase
{
    /**
     * @dataProvider loanData
     * @param $presentValue
     * @param $totalPeriod
     * @param $currentPeriod
     * @param $yearlyInterestRate
     * @param $expected
     */
    public function testGetPaymentAmount(
        $presentValue,
        $totalPeriod,
        $currentPeriod,
        $yearlyInterestRate,
        $expected
    ) {
        $ratePerPeriod = $yearlyInterestRate / 360 * $currentPeriod;
        $numberOfPeriods = $totalPeriod / $currentPeriod;

        $calculator = new AnnuityPaymentAmountCalculator();
        $paymentAmount = $calculator->getPaymentAmount($presentValue, $ratePerPeriod, $numberOfPeriods);

        $this->assertEquals($expected, round($paymentAmount, 2));
    }

    /**
     * @dataProvider loadEqualPrincipalData
     * @param $presentValue
     * @param $yearlyInterestRate
     * @param $totalPeriod
     * @param $currentPeriod
     * @param $expected
     */
    public function testGetEqualPrincipalPaymentAmount(
        $presentValue,
        $yearlyInterestRate,
        $totalPeriod,
        $currentPeriod,
        $expected
    ) {
        $ratePerPeriod = $yearlyInterestRate / 360 * $currentPeriod;
        $numberOfPeriods = $totalPeriod / $currentPeriod;

        $calculator = new EqualPrincipalPaymentAmountCalculator();
        $paymentAmount = $calculator->getPaymentAmount($presentValue, $ratePerPeriod, $numberOfPeriods);

        $this->assertEquals($expected, round($paymentAmount, 2));
    }

    /**
     * @return array
     */
    public function loanData(): array
    {
        return [
            // Exact
            [900, 90, 60, 0, 600],
            [900, 90, 30, 0, 300],
            [300, 30, 30, 0, 300],
            [900, 90, 60, 360, 1067.42],
            [900, 90, 30, 360, 495.56],
            [674.43, 60, 30, 360, 495.56],
            [381.20, 30, 30, 360, 495.56],
            // Regular, 30 day month, 360 days a year
            [5630, 1800, 30, 9, 116.87], // 60 payments, monthly, 360 days a year
            [1000, 60, 30, 0, 500], // 2 payments, monthly, 360 days a year
        ];
    }

    /**
     * @return array
     */
    public function loadEqualPrincipalData(): array
    {
        return [
            [900, 0, 90, 30, 300],
            [600, 0, 60, 30, 300],
            [900, 360, 90, 30, 570],
            [600, 360, 60, 30, 480],
            [300, 360, 30, 30, 390]
        ];
    }
}
