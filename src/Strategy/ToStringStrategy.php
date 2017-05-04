<?php

namespace Uvinum\Joiner\Strategy;

final class ToStringStrategy implements Strategy
{
    /** @var Strategy | null */
    private $nextStrategy;

    public function __construct($nextStrategy = null)
    {
        $this->nextStrategy = $nextStrategy;
    }

    public function execute($object)
    {
        if (\method_exists($object, '__toString')) {
            return $object->__toString();
        }

        return $this->next($object);
    }

    public function next($object)
    {
        if (null !== $this->nextStrategy) {
            return $this->nextStrategy->execute($object);
        }

        return null;
    }
}
