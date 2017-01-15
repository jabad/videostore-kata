<?php

namespace Webflix\Domain\Model\Core\Rental;

use Webflix\Domain\Model\BasicType\Money\Money;
use Webflix\Domain\Model\Core\Customer\Customer;

/**
 * Class RentalStatement
 */
class RentalStatement
{
    /** @var Customer */
    private $customer;

    /** @var  array */
    private $rentals;

    private function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public static function instance(Customer $customer): self
    {
        return new static($customer);
    }

    /**
     * @return Rental[]
     */
    public function rentals()
    {
        return $this->rentals;
    }

    public function addRental(Rental $rental)
    {
        $this->rentals[] = $rental;
    }

    /**
     * @return string
     */
    public function makeRentalStatement()
    {
        return StringRentalStatementFormatter::instance()->format($this);
    }

    public function name(): string
    {
        return $this->customer->name();
    }

    public function getRentalSummary(): RentalSummary
    {
        $rentalSummary = RentalSummary::instanceEmpty();

        foreach ($this->rentals() as $rental) {
            $rentalSummary = $rentalSummary->add(
                Money::fromAmount($rental->determineAmount()),
                $rental->determineFrequentRenterPoints()
            );
        }

        return $rentalSummary;
    }

    public function amountOwed(): float
    {
        return (float) $this->getRentalSummary()->totalCost()->amount();
    }

    public function frequentRenterPoints(): int
    {
        return $this->getRentalSummary()->frequentRenterPoints();
    }
}
