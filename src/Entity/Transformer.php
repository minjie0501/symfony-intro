<?php

namespace App\Entity;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

interface Transform
{
    public function transform(string $value): string;
}

class Capitalizer implements Transform
{
    public function transform(string $value): string
    {
        $newValue = "";
        for ($x = 0; $x < strlen($value); $x++) {
            if ($x % 2 !== 0) $newValue .= strtoupper($value[$x]);
            else $newValue .= strtolower($value[$x]);
        }
        return $newValue;
    }
}

class DashConverter implements Transform
{
    public function transform(string $value): string
    {
        return str_replace(' ', '-', $value);
    }
}

class MonoLogger
{
    public function __construct(string $text)
    {
        // create a log channel
        $log = new Logger('name');
        $log->pushHandler(new StreamHandler('./log.info', Logger::INFO));

        // add records to the log
        $log->info($text);
    }
}



// class Master{
//     private $capitalizer;
//     private $monoLogger;

//     public function __construct(string $userInput,Transform $capitalizer,MonoLogger $monoLogger )
//     {
//         $this->capitalizer = $capitalizer;
//         $this->monoLogger = $monoLogger;
//     }
// }
