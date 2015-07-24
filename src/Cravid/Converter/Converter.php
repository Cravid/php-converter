<?php

namespace Cravid\Converter;

class Converter implements ConverterInterface
{
    public function encodeTo($value, $format)
    {
        if (!$this->isFormatAvailable($format)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Unexpected source format "%s", expected one the following: %s.', 
                    $format, 
                    print_r($this->getAvailableFormats())
                )
            );
        }

        $driver = $this->resolver->resolve($format);
        
        return $driver->encode($value);
    }

    public function decodeFrom($value, $format)
    {
        if (!$this->isFormatAvailable($format)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Unexpected source format "%s", expected one the following: %s.', 
                    $format, 
                    print_r($this->getAvailableFormats())
                )
            );
        }

        $driver = $this->resolver->resolve($format);

        if (!$driver->isValid($value)) {
            throw new \InvalidArgumentException(sprintf('Value is not a valid "%s".', $format));
        }

        return $driver->decode($value);
    }

    private function isFormatAvailable($format)
    {
        return new \Reflection(new Format())->hasConstant($format);
    }

    public function getAvailableFormats()
    {
        return new \Reflection(new Format())->getConstants();
    }
}