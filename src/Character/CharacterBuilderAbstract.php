<?php

declare(strict_types=1);

namespace EmagHero\Character;

use EmagHero\Character\Attribute\UnitAttribute;

/**
 * base for Character builders
 */
abstract class CharacterBuilderAbstract
{
    protected $character;

    public function createCharacter(): void
    {
    }

    public function addName(string $name): void
    {
        $this->character->characterName = $name;
    }

    public function addAttributes(array $attributes): void
    {
        $this->character->attributes = [];
        foreach ($attributes as $attrName => $values) {
            if ($this->isValidAttribute($values)) {
                $this->character->attributes[$attrName] = (
                    new UnitAttribute([
                        'attrName' => $attrName,
                        'minValue' => $values[0],
                        'maxValue' => $values[1]
                    ])
                )->getRandomValue();
            }
        }
    }

    public function getCharacter(): GameCharacterAbstract
    {
        return $this->character;
    }

    /**
     * checks attribute values
     */
    private function isValidAttribute(array $values): bool
    {
        if (
            is_int($values[0]) &&
            is_int($values[1]) &&
            $values[1] >= $values[0]
        ) {
            return true;
        }
        return false;
    }
}
