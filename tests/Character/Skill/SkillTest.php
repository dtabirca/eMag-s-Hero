<?php

declare(strict_types=1);

namespace EmagHero\Tests\Character\Skill;

use PHPUnit\Framework\TestCase;
use EmagHero\Character\Skill\UnitSkill;

/**
 * testing skill object gets created and values get returned
 */
class SkillTest extends TestCase
{
    /**
     * create skill from array, 100% chance, should always return modifier
     */
    public function testSkillWith100Chance(): void
    {
        $skill = new UnitSkill([
            'skillName' => 'testing',
            'modifier' => 1.11,
            'chance' => 100
        ]);
        $modifier = $skill->getModifierByChance();

        $this->assertEquals(
            1.11,
            $modifier,
            'wrong chance calculation'
        );
    }
}
