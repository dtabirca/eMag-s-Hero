<?php

declare(strict_types=1);

namespace EmagHero\Battle;

use EmagHero\Configuration\GameSettings;
use EmagHero\Output\Output;

/**
 * creates a hero vs beast battle
 */
class HeroVsBeastFactory implements OneOnOneFactory
{
    public function createBattle(GameSettings $config, Output $output): OneOnOneBattle
    {
        return new HeroVsBeastBattle(
            $config,
            $output
        );
    }
}
