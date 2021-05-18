<?php

declare(strict_types=1);

namespace EmagHero\Tests\Character;

use PHPUnit\Framework\TestCase;
use EmagHero\Character\HeroBuilder;
use EmagHero\Character\BeastBuilder;

/**
 * create different characters types
 */
class CharacterTest extends TestCase
{
    /**
     * hero is instance of character and has all properties
     */
    public function testHeroCharacter(): void
    {
        $attributes = [
            'health' => [70, 100],
            'strength' => [70, 80],
            'defence' => [45, 55],
            'speed' => [40, 50],
            'luck' => [10, 30],
        ];
        $attackSkills = [
            [
                'label' => "Rapid strike",
                'use' => "attack",
                'modifier' => 2,
                'chance' => 10,
            ]
        ];
        $defenceSkills = [
            [
                'label' => "Magic shield",
                'use' => "defence",
                'modifier' => 0.5,
                'chance' => 20,
            ]
        ];

        $builder = new HeroBuilder();
        $builder->createCharacter();
        $builder->addName('Orderus');
        $builder->addAttributes($attributes);
        $builder->addSkills(
            array_merge(
                $attackSkills,
                $defenceSkills,
            )
        );

        $hero = $builder->getCharacter();

        // check object type
        $this->assertInstanceOf(
            'EmagHero\Character\GameCharacterAbstract',
            $hero,
            'Hero is not a Character object'
        );

        // check name
        $this->assertEquals(
            'Orderus',
            $hero->getName(),
            'wrong character name'
        );

        // check attributes
        $heroAttributes = $hero->getAttributes();
        foreach (array_keys($attributes) as $attrName) {
            $this->assertArrayHasKey(
                $attrName,
                $heroAttributes,
                'attribute not found'
            );
        }

        // check skills
        $heroAttackSkills = $hero->getAttackSkills();
        foreach ($attackSkills as $skill) {
            $this->assertContains(
                $skill,
                $heroAttackSkills,
                'skill not found'
            );
        }
        $heroDefenceSkills = $hero->getDefenceSkills();
        foreach ($defenceSkills as $skill) {
            $this->assertContains(
                $skill,
                $heroDefenceSkills,
                'skill not found'
            );
        }
    }

    /**
     * beast is instance of character and has all properties
     */
    public function testBeastCharacter(): void
    {
        $attributes = [
            'health' => [70, 100],
            'strength' => [70, 80],
            'defence' => [45, 55],
            'speed' => [40, 50],
            'luck' => [10, 30],
        ];

        $builder = new BeastBuilder();
        $builder->createCharacter();
        $builder->addName('Beast');
        $builder->addAttributes($attributes);
        $beast = $builder->getCharacter();

        // check object type
        $this->assertInstanceOf(
            'EmagHero\Character\GameCharacterAbstract',
            $beast,
            'Beast is not a Character object'
        );

        // check name
        $this->assertEquals(
            'Beast',
            $beast->getName(),
            'wrong character name'
        );

        // check attributes
        $beastAttributes = $beast->getAttributes();
        foreach (array_keys($attributes) as $attrName) {
            $this->assertArrayHasKey(
                $attrName,
                $beastAttributes,
                'attribute not found'
            );
        }
    }
}
