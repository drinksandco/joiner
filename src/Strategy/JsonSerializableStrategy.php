<?php

namespace Uvinum\Strategy;

final class JsonSerializableStrategy implements Strategy
{
    /** @var Strategy | null */
    private $nextStrategy;

    public function __construct($nextStrategy = null)
    {
        $this->nextStrategy = $nextStrategy;
    }

    public function execute($object)
    {
        if ($object instanceof \JsonSerializable) {
            return \json_decode($object->jsonSerialize(), true);
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
