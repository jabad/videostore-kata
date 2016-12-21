<?php

namespace Webflix\Domain\Model\Core\Rental;

/**
 * Class StringRentalStatementFormatter
 */
class StringRentalStatementFormatter implements RentalStatementFormatter
{
    private function __construct()
    {
    }

    public static function instance(): self
    {
        return new static();
    }

    public function format(RentalStatement $rentalStatement)
    {
        return $this->makeHeader($rentalStatement) .
            $this->makeRentalLines($rentalStatement) .
            $this->makeSummary($rentalStatement);
    }

    private function makeHeader(RentalStatement $rentalStatement): string
    {
        return "Rental Record for " . $rentalStatement->name() . "\n";
    }

    private function makeRentalLines(RentalStatement $rentalStatement): string
    {
        $rentalLines = "";

        foreach ($rentalStatement->rentals() as $rental) {
            $rentalLines .= $this->makeRentalLine($rental);
        }

        return $rentalLines;
    }

    private function makeRentalLine(Rental $rental): string
    {
        return $this->formatRentalLine($rental, $rental->determineAmount());
    }

    private function formatRentalLine(Rental $rental, float $thisAmount): string
    {
        return "\t" . $rental->title() . "\t" . number_format($thisAmount, 1) . "\n";
    }

    private function makeSummary(RentalStatement $rentalStatement): string
    {
        $getRentalSummary = $rentalStatement->getRentalSummary();

        return "You owed " .
            number_format($getRentalSummary->totalCost()->amount(), 1) .
            "\n" .
            "You earned " .
            $getRentalSummary->frequentRenterPoints() .
            " frequent renter points\n";
    }
}
