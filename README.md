[![Build Status](https://scrutinizer-ci.com/g/kaurikk/loan-amount-calculator/badges/build.png?b=master)](https://scrutinizer-ci.com/g/kaurikk/loan-amount-calculator/build-status/master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/kaurikk/loan-amount-calculator/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/kaurikk/loan-amount-calculator/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/kaurikk/loan-amount-calculator/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/kaurikk/loan-amount-calculator/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/fc9b33ce-55fa-4c3a-8a82-ecef5f03cba9/mini.png)](https://insight.sensiolabs.com/projects/fc9b33ce-55fa-4c3a-8a82-ecef5f03cba9)

# loan-amount-calculator
Library for calculating loan interest, payment amounts. Contains 2 main parts:
 * Interest calculator
 * Payment amount calculator (supports annuity and equal principal payments)

## Basic usage

### Interest calculator
```php
// Rate for 30 days
$yearlyInterestRate = 360;
$ratePerPeriod = $yearlyInterestRate / 360 * 30;
// Present value from where interest is calculated
$presentValue = 5000;


$calculator = new InterestAmountCalculator();
$interestAmount = $calculator->getInterestAmount($presentValue, $ratePerPeriod);

echo $interestAmount; // 1500
```
