<?php

namespace Deniem\LaraLogger\Factory;

use Deniem\LaraLogger\Contracts\MapperInterface;
use RuntimeException;

/**
 *
 */
class MapperFactory
{
    /**
     * @param array $config
     * @return MapperInterface
     */
    public function make(array $config): MapperInterface
    {
        if (empty($config)) {
            throw new RuntimeException('Mapper config cannot be blank!');
        }

        $mapperClass = $config['class'] ?? null;
        $mapperTargetEvent = $config['targetEvent'] ?? null;
        $mappings = $config['mappings'] ?? [];

        if ($mapperClass === null || !class_exists($mapperClass)) {
            throw new RuntimeException('Mapper class should exist!');
        }

        if (empty($mapperTargetEvent)) {
            throw new RuntimeException('Mapper target event cannot be blank!');
        }

        if (!in_array($mapperTargetEvent, MapperInterface::TARGET_EVENTS)) {
            throw new RuntimeException("$mapperTargetEvent is unsupported target event!");
        }

        return new $mapperClass($mapperTargetEvent, $mappings);
    }
}