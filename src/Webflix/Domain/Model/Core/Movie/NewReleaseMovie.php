<?php

namespace Webflix\Domain\Model\Core\Movie;

/**
 * Class NewReleaseMovie
 */
class NewReleaseMovie extends Movie
{
    /**
     * @param $daysRented
     * @return float
     */
    public function determineAmount($daysRented) : float
    {
        return $daysRented * 3.0;
    }

    /**
     * @param $daysRented
     * @return int
     */
    public function determineFrequentRenterPoints($daysRented) : int
    {
        return ($daysRented > 1) ? 2 : 1;
    }
}
