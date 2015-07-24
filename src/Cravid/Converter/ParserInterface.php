<?php

namespace Cravid\Converter;

/**
 * Interface for concrete Parser implementations.
 */
interface ParserInterface
{
    /**
     * Encodes a given array in the corresponding format.
     *
     * This method MUST be implemented in such a way as to always
     * return a valid value of the corresponding format.
     *
     * @param array $value The value to be encoded.
     * @return mixed The encoded value in the corresponding format.
     * @throws \LogicException if an encoding error occurs.
     */
    public function encode(array $value);

    /**
     * Returns an array of the decoded value.
     *
     * This method MUST be implemented in such a way as to always
     * return an array if no error occurs. For empty or null values,
     * this method SHOULD return an empty array.
     *
     * @param mixed $value The scheme to use with the new instance.
     * @return array The decoded value as array result.
     * @throws \LogicException if an decoding error occurs.
     */
    public function decode($value);

    /**
     * Checks if the value is type of the corresponding format.
     *
     * @var mixed $value The value to be checked.
     * @return bool Returns true if the given value is type of the 
     *     corresponding format.
     */
    public function isValid($value);
}