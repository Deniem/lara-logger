<?php

namespace Deniem\LaraLogger\Contracts;

/**
 *
 */
interface MapperInterface
{
    public const MAPPER_EXAMPLE_TARGET_DB_EVENT_NAME = 'example-db-target-event';
    public const MAPPER_EXAMPLE_TARGET_SOME_EVENT_NAME = 'example-some-target-event';

    public const TARGET_EVENTS = [
        self::MAPPER_EXAMPLE_TARGET_DB_EVENT_NAME,
        self::MAPPER_EXAMPLE_TARGET_SOME_EVENT_NAME,
    ];

    /**
     * @return string
     */
    public function getTargetEvent(): string;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param array $context
     * @return array
     */
    public function map(array $context): array;

    /**
     * @return array
     */
    public function getMappings(): array;
}