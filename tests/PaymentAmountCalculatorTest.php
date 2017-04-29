<?php

namespace Kauri\Loan\Test;


use Kauri\Loan\InterestAmountCalculator;
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
     * @param $periodsLengths
     * @param $expected
     * @param PaymentAmountCalculatorInterface $calculator
     * @param int $futureValue
     */
    public function testGetPaymentAmount(
        $presentValue,
        $yearlyInterestRate,
        $periodsLengths,
        $expected,
        PaymentAmountCalculatorInterface $calculator,
        $futureValue = 0
    ) {
        $paymentAmounts = $calculator->getPaymentAmounts($periodsLengths, $presentValue, $yearlyInterestRate,
            $futureValue);
        $paymentAmount = current($paymentAmounts);

        $this->assertEquals($expected, round($paymentAmount, 2));
    }

    /**
     * @return array
     */
    public function loanData(): array
    {
        $interestCalculator = new InterestAmountCalculator();

        $annuityCalculator = new AnnuityPaymentAmountCalculator($interestCalculator);
        $equalCalculator = new EqualPrincipalPaymentAmountCalculator($interestCalculator);

        return [
            [100, 0, [1 => 30], 100, $annuityCalculator],
            [300, 0, [1 => 30, 30, 30], 100, $annuityCalculator],
            [100, 360, [1 => 30], 130, $annuityCalculator],
            [200, 360, [1 => 30, 30], 146.96, $annuityCalculator],
            [200, 360, [1 => 30, 31], 147.93, $annuityCalculator],
            [200, 360, [1 => 31, 31], 148.58, $annuityCalculator],

            [100, 0, [1 => 30], 100, $equalCalculator],
            [300, 0, [1 => 30, 30, 30], 100, $equalCalculator],
            [300, 0, [1 => 30, 30, 30], 50, $equalCalculator, 150],
            [300, 360, [1 => 30, 30, 30], 140, $equalCalculator, 150],
        ];
    }
}
