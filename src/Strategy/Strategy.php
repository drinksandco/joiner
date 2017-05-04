<?php

namespace Uvinum\Joiner\Strategy;

interface Strategy
{
    public function execute($object);

    public function next($object);
}
