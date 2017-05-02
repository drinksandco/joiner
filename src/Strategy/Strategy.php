<?php

namespace Uvinum\Strategy;

interface Strategy
{
    public function execute($object);

    public function next($object);
}
