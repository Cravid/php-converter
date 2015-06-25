<?php

namespace Cravid\Converter\Driver;

class Json implements \Cravid\Converter\DriverInterface
{
    public function encode(array $value)
    {
        $json = json_encode($value, JSON_NUMERIC_CHECK | JSON_BIGINT_AS_STRING);

        if ($json === false) {
            throw new \LogicException(sprintf('Could not encode array, given %s', print_r($value, true)));
        }

        return $json;
    }

    public function decode(array $value)
    {
        $result = json_decode($value, true, 512, JSON_NUMERIC_CHECK | JSON_BIGINT_AS_STRING);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \LogicException(sprintf('Failed to decode "%s", error: "%s".', $value, json_last_error_msg()));
        }

        return $result;
    }

    public function isValid($value)
    {
        return JSON_ERROR_NONE === json_decode($value, true, 512, JSON_NUMERIC_CHECK | JSON_BIGINT_AS_STRING);
    }
}