<?php

namespace Webflix\Domain\Model\Core\Rental;

use Webflix\Domain\Model\BasicType\Money\Money;

/**
 * Class RentalSummary
 */
final class RentalSummaryBuilder
{
    /** @var RentalAmountCalculator */
    private $rentalAmountCalculator;

    /** @var RentalFrequentRenterPointsCalculator */
    private $rentalFrequentRenterPointsCalculator;

    private function __construct(
        RentalAmountCalculator $rentalAmountCalculator,
        RentalFrequentRenterPointsCalculator $rentalFrequentRenterPointsCalculator
    ) {
        $this->rentalAmountCalculator = $rentalAmountCalculator;
        $this->rentalFrequentRenterPointsCalculator = $rentalFrequentRenterPointsCalculator;
    }

    public static function instance(
        RentalAmountCalculator $rentalAmountCalculator,
        RentalFrequentRenterPointsCalculator $rentalFrequentRenterPointsCalculator
    ): self {
        return new static($rentalAmountCalculator, $rentalFrequentRenterPointsCalculator);
    }

    /**
     * @param Rental $rental
     *
     * @return RentalSummary
     */
    public function build(Rental $rental): RentalSummary
    {
        return RentalSummary::instance(
            $rental,
            Money::fromAmount($this->rentalAmountCalculator->determineAmount($rental)),
            $this->rentalFrequentRenterPointsCalculator->determineFrequentRenterPoints($rental)
        );
    }
}
