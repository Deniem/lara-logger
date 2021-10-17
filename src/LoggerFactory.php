<?php

namespace Deniem\LaraLogger;

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
        $logger = new Logger($loggerConfig->getChannel(), [$loggerConfig->getHandler()]);

        return new MappedLogger($logger, $loggerConfig->getMappers());
    }
}