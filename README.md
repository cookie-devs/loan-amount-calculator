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
