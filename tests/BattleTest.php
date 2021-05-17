<?php

declare(strict_types=1);

namespace EmagHero\Tests;

use EmagHero\Battle\HeroVsBeastBattle;
use PHPUnit\Framework\TestCase;

/**
 * Testing battle results with preset attributes for characters and no skills
 */
class BattleTest extends TestCase
{
    /**
     * hero vs beast; check health values after battle
     */
    public function testHeroVsBattle(): void
    {

        $battle = (new EmagHero\Battle\HeroVsBeastFactory())->createBattle(
            new EmagHero\Configuration\YamlFileSettings($settingsFile),
            new EmagHero\Output\ConsoleOutput()
        );
    }
}
