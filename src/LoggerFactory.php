<?php

namespace Deniem\LaraLogger;

use Deniem\LaraLogger\Models\MappedLoggerConfig;
use Monolog\Logger;
use ReflectionException;

/**
 *
 */
class LoggerFactory
{
    /**
     * @param array $config
     * @return MappedLogger
     * @throws ReflectionException
     */
    public function __invoke(array $config)
    {
        $loggerConfig = MappedLoggerConfig::configure($config);
        $logger = new Logger($loggerConfig->getChannel(), (array)$loggerConfig->getHandler());

        return new MappedLogger($logger, $loggerConfig->getMappers());
    }
}