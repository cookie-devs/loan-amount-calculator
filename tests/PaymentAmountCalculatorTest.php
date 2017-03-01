<?php

namespace Kauri\Loan\Test;


use Kauri\Loan\PaymentAmountCalculator\AnnuityPaymentAmountCalculator;
use Kauri\Loan\PaymentAmountCalculator\EqualPrincipalPaymentAmountCalculator;
use Kauri\Loan\PaymentAmountCalculatorInterface;
use PHPUnit\Framework\TestCase;

class PaymentAmountCalculatorTest extends TestCase
{
    /**
     * @dataProvider loanData
     * @param $presentValue
     * @param $yearlyInterestRate
     * @param $totalPeriod
     * @param $currentPeriod
     * @param $expected
     * @param PaymentAmountCalculatorInterface $calculator
     */
    public function testGetPaymentAmount(
        $presentValue,
        $yearlyInterestRate,
        $totalPeriod,
        $currentPeriod,
        $expected,
        PaymentAmountCalculatorInterface $calculator
    ) {
        $ratePerPeriod = $yearlyInterestRate / 360 * $currentPeriod;
        $numberOfPeriods = $totalPeriod / $currentPeriod;

        $paymentAmount = $calculator->getPaymentAmount($presentValue, $ratePerPeriod, $numberOfPeriods);

        $this->assertEquals($expected, round($paymentAmount, 2));
    }

    /**
     * @return array
     */
    public function loanData(): array
    {
        $annuityCalculator = new AnnuityPaymentAmountCalculator();
        $equalCalculator = new EqualPrincipalPaymentAmountCalculator();

        return [
            // Exact
            [900, 0, 90, 60, 600, $annuityCalculator],
            [900, 0, 90, 30, 300, $annuityCalculator],
            [300, 0, 30, 30, 300, $annuityCalculator],
            [900, 360, 90, 60, 1067.42, $annuityCalculator],
            [900, 360, 90, 30, 495.56, $annuityCalculator],
            [674.43, 360, 60, 30, 495.56, $annuityCalculator],
            [381.20, 360, 30, 30, 495.56, $annuityCalculator],
            // Regular, 30 day month, 360 days a year
            [5630, 9, 1800, 30, 116.87, $annuityCalculator], // 60 payments, monthly, 360 days a year
            [1000, 0, 60, 30, 500, $annuityCalculator], // 2 payments, monthly, 360 days a year
            [900, 0, 90, 30, 300, $equalCalculator],
            [600, 0, 60, 30, 300, $equalCalculator],
            [900, 360, 90, 30, 570, $equalCalculator],
            [600, 360, 60, 30, 480, $equalCalculator],
            [300, 360, 30, 30, 390, $equalCalculator]
        ];
    }
}
