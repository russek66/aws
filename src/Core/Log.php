<?php

namespace App\Core;

use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;

trait Log {
    use Config;

    protected ?Logger $instance = null;

    protected function getLogger():Logger
    {
        if (! $this->instance) {
            $this->configureInstance();
        }
        return $this->instance;
    }

    protected function configureInstance():Logger
    {
        $dir = $this->get(key: 'LOG_PATH');
        $logger = new Logger('APP_LOGGER');
        $logger->pushHandler(new RotatingFileHandler($dir . 'main.log', 5));
        return $this->instance = $logger;
    }

    public function debug($message, array $context = []):void{
        $this->getLogger()->debug($message, $context);
    }

    public function info($message, array $context = []):void{
        $this->getLogger()->info($message, $context);
    }

    public function notice($message, array $context = []):void{
        $this->getLogger()->notice($message, $context);
    }

    public function warning($message, array $context = []):void{
        $this->getLogger()->warning($message, $context);
    }

    public function error($message, array $context = []):void{
        $this->getLogger()->error($message, $context);
    }

    public function critical($message, array $context = []):void{
        $this->getLogger()->critical($message, $context);
    }

    public function alert($message, array $context = []):void{
        $this->getLogger()->alert($message, $context);
    }

    public function emergency($message, array $context = []):void{
        $this->getLogger()->emergency($message, $context);
    }

}