<?php

namespace Deniem\LaraLogger\Mappers;

/**
 *
 */
class BaseArrayMapper extends AbstractMapper
{
    /**
     * @param array $context
     * @return array
     */
    public function map(array $context): array
    {
        $mappedContext = [];

        foreach ($context as $key => $value) {
            $mapping = $this->mappings[$key] ?? null;
            if ($mapping !== null) {
                $mappedContext[$mapping] = $value;
            }
        }

        return $mappedContext;
    }
}