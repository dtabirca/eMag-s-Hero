<?php

declare(strict_types=1);

namespace EmagHero\Battle;

use EmagHero\Configuration\GameSettings;
use EmagHero\Output\Output;

/**
 * defines default battle methods
 */
interface Battle
{
    public function init(GameSettings $config, Output $output): void;
    public function fight(): void;
    public function report(): void;
}
