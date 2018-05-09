<?php

namespace Uvinum\Joiner;

final class NameWithToString
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function __toString()
    {
        return (string)$this->name;
    }
}
