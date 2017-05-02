<?php

namespace Uvinum\Manipulator;

use League\Pipeline\Pipeline;

final class ArrayManipulator implements Manipulator
{
    /** @var Pipeline */
    private $pipeline;

    public function __construct()
    {
        $this->pipeline = new Pipeline();
    }

    public function append($key, $args)
    {
        $this->pipeline = $this->pipeline->pipe(
            function ($serializedBase) use ($key, $args) {
                $keysDepth = \explode('>', $key);
                $this->setNestedValue($serializedBase, $keysDepth, $args);

                return $serializedBase;
            }
        );
    }

    private function setNestedValue(&$serializedBase, array $keysDepth, $value)
    {
        $currentKey = \current($keysDepth);
        $nextKey    = \next($keysDepth);
        if (!$nextKey) {
            $serializedBase[\strtolower($currentKey)] = $value;

            return $serializedBase;
        }

        return $this->setNestedValue($serializedBase[\strtolower($currentKey)], $keysDepth, $value);
    }

    public function filter($key)
    {
        $this->pipeline = $this->pipeline->pipe(
            function ($serializedBase) use ($key) {
                $keysDepth = \explode('>', $key);
                $this->unsetNestedValue($serializedBase, $keysDepth);

                return $serializedBase;
            }
        );
    }

    private function unsetNestedValue(&$serializedBase, array $keysDepth)
    {
        $currentKey = \current($keysDepth);
        $nextKey    = \next($keysDepth);
        if (!$nextKey) {
            unset($serializedBase[\strtolower($currentKey)]);

            return $serializedBase;
        }

        return $this->unsetNestedValue($serializedBase[\strtolower($currentKey)], $keysDepth);
    }

    public function process($serializedBase)
    {
        return $this->pipeline->process($serializedBase);
    }
}
