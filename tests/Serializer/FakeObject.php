<?php

namespace Uvinum\Tests\Serializer;

final class FakeObject
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }
}
