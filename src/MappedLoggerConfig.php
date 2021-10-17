<?php

namespace Deniem\LaraLogger;

use Deniem\LaraLogger\Factory\MapperFactory;
use Monolog\Handler\AbstractProcessingHandler;
use ReflectionClass;
use ReflectionException;
use RuntimeException;

/**
 *
 */
class MappedLoggerConfig
{
    public const DEFAULT_DRIVER = 'custom';
    public const DEFAULT_LEVEL = 'debug';

    /**
     * @var string
     */
    protected string $channel;

    /**
     * @var string
     */
    protected string $driver;
    /**
     * @var string
     */
    protected string $level;
    /**
     * @var AbstractProcessingHandler|null
     */
    protected ?AbstractProcessingHandler $handler = null;

    /**
     * @var array
     */
    protected array $mappers = [];


    /**
     * @param array $config
     * @return static
     * @throws ReflectionException
     */
    public static function configure(array $config): self
    {
        $mappersFactory = new MapperFactory();

        $handler = null;
        $mappers = array_map(fn($config) => $mappersFactory->make($config), $config['mappers'] ?? []);
        $channel = $config['channel'] ?? null;
        $driver = $config['driver'] ?? self::DEFAULT_DRIVER;
        $level = $config['level'] ?? self::DEFAULT_LEVEL;

        if (empty($config)) {
            throw new RuntimeException(__CLASS__ . ' config cannot be empty!');
        }

        if (empty($channel)) {
            throw new RuntimeException(__CLASS__ . ' channel cannot be blank!');
        }

        $handlerClass = $config['handler'] ?? null;
        $handlerConfig = $config['handler_with'] ?? null;

        if (!empty($handlerClass)) {

            if (!class_exists($handlerClass)) {
                throw new RuntimeException("$handlerClass config handler class is not exist!");
            }

            if ($handlerConfig != null && is_array($handlerConfig)) {
                $reflection = new ReflectionClass($handlerClass);
                $handler = $reflection->newInstanceArgs($handlerConfig);
            }

            if ($handler === null) {
                $handler = new $handlerClass();
            }
        }

        return new self($channel, $mappers, $handler, $driver, $level);
    }

    /**
     * @param string $channel
     * @param array|null $mappers
     * @param AbstractProcessingHandler|null $handler
     * @param string|null $driver
     * @param string|null $level
     */
    public function __construct(
        string                     $channel,
        ?array                     $mappers = [],
        ?AbstractProcessingHandler $handler = null,
        ?string                    $driver = self::DEFAULT_DRIVER,
        ?string                    $level = self::DEFAULT_LEVEL
    ) {
        if (empty($driver)) {
            throw new RuntimeException(__CLASS__ . ' driver cannot be blank!');
        }

        if (empty($level)) {
            throw new RuntimeException(__CLASS__ . ' level cannot be blank!');
        }

        $this->channel = $channel;
        $this->handler = $handler;
        $this->mappers = $mappers;
        $this->driver = $driver;
        $this->level = $level;
    }

    /**
     * @return string
     */
    public function getChannel(): string
    {
        return $this->channel;
    }

    /**
     * @return AbstractProcessingHandler|null
     */
    public function getHandler(): ?AbstractProcessingHandler
    {
        return $this->handler;
    }

    /**
     * @return string
     */
    public function getDriver(): string
    {
        return $this->driver;
    }

    /**
     * @return string
     */
    public function getLevel(): string
    {
        return $this->level;
    }

    /**
     * @return array
     */
    public function getMappers(): array
    {
        return $this->mappers;
    }
}