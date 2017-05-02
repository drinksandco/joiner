<?php

namespace Uvinum\Filter;

interface Filter
{
    public function filter($key);
    public function process($serializedBase);
}
