<?php

namespace Uvinum\Joiner\Strategy;

final class DateTimeFormatStrategy implements Strategy
{
    /** @var Strategy | null */
    private $nextStrategy;

    public function __construct($nextStrategy = null)
    {
        $this->nextStrategy = $nextStrategy;
    }

    public function execute($object)
    {
        if ($object instanceof \DateTimeInterface) {
            return $object->format('Y-m-d H:i:s');
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
