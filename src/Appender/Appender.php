<?php

namespace Uvinum\Joiner\Appender;

interface Appender
{
    public function append($key, $args);
    public function process($serializedBase);
}
