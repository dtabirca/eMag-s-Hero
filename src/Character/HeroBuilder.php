<?php

declare(strict_types=1);

namespace EmagHero\Character;

use EmagHero\Character\Attribute\UnitAttribute;
use EmagHero\Character\Skill\UnitSkill;

/**
 * creates a Hero character
 */
class HeroBuilder extends CharacterBuilderAbstract implements CharacterBuilderInterface
{
    public function createCharacter(): void
    {
        $this->character = new Hero();
    }

    public function addSkills(array $skills): void
    {
        $this->character->attackSkills = [];
        $this->character->defenceSkills = [];
        foreach ($skills as $values) {
            if ($values['use'] == 'attack') {
                $this->character->attackSkills[] = $values;
            } else if ($values['use'] == 'defence') {
                $this->character->defenceSkills[] = $values;
            }
        }
    }
}
