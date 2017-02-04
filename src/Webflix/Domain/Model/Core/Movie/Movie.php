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
}
