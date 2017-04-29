<?php

declare(strict_types = 1);

namespace Kauri\Loan;


abstract class PaymentAmountCalculator implements PaymentAmountCalculatorInterface
{
    /**
     * @var InterestAmountCalculatorInterface
     */
    protected $interestAmountCalculator;

    /**
     * EqualPrincipalPaymentAmountCalculator constructor.
     * @param InterestAmountCalculatorInterface $interestAmountCalculator
     */
    public function __construct(InterestAmountCalculatorInterface $interestAmountCalculator)
    {
        $this->interestAmountCalculator = $interestAmountCalculator;
    }

}
