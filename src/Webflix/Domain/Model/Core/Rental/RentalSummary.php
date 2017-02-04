<?php

namespace Webflix\Domain\Model\Core\Rental;

use Webflix\Domain\Model\BasicType\Money\Money;

/**
 * Class RentalSummary
 */
final class RentalSummary
{
    /** @var Rental */
    private $rental;

    /** @var Money */
    private $cost;

    /** @var  int */
    private $frequentRenterPoints;

    private function __construct(Rental $rental, Money $cost, int $frequentRenterPoints)
    {
        $this->rental = $rental;
        $this->cost = $cost;
        $this->frequentRenterPoints = $frequentRenterPoints;
    }

    public static function instance(Rental $rental, Money $cost, int $frequentRenterPoints): self
    {
        return new static($rental, $cost, $frequentRenterPoints);
    }

    public function rental(): Rental
    {
        return $this->rental;
    }

    public function cost(): Money
    {
        return $this->cost;
    }

    public function frequentRenterPoints(): int
    {
        return $this->frequentRenterPoints;
    }
}
