<?php

declare(strict_types=1);

namespace EmagHero\Character\Skill;

/**
 * creates a skill object
 */
class UnitSkill
{
    private string $skillName;
    private float $modifier;
    private int $chance;

    public function __construct(array $values)
    {
        $this->skillName = $values['skillName'];
        $this->modifier = $values['modifier'];
        $this->chance = $values['chance'];
    }

    public function getName()
    {
        return $this->attrName;
    }

    public function getModifierByChance()
    {
        if (mt_rand(0, 99) < $this->chance) {
            return $this->modifier;
        }
        return null;
    }
}
