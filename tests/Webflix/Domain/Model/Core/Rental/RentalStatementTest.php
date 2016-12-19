<?php

namespace tests\Webflix\Domain\Model\Core\Rental;

use PHPUnit_Framework_TestCase;
use Webflix\Domain\Model\Core\Movie\ChildrensMovie;
use Webflix\Domain\Model\Core\Movie\Movie;
use Webflix\Domain\Model\Core\Movie\NewReleaseMovie;
use Webflix\Domain\Model\Core\Movie\RegularMovie;
use Webflix\Domain\Model\Core\Rental\Rental;
use Webflix\Domain\Model\Core\Rental\RentalStatement;

/**
 * Class RentalStatementTest
 */
class RentalStatementTest extends PHPUnit_Framework_TestCase
{
    /** @var  RentalStatement */
    private $statement;
    /** @var  Movie */
    private $newRelease1;
    /** @var  Movie */
    private $newRelease2;
    /** @var  Movie */
    private $childrens;
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
        $this->statement = new RentalStatement('Customer Name');
        $this->newRelease1 = new NewReleaseMovie('New Release 1');
        $this->newRelease2 = new NewReleaseMovie('New Release 2');
        $this->childrens = new ChildrensMovie('Childrens');
        $this->regular1 = new RegularMovie('Regular 1');
        $this->regular2 = new RegularMovie('Regular 2');
        $this->regular3 = new RegularMovie('Regular 3');
    }

    /**
     * Test tear down objects.
     */
    protected function tearDown()
    {
        $this->statement = null;
        $this->newRelease1 = null;
        $this->newRelease2 = null;
        $this->childrens = null;
        $this->regular1 = null;
        $this->regular2 = null;
        $this->regular3 = null;
    }

    /**
     * @test
     */
    public function itShouldSetRightAmountAndPointsWhenMakingRentalStatementForSingleNewReleaseStatement()
    {
        $this->statement->addRental(new Rental($this->newRelease1, 3));
        $this->statement->makeRentalStatement();

        $this->assertAmountAndPointsForReport(9.0, 2);
    }

    /**
     * @test
     */
    public function itShouldSetRightAmountAndPointsWhenMakingRentalStatementForDualNewReleaseStatement()
    {
        $this->statement->addRental(new Rental($this->newRelease1, 3));
        $this->statement->addRental(new Rental($this->newRelease2, 3));
        $this->statement->makeRentalStatement();

        $this->assertAmountAndPointsForReport(18.0, 4);
    }

    /**
     * @test
     */
    public function itShouldSetRightAmountAndPointsWhenMakingRentalStatementForSingleChildrenStatement()
    {
        $this->statement->addRental(new Rental($this->childrens, 3));
        $this->statement->makeRentalStatement();

        $this->assertAmountAndPointsForReport(1.5, 1);
    }

    /**
     * @test
     */
    public function itShouldSetRightAmountAndPointsWhenMakingRentalStatementForMultipleRegularStatement()
    {
        $this->statement->addRental(new Rental($this->regular1, 1));
        $this->statement->addRental(new Rental($this->regular2, 2));
        $this->statement->addRental(new Rental($this->regular3, 3));
        $this->statement->makeRentalStatement();

        $this->assertAmountAndPointsForReport(7.5, 3);
    }

    /**
     * @test
     */
    public function itShouldPrintWithRentalStatementFormat()
    {
        $this->statement->addRental(new Rental($this->regular1, 1));
        $this->statement->addRental(new Rental($this->regular2, 2));
        $this->statement->addRental(new Rental($this->regular3, 3));

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
