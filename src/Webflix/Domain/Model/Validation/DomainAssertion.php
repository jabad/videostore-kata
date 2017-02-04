<?php

namespace Webflix\Domain\Model\Validation;

use Assert\Assertion;

/**
 * Class DomainAssertion
 */
class DomainAssertion extends Assertion
{
    protected static function createException(
        $value,
        $message,
        $code,
        $propertyPath = null,
        array $constraints = array()
    ) {
        return new \InvalidArgumentException($message, $code);
    }
}
