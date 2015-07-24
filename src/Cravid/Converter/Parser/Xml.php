<?php

namespace Cravid\Converter\Parser;

class Xml implements \Cravid\Converter\ParserInterface
{
    public function encode(array $value)
    {
        $simpleXml = new \SimpleXMLElement('<?xml version="1.0"?><root></root>');
        $simpleXml = $this->arrayToXml($value, $simpleXml);
        $xml = $simpleXml->asXml();

        if (false === $xml) {
            throw new \RuntimeException(sprintf('Failed to encode array, given: %s', print_r($value, true)));
        }

        return $xml;
    }

    private function arrayToXml(array $data, $xml)
    {
        foreach ($data as $key => $value)
        {
            if (is_array($value)) {
                if (!is_numeric($key)) {
                    $subnode = $xml->addChild("$key");
                } else {
                    $subnode = $xml->addChild("item");
                }
                $this->arrayToXml($value, $subnode);
            } else {
                $xml->addChild("$key", htmlspecialchars("$value"));
            }
        }
        return $xml;
    }

    public function decode($value)
    {
        $prev = libxml_use_internal_errors(true);
        $content = simplexml_load_string($value);
        $errors = libxml_get_errors();
        libxml_clear_errors();
        libxml_use_internal_errors($prev);

        if (!empty($errors)) {
            throw new \RuntimeException(sprintf('Failed decoding "%s", errors: %s', $value, print_r($errors, true)));
        }

        return $this->xmlToArray($content);
    }

    private function xmlToArray($xml)
    {
        foreach ((array)$xml as $key => $node)
        {
            if (is_object($node)) {
                $result[$key] = $this->xmlToArray($node);
            } else {
                $result[$key] = $node;
            }
        }

        return $result;
    }

    public function isValid($value)
    {
        $prev = libxml_use_internal_errors(true);
        $content = simplexml_load_string($value);
        $errors = libxml_get_errors();
        libxml_clear_errors();
        libxml_use_internal_errors($prev);

        return empty($errors);
    }
}