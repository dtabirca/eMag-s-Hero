<?php

/**
 * This launches the Hero vs Beast Battle simulation
 * with Orderus vs WildBeast scenario
 */

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

if ($_ENV['APP_ENV'] === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', true);
    ini_set('display_startup_errors', true);
} else {
    error_reporting(0);
}

$settingsFile = __DIR__ . '/config/Orderus_vs_WildBeast.settings.yml';

$battle = (new EmagHero\Battle\HeroVsBeastFactory())->createBattle(
    new EmagHero\Configuration\YamlFileSettings($settingsFile),
    new EmagHero\Output\ConsoleOutput()
);
