<?php

namespace Webflix\Domain\Model\Core\Rental;

/**
 * Interface RentalStatementFormatter
 */
interface RentalStatementFormatter
{
    public function format(RentalStatement $rentalStatement);
}
