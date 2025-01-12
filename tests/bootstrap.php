<?php

use App\Kernel;
use Symfony\Component\Dotenv\Dotenv;
use Zenstruck\Foundry\Configuration;
use Zenstruck\Foundry\Persistence\ResetDatabase\ResetDatabaseManager;

require dirname(__DIR__) . '/vendor/autoload.php';

(new Dotenv())->bootEnv(dirname(__DIR__) . '/.env');

if ($_SERVER['APP_DEBUG']) {
    umask(0000);
}

$kernel = new Kernel('test', true);

ResetDatabaseManager::resetBeforeFirstTest(
    static function () use ($kernel) {
        $kernel->boot();
        // @phpstan-ignore argument.type, symfonyContainer.serviceNotFound
        Configuration::boot($kernel->getContainer()->get('.zenstruck_foundry.configuration'));

        return $kernel;
    },
    static function () use ($kernel) {
        Configuration::shutdown();
        $kernel->shutdown();
    },
);
