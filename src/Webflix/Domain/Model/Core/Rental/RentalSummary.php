<?php

namespace Webflix\Domain\Model\Core\Rental;

use Webflix\Domain\Model\BasicType\Money\Money;

/**
 * Class RentalSummary
 */
final class RentalSummary
{
    /** @var Money */
    private $totalCost;

    /** @var  int */
    private $frequentRenterPoints;

    private function __construct(Money $totalCost, int $frequentRenterPoints)
    {
        $this->totalCost = $totalCost;
        $this->frequentRenterPoints = $frequentRenterPoints;
    }

    public static function instance(Money $totalCost, int $frequentRenterPoints): self
    {
        return new static($totalCost, $frequentRenterPoints);
    }

    public static function instanceEmpty()
    {
        return new self(Money::fromAmount('0'), 0);
    }

    /**
     * @return Money
     */
    public function totalCost(): Money
    {
        return $this->totalCost;
    }

    /**
     * @return int
     */
    public function frequentRenterPoints(): int
    {
        return $this->frequentRenterPoints;
    }

    /**
     * @param Money $totalCost
     * @param int $frequentRenterPoints
     *
     * @return RentalSummary
     */
    public function add(Money $totalCost, int $frequentRenterPoints): RentalSummary
    {
        return RentalSummary::instance(
            $this->totalCost()->add($totalCost),
            $this->frequentRenterPoints() + $frequentRenterPoints
        );
    }
}
