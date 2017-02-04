<?php

namespace Webflix\Domain\Model\Core\Rental;

use Webflix\Domain\Model\Core\Movie\MoviePriceCode;

/**
 * Class RentalAmountCalculator
 */
class RentalAmountCalculator
{
    /** @var RentalAmountConfig[] */
    private $configs;

    private function __construct(array $configs)
    {
        $this->configs = $configs;
    }

    public static function instance(): self
    {
        $configs = [
            MoviePriceCode::REGULAR => RentalAmountConfig::instance(2, 2, 1.5),
            MoviePriceCode::NEW_RELEASE => RentalAmountConfig::instance(0, 0, 3),
            MoviePriceCode::CHILDREN => RentalAmountConfig::instance(1.5, 3, 1.5),
        ];

        return new static($configs);
    }

    public function determineAmount(Rental $rental): float
    {
        $movie = $rental->movie();
        $daysRented = $rental->daysRented();

        $config = $this->configs[$movie->moviePriceCode()->code()];

        $thisAmount = $config->initialAmount();
        if ($daysRented > $config->minimumDaysRented()) {
            $thisAmount += ($daysRented - $config->minimumDaysRented()) * $config->amountBoost();
        }

        return $thisAmount;
    }
}
