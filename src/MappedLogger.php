<?php

namespace Deniem\LaraLogger;

use Deniem\LaraLogger\Contracts\MapperInterface;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

/**
 *
 */
class MappedLogger implements LoggerInterface
{
    /**
     * @var Logger
     */
    protected Logger $logger;

    /**
     * @var MapperInterface[]
     */
    protected array $mappers = [];

    /**
     * @param Logger $logger
     * @param MapperInterface[] $mappers
     */
    public function __construct(Logger $logger, array $mappers)
    {
        $this->logger = $logger;

        foreach ($mappers as $mapper) {
            $this->mappers[$mapper->getTargetEvent()] = $mapper;
        }
    }

    /**
     * @param string $message
     * @param array $context
     */
    public function emergency($message, array $context = [])
    {
        $this->log(__FUNCTION__, $message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     */
    public function alert($message, array $context = [])
    {
        $this->log(__FUNCTION__, $message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     */
    public function critical($message, array $context = [])
    {
        $this->log(__FUNCTION__, $message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     */
    public function error($message, array $context = [])
    {
        $this->log(__FUNCTION__, $message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     */
    public function warning($message, array $context = [])
    {
        $this->log(__FUNCTION__, $message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     */
    public function notice($message, array $context = [])
    {
        $this->log(__FUNCTION__, $message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     */
    public function info($message, array $context = [])
    {
        $this->log(__FUNCTION__, $message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     */
    public function debug($message, array $context = [])
    {
        $this->log(__FUNCTION__, $message, $context);
    }

    /**
     * @param mixed $level
     * @param string $message
     * @param array $context
     */
    public function log($level, $message, array $context = [])
    {
        $contextTargetEvent = $context['targetEvent'] ?? null;

        if (!empty($contextTargetEvent) && !is_null($mapper = $this->mappers[$contextTargetEvent] ?? null)) {
            $context = $mapper->map($context);
        }

        $this->logger->{$level}($message, $context);
    }
}