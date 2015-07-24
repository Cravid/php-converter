<?php

namespace Cravid\Converter;

/**
 *
 */
class ParserResolver
{
    /**
     *
     */
    public function resolve($format)
    {
        $className = __NAMESPACE__ . '\\Parser\\' . ucfirst(strtolower($format));
        $Parser = new $className();

        return $Parser;
    }
}