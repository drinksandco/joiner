<?php

namespace Uvinum\Joiner;

final class ChildObject extends ParentObject
{
    private $name;

    public function __construct($id, $name)
    {
        parent::__construct($id);
        $this->name = $name;
    }
}
