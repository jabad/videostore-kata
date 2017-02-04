<?php

namespace Webflix\Domain\Model\Core\Rental;

/**
 * Class RentalFrequentRenterPointsCalculator
 */
class RentalFrequentRenterPointsCalculator
{
    private function __construct()
    {
    }

    public static function instance(): self
    {
        return new static();
    }

    public function determineFrequentRenterPoints(Rental $rental): int
    {
        $frequentRenterPoints = 1;
        if ($rental->movie()->moviePriceCode()->isNewRelease() && $rental->daysRented() > 1) {
            $frequentRenterPoints++;
        }

        return $frequentRenterPoints;
    }
}
