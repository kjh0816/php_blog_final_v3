<?php

namespace App\Interceptor;

abstract class Interceptor
{
    abstract public function run(string $action);
}