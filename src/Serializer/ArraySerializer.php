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
        return $this->serializeItem($arg);
    }


    private function serializeItem($arg)
    {
        if ($this->isIterable($arg)) {
            $serializedArray = [];
            foreach ($arg as $key => $value) {
                $serializedArray[$key] = $this->serializeItem($value);
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
                $carry[$property->getName()] = $this->serializeItem($property->getValue($arg));
                return $carry;
            },
            []
        );
        $parentClass = $reflectionClass->getParentClass();
        if ($parentClass) {
            $serializedParentObject = \array_reduce(
                $parentClass->getProperties(),
                function ($carry, $property) use ($arg) {
                    /** @var \ReflectionProperty $property */
                    $property->setAccessible(true);
                    $carry[$property->getName()] = $this->serializeItem($property->getValue($arg));
                    return $carry;
                },
                []
            );
            $serializedObject = \array_merge($serializedObject, $serializedParentObject);
        }
        return $serializedObject;
    }

    private function isIterable($arg)
    {
        return \is_array($arg) || $arg instanceof \Traversable;
    }
}
