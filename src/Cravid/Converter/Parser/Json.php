<?php

namespace Cravid\Converter\Parser;

class Json implements \Cravid\Converter\ParserInterface
{
    public function encode(array $value)
    {
        $json = json_encode($value);

        if ($json === false) {
            throw new \LogicException(sprintf('Could not encode array, given %s', print_r($value, true)));
        }

        return $json;
    }

    public function decode($value)
    {
        $result = json_decode($value, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \LogicException(sprintf('Failed to decode "%s", error: "%s".', $value, json_last_error_msg()));
        }

        return $result;
    }

    public function isValid($value)
    {
        $result = json_decode($value, true);
        return JSON_ERROR_NONE === json_last_error();
    }
}