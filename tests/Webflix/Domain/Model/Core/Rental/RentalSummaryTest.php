<?php

namespace tests\Webflix\Domain\Model\Core\Rental;

use PHPUnit_Framework_TestCase;
use Webflix\Domain\Model\Core\Rental\RentalSummary;

/**
 * Class RentalSummaryTest
 */
class RentalSummaryTest extends PHPUnit_Framework_TestCase
{
    const CUSTOM_RENTAL_SUMMARY_INITIAL_TOTAL_AMOUNT = 5;
    const CUSTOM_RENTAL_SUMMARY_INITIAL_FREQUENT_RENTER_POINTS = 10;

    /** @var RentalSummary */
    private $emptyRentalSummary;

    /** @var  RentalSummary */
    private $customRentalSummary;

    /**
     * Test set up.
     */
    protected function setUp()
    {
        $this->emptyRentalSummary = RentalSummary::instanceEmpty();
        $this->customRentalSummary = RentalSummary::instance(
            self::CUSTOM_RENTAL_SUMMARY_INITIAL_TOTAL_AMOUNT,
            self::CUSTOM_RENTAL_SUMMARY_INITIAL_FREQUENT_RENTER_POINTS
        );
    }

    /**
     * Test tear down objects.
     */
    protected function tearDown()
    {
        $this->emptyRentalSummary = null;
        $this->customRentalSummary = null;
    }

    /**
     * @test
     */
    public function itShouldAddTotalAmountAndFrequentRenterPointsWhenRentalSummaryIsEmpty()
    {
        $newTotalAmount = 20;
        $newFrequentRenterPoints = 30;

        $this->emptyRentalSummary = $this->emptyRentalSummary->add($newTotalAmount, $newFrequentRenterPoints);

        $this->assertEquals($newTotalAmount, $this->emptyRentalSummary->totalAmount());
        $this->assertEquals($newFrequentRenterPoints, $this->emptyRentalSummary->frequentRenterPoints());
    }

    /**
     * @test
     */
    public function itShouldAddTotalAmountAndFrequentRenterPointsWhenRentalSummaryIsCustom()
    {
        $newTotalAmount = 20;
        $newFrequentRenterPoints = 30;

        $this->customRentalSummary = $this->customRentalSummary->add($newTotalAmount, $newFrequentRenterPoints);

        $this->assertEquals(
            self::CUSTOM_RENTAL_SUMMARY_INITIAL_TOTAL_AMOUNT + $newTotalAmount,
            $this->customRentalSummary->totalAmount()
        );

        $this->assertEquals(
            self::CUSTOM_RENTAL_SUMMARY_INITIAL_FREQUENT_RENTER_POINTS + $newFrequentRenterPoints,
            $this->customRentalSummary->frequentRenterPoints()
        );
    }
}
