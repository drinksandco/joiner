<?php

namespace Uvinum\Appender;

interface Appender
{
    public function append($key, $args);
    public function process($serializedBase);
}
