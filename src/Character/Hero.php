<?php

declare(strict_types=1);

namespace EmagHero\Character;

use EmagHero\Character\Skill\UnitSkill;

class Hero extends GameCharacterAbstract
{
    public string $characterType = 'hero';
    public array $attackSkills;
    public array $defenceSkills;

    public function getAttackSkills(): array
    {
        return $this->attackSkills;
    }

    public function getDefenceSkills(): array
    {
        return $this->defenceSkills;
    }

    /**
     * exports in a friendlier format for output
     */
    public function exportSkills(): array
    {
        $skills = [];
        foreach (
            array_merge($this->attackSkills, $this->defenceSkills) as $s
        ) {
            $skills[] = $s['label'];
        };
        return $skills;
    }

    /**
     * exports in a friendlier format for output
     */
    public function export(): array
    {
        return array_merge(
            ['ATTRIBUTES:'],
            $this->exportAttributes(),
            ['SKILLS:'],
            $this->exportSkills()
        );
    }

    /**
     * returns the attacking skills used in the current round
     */
    public function getAttackingSkillsByChance(): array
    {
        return $this->getSkillsByChance($this->getAttackSkills());
    }

    /**
     * returns the defending skills used in the current round
     */
    public function getDefendingSkillsByChance(): array
    {
        return $this->getSkillsByChance($this->getDefenceSkills());
    }

    /**
     * calculates the odds of using some of the available skills
     */
    private function getSkillsByChance(array $skills): array
    {
        $usedSkills = [];
        foreach ($skills as $values) {
            $modifier = (
                new UnitSkill([
                    'skillName'  => $values['label'],
                    'modifier' => $values['modifier'],
                    'chance'     => $values['chance']
                ])
            )->getmodifierByChance();
            if ($modifier != null) {
                $usedSkills[$values['label']] = $modifier;
            }
        }
        return $usedSkills;
    }
}
