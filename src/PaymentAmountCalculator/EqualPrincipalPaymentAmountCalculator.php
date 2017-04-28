<?php

declare(strict_types = 1);

namespace Kauri\Loan\PaymentAmountCalculator;

use Kauri\Loan\PaymentAmountCalculatorInterface;

class EqualPrincipalPaymentAmountCalculator implements PaymentAmountCalculatorInterface
{
    /**
     * @param array $periods
     * @param float $presentValue
     * @param float $interestRate
     * @param float $futureValue
     * @return array
     */
    public function getPaymentAmounts(
        array $periods,
        float $presentValue,
        float $interestRate,
        float $futureValue
    ): array {
        $paymentAmounts = array();

        $principalLeft = $presentValue;
        $noOfPayments = count($periods);
        $principal = $this->getPrincipalPart($presentValue, $futureValue, $noOfPayments);

        foreach ($periods as $sequenceNo => $periodLength) {
            $ratePerPeriod = $this->getPeriodInterestRate($interestRate, $periodLength);
            $noOfRemainingPeriods = $noOfPayments - $sequenceNo + 1;

            $paymentAmount = $this->getPaymentAmount($principalLeft, $futureValue, $ratePerPeriod,
                $noOfRemainingPeriods);

            $principalLeft = $this->decreasePrincipalLeft($principalLeft, $principal);

            $paymentAmounts[$sequenceNo] = $paymentAmount;
        }

        return $paymentAmounts;
    }

    /**
     * @param float $presentValue
     * @param float $discount
     * @return float
     */
    private function decreasePrincipalLeft(float $presentValue, float $discount)
    {
        return (float) ($presentValue - $discount);
    }

    /**
     * @param $interestRate
     * @param $periodLength
     * @return float
     */
    private function getPeriodInterestRate(float $interestRate, float $periodLength): float
    {
        $periodRate = $interestRate / 360 * $periodLength;
        return (float) $periodRate;
    }

    /**
     * @param float $presentValue
     * @param float $futureValue
     * @param int $noOfPeriods
     * @return float
     */
    private function getPrincipalPart(float $presentValue, float $futureValue, int $noOfPeriods): float
    {
        $principal = ($presentValue - $futureValue) / $noOfPeriods;

        return (float) $principal;
    }

    /**
     * @param float $presentValue
     * @param float $futureValue
     * @param float $ratePerPeriod
     * @param int $numberOfPeriods
     * @return float
     */
    private function getPaymentAmount(
        float $presentValue,
        float $futureValue,
        float $ratePerPeriod,
        int $numberOfPeriods
    ): float {
        $principal = $this->getPrincipalPart($presentValue, $futureValue, $numberOfPeriods);

        if ($ratePerPeriod > 0) {
            $payment = $principal + $presentValue * ($ratePerPeriod / 100);
        } else {
            $payment = $principal;
        }

        return (float) $payment;
    }
}
