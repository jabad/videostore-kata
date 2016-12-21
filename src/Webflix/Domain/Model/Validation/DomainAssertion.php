<?php

namespace Webflix\Domain\Model\Validation;

use Assert\Assertion;

/**
 * Class DomainAssertion
 */
class DomainAssertion extends Assertion
{
    protected static function createException($value, $message, $code, $propertyPath, array $constraints = array())
    {
        return new \InvalidArgumentException($message, $code);
    }
}
