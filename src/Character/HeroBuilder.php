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
            if ($this->isValidSkill($values)) {
                if ($values['use'] == 'attack') {
                    $this->character->attackSkills[] = $values;
                } else if ($values['use'] == 'defence') {
                    $this->character->defenceSkills[] = $values;
                }
            }
        }
    }

    private function isValidSkill(array $values): bool
    {
        if (
            !array_key_exists('label', $values) ||
            !array_key_exists('use', $values) ||
            !array_key_exists('modifier', $values) || 
            !array_key_exists('chance', $values)   
        ) {
            return false;
        }
        if (
            !is_string($values['label']) ||
            !in_array($values['use'], ['attack', 'defence']) ||
            !is_numeric($values['modifier']) || 
            !(
                is_int($values['chance']) &&
                $values['chance'] >= 0 &&
                $values['chance'] <= 100
            )   
        ) {        
            return false;
        }

        return true;
    }
}
