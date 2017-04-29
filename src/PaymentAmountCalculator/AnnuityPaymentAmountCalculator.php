<?php

declare(strict_types = 1);

namespace Kauri\Loan\PaymentAmountCalculator;

use Kauri\Loan\PaymentAmountCalculator;

class AnnuityPaymentAmountCalculator extends PaymentAmountCalculator
{
    /**
     * @see http://www.financeformulas.net/Annuity_Payment_Formula.html
     * @see http://www.tvmcalcs.com/index.php/calculators/apps/lease_payments
     * @see http://www.ms.uky.edu/~rkremer/files/Finance04.pdf
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
        float $futureValue = 0.0
    ): array {
        $paymentAmounts = array();

        $discountFactor = 0;
        $futureValueDenominator = 1;

        foreach ($periods as $sequenceNo => $periodsLength) {
            $partialDiscountFactor = pow(1 + ($interestRate / 360 / 100 * $periodsLength),
                -$sequenceNo);

            $discountFactor = $discountFactor + $partialDiscountFactor;

            $partialFutureValueDenominator = 1 + ($interestRate / 360 / 100 * $periodsLength);
            $futureValueDenominator = $futureValueDenominator * $partialFutureValueDenominator;
        }

        $paymentAmount = ($presentValue - ($futureValue / $futureValueDenominator)) / $discountFactor;

        foreach ($periods as $sequenceNo => $periodsLength) {
            $paymentAmounts[$sequenceNo] = $paymentAmount;
        }

        return $paymentAmounts;
    }

}
