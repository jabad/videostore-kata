<?php

namespace Webflix\Domain\Model\Core\Movie;

/**
 * Class Movie
 */
class Movie
{
    /** @var string */
    private $title;

    /** @var MoviePriceCode */
    private $moviePriceCode;

    private function __construct(string $title, MoviePriceCode $moviePriceCode)
    {
        $this->title = $title;
        $this->moviePriceCode = $moviePriceCode;
    }

    public static function instanceRegularMovie(string $title): self
    {
        return new static($title, MoviePriceCode::instanceRegular());
    }

    public static function instanceNewReleaseMovie(string $title): self
    {
        return new static($title, MoviePriceCode::instanceNewRelease());
    }

    public static function instanceChildrenMovie(string $title): self
    {
        return new static($title, MoviePriceCode::instanceChildren());
    }

    public function title(): string
    {
        return $this->title;
    }

    public function moviePriceCode(): MoviePriceCode
    {
        return $this->moviePriceCode;
    }

    public function determineAmount(int $daysRented): float
    {
        $thisAmount = 0;

        switch ($this->moviePriceCode()->code()) {
            case MoviePriceCode::REGULAR:
                $thisAmount += 2;
                if ($daysRented > 2) {
                    $thisAmount += ($daysRented - 2) * 1.5;
                }
                break;

            case MoviePriceCode::NEW_RELEASE:
                $thisAmount += ($daysRented) * 3;
                break;

            case MoviePriceCode::CHILDREN:
                $thisAmount += 1.5;
                if ($daysRented > 3) {
                    $thisAmount += ($daysRented - 3) * 1.5;
                }
                break;
        }

        return $thisAmount;
    }

    public function determineFrequentRenterPoints(int $daysRented): int
    {
        $frequentRenterPoints = 1;
        if ($this->moviePriceCode()->isNewRelease() && $daysRented > 1) {
            $frequentRenterPoints++;
        }

        return $frequentRenterPoints;
    }
}
