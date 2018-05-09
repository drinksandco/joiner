<?php

namespace Uvinum\Joiner;

class ParentObject
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
}
