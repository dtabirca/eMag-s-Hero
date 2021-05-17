<?php

declare(strict_types=1);

namespace EmagHero\Configuration;

use Symfony\Component\Yaml\Yaml;

/**
 * loads configuration from a yaml file
 */
class YamlFileSettings implements GameSettings
{
    private string $configFile;
    private array $settings;

    public function __construct(string $file)
    {
        $this->configFile = $file;
        $this->settings = $this->loadFromFile();
    }

    private function loadFromFile(): array
    {
        if (@file_exists($this->configFile)) {
            return Yaml::parseFile($this->configFile);
        }
        return [];
    }

    public function getSettings(): array
    {
        return $this->settings;
    }
}
