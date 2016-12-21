<?php

namespace Webflix\Domain\Model\Core\Movie;

/**
 * Class RegularMovie
 */
class RegularMovie extends Movie
{
    /**
     * @param $daysRented
     * @return float
     */
    public function determineAmount($daysRented) : float
    {
        $thisAmount = 2;

        if ($daysRented > 2) {
            $thisAmount += ($daysRented - 2) * 1.5;
        }

        return $thisAmount;
    }

    /**
     * @param $daysRented
     * @return int
     */
    public function determineFrequentRenterPoints($daysRented) : int
    {
        return 1;
    }
}
