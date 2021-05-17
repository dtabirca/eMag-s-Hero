<?php

declare(strict_types=1);

namespace EmagHero\Character;

interface CharacterBuilderInterface
{
    public function createCharacter(): void;
    public function addName(string $name): void;
    public function addAttributes(array $attributes): void;
    public function getCharacter(): GameCharacterAbstract;
}
