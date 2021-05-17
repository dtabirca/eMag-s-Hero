<?php

declare(strict_types=1);

namespace EmagHero\Battle;

use EmagHero\Configuration\GameSettings;
use EmagHero\Output\Output;

interface OneOnOneFactory
{
    public function createBattle(GameSettings $config, Output $output): OneOnOneBattle;
}
