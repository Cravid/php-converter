<?php

namespace Cravid\Converter;

/**
 *
 */
class DriverResolver
{
    /**
     *
     */
    public function resolve($format)
    {
        $className = ucfirst(strtolower($format));
        $driver = new 'Driver/' . $className();

        return $driver;
    }
}