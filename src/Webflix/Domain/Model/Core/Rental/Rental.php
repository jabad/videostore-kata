<?php

namespace Webflix\Domain\Model\Core\Rental;

use Webflix\Domain\Model\Core\Movie\Movie;

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
        return $this->movie()->determineAmount($this->daysRented());
    }

    public function determineFrequentRenterPoints(): int
    {
        return $this->movie()->determineFrequentRenterPoints($this->daysRented());
    }
}
