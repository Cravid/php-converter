<?php

namespace Cravid\Converter;

class Converter
{
    /**
     *
     */
    protected $resolver = null;

    
    public function __construct(ParserResolver $resolver = null)
    {
        if ($resolver === null) {
            $resolver = new ParserResolver();
        }
        $this->resolver = $resolver;
    }
    
    public function encodeTo($value, $format)
    {
        if (!$this->isFormatAvailable($format)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Unexpected source format "%s", expected one the following: %s.', 
                    $format, 
                    print_r($this->getAvailableFormats(), true)
                )
            );
        }

        $Parser = $this->resolver->resolve($format);
        
        return $Parser->encode($value);
    }

    public function decodeFrom($value, $format)
    {
        if (!$this->isFormatAvailable($format)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Unexpected source format "%s", expected one the following: %s.', 
                    $format, 
                    print_r($this->getAvailableFormats(), true)
                )
            );
        }

        $Parser = $this->resolver->resolve($format);

        if (!$Parser->isValid($value)) {
            throw new \InvalidArgumentException(sprintf('Value is not a valid "%s".', $format));
        }

        return $Parser->decode($value);
    }
    
    public function isFormatAvailable($format)
    {
        return (new \ReflectionClass(new Format()))->hasConstant(strtoupper($format));
    }

    public function getAvailableFormats()
    {
        return (new \ReflectionClass(new Format()))->getConstants();
    }
}
