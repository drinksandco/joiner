<?php

namespace Uvinum\Joiner\Serializer;

use Uvinum\Joiner\Strategy\Strategy;

final class ArraySerializer implements Serializer
{
    private $strategies;

    public function __construct(Strategy $strategy = null)
    {
        $this->strategies = $strategy;
    }

    public function serialize($arg)
    {
        $serializedArguments = \array_reduce(
            [$arg],
            [$this, "serializeItem"],
            []
        );

        return $serializedArguments;
    }


    private function serializeItem($carry, $arg)
    {
        if ($this->isIterable($arg)) {
            $serializedArray = [];
            foreach ($arg as $key => $value) {
                if ($this->isIterable($value)) {
                    $serializedArray[$key] = \array_reduce(
                        $value,
                        [$this, "serializeItem"],
                        []
                    );

                    return $serializedArray;
                }

                $serializedArray[$key] = $this->serializeItem($carry, $value);
            }

            return $serializedArray;
        }

        if (!\is_object($arg)) {
            return $arg;
        }

        if (null !== $this->strategies) {
            $serializedObjectDueToStrategy = $this->strategies->execute($arg);
            if (null !== $serializedObjectDueToStrategy) {
                return $serializedObjectDueToStrategy;
            }
        }

        return $this->serializeObject($arg);
    }

    private function serializeObject($arg)
    {
        $reflectionClass  = new \ReflectionClass(\get_class($arg));
        $serializedObject = \array_reduce(
            $reflectionClass->getProperties(),
            function ($carry, $property) use ($arg) {
                /** @var \ReflectionProperty $property */
                $property->setAccessible(true);
                $carry[$property->getName()] = \array_reduce(
                    [$property->getValue($arg)],
                    [$this, "serializeItem"],
                    []
                );

                return $carry;
            },
            []
        );

        return $serializedObject;
    }

    private function isIterable($arg)
    {
        return \is_array($arg) || $arg instanceof \Traversable;
    }
}
