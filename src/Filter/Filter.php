<?php

namespace Uvinum\Joiner\Filter;

interface Filter
{
    public function filter($key);
    public function process($serializedBase);
}
