<?php

namespace Uvinum\Tests\Serializer;

final class FakeObjectWithArrayProperty
{
    private $name;

    private $foods;

    public function __construct($name, $foods)
    {
        $this->name  = $name;
        $this->foods = $foods;
    }

    public function name()
    {
        return $this->name;
    }

    public function foods()
    {
        return $this->foods;
    }
}
