<?php

namespace Webflix\Domain\Model\Core\Movie;

/**
 * Class MoviePriceCode
 */
class MoviePriceCode
{
    const REGULAR = 0;
    const NEW_RELEASE = 1;
    const CHILDREN = 2;

    const CODES_ALLOWED = [
        self::REGULAR,
        self::NEW_RELEASE,
        self::CHILDREN
    ];

    /** @var int */
    private $code;

    private function __construct(int $code)
    {
        $this->setCode($code);
    }

    private function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }

    public static function instanceRegular(): self
    {
        return new static(self::REGULAR);
    }

    public static function instanceNewRelease(): self
    {
        return new static(self::NEW_RELEASE);
    }

    public static function instanceChildren(): self
    {
        return new static(self::CHILDREN);
    }

    public function code(): int
    {
        return $this->code;
    }

    public function isNewRelease(): bool
    {
        return $this->code() === self::NEW_RELEASE;
    }
}
