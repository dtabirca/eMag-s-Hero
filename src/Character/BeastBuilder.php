<?php

declare(strict_types=1);

namespace EmagHero\Character;

use EmagHero\Character\Attribute\UnitAttribute;

/**
 * creates a Beast character
 */
class BeastBuilder extends CharacterBuilderAbstract implements CharacterBuilderInterface
{
    public function createCharacter(): void
    {
        $this->character = new Beast();
    }
}
