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

        foreach ($rentalStatement->rentalSummaries() as $rentalSummary) {
            $rentalLines .= $this->makeRentalLine($rentalSummary);
        }

        return $rentalLines;
    }

    private function makeRentalLine(RentalSummary $rentalSummary): string
    {
        return $this->formatRentalLine($rentalSummary, (float) $rentalSummary->cost()->amount());
    }

    private function formatRentalLine(RentalSummary $rentalSummary, float $thisAmount): string
    {
        return "\t" . $rentalSummary->rental()->title() . "\t" . number_format($thisAmount, 1) . "\n";
    }

    private function makeSummary(RentalStatement $rentalStatement): string
    {
        return "You owed " .
            number_format($rentalStatement->amountOwed(), 1) .
            "\n" .
            "You earned " .
            $rentalStatement->frequentRenterPoints() .
            " frequent renter points\n";
    }
}
