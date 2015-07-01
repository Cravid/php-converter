<?php

namespace Cravid\Converter;

class Fileloader
{
    /**
     * Loads the content of a given resource.
     *
     * @param string $resource The resource to be loaded.
     * @return mixed The raw resource content.
     * @throws \RuntimeException if the resource does not exist or could not be loaded.
     */
    public function load($resource)
    {
        if (!file_exists($resource)) {
            throw new \RuntimeException(sprintf('Resource "%s" does not exists.', $resource));
        }

        $content = file_get_contents($resource);

        if (false === $content) {
            throw new \RuntimeException(sprintf('Failed to load resource "%s".', $resource));
        }

        return $content;
    }
}