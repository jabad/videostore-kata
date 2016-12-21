<?php

namespace Webflix\Domain\Model\Core\Customer;

/**
 * Class Customer
 */
class Customer
{
    /** @var  string */
    private $name;

    private function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function instance(string $name): self
    {
        return new static($name);
    }

    public function name(): string
    {
        return $this->name;
    }
}
