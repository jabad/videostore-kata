<?php

namespace Webflix\Domain\Model\Core\Movie;

/**
 * Class ChildrensMovie
 */
class ChildrensMovie extends Movie
{
    /**
     * @param $daysRented
     * @return float
     */
    public function determineAmount($daysRented) : float
    {
        $thisAmount = 1.5;

        if ($daysRented > 3) {
            $thisAmount += ($daysRented - 3) * 1.5;
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
