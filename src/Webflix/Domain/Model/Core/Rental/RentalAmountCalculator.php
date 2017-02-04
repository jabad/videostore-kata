<?php

namespace Webflix\Domain\Model\Core\Rental;

use Webflix\Domain\Model\Core\Movie\MoviePriceCode;

/**
 * Class RentalAmountCalculator
 */
class RentalAmountCalculator
{
    public function determineAmount(Rental $rental): float
    {
        $movie = $rental->movie();
        $daysRented = $rental->daysRented();

        $thisAmount = 0;

        switch ($movie->moviePriceCode()->code()) {
            case MoviePriceCode::REGULAR:
                $thisAmount += 2;
                if ($daysRented > 2) {
                    $thisAmount += ($daysRented - 2) * 1.5;
                }
                break;

            case MoviePriceCode::NEW_RELEASE:
                $thisAmount += ($daysRented) * 3;
                break;

            case MoviePriceCode::CHILDREN:
                $thisAmount += 1.5;
                if ($daysRented > 3) {
                    $thisAmount += ($daysRented - 3) * 1.5;
                }
                break;
        }

        return $thisAmount;
    }
}
