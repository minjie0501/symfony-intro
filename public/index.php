<?php
use App\Kernel;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Php;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';



return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};

?>

asdads