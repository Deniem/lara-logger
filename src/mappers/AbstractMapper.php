<?php

namespace Deniem\LaraLogger\Mappers;

use Deniem\LaraLogger\Contracts\MapperInterface;

/**
 *
 */
abstract class AbstractMapper implements MapperInterface
{
    /**
     * @var string
     */
    protected string $targetEvent;

    /**
     * @var array
     */
    protected array $mappings;

    /**
     * @param string $targetEvent
     * @param array $mappings
     */
    public function __construct(
        string $targetEvent,
        array $mappings
    ) {
        $this->targetEvent = $targetEvent;
        $this->mappings = $mappings;
    }

    /**
     * @return string
     */
    public function getTargetEvent(): string
    {
        return $this->targetEvent;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::class;
    }

    /**
     * @return array
     */
    public function getMappings(): array
    {
        return $this->mappings;
    }

    /**
     * @param array $context
     * @return array
     */
    abstract public function map(array $context): array;
}