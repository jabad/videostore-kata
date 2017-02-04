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

    /** @var RentalSummary[] */
    private $rentalSummaries;

    private function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public static function instance(Customer $customer): self
    {
        return new static($customer);
    }

    /**
     * @return RentalSummary[]
     */
    public function rentalSummaries()
    {
        return $this->rentalSummaries;
    }

    public function addRentalSummary(RentalSummary $rentalSummary)
    {
        $this->rentalSummaries[] = $rentalSummary;
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

    public function amountOwed(): float
    {
        $totalCost = Money::fromAmount(0);

        foreach ($this->rentalSummaries() as $rentalSummary) {
            $totalCost = $totalCost->add($rentalSummary->cost());
        }

        return (float) $totalCost->amount();
    }

    public function frequentRenterPoints(): int
    {
        $totalFrequentRenterPoints = 0;

        foreach ($this->rentalSummaries() as $rentalSummary) {
            $totalFrequentRenterPoints += $rentalSummary->frequentRenterPoints();
        }

        return $totalFrequentRenterPoints;
    }
}
