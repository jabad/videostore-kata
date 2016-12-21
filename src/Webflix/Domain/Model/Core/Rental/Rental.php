<?php

namespace Webflix\Domain\Model\Core\Rental;

use Webflix\Domain\Model\Core\Movie\Movie;
use Webflix\Domain\Model\Core\Movie\MoviePriceCode;

/**
 * Class Rental
 */
class Rental
{
    /** @var Movie */
    private $movie;

    /** @var int */
    private $daysRented;

    private function __construct(Movie $movie, int $daysRented)
    {
        $this->movie = $movie;
        $this->daysRented = $daysRented;
    }

    public static function instance(Movie $movie, int $daysRented): self
    {
        return new static($movie, $daysRented);
    }

    public function movie(): Movie
    {
        return $this->movie;
    }

    public function daysRented(): int
    {
        return $this->daysRented;
    }

    public function title() : string
    {
        return $this->movie->title();
    }

    public function determineAmount(): float
    {
        $thisAmount = 0;
        $daysRented = $this->daysRented();

        switch ($this->movie()->moviePriceCode()->code()) {
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

    public function determineFrequentRenterPoints(): int
    {
        $frequentRenterPoints = 1;
        if ($this->movie()->moviePriceCode()->code() === MoviePriceCode::NEW_RELEASE && $this->daysRented() > 1) {
            $frequentRenterPoints++;
        }

        return $frequentRenterPoints;
    }
}
