<?php

namespace Tests\Webflix\Domain\Model\Core\Rental;

use PHPUnit\Framework\TestCase;
use Webflix\Domain\Model\Core\Customer\Customer;
use Webflix\Domain\Model\Core\Movie\Movie;
use Webflix\Domain\Model\Core\Rental\Rental;
use Webflix\Domain\Model\Core\Rental\RentalAmountCalculator;
use Webflix\Domain\Model\Core\Rental\RentalFrequentRenterPointsCalculator;
use Webflix\Domain\Model\Core\Rental\RentalStatement;
use Webflix\Domain\Model\Core\Rental\RentalSummaryBuilder;

/**
 * Class RentalStatementTest
 */
class RentalStatementTest extends TestCase
{
    /** @var RentalStatement */
    private $statement;

    /** @var  RentalSummaryBuilder */
    private $rentalSummaryBuilder;

    /** @var  Movie */
    private $newRelease1;

    /** @var  Movie */
    private $newRelease2;

    /** @var  Movie */
    private $children;

    /** @var  Movie */
    private $regular1;

    /** @var  Movie */
    private $regular2;

    /** @var  Movie */
    private $regular3;

    /**
     * Test set up.
     */
    protected function setUp()
    {
        $this->statement = RentalStatement::instance(Customer::instance('Customer Name'));
        $this->rentalSummaryBuilder = RentalSummaryBuilder::instance(
            RentalAmountCalculator::instance(),
            RentalFrequentRenterPointsCalculator::instance()
        );
        $this->newRelease1 = Movie::instanceNewReleaseMovie('New Release 1');
        $this->newRelease2 = Movie::instanceNewReleaseMovie('New Release 2');
        $this->children = Movie::instanceChildrenMovie('Childrens');
        $this->regular1 = Movie::instanceRegularMovie('Regular 1');
        $this->regular2 = Movie::instanceRegularMovie('Regular 2');
        $this->regular3 = Movie::instanceRegularMovie('Regular 3');
    }

    /**
     * Test tear down objects.
     */
    protected function tearDown()
    {
        $this->statement = null;
        $this->rentalSummaryBuilder = null;
        $this->newRelease1 = null;
        $this->newRelease2 = null;
        $this->children = null;
        $this->regular1 = null;
        $this->regular2 = null;
        $this->regular3 = null;
    }

    /**
     * @test
     */
    public function itShouldSetRightAmountAndPointsWhenMakingRentalStatementForSingleNewReleaseStatement()
    {
        $this->statement->addRentalSummary(
            $this->rentalSummaryBuilder->build(Rental::instance($this->newRelease1, 3))
        );
        $this->statement->makeRentalStatement();

        $this->assertAmountAndPointsForReport(9.0, 2);
    }

    /**
     * @test
     */
    public function itShouldSetRightAmountAndPointsWhenMakingRentalStatementForDualNewReleaseStatement()
    {
        $this->statement->addRentalSummary(
            $this->rentalSummaryBuilder->build(Rental::instance($this->newRelease1, 3))
        );
        $this->statement->addRentalSummary(
            $this->rentalSummaryBuilder->build(Rental::instance($this->newRelease2, 3))
        );
        $this->statement->makeRentalStatement();

        $this->assertAmountAndPointsForReport(18.0, 4);
    }

    /**
     * @test
     */
    public function itShouldSetRightAmountAndPointsWhenMakingRentalStatementForSingleChildrenStatement()
    {
        $this->statement->addRentalSummary(
            $this->rentalSummaryBuilder->build(Rental::instance($this->children, 3))
        );
        $this->statement->makeRentalStatement();

        $this->assertAmountAndPointsForReport(1.5, 1);
    }

    /**
     * @test
     */
    public function itShouldSetRightAmountAndPointsWhenMakingRentalStatementForMultipleRegularStatement()
    {
        $this->statement->addRentalSummary(
            $this->rentalSummaryBuilder->build(Rental::instance($this->regular1, 1))
        );
        $this->statement->addRentalSummary(
            $this->rentalSummaryBuilder->build(Rental::instance($this->regular2, 2))
        );
        $this->statement->addRentalSummary(
            $this->rentalSummaryBuilder->build(Rental::instance($this->regular3, 3))
        );
        $this->statement->makeRentalStatement();

        $this->assertAmountAndPointsForReport(7.5, 3);
    }

    /**
     * @test
     */
    public function itShouldPrintWithRentalStatementFormat()
    {
        $this->statement->addRentalSummary(
            $this->rentalSummaryBuilder->build(Rental::instance($this->regular1, 1))
        );
        $this->statement->addRentalSummary(
            $this->rentalSummaryBuilder->build(Rental::instance($this->regular2, 2))
        );
        $this->statement->addRentalSummary(
            $this->rentalSummaryBuilder->build(Rental::instance($this->regular3, 3))
        );

        $this->assertEquals(
            "Rental Record for Customer Name\n" .
            "\tRegular 1\t2.0\n" .
            "\tRegular 2\t2.0\n" .
            "\tRegular 3\t3.5\n" .
            "You owed 7.5\n" .
            "You earned 3 frequent renter points\n",
            $this->statement->makeRentalStatement()
        );
    }

    private function assertAmountAndPointsForReport($expectedAmount, $expectedPoints)
    {
        $this->assertEquals($expectedAmount, $this->statement->amountOwed());
        $this->assertEquals($expectedPoints, $this->statement->frequentRenterPoints());
    }
}
