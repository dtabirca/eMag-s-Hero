<?php

declare(strict_types=1);

namespace EmagHero\Tests\Battle;

use PHPUnit\Framework\TestCase;
use EmagHero\Battle\HeroVsBeastFactory;
use EmagHero\Configuration\YamlFileSettings;
use EmagHero\Output\NoOutput;

/**
 * Testing battle scenarios with preset attributes for characters
 */
class BattleTest extends TestCase
{
    /**
     * hero vs beast, no luck, no skills; checking health values after battle
     */
    public function testHeroVsBattleNoLuckNoSkills(): void
    {
        $settingsFile = __DIR__ . '/../../config/no_randoms.test.settings.yml';

        $battle = (new HeroVsBeastFactory())->createBattle(
            new YamlFileSettings($settingsFile),
            new NoOutput()
        );

        $player1Health = $battle->getPlayerOne()->getAttribute('health');
        $player2Health = $battle->getPlayerTwo()->getAttribute('health');

        $this->assertEquals(
            -5,
            $player1Health,
            'wrong damage calculation'
        );
        $this->assertEquals(
            50,
            $player2Health,
            'wrong damage calculation'
        );
    }

    /**
     * hero vs beast, always lucky, no skills; should take no damage after battle
     */
    public function testHeroVsBattleAlwaysLucky(): void
    {
        $settingsFile = __DIR__ . '/../../config/always_lucky.test.settings.yml';

        $battle = (new HeroVsBeastFactory())->createBattle(
            new YamlFileSettings($settingsFile),
            new NoOutput()
        );

        $player1Health = $battle->getPlayerOne()->getAttribute('health');
        $player2Health = $battle->getPlayerTwo()->getAttribute('health');

        $this->assertEquals(
            100,
            $player1Health,
            'wrong damage calculation'
        );
        $this->assertEquals(
            90,
            $player2Health,
            'wrong damage calculation'
        );
    }

    /**
     * hero vs beast, skills activated; checking health values after battle
     */
    public function testHeroVsBattleSkillsAlwaysOn(): void
    {
        $settingsFile = __DIR__ . '/../../config/skills_on.test.settings.yml';

        $battle = (new HeroVsBeastFactory())->createBattle(
            new YamlFileSettings($settingsFile),
            new NoOutput()
        );

        $player1Health = $battle->getPlayerOne()->getAttribute('health');
        $player2Health = $battle->getPlayerTwo()->getAttribute('health');

        $this->assertEquals(
            47.5,
            $player1Health,
            'wrong damage calculation'
        );
        $this->assertEquals(
            -30,
            $player2Health,
            'wrong damage calculation'
        );
    }

    /**
     * testing battle with new skills added
     */
    public function testHeroVsBattleMoreSkillsAdded(): void
    {
        $settingsFile = __DIR__ . '/../../config/more_skills.test.settings.yml';

        $battle = (new HeroVsBeastFactory())->createBattle(
            new YamlFileSettings($settingsFile),
            new NoOutput()
        );

        $player1Health = $battle->getPlayerOne()->getAttribute('health');
        $player2Health = $battle->getPlayerTwo()->getAttribute('health');

        $this->assertEquals(
            100,
            $player1Health,
            'wrong damage calculation'
        );
        $this->assertEquals(
            -30,
            $player2Health,
            'wrong damage calculation'
        );
    }
}
