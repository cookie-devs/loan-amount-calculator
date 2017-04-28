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

            $principalLeft = $principalLeft - $principal;

            $paymentAmounts[$sequenceNo] = $paymentAmount;
        }

        return $paymentAmounts;
    }

    /**
     * @param $interestRate
     * @param $periodLength
     * @return float|int
     */
    private function getPeriodInterestRate($interestRate, $periodLength)
    {
        return $interestRate / 360 * $periodLength;
    }

    /**
     * @param $presentValue
     * @param $futureValue
     * @param $noOfPeriods
     * @return float|int
     */
    private function getPrincipalPart($presentValue, $futureValue, $noOfPeriods)
    {
        return $principal = ($presentValue - $futureValue) / $noOfPeriods;
    }

    /**
     * @param float $presentValue
     * @param float $futureValue
     * @param float $ratePerPeriod
     * @param float $numberOfPeriods
     * @return float
     */
    private function getPaymentAmount(
        float $presentValue,
        float $futureValue,
        float $ratePerPeriod,
        float $numberOfPeriods
    ): float {
        $principal = $this->getPrincipalPart($presentValue, $futureValue, $numberOfPeriods);

        if ($ratePerPeriod > 0) {
            $payment = $principal + $presentValue * ($ratePerPeriod / 100);
        } else {
            $payment = $principal;
        }

        return $payment;
    }
}
