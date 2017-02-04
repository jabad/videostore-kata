<?php

namespace Webflix\Domain\Model\Core\Rental;

/**
 * Class RentalAmountConfig
 */
final class RentalAmountConfig
{
    /** @var float */
    private $initialAmount;

    /** @var int */
    private $minimumDaysRented;

    /** @var  float */
    private $amountBoost;

    private function __construct(float $initialAmount, int $minimumDaysRented, float $amountBoost)
    {
        $this->initialAmount = $initialAmount;
        $this->minimumDaysRented = $minimumDaysRented;
        $this->amountBoost = $amountBoost;
    }

    public static function instance(float $initialAmount, int $minimumDaysRented, float $amountBoost): self
    {
        return new static($initialAmount, $minimumDaysRented, $amountBoost);
    }

    public function initialAmount(): float
    {
        return $this->initialAmount;
    }

    public function minimumDaysRented(): int
    {
        return $this->minimumDaysRented;
    }

    public function amountBoost(): float
    {
        return $this->amountBoost;
    }
}
