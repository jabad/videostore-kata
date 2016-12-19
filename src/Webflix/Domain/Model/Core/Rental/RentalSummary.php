<?php

namespace Webflix\Domain\Model\Core\Rental;

/**
 * Class RentalSummary
 */
final class RentalSummary
{
    /** @var  float */
    private $totalAmount;

    /** @var  int */
    private $frequentRenterPoints;

    private function __construct(float $totalAmount, int $frequentRenterPoints)
    {
        $this->totalAmount = $totalAmount;
        $this->frequentRenterPoints = $frequentRenterPoints;
    }

    public static function instance(float $totalAmount, int $frequentRenterPoints)
    {
        return new self($totalAmount, $frequentRenterPoints);
    }

    public static function instanceEmpty()
    {
        return new self(0, 0);
    }

    /**
     * @return float
     */
    public function totalAmount(): float
    {
        return $this->totalAmount;
    }

    /**
     * @return int
     */
    public function frequentRenterPoints(): int
    {
        return $this->frequentRenterPoints;
    }

    /**
     * @param float $totalAmount
     * @param int $frequentRenterPoints
     *
     * @return RentalSummary
     */
    public function add(float $totalAmount, int $frequentRenterPoints): RentalSummary
    {
        return RentalSummary::instance(
            $this->totalAmount() + $totalAmount,
            $this->frequentRenterPoints() + $frequentRenterPoints
        );
    }
}
